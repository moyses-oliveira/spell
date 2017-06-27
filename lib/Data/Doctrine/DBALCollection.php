<?php

namespace Spell\Data\Doctrine;

/**
 * Description of DBLCollection
 *
 * @author moysesoliveira
 */
class DBALCollection {


    /**
     *
     * @var array 
     */
    private $collection = [];

    /**
     * 
     * @param string $key
     * @return \Spell\Data\Doctrine\DBAL
     */
    public function get(string $key) : DBAL
    {
        return $this->collection[$key];
    }

    /**
     * 
     * @param string $key
     * @param string $host
     * @param string $dbname
     * @param string $user
     * @param string|null $password
     * @param int $port
     * @param string $driver
     */
    public function add(string $key, string $host, string $dbname, string $user, ?string $password = null, int $port = 3306, string $driver = 'pdo_mysql')
    {
        $this->addDBAL($key, new DBAL($host, $dbname, $user, $password, $port, $driver));
    }

    /**
     * 
     * @param string $key
     * @param \Spell\Data\Doctrine\DBAL $dbal
     */
    public function addDBAL(string $key, DBAL $dbal)
    {
        $this->collection[$key] = $dbal;
    }
}
