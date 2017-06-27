<?php

namespace Spell\Flash;

use Spell\Localization\Text;

/**
 * Description of Localization
 *
 * @author moysesoliveira
 */
class Localization {

    private static $text;
    private static $lang;
    private static $path;

    public static function config(string $path, string $lang)
    {
        static::$text = new Text();
        static::setPath($path);
        static::setLang($lang);
    }

    public static function init()
    {
        $dir = implode(DIRECTORY_SEPARATOR, [static::$path, 'Data', 'Localization', static::$lang]);
        $files = glob($dir . DIRECTORY_SEPARATOR . '*.php');
        foreach($files as $f)
            static::getText()->load(require $f);
    }

    public static function setPath(string $path)
    {
        static::$path = $path;
    }

    public static function setLang(string $lang)
    {
        static::$lang = $lang;
    }

    public static function getText(): Text
    {
        return static::$text;
    }

    public static function T($key): string
    {
        return static::getText()->get($key);
    }

}
