<?php

namespace Spell\Data\Service;

#use Spell\Mail\Message;
#use Spell\Mail\Mime\Part;
use Zend\Mail\Message;
use Zend\Mime\Part;
use Zend\Mime\Message AS MimeMessage;
use Zend\Mail\Transport\Smtp AS TransportSmtp;
/**
 * Description of SMTP
 *
 * @author moysesoliveira
 */
class SMTP {

    /**
     *
     * @var \Spell\Mail\Transport\Smtp
     */
    public $transport = null;

    /**
     *
     * @var Message;
     */
    public $composer = null;

    /**
     * 
     * @param SMTPConfig $conf
     */
    public function __construct(SMTPConfig $conf)
    {
        $this->transport = new TransportSmtp($conf->getOptions());
        $this->composer = new Message();
        $this->getComposer()->setEncoding('UTF-8');
    }

    /**
     * 
     * @param string $email
     * @param string|null $name
     * @return \Spell\Data\Service\SMTP
     */
    public function getTransport(): TransportSmtp
    {
        return $this->transport;
    }

    /**
     * 
     * @param string $email
     * @param string|null $name
     * @return \Spell\Data\Service\SMTP
     */
    public function getComposer(): Message
    {
        return $this->composer;
    }

    /**
     * 
     * @param string $name
     * @return \Spell\Data\Service\SMTP
     */
    public function setFromName(string $name): SMTP
    {
        $email = $this->getTransport()->getOptions()->getConnectionConfig()['username'];
        $this->getComposer()->setFrom($email, $name);
        return $this;
    }

    /**
     * 
     * @param string $email
     * @param string|null $name
     * @return \Spell\Data\Service\SMTP
     */
    public function setFrom(string $email, ?string $name = null): SMTP
    {
        $this->getComposer()->setFrom($email, $name);
        return $this;
    }

    public function setSubject(string $subject): SMTP
    {
        $this->getComposer()->setSubject($subject);
        return $this;
    }

    public function addTo(string $email, ?string $name = null): SMTP
    {
        $this->getComposer()->addTo($email, $name);
        return $this;
    }

    public function addCc(string $email, ?string $name = null): SMTP
    {
        $this->getComposer()->addCc($email, $name);
        return $this;
    }

    public function addBcc(string $email, ?string $name = null): SMTP
    {
        $this->getComposer()->addBcc($email, $name);
        return $this;
    }

    public function setBody(string $body): SMTP
    {
        $part = new Part($body);
        $part->type = 'text/html';
        $mime = new MimeMessage();
        $mime->setParts([$part]);
        $this->getComposer()->setBody($mime);
        return $this;
    }

    public function send()
    {
        $this->transport->send($this->getComposer());
    }

}
