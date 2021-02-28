<?php
/*
 * Copyright © 2021. mPhpMaster(https://github.com/mPhpMaster) All rights reserved.
 */

namespace mPhpMaster\LaravelTraitsHas\Traits;

/** @todo: class \User */

use User;

/**
 * Trait TBelongsToUser
 * @method static \Illuminate\Database\Eloquent\Builder|static byUserId(User|int|null $user_id = null)
 *
 * @property User    user
 * @property integer user_id
 * @property string  user_name
 * @see     TBelongsToUser::scopeByUserId()
 * @package PhpMaster\LaravelTraitsHas\Traits
 */
trait TBelongsToUser
{
    /**
     * Get user relation
     * $this->user
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get User name
     * $this->user_name
     *
     * @param $value
     *
     * @return string
     */
    public function getUserNameAttribute($value)
    {
        if ( !$value ) {
            /** @var User $value */
            $value = ($value = $this->user) ? $value->name : '';
        }
        return (string)$value;
    }

    /**
     * ::ByUserId()
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param User|int                              $user_id
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByUserId(\Illuminate\Database\Eloquent\Builder $query, $user_id)
    {
        $users_id = (array)$user_id;
        foreach ($users_id as $key => $_user_id) {
            if ( is_null($_user_id) ) {
                unset($users_id[ $key ]);
                continue;
            }
            $users_id[ $key ] = $_user_id instanceof User ? $_user_id->id : intval($_user_id);
        }

        if ( empty($users_id) ) {
            return $query;
        }

        $users_id = collect($users_id)
            ->unique()->toArray();

        return $query->whereIn('user_id', $users_id);
    }
}
