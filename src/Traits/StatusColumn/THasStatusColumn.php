<?php
/*
 * Copyright © 2021. mPhpMaster(https://github.com/mPhpMaster) All rights reserved.
 */

namespace mPhpMaster\LaravelTraitsHas\Traits\StatusColumn;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Trait THasStatusColumn
 *
 * @method Builder status($status = null)
 *
 * @mixin IStatusColumn
 *
 * @package mPhpMaster\LaravelTraitsHas\Traits\StatusColumn
 */
trait THasStatusColumn
{
    /**
     * Returns Trait Status
     *
     * @return bool
     */
    public static function THasStatusColumnStatus(): bool
    {
        return (bool) hasConst(static::class, 'HAS_STATUS_COLUMN') && static::HAS_STATUS_COLUMN;
    }

    /**
     * Model constructor.
     *
     * @param array $attributes
     */
    public function THasStatusColumnConstruct(array $attributes = [])
    {
        if (static::THasStatusColumnStatus()) {
            $this->fillable = array_merge($this->fillable, [
                static::STATUS_COLUMN
            ]);
        }
    }

    protected static function bootTHasStatusColumn()
    {
//        if (!static::THasStatusColumnStatus()) return;
    }

    /**
     * Get By status.
     * ::Status()
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @param  array|mixed|null $status
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeStatus($query, $status = null)
    {
        return $query->whereIn(static::STATUS_COLUMN, (array) $status);
    }
    
    /**
     * Returns all statuses.
     *
     * @return array
     */
    abstract public static function getAllStatuses(): array;


    /**
     * Returns translation of given status.
     *
     * @param string $status
     *
     * @return string
     */
    abstract public static function transStatus(string $status): string;

    /**
     * Returns Status value by given name.
     * 
     * @param string|null $key
     * @param mixed|null $default
     *
     * @return mixed|null
     */
    public static function getStatusValue(?string $key = null, $default = null)
    {
        if(is_null($key)) {
            return array_values(static::getAllStatuses());
        }

        return array_get(static::getAllStatuses(), $key, $default);
    }

    /**
     * Returns Status name by given value.
     * 
     * @param string|null $key
     * @param mixed|null $default
     *
     * @return mixed|null
     */
    public static function getStatusName(?string $key = null, $default = null)
    {
        if(is_null($key)) {
            return array_keys(static::getAllStatuses());
        }

        $value = array_search($key, static::getAllStatuses());

        return $value === false ? $default : $value;
    }
}
