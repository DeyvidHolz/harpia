<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>
    <?php echo get('page.title') !== 'undefined' ? str_replace('{app_name}', APP_NAME, get('page.title')) : APP_NAME ?>
  </title>

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@300;400;700&display=swap" rel="stylesheet">

  <!-- Main -->
  <link rel="stylesheet" href="<?= asset('css/main.css') ?>">

  <!-- Material Design Icons -->
  <link rel="stylesheet" href="https://cdn.materialdesignicons.com/5.0.45/css/materialdesignicons.min.css">

  <!-- Bootstrap -->
  <link rel="stylesheet" href="<?= asset('css/bootstrap/bootstrap.min.css') ?>">
  <link rel="stylesheet" href="<?= asset('css/bootstrap/bootstrap-grid.min.css') ?>">
  <link rel="stylesheet" href="<?= asset('css/bootstrap/bootstrap-reboot.min.css') ?>">
  
  <!-- MDBootstrap -->
  <link rel="stylesheet" href="<?= asset('css/mdb/mdb.min.css') ?>">

  <!-- jQuery -->
  <script type="text/javascript" src="<?= asset('js/jquery/jquery-3.4.1.min.js') ?>"></script>
  <script type="text/javascript" src="<?= asset('js/jquery/jquery.mask.js') ?>"></script>

  <!-- Harpia Components -->
  <script type="text/javascript" src="<?= asset('js/harpia.components.js') ?>"></script>
</head>
<body>
