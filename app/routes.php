<?php

Route::get('/', function() {
  Package::use('harpia/BRFormat');
  Package::use('harpia/Validator');
  Core::useModel('User');

  echo '<pre>';
  echo 'Hello World:<br><hr>';

  // $exe = executeQuery("INSERT INTO users2 (login) VALUES ('deyvidholz')");

});