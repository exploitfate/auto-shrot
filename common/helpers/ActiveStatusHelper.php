<?php

namespace common\helpers;

/**
 * Active Status Helper
 */
class ActiveStatusHelper extends AbstractStatusHelper
{
    const STATUS_DISABLE = 0;
    const STATUS_ACTIVE = 1;

    /**
     * @var array
     */
    protected static $statuses = [
        self::STATUS_DISABLE => 'Disable',
        self::STATUS_ACTIVE => 'Active',
    ];
}
