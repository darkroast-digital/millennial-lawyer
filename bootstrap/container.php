<?php

/*
|--------------------------------------------------------------------------
| #CONTAINER
|--------------------------------------------------------------------------
*/



// #BOOT CONTAINER
// =========================================================================

$container = $app->getContainer();



// #VIEWS
// =========================================================================

$container['view'] = function ($container) {
    $view = new \Slim\Views\Twig(__DIR__ . '/../resources/views', [
        'cache' => $container->settings['views']['cache']
    ]);

    $basePath = rtrim(str_ireplace('index.php', '', $container['request']->getUri()->getBasePath()), '/');

    $view->addExtension(new Slim\Views\TwigExtension($container['router'], $basePath));

    return $view;
};

$twig = $container->view->getEnvironment();
