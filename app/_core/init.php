<?php

require_once "../app/_core/functions.php";

require_once "../app/_core/Core.php";
require_once "../app/_core/ErrorHandler.php";
require_once "../app/_core/Route.php";
require_once "../app/_core/View.php";
require_once "../app/_core/Package.php";
require_once "../app/_core/MySQL.Response.php";
require_once "../app/_core/Model.php";

require_once "../app/_core/_packages/ImageHandler.php";
require_once "../app/_core/_packages/FileHandler.php";

require_once "../app/_core/Resource.php";
require_once "../app/_core/Layout.php";
require_once "../app/_core/Component.php";

require_once "../app/config.php";
require_once "../app/routes.php";
require_once "../app/global.packages.php";

if (SESSION_AUTO_START) session_start();

date_default_timezone_set(CONF_DEFAULT_TIMEZONE);

if (DB_FUNC_CREATE_TABLES) {
  require_once "../app/_table.create.order.php";
}

// @TODO: melhorar código para ficar mais legível.

// Defining URL and DOMAIN
$url = '';
$url = isset($_SERVER['REQUEST_SCHEME']) ? $_SERVER['REQUEST_SCHEME'].'://' : '';
$url .= $_SERVER['SERVER_NAME'];
if (isset($_SERVER['SERVER_PORT'])) $url .= ':'.$_SERVER['SERVER_PORT'];

$url .= $_SERVER['REQUEST_URI'];
define('URL', $url);

$publicPath = sprintf("%s://%s%s", $_SERVER['REQUEST_SCHEME'], $_SERVER['SERVER_NAME'], $_SERVER['SCRIPT_NAME']);
$publicPath = str_replace('index.php', '', $publicPath);
define('PUBLIC_PATH', $publicPath);

// Defining PATH
$path = isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : '/';
$params = [];
$routeNotValid = false;

// @Session: searching params

$route = null;
if (isset($routes[$path])) $route = $routes[$path];

$paramPath = explode('/', $path);
unset($paramPath[0]);
$paramPath = array_values($paramPath);

if (!$route) {
  foreach($routes as $index => $r) {

    if ($route) {
      break;
    }

    $routeNotValid = false;

    if (count($r['truePathSplit']) === count($paramPath)) {
      // Split count is equal, checking route $r has any params

      foreach ($r['truePathSplit'] as $i => $rpath) {
        $match = preg_match('/^\{(.+)\}$/i', $rpath);

        if ($match) {
          // It's a parameter
          $p = preg_replace('/([^A-Za-z0-9])/', '', $rpath);
          $params[$p] = $paramPath[$i];
        } else {
          if ($paramPath[$i] !== $rpath) {
            $routeNotValid = true;
            break;
          }
        }
      }

      if (!$routeNotValid && count($params)) {
        $route = $r;
        break;
      }
    }
  }
}

// Getting route
if ($route) {
  $route = Route::getRoute($route, $params);
}

define('DIR_PUBLIC', PUBLIC_PATH.'/');
define('DIR_ASSETS', PUBLIC_PATH.directory_assets.'/');
define('DIR_STORAGE', PUBLIC_PATH.directory_storage);

if ($route) {
  define('PATH', $path);

  // Checking maintenance routes
  if (IN_MAINTENANCE) {
    if (URL_MAINTENANCE === '*') {
      http_response_code(503);
      view(VIEW_SERVICE_UNAVAILABLE);
      exit;
    } else {
      $url = URL;
      $maintenanceURL = URL_MAINTENANCE;
      $regex = preg_replace('/\//', '\/', $maintenanceURL);
      $regex = '/' . $regex . '/';
      if (preg_match($regex, $url)) {
        http_response_code(503);
        view(VIEW_SERVICE_UNAVAILABLE);
        exit;
      }
    }
  }

  // Preparing route
  if (!is_object($route->controller)) {
    $controller = explode('@', $route->controller);
    $controllerName = $controller[0];
    $controllerMethod = isset($controller[1]) ? $controller[1] : '';

    if (empty($controllerMethod)) {
      harpErr(['Route Error<Controller>' => "Route '$path': controller: '$controllerName' method is empty.", 'Example' => 'Correct usage: controllerName@controllerMethod'],__LINE__,__FILE__);
      die;
    }

    require_once "../app/controller/" . $controllerName . ".php";

    $controller = new $controllerName;
    if (method_exists($controller, $controllerMethod)) {
      $controller->$controllerMethod(Core::getRequest(['route' => $route, 'routeParams' => $params]));
    } else {
      harpErr(['Route Error<Controller>' => "Route '$path': controller: '$controllerName' method '$controllerMethod()' not found."],__LINE__,__FILE__);
      die;
    }
  } else {
    call_user_func_array($route->controller, Core::getRequest(['route' => $route, 'routeParams' => $params], true));
  }
  
} else {
  http_response_code(404);
  view(VIEW_NOT_FOUND);
}

exit;