<?php
/*
 * Copyright © 2021. mPhpMaster(https://github.com/mPhpMaster) All rights reserved.
 */

namespace mPhpMaster\LaravelTraitsHas\Traits\StatusColumn;

/**
 * Interface IStatusColumn
 *
 * @package mPhpMaster\LaravelTraitsHas\Traits\StatusColumn
 */
interface IStatusColumn
{
    const
        // allow to auto fill status column (enabled, disabled)
        HAS_STATUS_COLUMN = true,
        // status column name
        STATUS_COLUMN = "status";

}
