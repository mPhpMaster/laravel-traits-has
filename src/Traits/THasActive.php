<?php
/*
 * Copyright © 2021. mPhpMaster(https://github.com/mPhpMaster) All rights reserved.
 */

namespace mPhpMaster\LaravelTraitsHas\Traits;

use Illuminate\Contracts\Support\Arrayable;

/**
 * Trait THasActive
 * 
 * @property integer|boolean $active
 * @property-read  string $active_text
 * @method static \Illuminate\Database\Eloquent\Builder activeOnly()
 * @method static \Illuminate\Database\Eloquent\Builder inactiveOnly()
 *                                    
 * @package App\Traits\Helpers
 */
trait THasActive
{

    /**
     * Scope to get Active records only.
     * ::activeOnly()
     * 
     * @param \Illuminate\Database\Eloquent\Builder $query
     *                                                    
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActiveOnly($query)
    {
        return $query->where('active', true);
    }

    /**
     * Scope to get Inactive records only.
     * ::inactiveOnly()
     * 
     * @param \Illuminate\Database\Eloquent\Builder $query
     *                                                    
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeInactiveOnly($query)
    {
        return $query->where('active', false);
    }

    /**
     * Check if current record is active.
     * 
     * @return bool
     */
    public function isActive(): bool
    {
        return boolval($this->active) === true;
    }

    /**
     * Set active column.
     * 
     * @param array|bool $value
     * @param bool $save
     *                  
     * @return $this
     */
    public function setActive($value, bool $save = false)
    {
        $value = collect((is_array($value) || ($value instanceof Arrayable)) ? $value : ['active' => $value]);

        $active = $value->get('active', null);
        if(!is_null($active)){
            $this->active = (bool) $active;

            if($save){
                $this->save();
            }
        }

        return $this;
    }

    /**
     * Set Active Attribute
     * 
     * @param $value
     */
    public function setActiveAttribute($value)
    {
        $this->attributes['active'] = (int) $value;
    }

    /**
     * Get Active Attribute
     * 
     * @param $value
     *              
     * @return int
     */
    public function getActiveAttribute($value)
    {
        return (int) $value;
    }

    /**
     * Get Active as text
     * $this->active_text
     * 
     * @return string
     */
    abstract public function getActiveTextAttribute();
}
