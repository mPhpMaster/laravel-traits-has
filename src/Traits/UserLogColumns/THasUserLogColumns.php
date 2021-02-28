<?php
/*
 * Copyright © 2021. mPhpMaster(https://github.com/mPhpMaster) All rights reserved.
 */

namespace mPhpMaster\LaravelTraitsHas\Traits\UserLogColumns;

use \Model; // @todo
use \User; // @todo
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Trait THasUserLogColumns
 * 
 * @property-read User|null   $deleter
 * @property-read User|null   $creator
 * @property-read User|null   $updater
 * @property-read string|null $creator_name
 * @property-read string|null $deleter_name
 * @property-read string|null $updater_name
 * @method static Builder|static createdBy($user_id = null)
 * @method static Builder|static deletedBy($user_id = null)
 * @method static Builder|static updatedBy($user_id = null)
 * @see THasUserLogColumns::deleter()
 * @see THasUserLogColumns::creator()
 * @see THasUserLogColumns::getCreatorNameAttribute()
 * @see THasUserLogColumns::getDeleterNameAttribute()
 * @see THasUserLogColumns::updater()
 * @see THasUserLogColumns::getUpdaterNameAttribute()
 *                                                   
 * @mixin IUserLogColumns
 * @mixin \Illuminate\Database\Eloquent\SoftDeletes
 *                                                 
 * @package mPhpMaster\LaravelTraitsHas\Traits\UserLogColumns
 */
trait THasUserLogColumns
{
    /**
     * @return bool
     */
    public function usesSoftDelete()
    {
        return in_array(\Illuminate\Database\Eloquent\SoftDeletes::class, class_uses_recursive($this));
    }

    /**
     * Returns Trait Status
     *
     * @return bool
     */
    public static function THasUserLogColumnsStatus(): bool
    {
        return (bool)hasConst(static::class, 'HAS_USER_LOG_COLUMNS') && static::HAS_USER_LOG_COLUMNS;
    }

    /**
     * When creating new model skip nulled *updated_at*
     *
     * @var bool
     */
    public
        $skip_updated_at = false;

    /**
     * Model constructor.
     *
     * @param array $attributes
     */
    public function THasUserLogColumnsConstruct(array $attributes = [])
    {
        if ( static::THasUserLogColumnsStatus() ) {
            $fillables = [
                $this->getCreatedByColumn(),
                $this->getUpdatedByColumn(),
            ];

            if ( $this->usesSoftDelete() ) {
                $fillables[] = $this->getDeletedByColumn();
            }

            $this->fillable = array_merge($this->fillable, $fillables);
        }
    }

    /**
     * Hide created_by column
     *
     * @return static
     */
    public function hideCreatorColumn()
    {
        if ( static::THasUserLogColumnsStatus() ) {
            $this->makeHidden([
                $this->getCreatedByColumn(),
                $this->getCreatedAtColumn(),
            ]);
        }

        return $this;
    }

    /**
     * Show created_by column
     *
     * @return static
     */
    public function showCreatorColumn()
    {
        if ( static::THasUserLogColumnsStatus() ) {
            $this->makeVisible([
                $this->getCreatedByColumn(),
                $this->getCreatedAtColumn(),
            ]);
        }

        return $this;
    }


    /**
     * Hide deleted_by column
     *
     * @return static
     */
    public function hideDeleterColumn()
    {
        if ( static::THasUserLogColumnsStatus() ) {
            $this->makeHidden([
                $this->getDeletedByColumn(),
                $this->getDeletedAtColumn(),
            ]);
        }

        return $this;
    }

    /**
     * Show created_by column
     *
     * @return static
     */
    public function showDeleterColumn()
    {
        if ( static::THasUserLogColumnsStatus() ) {
            $this->makeVisible([
                $this->getDeletedByColumn(),
                $this->getDeletedAtColumn(),
            ]);
        }

        return $this;
    }

    /**
     * Hide updated_by column
     *
     * @return static
     */
    public function hideUpdaterColumn()
    {
        if ( static::THasUserLogColumnsStatus() ) {
            $this->makeHidden([
                $this->getUpdatedByColumn(),
                $this->getUpdatedAtColumn(),
            ]);
        }

        return $this;
    }

    /**
     * Show updated_by column
     *
     * @return static
     */
    public function showUpdaterColumn()
    {
        if ( static::THasUserLogColumnsStatus() ) {
            $this->makeVisible([
                $this->getUpdatedByColumn(),
                $this->getUpdatedAtColumn(),
            ]);
        }

        return $this;
    }

    /**
     *
     */
    protected static function bootTHasUserLogColumns()
    {
        if ( !static::THasUserLogColumnsStatus() ) return;

        // before new model create
        // assign Created By
        static::creating(function (IUserLogColumns $model) {
            if ( static::THasUserLogColumnsStatus() ) {
                if ( $model->isFillable(static::CREATED_BY_COLUMN) ) {
                    $model->{static::CREATED_BY_COLUMN} = $model->{static::CREATED_BY_COLUMN} ?: getCurrentUser();
                }
            }

        });

        // when new model created
        // unassign Updated At
        static::creating(function (IUserLogColumns $model) {
            // clear updated_at default value to null
            if ( !$model->skip_updated_at && $model->usesTimestamps() ) {
                $model->{$model->getUpdatedAtColumn()} = null;
            }

        });

        // when new model created
        // assign Updated By
        static::saving(function (IUserLogColumns $model) {
            if ( static::THasUserLogColumnsStatus() ) {
                // assign user to updated by column when updating
                if (
                    $model->isFillable(static::UPDATED_BY_COLUMN) &&
                    $model->exists
                ) {
                    $model->{static::UPDATED_BY_COLUMN} = getCurrentUser();
                }
            }

        });

        // when model deleted
        // assign deleted By
        static::deleting(function (IUserLogColumns $model) {
            if ( static::THasUserLogColumnsStatus() && $model->usesSoftDelete() && $model->exists ) {
                $model->update([
                    $model->getDeletedByColumn() => getCurrentUser()
                ]);
            }
        });

        if ( (new static)->usesSoftDelete() ) {
            // when model restored
            // unassuming deleted By
            static::restoring(function (IUserLogColumns $model) {
                if ( static::THasUserLogColumnsStatus() && $model->usesSoftDelete() ) {
                    $model->update([
                        $model->getDeletedByColumn() => null
                    ]);
                }
            });
        }
    }

    /**
     * created_by Relation
     *
     * @return BelongsTo|null
     */
    public function creator()
    {
        if ( static::THasUserLogColumnsStatus() ) {
            return $this->belongsTo(User::class, $this->getCreatedByColumn(), 'id');
        }

        return null;
    }

    /**
     * deleted_by Relation
     *
     * @return BelongsTo|null
     */
    public function deleter()
    {
        if ( static::THasUserLogColumnsStatus() && $this->usesSoftDelete() ) {
            return $this->belongsTo(User::class, $this->getDeletedByColumn(), 'id');
        }

        return null;
    }

    /**
     * updated_by Relation
     *
     * @return BelongsTo|null
     */
    public function updater()
    {
        if ( static::THasUserLogColumnsStatus() ) {
            return $this->belongsTo(User::class, $this->getUpdatedByColumn(), 'id');
        }

        return null;
    }

    /**
     * Returns creator name.
     *
     * @return string|null
     */
    public function getCreatorNameAttribute()
    {
        return ($rel = $this->creator) ? $rel->name : null;
    }

    /**
     * Returns creator id.
     *  $this->creator_id
     * 
     * @return int|null
     */
    public function getCreatorIdAttribute()
    {
        return $this->{$this->getCreatedByColumn()};
    }

    /**
     * Returns deleter name.
     * $this->deleter_name
     * 
     * @return string|null
     */
    public function getDeleterNameAttribute()
    {
        return ($rel = $this->deleter) ? $rel->name : null;
    }

    /**
     * Returns deleter id.
     * $this->deleter_id
     * 
     * @return int|null
     */
    public function getDeleterIdAttribute()
    {
        return $this->{$this->getDeletedByColumn()};
    }

    /**
     * Returns updater name.
     * $this->updater_name
     * 
     * @return string|null
     */
    public function getUpdaterNameAttribute()
    {
        return ($rel = $this->updater) ? $rel->name : null;
    }

    /**
     * Returns updater id.
     * $this->updater_id
     * 
     * @return int|null
     */
    public function getUpdaterIdAttribute()
    {
        return $this->{$this->getUpdatedByColumn()};
    }

    /**
     * @param Model|int|null $user
     * @param bool                          $save
     *
     * @return $this|Model
     */
    public function setCreatedBy($user = null, bool $save = false)
    {
        if ( $user !== 0 ) {
            $user = isModel($user) ? $user->id : $user;
            $this->{$this->getCreatedByColumn()} = $user ?: 0;
        } else {
            $this->{$this->getCreatedByColumn()} = 0;
        }

        if ( $save ) {
            $this->save();
        }

        return $this;
    }

    /**
     * @param Model|int|null $user
     * @param bool                          $save
     *
     * @return $this|Model
     */
    public function setUpdatedBy($user = null, bool $save = false)
    {
        if ( $user !== 0 ) {
            $user = isModel($user) ? $user->id : $user;
            $this->{$this->getUpdatedByColumn()} = $user ?: 0;
        } else {
            $this->{$this->getUpdatedByColumn()} = 0;
        }

        if ( $save ) {
            $this->save();
        }

        return $this;
    }

    /**
     * Scope Get by creator
     * ::CreatedBy()
     * 
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int|int[]|User|User[]       $user_id
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeCreatedBy(Builder $query, $user_id = null)
    {
        if ( is_array($user_id) ) {
            return $query->where(function (Builder $builder) use ($user_id) {
                foreach ($user_id as $item) {
                    $item = $item && isModel($item) ? $item->id : $item;
                    $builder = $builder->orWhere(static::CREATED_BY_COLUMN, $item ?: 0);
                }
                return $builder;
            });
        }

        $_user_id = isModel($user_id) ? $user_id->id : $user_id;
        return $query->where($this->getCreatedByColumn(), $_user_id ?: 0);
    }

    /**
     * Scope Get by updater
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int|int[]|User|User[]       $user_id
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeUpdatedBy(Builder $query, $user_id = null)
    {
        if ( is_array($user_id) ) {
            return $query->where(function (Builder $builder) use ($user_id) {
                foreach ($user_id as $item) {
                    $item = isModel($item) ? $item->id : $item;
                    $builder = $builder->orWhere(static::UPDATED_BY_COLUMN, $item ?: 0);
                }
                return $builder;
            });
        }

        $_user_id = isModel($user_id) ? $user_id->id : $user_id;
        return $query->where($this->getUpdatedByColumn(), $_user_id ?: 0);
    }

    /**
     * Scope Get by deleter
     * 
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int|int[]|User|User[]       $user_id
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeDeletedBy(Builder $query, $user_id = null)
    {
        if ( is_array($user_id) ) {
            return $query->where(function (Builder $builder) use ($user_id) {
                foreach ($user_id as $item) {
                    $item = isModel($item) ? $item->id : $item;
                    $builder = $builder->orWhere($item->getDeletedByColumn(), $item ?: 0);
                }
                return $builder;
            });
        }

        $_user_id = isModel($user_id) ? $user_id->id : $user_id;
        return $query->where($user_id->getDeletedByColumn(), $_user_id ?: 0);
    }

    /**
     * Check creator
     * 
     * @param int|User $user_id
     *
     * @return bool
     */
    public function isCreatedBy($user_id)
    {
        $user_id = isModel($user_id) ? $user_id->id : $user_id;
        return $this->{$this->getCreatedByColumn()} === ($user_id ?: 0);
    }

    /**
     * Check updater
     * 
     * @param int|User $user_id
     *
     * @return bool
     */
    public function isUpdatedBy($user_id)
    {
        $user_id = isModel($user_id) ? $user_id->id : $user_id;
        return $this->updated_by === ($user_id ?: 0);
    }

    /**
     * Check Deleter
     * 
     * @param int|User $user_id
     *
     * @return bool
     */
    public function isDeletedBy($user_id)
    {
        $user_id = isModel($user_id) ? $user_id->id : $user_id;
        return $this->{$this->getDeletedByColumn()} === ($user_id ?: 0);
    }

    /**
     * Get the name of the "created by" column.
     *
     * @return string
     */
    public function getCreatedByColumn()
    {
        return defined('static::CREATED_BY_COLUMN') ? static::CREATED_BY_COLUMN : 'created_by';
    }

    /**
     * Get the fully qualified "created by" column.
     *
     * @return string
     */
    public function getQualifiedCreatedByColumn()
    {
        return $this->qualifyColumn($this->getCreatedByColumn());
    }

    /**
     * Get the name of the "updated by" column.
     *
     * @return string
     */
    public function getUpdatedByColumn()
    {
        return defined('static::UPDATED_BY_COLUMN') ? static::UPDATED_BY_COLUMN : 'updated_by';
    }

    /**
     * Get the fully qualified "updated by" column.
     *
     * @return string
     */
    public function getQualifiedUpdatedByColumn()
    {
        return $this->qualifyColumn($this->getUpdatedByColumn());
    }

    /**
     * Get the name of the "deleted by" column.
     *
     * @return string
     */
    public function getDeletedByColumn()
    {
        return defined('static::DELETED_BY') ? static::DELETED_BY : 'deleted_by';
    }

    /**
     * Get the fully qualified "deleted by" column.
     *
     * @return string
     */
    public function getQualifiedDeletedByColumn()
    {
        return $this->qualifyColumn($this->getDeletedByColumn());
    }
}
