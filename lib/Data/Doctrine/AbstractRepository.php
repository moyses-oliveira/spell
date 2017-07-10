<?php

namespace Spell\Data\Doctrine;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\EntityManager;
use Spell\Flash\DBAL;

/**
 * Description of AbstractRepository
 *
 * @author moysesoliveira
 */
abstract class AbstractRepository extends EntityRepository {

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
