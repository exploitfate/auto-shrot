<?php

Yii::setAlias('@common', dirname(__DIR__));
Yii::setAlias('@frontend', dirname(dirname(__DIR__)) . '/frontend');
Yii::setAlias('@backend', dirname(dirname(__DIR__)) . '/backend');
Yii::setAlias('@console', dirname(dirname(__DIR__)) . '/console');

// Set default parameters for \yii\data\Pagination
\Yii::$container->set(
    \yii\data\Pagination::class,
    [
        'pageSizeLimit' => [1, 1000],
        'defaultPageSize' => 20,
    ]
);
