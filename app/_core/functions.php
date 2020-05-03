<?php

function view($path, $data = null) {
  @session_start();
  if (isset($_SESSION['HARPIA_REDIRECT_DATA'])) {
    $data['@redirect_data'] = $_SESSION['HARPIA_REDIRECT_DATA'];
    unset ($_SESSION['HARPIA_REDIRECT_DATA']);
  }
  $view = new View($path, $data);
  return $view->get();
}

function get($index = null, $displayNulls = !PRODUCTION, $returnUndefinedToFalse = false) {
  global $__VIEW_DATA;

  if (!$index) return empty($__VIEW_DATA) ? $returnUndefinedToFalse ? false : 'undefined' : $__VIEW_DATA;

  if ($displayNulls === '@') $displayNulls = !PRODUCTION;

  if (isset($__VIEW_DATA[$index])) {
    return $__VIEW_DATA[$index];
  } else if (isset($_SESSION[$index])) {
    return $_SESSION[$index];
  } else {
    return $displayNulls ? $returnUndefinedToFalse ? false : 'undefined' : '';
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

function executeQuery($query, $onlyIfChanged = false) {
  // Set $onlyIfChanged = true to return only with anything was change on the database.

  $stmt = getConnection()->prepare($query);
  if ($stmt->execute()) {
    $stmtInfo = [
      'query' => $query,
      'errorCode' => $stmt->errorInfo()[1],
      'error' => null,
      'fetch' => $stmt->fetchAll(),
      'executed' => true
    ];

    if ($onlyIfChanged && $stmt->rowCount()) {
      return new MySQLResponse($stmtInfo);
    } else {
      return new MySQLResponse($stmtInfo);
    }
    
  }

  $stmtInfo = [
    'query' => $query,
    'errorCode' => $stmt->errorInfo()[1],
    'error' => (isset($stmt->errorInfo()[2]) && !empty($stmt->errorInfo()[2])) ? $stmt->errorInfo()[2] : false,
    'fetch' => null,
    'executed' => false
  ];
  
  return new MySQLResponse($stmtInfo);
}

function executed(MySQLResponse $db) {
  return $db->executed;
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
  exit;
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

function storage($path) {
  return DIR_PUBLIC.'storage/'.$path;
}

function redirect($route, $data = null) {
  if ($route{0} === '@') $route = preg_replace('/^@\/?/', PUBLIC_PATH, $route);
  if ($data) {
    @session_start();
    $_SESSION['HARPIA_REDIRECT_DATA'] = $data;
  }
  header("Location: $route");
  exit;
}

function debug($var, $ref = null) {
  echo '<pre>';
  echo '<span style="color: #2770e6"><strong>Debugging:</strong>&nbsp;'.$ref.'</span><br><br>';
  print_r($var);
  echo '<hr>';
  echo '</pre>';
}

function getPageTitle() {
  $pageTitle = get('page_title');

  if (empty($pageTitle) || $pageTitle === 'undefined') return APP_CONTENT_PAGE_TITLE ? APP_CONTENT_PAGE_TITLE : APP_NAME;

  if (APP_CONTENT_PAGE_TITLE && !empty(APP_CONTENT_PAGE_TITLE)) {
    return str_replace('{app_name}', APP_CONTENT_PAGE_TITLE, $pageTitle);
  } else {
    return str_replace('{app_name}', APP_NAME, $pageTitle);
  }
}