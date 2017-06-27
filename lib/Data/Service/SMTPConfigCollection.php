<?php

namespace Spell\Data\Service;

/**
 * Email Collection
 *
 * @author moysesoliveira
 */
class SMTPConfigCollection {

    /**
     *
     * @var array 
     */
    private $collection = [];

    /**
     * 
     * @param string $key
     * @return SMTP
     */
    public function get(string $key) : SMTPConfig
    {
        return $this->collection[$key];
    }

    /**
     * 
     * @param string $key
     * @param string $host
     * @param string $user
     * @param string|null $password
     * @param int $port
     * @param string $security
     */
    public function add(string $key, string $host, string $user, ?string $password, int $port = 465, string $security = 'ssl')
    {   
        /*
        $user = 'contato@moysesoliveira.com.br';
        $pass = 'isra3l70';
        $from = 'contato@moysesoliveira.com.br';
        $host = 'smtp.gmail.com';
        $port = 465;
         *
         */
        $this->addSMTP($key, new SMTPConfig($host, $user, $password, $port, $security));
    }

    /**
     * 
     * @param string $key
     * @param SMTP $smtp
     */
    public function addSMTP(string $key, SMTPConfig $smtp)
    {
        $this->collection[$key] = $smtp;
    }
}
