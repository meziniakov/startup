<?php
return [
    'id' => 'backend',
    'basePath' => dirname(__DIR__),
    'language' => 'ru-RU',
    'components' => [
        'urlManager' => require __DIR__ . '/_urlManager.php',
        'frontendCache' => require Yii::getAlias('@frontend/config/_cache.php')
    ],
];
