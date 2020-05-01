<?php

$routes = [];

function setRoute(Route $route) {
  global $routes;

  $path = $route->path;
  $path = preg_replace('/(\{(.+?)\})/', '*', $path);

  $paramCount = preg_match_all('/(\{(.+?)\})/' , $route->path, $matches);
  if (isset($matches[0]) && is_array($matches[0])) {
    $matches = $matches[0];
  }

  $truePathSplit = explode('/', $route->path);
  unset($truePathSplit[0]);
  $truePathSplit = array_values($truePathSplit);


  $routes[$path] = [
    'checkPath' => $path,
    'truePath' => $route->path,
    'truePathSplit' => $truePathSplit,
    'params' => $matches,
    'paramCount' => $paramCount,
    'controller' => $route->controller,
  ];

}

class Route 
{

  public $path = '';
  public $method = '';
  public $controller = '';
  public $params = [];

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

  public static function getRoute(Array $arrRoute, $params = null) {
    global $routes;
    
    $route = new Route();
    $route->path = $arrRoute['checkPath'];
    $route->method = $_SERVER['REQUEST_METHOD'];
    $route->controller = $arrRoute['controller'];
    $route->params = $params;

    return $route;
  }

}