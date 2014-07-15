<?php
return [
    'home' => [
        'route' => '/',
        'paths' => [
            'module' => 'Test',
            'controller' => 'Frontend\Test',
            'action' => 'index'
        ],
        'params' => []
    ],
    'query' => [
        'route' => '/query',
        'paths' => [
            'module' => 'Test',
            'controller' => 'Frontend\Test',
            'action' => 'query'
        ],
        'params' => []
    ],
];