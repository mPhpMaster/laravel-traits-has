<?php
/*
 * Copyright © 2021. mPhpMaster(https://github.com/mPhpMaster) All rights reserved.
 */

namespace mPhpMaster\LaravelTraitsHas;

/**
 * Class HasFlag
 *
 * @package mPhpMaster\LaravelTraitsHas
 */
abstract class HasFlag
{
    /**
     * @var int
     */
    protected $flags;

    /**
     * @param $flag
     *
     * @return bool
     */
    protected function isFlagSet($flag)
    {
        return (($this->flags & $flag) == $flag);
    }

    /**
     * @param $flag
     * @param $value
     *
     * @return static
     */
    protected function setFlag($flag, $value)
    {
        if($value)
        {
            $this->flags |= $flag;
        }
        else
        {
            $this->flags &= ~$flag;
        }

        return $this;
    }
}
