<?php
use Core\Router;
use Core\ValidationException;
use Http\Session;

session_start();

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../functions.php';

$router = new Router;
require basePath('bootstrap.php');
require basePath('routes.php');

$uri = parse_url($_SERVER['REQUEST_URI'])['path'];
$method = $_POST['_method'] ?? $_SERVER['REQUEST_METHOD'];

try {
    $router->route($uri, $method);
} catch (ValidationException $e) {
    Session::flash('errors', $e->errors);
    Session::flash('old', $e->old);
    redirect('/login');
}

Session::unflash();

