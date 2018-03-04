<?php
return [
    'bootstrap' => ['gii'],
    'modules' => [
        'gii' => 'yii\gii\Module',
    ],
    'controllerMap' => [
        'stubs' => [
            'class' => 'bazilio\stubsgenerator\StubsController',
        ],
    ],
];
