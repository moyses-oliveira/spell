<?php

namespace Spell\UI\Layout;

/**
 *
 * @author moysesoliveira
 */
trait Data
{

    /**
     *
     * @var array 
     */
    protected $data = [];

    /**
     * 
     * @param type $key
     * @param type $value
     * @throws Exception
     */
    public function addData($key, $value)
    {
        if (!is_string($key))
            throw new Exception('Data must be an string.');

        $this->data[$key] = $value;
        return $this;
    }

    /**
     * 
     * @param array $data
     * @throws Exception
     */
    public function setData(array $data)
    {
        $this->data = array_merge($this->data, (array) $data);
        return $this;
    }

    /**
     * 
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

}
