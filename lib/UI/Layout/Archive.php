<?php

namespace Spell\UI\Layout;

use Spell\Flash\Path;
/**
 * Description of Archive
 *
 * @author moysesoliveira
 */
trait Archive
{

    /**
     *
     * @var string 
     */
    private $path = null;

    /**
     *
     * @var string 
     */
    private $file = null;

    /**
     * 
     * @param path $file
     */
    public function setFile($file)
    {
        $this->file = $file;
        return $this;
    }

    /**
     * 
     * @param string $path
     */
    public function setPath($path)
    {
        $setting = Path::combine([$path, 'setting.php']);
        if(file_exists($setting))
            require_once $setting;
        
        $this->path = $path;
        return $this;
    }

    /**
     * 
     * @return string
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * 
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

}
