<?php

namespace Spell\Data\Doctrine;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\EntityManager;

/**
 * Description of AbstractRepository
 *
 * @author moysesoliveira
 */
abstract class AbstractRepository extends EntityRepository {

    protected function getEm(): EntityManager
    {
        return $this->getEntityManager();
    }

}
