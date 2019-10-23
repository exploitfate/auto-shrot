<?php

namespace common\helpers;

/**
 * Abstract Status Helper
 */
abstract class AbstractStatusHelper
{
    /**
     * @var array
     */
    protected static $statuses = [];

    /**
     * Get statuses
     *
     * @return array
     */
    public static function getStatuses()
    {
        return static::$statuses;
    }

    /**
     * Get statuses keys
     *
     * @return array
     */
    public static function getStatusesKeys()
    {
        return array_keys(static::$statuses);
    }

    /**
     * Get status label by status key
     *
     * @param integer $key
     * @return string
     */
    public static function getStatusLabel($key)
    {
        return array_key_exists($key, static::$statuses) ? static::$statuses[$key] : '';
    }

    /**
     * Get status key by status label
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
        $key = array_search($titleLabel, static::$statuses);
        if ($key === false) {
            return $key;
        }

        return (int)$key;
    }
}
