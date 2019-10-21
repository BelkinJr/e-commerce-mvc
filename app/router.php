<?php
use PHPRouter\RouteCollection;
use PHPRouter\Router;
use PHPRouter\Route;

$collection = new RouteCollection();

$collection->attachRoute(
    new Route(
        '/',
        array(
            '_controller' => 'vbelkin\a3\controller\HomeController::indexAction',
            'methods' => 'GET',
            'name' => 'Home'
        )
    )
);

$collection->attachRoute(
    new Route(
        '/account/',
        array(
        '_controller' => 'vbelkin\a3\controller\AccountController::indexAction',
        'methods' => 'GET',
        'name' => 'accountIndex'
        )
    )
);

$collection->attachRoute(
    new Route(
        '/account/create/',
        array(
        '_controller' => 'vbelkin\a3\controller\AccountController::createAction',
        'methods' => ['GET','POST'],
        'name' => 'accountCreate'
        )
    )
);

$collection->attachRoute(
    new Route(
        '/account/delete/:id',
        array(
        '_controller' => 'vbelkin\a3\controller\AccountController::deleteAction',
        'methods' => 'GET',
        'name' => 'accountDelete'
        )
    )
);

$collection->attachRoute(
    new Route(
        '/account/update/:id',
        array(
        '_controller' => 'vbelkin\a3\controller\AccountController::updateAction',
        'methods' => 'POST',
        'name' => 'accountUpdate'
        )
    )
);

$collection->attachRoute(
    new Route(
        '/account/update/:id',
        array(
            '_controller' => 'vbelkin\a3\controller\AccountController::updateRedirect',
            'methods' => 'GET',
            'name' => 'updateRedirect'
        )
    )
);

$collection->attachRoute(
    new Route(
        '/account/login/',
        array(
            '_controller' => 'vbelkin\a3\controller\AccountController::loginAction',
            'methods' => 'GET',
            'name' => 'accountLogin'
        )
    )
);

$router = new Router($collection);
$router->setBasePath('/');
return $router;