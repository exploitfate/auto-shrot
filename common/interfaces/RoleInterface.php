<?php

namespace common\interfaces;

interface RoleInterface
{
    /**
     * Get roles
     *
     * @return array
     */
    public static function getRoles();

    /**
     * Get roles keys
     *
     * @return array
     */
    public static function getRolesKeys();

    /**
     * Get role label by role key
     *
     * @param integer $key
     * @return string
     */
    public static function getRolesLabel($key);
}
