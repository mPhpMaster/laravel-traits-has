<?php
/*
 * Copyright © 2021. mPhpMaster(https://github.com/mPhpMaster) All rights reserved.
 */

if ( !function_exists('getTraits') ) {
    /**
     * @param string|string[]|null $grep
     *
     * @return array
     */
    function getTraits($grep = null)
    {
        $traits = array_values(get_declared_traits());
        $results = [];
        if ( !is_null($grep) ) {
            foreach ((array)$traits as $trait) {
                foreach ((array)$grep as $needle) {
                    if ( is_string($trait) && is_string($needle) && $needle !== '' && mb_strpos($trait, $needle) !== false ) {
                        $results[] = $trait;
                    }
                }
            }
        } else {
            $results = $traits;
        }

        return $results;
    }
}

if ( !function_exists('hasConst') ) {
    /**
     * Check if given class has the given const.
     *
     * @param mixed  $class <p>
     *                          Either a string containing the name of the class to
     *                          check, or an object.
     *                          </p>
     * @param string $const <p>
     *                          Const name to check
     *                          </p>
     *
     * @return bool
     */
    function hasConst($class, $const): bool
    {
        $hasConst = false;
        try {
            if ( is_object($class) || is_string($class) ) {
                $reflect = new ReflectionClass($class);
                $hasConst = array_key_exists($const, $reflect->getConstants());
            }
        } catch (ReflectionException $exception) {
            $hasConst = false;
        } catch (Exception $exception) {
            $hasConst = false;
        }

        return (bool)$hasConst;
    }
}

if ( !function_exists('getCurrentUser') ) {
    /**
     * Get Current Loggedin User.
     * @todo: write get current user method
     *      
     * @param null|mixed $default
     *
     * @return \User|mixed @todo: class \User
     */
//    function getCurrentUser($default = null)
//    {
//        return $default;
//    }
}

if ( !function_exists('isModel') ) {
    /**
     * Determine if a given object is inherit Model class.
     * @todo: class \Model
     *      
     * @param object $object
     *
     * @return bool
     */
    function isModel($object)
    {
        try {
            return ($object instanceof \Model) || is_a($object, \Model::class);
        } catch (Exception $exception) {

        }

        return false;
    }
}

if ( !function_exists("CreateUserLogColumnsForMigrations") ) {
    /**
     * **DEV ONLY**
     * Create User Log Columns For Migrations
     *
     * @param \Illuminate\Database\Schema\Blueprint $table
     */
    function CreateUserLogColumnsForMigrations(\Illuminate\Database\Schema\Blueprint $table, $with_deleted_by = false)
    {
        $table->unsignedInteger('created_by');
        $table->unsignedInteger('updated_by')->nullable()->default(0);
        $with_deleted_by && $table->unsignedInteger('deleted_by')->nullable()->default(0);
    }
}