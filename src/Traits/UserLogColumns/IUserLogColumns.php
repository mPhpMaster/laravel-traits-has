<?php
/*
 * Copyright © 2021. mPhpMaster(https://github.com/mPhpMaster) All rights reserved.
 */

namespace mPhpMaster\LaravelTraitsHas\Traits\UserLogColumns;

/**
 * Interface IUserLogColumns
 *
 * @package mPhpMaster\LaravelTraitsHas\Traits\UserLogColumns
 */
interface IUserLogColumns
{
    const
        // allow to auto fill user log columns (created_by, updated_by)
        HAS_USER_LOG_COLUMNS = true,
        // creation user id
        CREATED_BY_COLUMN = "created_by",
        // updating user id
        UPDATED_BY_COLUMN = "updated_by";


}
