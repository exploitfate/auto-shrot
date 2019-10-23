<?php

namespace common\helpers;

/**
 * Role Helper
 */
class RoleHelper
{

    const ROLE_USER = 1;
    const ROLE_MANAGER = 9;
    const ROLE_ADMIN = 10;

    protected static $roles = [
        self::ROLE_USER => 'User',
        self::ROLE_MANAGER => 'Manager',
        self::ROLE_ADMIN => 'Admin',
    ];

    /**
     * Get roles
     *
     * @return array
     */
    public static function getRoles()
    {
        return static::$roles;
    }

    /**
     * Get roles keys
     *
     * @return array
     */
    public static function getRolesKeys()
    {
        return array_keys(static::$roles);
    }

    /**
     * Get role label by role key
     *
     * @param integer $key
     * @return string
     */
    public static function getRolesLabel($key)
    {
        return array_key_exists($key, static::$roles) ? static::$roles[$key] : '';
    }

    /**
     * Get role key by role label
     *
     * @param string $label
     * @return integer|boolean
     */
    public function getStatusKey($label)
    {
        $key = false;
        if (empty($label)) {
            return $key;
        }
        $titleLabel = mb_convert_case($label, MB_CASE_TITLE);
        $key = array_search($titleLabel, static::$roles);
        if ($key === false) {
            return $key;
        }

        return (int)$key;
    }
}
