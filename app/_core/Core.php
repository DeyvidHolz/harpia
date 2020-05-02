<?php

class Core
{

  public static function useModel($path) 
  {
    require_once "../app/model/$path.php";
  }

  public static function getRequest(Array $data, $returnArray = false) {
    $request = new stdClass();

    if (isset($data['route'])) {
      $request->routePath = $data['route']->path;
      $request->routeMethod = $data['route']->method;
      $request->controller = is_callable($data['route']->controller) ? 'null@function' : $data['route']->controller;

      $request->controller = explode('@', $request->controller);
      $request->controllerMethod = $request->controller[1];
      $request->controller = $request->controller[0];

      $request->param = new stdClass();
      
      if (isset($data['routeParams'])) {
        foreach ($data['routeParams'] as $param => $value) {
          $tempParam = str_replace(':', '', $param);
          $tempParam = str_replace('-', '_', $tempParam);

          $request->param->$tempParam = $value;
        }
      }

      $request->method = $_SERVER['REQUEST_METHOD'];
      $request->uri = $_SERVER['REQUEST_URI'];
      $request->script = $_SERVER['SCRIPT_NAME'];

      $request->query = new stdClass();
      if (isset($_SERVER['QUERY_STRING'])) {
        $qs = explode('=', $_SERVER['QUERY_STRING']);
        foreach($qs as $index => $query) {
          if (!empty($query)) {
            $tempQuery = preg_replace('/[^a-zA-Z0-9]/', '', $query);
            if ($index % 2 === 0) {
              $request->query->$tempQuery = isset($qs[$index+1]) ? $qs[$index+1] : null;
            }
          }
        }
      }

      $request->body = new stdClass();
      if (!empty($_POST)) {
        foreach($_POST as $index => $value) {
          $tempBody = preg_replace('/[^a-zA-Z0-9]/', '', $index);
          $request->body->$tempBody = $value;
        }
      }

      $request->file = new stdClass();
      if (!empty($_FILES)) {
        foreach($_FILES as $index => $value) {
          $tempFileIndex = preg_replace('/[^a-zA-Z0-9]/', '', $index);
          $request->file->$tempFileIndex = $value;
        }
      }

    }

    return $returnArray ? [$request] : $request;
  }

}