<?php

namespace common\traits;

trait StatusTrait
{
    /**
     * Statuses list
     *
     * @var array
     */
    protected static $statuses;

    /**
     * Get statuses
     *
     * @return array
     */
    public static function getStatuses()
    {
        return self::$statuses;
    }

    /**
     * Get statuses keys
     *
     * @return array
     */
    public static function getStatusesKeys()
    {
        return array_keys(self::$statuses);
    }

    /**
     * Get status label by status key
     *
     * @param integer $key
     * @return string
     */
    public static function getStatusLabel($key)
    {
        return array_key_exists($key, self::$statuses) ? self::$statuses[$key] : '';
    }
}
