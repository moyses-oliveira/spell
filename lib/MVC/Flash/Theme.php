<?php

namespace Spell\MVC\Flash;

use Spell\UI\Layout\ThemeCollection;

/**
 * Description of Theme
 *
 * @author moysesoliveira
 */
class Theme {

    /**
     *
     * @var ThemeCollection 
     */
    private static $collection = null;

    /**
     * 
     * @param ThemeCollection $collection
     */
    public static function setCollection(ThemeCollection $collection)
    {
        static::$collection = $collection;
    }

    /**
     * 
     * @return ThemeCollection
     */
    public static function getCollection(): ThemeCollection
    {
        return static::$collection;
    }

    /**
     * 
     * @param string $key
     * @return \Spell\UI\Layout\Theme
     */
    public static function get(string $key): \Spell\UI\Layout\Theme
    {
        return static::getCollection()->get($key);
    }

}
