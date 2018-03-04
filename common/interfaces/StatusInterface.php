<?php

namespace common\interfaces;

interface StatusInterface
{
    /**
     * Get statuses
     *
     * @return array
     */
    public static function getStatuses();

    /**
     * Get status keys
     *
     * @return array
     */
    public static function getStatusesKeys();

    /**
     * Get status label by status key
     *
     * @param integer $key
     * @return string
     */
    public static function getStatusLabel($key);
}
