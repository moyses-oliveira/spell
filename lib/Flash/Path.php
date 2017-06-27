<?php

/**
 * Path class
 *  
 * @author Moysés Filipe Lopes Peixoto de Oliveira
 * @version 1.0
 * @access public
 * @modification 2016-10-20
 */

namespace Spell\Flash;

class Path {

    public static function combine($stack, $s = DIRECTORY_SEPARATOR)
    {
        if($stack == null)
            return '';

        if(!is_array($stack))
            $stack = [$stack];

        for($k = 0; $k < count($stack); $k++):
            $fix = str_replace(array('/', '\\'), $s, $stack[$k]);
            $stack[$k] = $k > 0 ? trim($fix, $s) : rtrim($fix, $s);
        endfor;

        return implode($s, $stack);
    }

    public static function make($path)
    {
        if(is_array($path)):
            $pathArray = $path;
        else:
            $path = rtrim(str_replace(array('/', '\\'), DIRECTORY_SEPARATOR, $path), DIRECTORY_SEPARATOR);
            $pathArray = explode(DIRECTORY_SEPARATOR, $path);
        endif;

        $keys = array_keys($pathArray);
        foreach($keys as $k):
            $new_path = static::combine(array_slice($pathArray, 0, $k + 1));
            static::dirMaker($new_path);
        endforeach;
        return true;
    }

    private static function dirMaker($new_path)
    {
        try {
            if(is_file($new_path))
                throw new \Exception('You are trying to create folder in a file address.');

            if(is_dir($new_path))
                return;

            $oldmask = umask(0);
            mkdir($new_path, 0755);
            umask($oldmask);
        } catch(\Exception $e) {
            throw $e;
        }
    }

    public static function symLink($target, $link, $fromPath = null)
    {
        $output = null;
        $path = !$fromPath ? getcwd() : $fromPath;
        if(DIRECTORY_SEPARATOR == '\\') {
            $from = static::combine(array($path, $target), false);
            $to = static::combine(array($path, $link), false);
            $code = 'mklink /J "' . $to . '" "' . $from . '"';
            exec($code, $output);
        } else {
            $from = static::combine(array($path, $target), true);
            $to = $link;
            symlink($from, $to);
        }
        return true;
    }

}
