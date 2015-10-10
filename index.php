<?php

namespace MyWebsite;

use Tale\Jade\Renderer;
use Exception;


include 'vendor/autoload.php';


$config = [
    'cache' => false,
    'pretty' => true,
    'url' => 'http://localhost'
];

if (file_exists(__DIR__.'/config.php'))
    $config = array_replace_recursive($config, include(__DIR__.'/config.php'));


$renderer = new Renderer([
    'compilerOptions' => [
        'pretty' => $config['pretty'],
        'paths' => [
            __DIR__.'/views/'
        ]
    ],
    'adapterOptions' => [
        'path' => __DIR__.'/cache',
        'lifeTime' => $config['cache'] ? 3600 : 0
    ]
]);


$page = isset($_GET['page'])
    ? preg_replace('/[^a-z0-9\-_]/i', '', $_GET['page'])
    : 'index';

$action = isset($_GET['action'])
        ? preg_replace('/[^a-z0-9\-_]/i', '', $_GET['action'])
        : 'index';

try {

    echo $renderer->render('pages/'.$page, [
        'page'   => $page,
        'action' => $action,
        'url' => $config['url']
    ]);
} catch(Exception $e) {

    echo $renderer->render('pages/404', [
        'page'   => $page,
        'action' => $action,
        'url' => $config['url']
    ]);
}
