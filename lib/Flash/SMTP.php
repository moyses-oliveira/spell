<?php

namespace Spell\Flash;

use Spell\Data\Service\SMTPConfigCollection;
use Spell\Data\Service\SMTP AS SMTPTransport;

/**
 * E-mail Notification Service
 *
 * @author moysesoliveira
 */
class SMTP {

    /**
     *
     * @var SMTPCollection 
     */
    private static $collection = null;

    /**
     * 
     * @param SMTPCollection $collection
     */
    public static function setCollection(SMTPConfigCollection $collection)
    {
        static::$collection = $collection;
    }

    /**
     * 
     * @return SMTPCollection
     */
    public static function getCollection(): SMTPConfigCollection
    {
        return static::$collection;
    }

    /**
     * 
     * @param string $key
     * @return 
     */
    public static function get(string $key = 'default'): SMTPTransport
    {
        $conf = static::getCollection()->get($key);
        return new SMTPTransport($conf);
    }

}
