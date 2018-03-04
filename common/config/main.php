<?php

$urlManagerBackendConfig = require(__DIR__ . '/urlManagerBackend.php');
$urlManagerFrontendConfig = require(__DIR__ . '/urlManagerFrontend.php');

return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'formatter' => [
            'defaultTimeZone' => 'UTC',
            'dateFormat' => 'php:Y-m-d',
            'datetimeFormat' => 'php:Y-m-d H:i:s',
        ],

        'urlManagerFrontend' => $urlManagerFrontendConfig,
        'urlManagerPromo' => $urlManagerFrontendConfig,
        'urlManagerBackend' => $urlManagerBackendConfig,

    ],
    'timeZone' => 'UTC',

];
