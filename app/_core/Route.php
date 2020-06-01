<?php

$routes = [
  'GET' => [],
  'POST' => [],
  'PATCH' => [],
  'PUT' => [],
  'DELETE' => [],
  'OPTIONS' => [],
];

function setRoute(Route $route, $method = 'GET') {
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


  $routes[$method][$path] = [
    'checkPath' => $path,
    'truePath' => $route->path,
    'truePathSplit' => $truePathSplit,
    'params' => $matches,
    'paramCount' => $paramCount,
    'controller' => $route->controller,
    'method' => $route->method,
  ];

}

class Route 
{

  public $path = '';
  public $method = '';
  public $controller = '';
  public $params = [];

  public static function get(String $path, $controller = null) 
  {
    $route = $route = self::_getMountedRouteObject($path, $controller, 'POST');
    setRoute($route);
  }

  public static function post(String $path, $controller = null) 
  {
    $route = self::_getMountedRouteObject($path, $controller, 'POST');
    setRoute($route, $route->method);
  }

  public static function patch(String $path, $controller = null) 
  {
    $route = self::_getMountedRouteObject($path, $controller, 'PATCH');
    setRoute($route, $route->method);
  }

  public static function delete(String $path, $controller = null) 
  {
    $route = self::_getMountedRouteObject($path, $controller, 'DELETE');
    setRoute($route, $route->method);
  }

  public static function put(String $path, $controller = null) 
  {
    $route = self::_getMountedRouteObject($path, $controller, 'PUT');
    setRoute($route, $route->method);
  }

  public static function options(String $path, $controller = null) 
  {
    $route = self::_getMountedRouteObject($path, $controller, 'OPTIONS');
    setRoute($route, $route->method);
  }

  public static function getRoute(Array $arrRoute, $params = null) 
  {
    $route = new Route();
    $route->path = $arrRoute['checkPath'];
    $route->method = $_SERVER['REQUEST_METHOD'];
    $route->controller = $arrRoute['controller'];
    $route->params = $params;

    return $route;
  }

  public static function _getMountedRouteObject($path, $controller, $method = 'GET') {
    if (!$controller) {
      harpErr(['Route Error' => "Route '$path': controller param not valid. Check the routes file."],__LINE__,__FILE__);
      die;
    }

    $route = new Route();
    $route->path = $path;
    $route->controller = $controller;
    $route->method = $method;
    return $route;
  }

}