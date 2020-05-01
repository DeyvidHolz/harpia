<?php

Route::get('/', function() {
  Package::use('harpia/Validator');

  echo '<pre>';
  echo 'Hello World:<br><hr>';

  $name = 'Harpia';

  print_r(

    Validator::get([
      [$name => 'length:1-6', 'nome' => 'field']
    ])

  );

});