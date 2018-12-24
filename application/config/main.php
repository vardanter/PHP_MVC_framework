<?php
return [
    'urlRules' => [
        'signup' => [
            'url' => '/',
            'rule' => '\application\controllers\AuthController',
            'method' => 'get, post'
        ],
        'profile' => [
            'url' => '/profile',
            'rule' => '\application\controllers\AuthController@profile',
            'method' => 'get'
        ],
        'logout' => [
            'url' => '/logout',
            'rule' => '\application\controllers\AuthController@logout',
            'method' => 'get'
        ],
        'localize' => [
            'url' => '/localize.js',
            'rule' => '\application\controllers\DefaultController@locals',
            'method' => 'get'
        ],
        'setlang' => [
            'url' => '/setlang',
            'rule' => '\application\controllers\DefaultController@setLanguage',
            'method' => 'get'
        ]
    ],
    'db' => [
        'dsn' => 'mysql:host=localhost;dbname=regtest;charset=utf8',
        'user' => 'root',
        'password' => '12345678'
    ],
    'locals' => 'application/local',
    'lang' => 'ru'
];