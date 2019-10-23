<?php

namespace common\helpers;

/**
 * Abstract Type Helper
 */
abstract class AbstractTypeHelper
{
    /**
     * @var array
     */
    protected static $types = [];

    /**
     * Get types
     *
     * @return array
     */
    public static function getTypes()
    {
        return static::$types;
    }

    /**
     * Get types keys
     *
     * @return array
     */
    public static function getTypesKeys()
    {
        return array_keys(static::$types);
    }

    /**
     * Get type label by type key
     *
     * @param integer $key
     * @return string
     */
    public static function getTypeLabel($key)
    {
        return array_key_exists($key, static::$types) ? static::$types[$key] : '';
    }

    /**
     * Get type key by type label
     *
     * @param string $label
     * @return integer|boolean
     */
    public function getTypeKey($label)
    {
        $key = false;
        if (empty($label)) {
            return $key;
        }
        $titleLabel = mb_convert_case($label, MB_CASE_TITLE);
        $key = array_search($titleLabel, static::$types);
        if ($key === false) {
            return $key;
        }

        return (int)$key;
    }
}
