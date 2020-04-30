<?php

$routes = [];

function setRoute(Route $route) {
  global $routes;

  $routes[$route->path.'@'.$route->method] = $route;
}

class Route 
{

  public $path = '';
  public $method = '';
  public $controller = '';

  public static function get(String $path, $controller = null) {
    if (!$controller) {
      harpErr(['Route Error' => "Route '$path': controller param not valid. Check the routes file."],__LINE__,__FILE__);
      die;
    }

    $route = new Route();
    $route->path = $path;
    $route->controller = $controller;
    $route->method = 'GET';
    setRoute($route);
  }

  public static function post(String $path, $controller = null) {
    if (!$controller) {
      harpErr(['Route Error' => "Route '$path': controller param not valid. Check the routes file."],__LINE__,__FILE__);
      die;
    }

    $route = new Route();
    $route->path = $path;
    $route->controller = $controller;
    $route->method = 'POST';

    setRoute($route);
  }

  public static function getRoute($path, $method) {
    global $routes;

    if (isset($routes[$path.'@'.$method])) {
      return $routes[$path.'@'.$method];
    }
    return false;
  }

}