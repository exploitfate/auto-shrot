<?php

namespace common\traits;

trait RoleTrait
{
    /**
     * Roles list
     *
     * @var array
     */
    protected static $roles;

    /**
     * Get roles
     *
     * @return array
     */
    public static function getRoles()
    {
        return self::$roles;
    }

    /**
     * Get roles keys
     *
     * @return array
     */
    public static function getRolesKeys()
    {
        return array_keys(self::$roles);
    }

    /**
     * Get role label by role key
     *
     * @param integer $key
     * @return string
     */
    public static function getRolesLabel($key)
    {
        return array_key_exists($key, self::$roles) ? self::$roles[$key] : '';
    }
}
