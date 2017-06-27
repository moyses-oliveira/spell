<?php

namespace Spell\Data\Service;

use Zend\Mail\Transport\SmtpOptions;
/**
 * Description of SMTP
 *
 * @author moysesoliveira
 */
class SMTPConfig {
    
    /**
     *
     * @var SmtpOptions 
     */
    private $options = null;

    /**
     * 
     * @param string $host
     * @param string $user
     * @param string|null $password
     * @param int $port
     * @param string $security
     */
    public function __construct(string $host, string $user, ?string $password, int $port = 465, string $security = 'ssl')
    {
        $this->options = new SmtpOptions();
        $this->options->setHost($host)
            ->setPort($port)
            ->setConnectionClass('login')
            ->setName($host)
            ->setConnectionConfig(array(
                'username' => $user,
                'password' => $password,
                'ssl' => $security
        ));
    }
    
    public function getOptions() : SmtpOptions {
        return $this->options;
    }
}
