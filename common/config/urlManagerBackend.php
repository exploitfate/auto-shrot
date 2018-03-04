<?php

return [
    'class' => '\yii\web\UrlManager',
    'enablePrettyUrl' => true,
    'showScriptName' => false,
    'suffix' => '/',
    'normalizer' => [
        'class' => 'yii\web\UrlNormalizer',
        'collapseSlashes' => true,
        'normalizeTrailingSlash' => true,
    ],
    'rules' => [
        // static site rules
        '/' => 'site/index',
        '<action:(signup|login|logout)>' => 'site/<action>',

        'dating/' => 'dating/dashboard/index',
        'dating/<controller:\w+(\-[\w]+)*>/' => 'dating/<controller>/index',
        'dating/<controller:\w+(\-[\w]+)*>/<id:[\d]+>' => 'dating/<controller>/view',
        'dating/<controller:\w+(\-[\w]+)*>/<action:\w+(\-[\w]+)*>/<id:[\d]+>' => 'dating/<controller>/<action>',
        'dating/<controller:\w+(\-[\w]+)*>/<action:\w+(\-[\w]+)*>' => 'dating/<controller>/<action>',

        /**
         * Template of module rules
         */
        /*
        //'module/' => 'module/default/index',
        '<module>/<controller:\w+(\-[\w]+)*>/' => '<module>/<controller>/index',
        '<module>/<controller:\w+(\-[\w]+)*>/<id:[\d]+>' => '<module>/<controller>/view',
        '<module>/<controller:\w+(\-[\w]+)*>/<action:\w+(\-[\w]+)*>/<id:[\d]+>' => '<module>/<controller>/<action>',
        '<module>/<controller:\w+(\-[\w]+)*>/<action:\w+(\-[\w]+)*>' => '<module>/<controller>/<action>',
        */

        '<controller:\w+(\-[\w]+)*>/' => '<controller>/index',
        '<controller:\w+(\-[\w]+)*>/<id:[\d]+>' => '<controller>/view',
        '<controller:\w+(\-[\w]+)*>/<action:\w+(\-[\w]+)*>' => '<controller>/<action>',
        '<controller:\w+(\-[\w]+)*>/<action:\w+(\-[\w]+)*>/<id:[\d]+>' => '<controller>/<action>',
    ],
];
