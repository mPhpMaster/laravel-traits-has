<?php
/*
 * Copyright © 2021. mPhpMaster(https://github.com/mPhpMaster) All rights reserved.
 */

namespace mPhpMaster\LaravelTraitsHas\Interfaces;

/**
 * Interface IHasAttributesWithString
 *
 * @package mPhpMaster\LaravelTraitsHas\Interfaces
 */
interface IHasAttributesWithString
{
    /**
     * Returns all allowed strings name & value.
     *
     * @return array [ name => string ]
     */
    public static function getAllowedStrings(): array;

    /**
     * Returns method that apply the suffixing.
     *
     * @return \Closure
     */
    public static function getDefaultStringSuffixer(): \Closure;
}
