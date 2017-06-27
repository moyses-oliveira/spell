<?php

namespace Spell\Data\Doctrine;

use Doctrine\ORM\EntityManager;
use Doctrine\DBAL\Configuration;
use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\AnnotationRegistry;

/**
 * Doctrine Database Layer
 *
 * @author moysesoliveira
 */
class DBAL {

    /**
     *
     * @var EntityManager|null 
     */
    private $em = null;

    /**
     *
     * @var string 
     */
    private $host = null;

    /**
     *
     * @var string 
     */
    private $dbname = null;

    /**
     *
     * @var string 
     */
    private $user = null;

    /**
     *
     * @var string|null 
     */
    private $password = null;

    /**
     *
     * @var int 
     */
    private $port = null;

    /**
     *
     * @var string 
     */
    private $driver = null;

    /**
     * 
     * @param string $host
     * @param string $dbname
     * @param string $user
     * @param string|null $password
     * @param int $port
     * @param string $driver
     */
    public function __construct(string $host, string $dbname, string $user, ?string $password = null, int $port = 3306, string $driver = 'pdo_mysql')
    {
        $this->host = $host;
        $this->dbname = $dbname;
        $this->user = $user;
        $this->password = $password;
        $this->port = $port;
        $this->driver = $driver;
    }

    /**
     * 
     * @return EntityManager
     */
    public function getEm(): EntityManager
    {
        if(!$this->em)
            $this->loadEntityManager();

        return $this->em;
    }

    private function loadEntityManager()
    {
        $config = new Configuration();
        $conn = DriverManager::getConnection($this->dbParams(), $config);
        $conn->getConfiguration();
        //$paths = ['App/Panel/Entity'];
        $mdconfig = Setup::createConfiguration(false);
        $driver = new AnnotationDriver(new AnnotationReader(), []);

        // registering noop annotation autoloader - allow all annotations by default
        AnnotationRegistry::registerLoader('class_exists');
        $mdconfig->setMetadataDriverImpl($driver);

        $this->em = EntityManager::create($conn, $mdconfig);
    }

    /**
     * Convert Entity object to array
     * 
     * @return array
     */
    public function dbParams(): array
    {
        $reflection = new \ReflectionClass(get_class($this));
        $keys = array_keys($reflection->getDefaultProperties());
        $data = [];
        foreach($keys as $k)
            if($k !== 'em')
                $data[$k] = $this->{$k};

        $data['charset'] = 'UTF8';
        $data['driverOptions'] = [1002 => "SET NAMES 'UTF8' COLLATE 'utf8_general_ci'" ];
        return $data;
    }

}
