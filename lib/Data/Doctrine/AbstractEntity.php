<?php

namespace Spell\Data\Doctrine;

use Spell\Flash\DBAL;
use Doctrine\ORM\EntityManager;

/**
 * Description of AbstractEntity
 *
 * @author moysesoliveira
 */
abstract class AbstractEntity implements EntityInterface {

    /**
     * Normalize data from Request and put into Entity object
     * 
     * @param array $request
     * @return \Spell\Data\Entity\EntityInterface
     */
    public function fromRequest(array $request): EntityInterface
    {
        return $this->fromArray($request);
    }

    /**
     * Put data into Entity object
     * 
     * @param array $data
     * @return \Spell\Data\Entity\EntityInterface
     */
    public function fromArray(array $data): EntityInterface
    {
        $defaults = $this->getEntityReflection()->getDefaultProperties();
        foreach($defaults as $k => $default):
            if(!isset($data[$k])):
                $this->{$k} = $this->{$k} === null ? $default : $this->{$k};
                continue;
            endif;
            $this->{$k} = $data[$k];
        endforeach;
        return $this;
    }

    /**
     * Convert Entity object to array
     * 
     * @return array
     */
    public function toArray(): array
    {
        $keys = array_keys($this->getEntityReflection()->getDefaultProperties());
        $data = [];
        foreach($keys as $k)
            $data[$k] = $this->{$k};

        return $data;
    }

    /**
     * Current entity information
     * 
     * @return \ReflectionClass
     */
    private function getEntityReflection(): \ReflectionClass
    {
        return (new \ReflectionClass(get_class($this)));
    }

    /**
     * Load entity data by id
     * 
     * @param string $pk
     * @param string $alias
     * @return \Spell\Data\Doctrine\EntityInterface|null
     */
    public function load(string $pk, string $alias = 'default'): ?EntityInterface
    {
        $em = $this->getEm($alias);
        $entity = $em->find(get_class($this), $pk);
        if(!$entity)
            return null;

        $this->fromArray($entity->toArray());
        return $entity;
    }

    /**
     * 
     * @param array $data
     * @param string $alias
     */
    public function persist(array $data, string $alias = 'default'): EntityInterface
    {
        $fnNull = function($id) {
            return null;
        };
        $entityName = get_class($this);
        $current = $this->toArray() + $data;
        $em = $this->getEm($alias);
        $uw = $em->getUnitOfWork();
        $model = $em->getPartialReference($entityName, 0);
        $pks = array_map($fnNull, $uw->getEntityIdentifier($model));
        $ids = array_intersect_key($current, $pks) + $pks;
        $entity = $ids === $pks ? new $entityName() : $em->find($entityName, $ids);
        $this->fromArray($data);
        $entity->fromArray($this->toArray());
        $em->persist($entity);
        $em->flush();
        $this->fromArray($entity->toArray());
        return $entity;
    }

    /**
     * 
     * @param string $alias
     * @return EntityManager
     */
    protected function getEm(string $alias = 'default'): EntityManager
    {
        return DBAL::get($alias)->getEm();
    }

    /**
     * 
     * @param array $data
     * @param string $key
     * @return string|null
     */
    public function set(array $data, string $key): ?string
    {
        return isset($data[$key]) ? $data[$key] : $this->{$key};
    }

}
