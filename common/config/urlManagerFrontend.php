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
        '<action:(terms-of-use|privacy-policy|reset-password)>' => 'site/<action>',

        /*
        // 'module/' => 'module/default/index',
        '<module>/<controller:\w+(\-[\w]+)*>/' => '<module>/<controller>/index',
        '<module>/<controller:\w+(\-[\w]+)*>/<id:[\d]+>' => '<module>/<controller>/view',
        '<module>/<controller:\w+(\-[\w]+)*>/<action:\w+(\-[\w]+)*>/<id:[\d]+>' => '<module>/<controller>/<action>',
        '<module>/<controller:\w+(\-[\w]+)*>/<action:\w+(\-[\w]+)*>' => '<module>/<controller>/<action>',
        */

        '<controller:\w+(\-[\w]+)*>/' => '<controller>/index',
        '<controller:\w+(\-[\w]+)*>/<id:[\d]+>' => '<controller>/view',
        '<controller:\w+(\-[\w]+)*>/<action:\w+(\-[\w]+)*>/<id:[\d]+>' => '<controller>/<action>',
        '<controller:\w+(\-[\w]+)*>/<action:\w+(\-[\w]+)*>' => '<controller>/<action>',
    ],
];
