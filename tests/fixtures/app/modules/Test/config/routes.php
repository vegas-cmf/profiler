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
    'exception' => [
        'route' => '/exception',
        'paths' => [
            'module' => 'Test',
            'controller' => 'Frontend\Test',
            'action' => 'exception'
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