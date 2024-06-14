<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Slim\Routing\RouteCollectorProxy;

require_once("controllers/MozoController.php");
require_once("controllers/ProductoController.php");
require_once("controllers/PedidoController.php");
require_once '../vendor/autoload.php';


date_default_timezone_set("America/Argentina/Buenos_Aires");

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

$app = AppFactory::create();


$app->group('/mozos', function (RouteCollectorProxy $group) {
  $group->get('[/]', \MozoController::class . ':leerTodos');
  $group->get('/{id}', \MozoController::class . ':leerUno');
  $group->post('[/]', \MozoController::class . ':crearUno');
});

$app->group('/productos', function (RouteCollectorProxy $group) {
  $group->get('[/]', \ProductoController::class . ':leerTodos');
  $group->get('/{id}', \ProductoController::class . ':leerUno');
  $group->post('[/]', \ProductoController::class . ':crearUno');
});

$app->group('/pedidos', function (RouteCollectorProxy $group) {
  $group->get('[/]', \PedidoController::class . ':leerTodos');
  $group->get('/{id}', \PedidoController::class . ':leerUno');
  $group->post('[/]', \PedidoController::class . ':crearUno');
});


$app->run();