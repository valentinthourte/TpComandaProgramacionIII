<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Slim\Routing\RouteCollectorProxy;

require_once("controllers/UsuarioController.php");
require_once("controllers/ProductoController.php");
require_once("controllers/PedidoController.php");
require_once("controllers/MesaController.php");
require_once("controllers/ComandaController.php");
require_once("controllers/ReportesController.php");
require_once("controllers/LoginController.php");

require_once("middlewares/MAutenticacionTipoUsuario.php");
require_once("middlewares/MValidacionToken.php");
require_once("middlewares/MValidacionLogin.php");

require_once '../vendor/autoload.php';


date_default_timezone_set("America/Argentina/Buenos_Aires");

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

$app = AppFactory::create();
$app->addBodyParsingMiddleware();


$app->group('/usuarios', function (RouteCollectorProxy $group) {
  $group->get('[/]', \UsuarioController::class . ':leerTodos')
  ->add(new MAutenticacionTipoUsuario(array("cocinero","socio", "cervecero", "bartender", "pastelero")));

  $group->get('/{id}', \UsuarioController::class . ':leerUno')
  ->add(new MAutenticacionTipoUsuario(array("cocinero","socio", "cervecero", "bartender", "pastelero")));

  $group->post('[/]', \UsuarioController::class . ':crearUno')
  ->add(new MAutenticacionTipoUsuario(array("socio")));

  $group->put('{id}', \UsuarioController::class . ':actualizar')
  ->add(new MAutenticacionTipoUsuario(array("socio")));

  $group->delete('/{id}', \UsuarioController::class . ':darDeBaja')
  ->add(new MAutenticacionTipoUsuario(array("socio")));



  $group->get('/logins/loginsPorFecha', \UsuarioController::class . ':logins')
  ->add(new MAutenticacionTipoUsuario(array("socio")));

})->add(new MValidacionToken());


$app->group('/productos', function (RouteCollectorProxy $group) {
  $group->get('[/]', \ProductoController::class . ':leerTodos')
  ->add(new MAutenticacionTipoUsuario(array("cocinero","socio", "cervecero", "bartender", "pastelero")));

  $group->get('/exportarACsv', \ProductoController::class . ':exportarACsv')
  ->add(new MAutenticacionTipoUsuario(array("cocinero","socio", "cervecero", "bartender", "pastelero")));

  $group->get('/{id}', \ProductoController::class . ':leerUno')
  ->add(new MAutenticacionTipoUsuario(array("cocinero","socio", "cervecero", "bartender", "pastelero")));

  $group->post('[/]', \ProductoController::class . ':crearUno')
  ->add(new MAutenticacionTipoUsuario(array("cocinero","socio", "cervecero", "bartender", "pastelero")));

  $group->post('/cargaMasiva', \ProductoController::class . ':cargaMasiva')
  ->add(new MAutenticacionTipoUsuario(array("mozo","cocinero","socio", "cervecero", "bartender", "pastelero")));

})->add(new MValidacionToken());


$app->group('/pedidos', function (RouteCollectorProxy $group) {
  $group->get('[/]', \PedidoController::class . ':leerTodos')
  ->add(new MAutenticacionTipoUsuario(array("cocinero","socio", "cervecero", "bartender", "pastelero")));

  $group->get('/{numeroPedido}', \PedidoController::class . ':leerUno')
  ->add(new MAutenticacionTipoUsuario(array("cocinero","socio", "cervecero", "bartender", "pastelero")));

  $group->get('/exportar/pdfPorFecha', \PedidoController::class . ':pdfPorFecha')
  ->add(new MAutenticacionTipoUsuario(array("socio")));

  $group->post('[/]', \PedidoController::class . ':crearUno')
  ->add(new MAutenticacionTipoUsuario(array("mozo","socio")));

  $group->get('/tiempoRestante/{numeroPedido}', \PedidoController::class . ':tiempoRestantePedido')
  ->add(new MAutenticacionTipoUsuario(array("cocinero","socio", "cervecero", "bartender", "pastelero", "cliente")));

  $group->put('/{numeroPedido}', \PedidoController::class . ':actualizar')
  ->add(new MAutenticacionTipoUsuario(array("mozo", "socio")));

  $group->post('/agregarImagen/{numeroPedido}', \PedidoController::class . ':agregarImagen')
  ->add(new MAutenticacionTipoUsuario(array("mozo", "socio")));

})->add(new MValidacionToken());


$app->group('/comandas', function (RouteCollectorProxy $group) {
  $group->get('[/]', \ComandaController::class . ':leerTodos')
  ->add(new MAutenticacionTipoUsuario(array("cocinero","socio", "cervecero", "bartender", "pastelero")));

  $group->get('/obtenerPorEstadoYTipoUsuario', \ComandaController::class . ':leerPorEstadoTipoUsuario')
  ->add(new MAutenticacionTipoUsuario(array("cocinero","socio", "cervecero", "bartender", "pastelero")));

  $group->get('/{id}', \ComandaController::class . ':leerUno')
  ->add(new MAutenticacionTipoUsuario(array("cocinero","socio", "cervecero", "bartender", "pastelero")));

  $group->put('/{numeroPedido}', \ComandaController::class . ':actualizar')
  ->add(new MAutenticacionTipoUsuario(array("cocinero", "cervecero", "bartender", "pastelero", "socio")));

})->add(new MValidacionToken());


$app->group('/mesas', function (RouteCollectorProxy $group) {
  $group->get('[/]', \MesaController::class . ':leerTodos')
  ->add(new MAutenticacionTipoUsuario(array("mozo","cocinero", "cervecero", "bartender", "pastelero", "socio")));

  $group->get('/{numeroMesa}', \MesaController::class . ':leerUno')
  ->add(new MAutenticacionTipoUsuario(array("mozo","cocinero", "cervecero", "bartender", "pastelero", "socio")));

  $group->post('[/]', \MesaController::class . ':crearUno')
  ->add(new MAutenticacionTipoUsuario(array("mozo","cocinero", "cervecero", "bartender", "pastelero", "socio")));

  $group->put('/{numeroMesa}', \MesaController::class . ":actualizar")
  ->add(new MAutenticacionTipoUsuario(array("mozo", "socio")));

  $group->put('/cobrarCuenta/{numeroMesa}', \MesaController::class . ":cobrarCuenta")
  ->add(new MAutenticacionTipoUsuario(array("mozo", "socio")));

  $group->delete('/{numeroMesa}', \MesaController::class . ":eliminar")
  ->add(new MAutenticacionTipoUsuario(array("mozo", "socio")));

})->add(new MValidacionToken());

$app->group('/reportes', function (RouteCollectorProxy $group) {
  
  $group->get('/pedidos/pedidosDemorados', \ReportesController::class . ':pedidosDemorados')
  ->add(new MAutenticacionTipoUsuario(array("socio")));

  $group->get('/pedidos/porUsuario/{id}', \ReportesController::class . ':pedidosPorUsuario')
  ->add(new MAutenticacionTipoUsuario(array("socio")));
  
  $group->get('/pedidos/cantidadPorUsuario/{id}', \ReportesController::class . ':cantidadPedidosPorUsuario')
  ->add(new MAutenticacionTipoUsuario(array("socio")));
  
  $group->get('/mesas/masUsada', \ReportesController::class . ':mesaMasUsada')
  ->add(new MAutenticacionTipoUsuario(array("socio")));

})->add(new MValidacionToken());

$app->post('/login', \LoginController::class . ':loginUsuario')
->add(new MValidacionLogin());

$app->run();