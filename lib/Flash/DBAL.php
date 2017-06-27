<?php

namespace Spell\Flash;

use Spell\Data\Doctrine\DBALCollection;

/**
 * Data Base Connection Helper
 *
 * @author moysesoliveira
 */
class DBAL {

    /**
     *
     * @var DBALCollection 
     */
    private static $collection = null;

    /**
     * 
     * @param DBALCollection $collection
     */
    public static function setCollection(DBALCollection $collection)
    {
        static::$collection = $collection;
    }

    /**
     * 
     * @return DBALCollection
     */
    public static function getCollection(): DBALCollection
    {
        return static::$collection;
    }

    /**
     * 
     * @param string $key
     * @return \Spell\Data\Doctrine\DBAL
     */
    public static function get(string $key): \Spell\Data\Doctrine\DBAL
    {
        return static::getCollection()->get($key);
    }

}
