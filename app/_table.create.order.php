<?php

// @Config: DB_FUNC_CREATE_TABLES (def: true)
// To fix Foreign Key errors, use this file to create your database tables in order.

foreach (scandir("../app/model/") as $filename) {
  $path = "../app/model/" . '/' . $filename;
  if (is_file($path)) {
      require $path;
  }
}

// Write below

User::createDbTable([
  'name' => User::$table,
  'columns' => [
    'id' => 'INT NOT NULL PRIMARY KEY AUTO_INCREMENT',
    'name' => 'VARCHAR(60) NOT NULL',
    'login' => 'VARCHAR(200) NOT NULL',
    'email' => 'VARCHAR(256) NOT NULL',
    'password' => 'VARCHAR(256) NOT NULL',
  ],
  'foreignKeys' => [
    // 'modelColumn' => 'tableReferenced|id|onUpdate:cascade',
  ], 
  'option.createTimestampColumns' => true,
  'option.uniques' => ['login']
]);
