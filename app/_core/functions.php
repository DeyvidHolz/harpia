<?php

function view($path, $data = null) {
  $view = new View($path, $data);
  return $view->get();
}

function get($index, $displayNulls = !PRODUCTION) {
  global $__VIEW_DATA;

  if (isset($__VIEW_DATA[$index])) {
    return $__VIEW_DATA[$index];
  } else {
    return $displayNulls ? '[null]' : '';
  }
}

function response($arr = 'null', $code = 200, $options = []) {

  if (!isset($options['Access-Control-Allow-Origin'])) $options['Access-Control-Allow-Origin'] = [APP_URL];
  if (!isset($options['Content-Type'])) $options['Content-Type'] = "application/json; charset=utf-8";
  if (!isset($options['Access-Control-Allow-Methods'])) $options['Access-Control-Allow-Methods'] = 'GET, POST, OPTIONS';

  // Access-Control-Allow-Origin
  foreach($options['Access-Control-Allow-Origin'] as $allowedURL) {
    header("Access-Control-Allow-Origin: $allowedURL");
  }

  // Access-Control-Allow-Methods
  header("Access-Control-Allow-Methods: " . $options['Access-Control-Allow-Methods']);

  // Content-Type
  header("Content-Type: " . $options['Content-Type']);

  // HTTP Response Code
  http_response_code($code);

  if (is_array($arr)) {
    echo json_encode($arr);
  } else {
    echo json_encode(['message' => $arr]);
  }
}

function getConnection($charset = 'utf8') {
  try {
    $connection = new PDO("mysql:host=".DB_HOST.";dbname=".DB_DATABASE.';charset=' .$charset, DB_USER, DB_PASSWORD);
    return $connection;
  } catch (Exception $e) {
      echo '<h2>Failed to connect to the database. Error: '.$e->getMessage().'<h2>';
  }
}

function createInstance(String $class, stdClass $object) {
  $class = new $class($object);
  return $class;
}

function harpErr($err, $line, $file) {
  if (!PRODUCTION)

  if (!is_array($err)) $err = [$err];

  $strErr = '';
  foreach($err as $index => $error) {
    $strErr .= '[<span style="color:#e00b2b">' . $index . '</span>] -> ' . $error . '<hr style="background:white;border-color:white">';
  }

  $err = $strErr;

  $production = PRODUCTION ? 'true' : 'false';

  echo sprintf('
    <style>
      .harpia_error {
        z-index: 100000;
        background: #272727;
        position: fixed;
        top: 0; left: 0; bottom: 0; right: 0;
        width: 100vw;
        height: 100vh;
        color: #fff;
        padding: 1rem;
      }
    </style>

    <div class="harpia_error">
      <h2>HarpErr::%s<%s>
      <div>%s</div>

      <div style="position: absolute; bottom:5rem; text-align: center; width:100vw;">HARPIA_ERROR_INFORMATION | PRODUCTION_MODE (config::PRODUCTION): ' . 
      $production
      . '</div>
    </div>
  ', $file, $line, $err);
}

function parseJSON($var, $echo = true) {
  try {
    if ($echo) {
      echo json_encode($var);
    } else {
      return $var;
    }
  } catch (Exception $e) {
    if ($echo) {
      echo 'undefined';
    } else {
      return 'undefined';
    }
  }
}

function asset($path) {
  return DIR_ASSETS.$path;
}

function assets($path) {
  return DIR_ASSETS.$path;
}