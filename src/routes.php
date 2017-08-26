<?php

/* --------------------------------------------------------------- */
/*                       CONVERT CONTROLLERS                       */
/* --------------------------------------------------------------- */

$app['controllers']->convert('todo', function ($id) use ($app) {
    if ($id) {
        return $app['repository.todo']->find($id);
    }
});

/* --------------------------------------------------------------- */
/*                    INSTANCIATE CONTROLLERS                      */
/* --------------------------------------------------------------- */

$app['controller.index'] = $app->share(function ($app) {
    return new App\Controller\IndexController($app, $app['request']);
});

$app['controller.authentication'] = $app->share(function ($app) {
    return new App\Controller\AuthenticationController($app, $app['request'], $app['orm.em']);
});

$app['controller.todo'] = $app->share(function ($app) {
    return new App\Controller\TodoController($app, $app['request'], $app['orm.em']);
});

/* --------------------------------------------------------------- */
/*                         REGISTER ROUTES                         */
/* --------------------------------------------------------------- */

// Home page
$app->get('/', 'controller.index:indexAction')
    ->bind('homepage');

// Authentication routes
$app->match('/login', 'controller.authentication:loginAction')
    ->bind('login');

$app->get('/logout', 'controller.authentication:logoutAction')
    ->bind('logout');

// TodoList management
$app->get('/todos', 'controller.todo:indexAction')
    ->bind('todos-index');

$app->get('/todos/{id}', 'controller.todo:viewAction')
    ->bind('todos-view');

$app->post('/todos/add', 'controller.todo:addAction')
    ->bind('todos-add');

$app->match('/todos/delete/{id}', 'controller.todo:deleteAction')
    ->bind('todos-delete');