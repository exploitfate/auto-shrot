<?php

namespace common\interfaces;

interface TypeInterface
{
    /**
     * Get types
     *
     * @return array
     */
    public static function getTypes();

    /**
     * Get types keys
     *
     * @return array
     */
    public static function getTypesKeys();

    /**
     * Get type label by type key
     *
     * @param integer $key
     * @return string
     */
    public static function getTypeLabel($key);
}
