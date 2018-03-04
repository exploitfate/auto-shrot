<?php

namespace common\traits;

trait TypeTrait
{
    /**
     * Types list
     *
     * @var array
     */
    protected static $types;

    /**
     * Get types
     *
     * @return array
     */
    public static function getTypes()
    {
        return self::$types;
    }

    /**
     * Get types keys
     *
     * @return array
     */
    public static function getTypesKeys()
    {
        return array_keys(self::$types);
    }

    /**
     * Get type label by type key
     *
     * @param integer $key
     * @return string
     */
    public static function getTypeLabel($key)
    {
        return array_key_exists($key, self::$types) ? self::$types[$key] : '';
    }
}
