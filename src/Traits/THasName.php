<?php
/*
 * Copyright © 2021. mPhpMaster(https://github.com/mPhpMaster) All rights reserved.
 */

namespace mPhpMaster\LaravelTraitsHas\Traits;

/**
 * Trait THasName
 * 
 * @property string name
 *                      
 * @package mPhpMaster\LaravelTraitsHas\Traits
 */
trait THasName
{
    /**
     * Get name
     * $this->name
     * 
     * @param $value
     *              
     * @return string
     */
    public function getNameAttribute($value = null)
    {
        /**
         * Return name column.
         */
        return (string) $value ? $value : ($this->attributes['name'] ?? '');
    }

    /**
     * Set name
     * $this->name
     * 
     * @param $value
     *              
     * @return void
     */
    public function setNameAttribute($value = "")
    {
        $this->attributes["name"] = $value;
    }
}
