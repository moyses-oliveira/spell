<?php

namespace Spell\Data\Doctrine;

interface EntityInterface {
    
    /**
     * Normalize data from Request and put into Entity object
     * 
     * @param array $request
     * @return \Spell\Data\Entity\EntityInterface
     */
    public function fromRequest(array $request) : EntityInterface;
    
    /**
     * Put data into Entity object
     * 
     * @param array $data
     * @return \Spell\Data\Entity\EntityInterface
     */
    public function fromArray(array $data) : EntityInterface;
    
    /**
     * Convert Entity object to array
     * 
     * @return array
     */
    public function toArray() : array;
    
    /**
     * Load EntityInterface data from database using primary_key value
     * 
     * @param string|null $pk
     * @param string $alias
     * @return \Spell\Data\Doctrine\EntityInterface|null
     */
    public function load(string $pk, string $alias = 'default'): ?EntityInterface;
    
    
    /**
     * Persist EntityInterface data into database
     * 
     * @param array $data
     * @param string $alias
     * @return \Spell\Data\Doctrine\EntityInterface
     */
    public function persist(array $data, string $alias = 'default') : EntityInterface;
    
}
