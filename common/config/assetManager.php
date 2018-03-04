<?php

return [
    'linkAssets' => true,
    'bundles' => [
        'yii\web\JqueryAsset' => [
            // 'js' => ['//ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js'],
            'js' => [
                YII_ENV_DEV ? 'jquery.js' : 'jquery.min.js'
            ],
        ],
        'yii\jui\JuiAsset' => [
            // 'sourcePath' => null,
            // 'js' => ['//ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js'],
            // 'css' => ['//ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.min.css'],
            'js' => [
                YII_ENV_DEV ? 'jquery-ui.js' : 'jquery-ui.min.js'
            ],
            'css' => [
                YII_ENV_DEV ? 'themes/smoothness/jquery-ui.css' : 'themes/smoothness/jquery-ui.min.css'
            ],
        ],
        'yii\bootstrap\BootstrapAsset' => [
            // 'sourcePath' => null,
            // 'css' => ['//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css'],
            'css' => [
                YII_ENV_DEV ? 'css/bootstrap.css' : 'css/bootstrap.min.css'
            ],

        ],
        'yii\bootstrap\BootstrapPluginAsset' => [
            // 'sourcePath' => null,
            // 'js' => ['//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js'],
            'js' => [
                YII_ENV_DEV ? 'js/bootstrap.js' : 'js/bootstrap.min.js'
            ],
        ],
        'yii\bootstrap\BootstrapThemeAsset' => [
            // 'sourcePath' => null,
            // 'css' => ['//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap-theme.min.css'],
            'css' => [
                YII_ENV_DEV ? 'css/bootstrap-theme.css' : 'css/bootstrap-theme.min.css'
            ],
        ],
    ],
];
