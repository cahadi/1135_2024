<?php
require_once __DIR__ . '/vendor/autoload.php';

use MiladRahimi\PhpRouter\Router;
use MiladRahimi\PhpRouter\Exceptions\RouteNotFoundException;
use Laminas\Diactoros\Response\HtmlResponse;

use Tracy\Debugger;

function dd($some)
{
    echo '<pre>';
    print_r($some);
    echo '</pre>';
}

error_reporting(E_ALL);
ini_set('display_errors', 'on');

Debugger::enable();

$router = Router::create();

$router->group(['prefix'=> '/1135'], function(Router $router)
{
    $router->get('/', [\App\Controllers\FrontendController::class, 'articles'], 'articles');
    $router->get('/{id}', [\App\Controllers\FrontendController::class, 'singleArticle'], 'article');

    $router->get('/admin', [\App\Controllers\BackendController::class, 'index']);
    
    $router->get('/articles', [\App\Controllers\BackendController::class, 'articles']);

    $router->get('/add', [\App\Controllers\BackendController::class, 'editArticle']);
    $router->post('/save', [\App\Controllers\BackendController::class, 'createArticles']);

    $router->get('/edit{id}', [\App\Controllers\BackendController::class, 'editArticle']);
    $router->post('/update{id}', [\App\Controllers\BackendController::class, 'updateArticle']);

    $router->get('/delete{id}', [\App\Controllers\BackendController::class, 'deleteArticle']);

});


try {
    echo "Request URI: " . $_SERVER['REQUEST_URI'] . "\n";
    $router->dispatch();
} 
catch (RouteNotFoundException $e) {
    $router->getPublisher()->publish(new HtmlResponse('Not found.', 404));
}
catch (Throwable $e) {
    dd($e);
    //$router->getPublisher()->publish(new HtmlResponse('Internal error.', 500));
}