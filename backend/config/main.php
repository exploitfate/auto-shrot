<?php

$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

$urlManagerBackendConfig = require(__DIR__ . '/../../common/config/urlManagerBackend.php');
$authManagerConfig = require(__DIR__ . '/../../common/config/authManager.php');
$assetManagerConfig = require(__DIR__ . '/../../common/config/assetManager.php');

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'modules' => [],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-backend',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => [
                        'error',
                        'warning',
                        //'info',
                        //'trace',
                    ],
                    'except' => [
                        'yii\debug\Module::checkAccess',
                        'yii\web\HttpException:404',
                        'yii\web\HttpException:403',
                    ],
                ],
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => [
                        'error',
                        'warning',
                        //'info',
                        //'trace',
                    ],
                    'except' => [
                        'yii\debug\Module::checkAccess',
                        'yii\web\HttpException:404',
                        'yii\web\HttpException:403',
                    ],
                    'logVars' => [],
                    'logFile' => '@app/runtime/logs/pretty/app.log',
                ],
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => [
                        'error',
                        'warning',
                        //'info',
                        //'trace',
                    ],
                    'categories' => ['yii\debug\Module::checkAccess', ],
                    'logFile' => '@app/runtime/logs/debug/app.log',
                ],
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => [
                        'error',
                        'warning',
                        //'info',
                        //'trace',
                    ],
                    'categories' => ['yii\web\HttpException:404', ],
                    'logFile' => '@app/runtime/logs/404/app.log',
                ],
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => [
                        'error',
                        'warning',
                        //'info',
                        //'trace',
                    ],
                    'categories' => ['yii\web\HttpException:403', ],
                    'logFile' => '@app/runtime/logs/403/app.log',
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'authManager' => $authManagerConfig,
        'assetManager' => $assetManagerConfig,
        'urlManager' => $urlManagerBackendConfig,
    ],
    'params' => $params,
];
