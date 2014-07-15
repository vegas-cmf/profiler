<?php
return [
    'profiler' => [
        'route' => '/profiler/{requestId}',
        'paths' => [
            'module' => 'Profiler',
            'controller' => 'Frontend\Profiler',
            'action' => 'show'
        ],
        'params' => []
    ],
];