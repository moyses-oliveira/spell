<?php

namespace Spell\Data\Doctrine;

use Doctrine\ORM\EntityRepository;
use Spell\Flash\DBAL;
use Doctrine\ORM\EntityManager;

/**
 * Description of AbstractService
 *
 * @author moysesoliveira
 */
abstract class AbstractService {

    /**
     * 
     * @param string $entityName
     * @param string $alias
     * @return EntityRepository
     */
    public function getRepository(string $entityName, string $alias = 'default'): EntityRepository
    {
        return $this->getEm($alias)->getRepository($entityName);
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

}
