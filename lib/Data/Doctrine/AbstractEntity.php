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
    public function load(?string $pk = null, string $alias = 'default'): ?EntityInterface
    {
        if(!$pk)
            return $this;

        return $this->getEm($alias)->find(get_class($this), $pk);
    }

    /**
     * 
     * @param array $data
     * @param string $alias
     */
    public function persist(array $data, string $alias = 'default'): EntityInterface
    {
        $this->fromArray($data);
        $em = $this->getEm($alias);
        $em->persist($this);
        $em->flush();
        return $this;
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
