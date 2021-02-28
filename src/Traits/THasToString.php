<?php
/*
 * Copyright © 2021. mPhpMaster(https://github.com/mPhpMaster) All rights reserved.
 */

namespace mPhpMaster\LaravelTraitsHas\Traits;

/**
 * Trait THasToString
 *
 * @mixin Stringable
 *                  
 * @package mPhpMaster\LaravelTraitsHas\Traits
 */
trait THasToString {

    /**
     * @return string
     */
    abstract function __toString();
    
    public function toString(): string {
        return (string)$this->__toString();
    }
}
