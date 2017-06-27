<?php

namespace Spell\Flash;

/**
 * Description of Autoloader
 *
 * @author moysesoliveira
 */
class Autoloader
{
    /**
     *
     * @var array 
     */
    private static $records = [];
    
    /**
     * root path of application
     * 
     * @var string 
     */
    private static $root = null;
    
    /**
     * 
     * @param string $namespace
     * @param string $path
     * @param string $extension
     */
    public static function add($namespace, $path, $extension){
        static::$records[$namespace] = [$path, $extension];
    }
    
    public static function remove($namespace) {
        unset(static::$records[$namespace]);
    }
    
    public static function load($class){
        $stack = explode('\\', ltrim($class, '\\'));
        $namespace = $stack[0];
        $namespaces = array_keys(static::$records);
        if(!in_array($namespace, $namespaces))
            return;
        
        list($rawPath, $extension) = static::$records[$namespace];
        
        $stack[0] = static::normalizePath($rawPath);
        array_unshift($stack, static::$root);        
        $file = implode(DIRECTORY_SEPARATOR, $stack) . $extension;
        if(!file_exists($file))
            throw (new \Exception(sprintf('Class "%s" can\'t be found!', $class )));
            
        require $file;
    }
    
    public static function init($root){
        static::$root = realpath(static::normalizePath($root, true));
        spl_autoload_register( ['Spell\Flash\Autoloader', 'load']);
    }
    
    public static function register($file){
        $filename = implode(DIRECTORY_SEPARATOR, [static::$root, static::normalizePath($file)]);
        if(!file_exists($filename))
            throw (new \Exception(sprintf('File "%s" can\'t be found!', $filename))); 
        
        require_once $filename;
    }
    
    private static function normalizePath($path, $rtrim = false){
        $fix = str_replace(['/','\\'], DIRECTORY_SEPARATOR, $path);
        if(!$rtrim)
            return trim($fix, DIRECTORY_SEPARATOR);
        
        return rtrim($fix, DIRECTORY_SEPARATOR);
    }
}
