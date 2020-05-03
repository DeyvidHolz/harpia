<?php

// @Config: DB_FUNC_CREATE_TABLES (def: true)
// To fix Foreign Key errors, use this file to create your database tables in order.

const CREATE_DEFAULT_DATA = true;

foreach (scandir("../app/model/") as $filename) {
  $path = "../app/model/" . '/' . $filename;
  if (is_file($path)) {
    require $path;
  }
}

// Write below

AppContent::createDbTable([
  'name' => AppContent::$table,
  'columns' => [
    'id' => 'INT NOT NULL PRIMARY KEY AUTO_INCREMENT',
    'ref' => 'VARCHAR(255)',
    'type' => 'VARCHAR(255)',
    'content' => 'MEDIUMTEXT',
    'action' => 'VARCHAR(255)',
  ],
  'foreignKeys' => [], 
]);

User::createDbTable([
  'name' => User::$table,
  'columns' => [
    'id' => 'INT NOT NULL PRIMARY KEY AUTO_INCREMENT',
    'name' => 'VARCHAR(60) NOT NULL',
    'login' => 'VARCHAR(200) NOT NULL',
    'email' => 'VARCHAR(256)',
    'password' => 'VARCHAR(256) NOT NULL',
  ],
  'foreignKeys' => [
    // 'modelColumn' => 'tableReferenced|id|onUpdate:cascade',
  ], 
  'option.createTimestampColumns' => true,
]);

PermissionGroup::createDbTable([
  'name' => PermissionGroup::$table,
  'columns' => [
    'id' => 'INT NOT NULL PRIMARY KEY AUTO_INCREMENT',
    'name' => 'VARCHAR(256) NOT NULL',
    'permissions' => 'MEDIUMTEXT NOT NULL',
  ],
  'foreignKeys' => [
    // 'modelColumn' => 'tableReferenced|id|onChange:cascade',
  ],
]);

Permission::createDbTable([
  'name' => Permission::$table,
  'columns' => [
    'id' => 'INT NOT NULL PRIMARY KEY AUTO_INCREMENT',
    'group_id' => 'INT',
    'user_id' => 'int NOT NULL',
  ],
  'foreignKeys' => [
    'group_id' => PermissionGroup::$table.'|id|onChange:cascade',
    'user_id' => User::$table.'|id|onChange:cascade',
  ],
]);

Post::createDbTable([
  'name' => Post::$table,
  'columns' => [
    'id' => 'INT NOT NULL PRIMARY KEY AUTO_INCREMENT',
    'user_id' => 'INT',
    'title' => 'VARCHAR(256) NOT NULL',
    'subtitle' => 'VARCHAR(256) NOT NULL',
    'categories' => 'MEDIUMTEXT',
    'content' => 'MEDIUMTEXT NOT NULL',
    'images' => 'MEDIUMTEXT',
    'slug' => 'VARCHAR(256) NOT NULL',
  ],
  'foreignKeys' => [
    // 'modelColumn' => 'tableReferenced|id|onUpdate:cascade',
    'user_id' => User::$table . '|id|onChange:cascade',
  ],
]);

if (CREATE_DEFAULT_DATA) {
  if (!User::getAll()) {
    $user = new User();
    $user->name = 'Admin';
    $user->login = 'admin';
    $user->password = 'admin';
    $user->createHash();
    User::save($user);
  }
  
  $pg = new PermissionGroup();
  $pg->name = 'admin';
  $pg->permissions = '*';
  $pg->create();
  
  if (!Permission::getAll()) {
    $p = new Permission();
    $p->group_id = 1;
    $p->user_id = 1;
    Permission::save($p);
  }

  if (!AppContent::getAll()) {
    $create = [
      'email_main' => 'example@example.com',
      'email_contact' => 'contact@example.com',
      'email_noreply' => 'noreply@example.com',
      'phone' => '0000000000',
      'whatsapp' => '00000000000',
      'address' => '',
      'social_facebook' => '#',
      'social_instagram' => '#',
      'social_linkedin' => '#',
      'social_youtube' => '#',
      'page_title' => 'Harpia App',
      'meta_description' => 'Harpia Application',
      'meta_keywords' => 'application, harpia',
      'app_maintenance_url' => '',
      'app_maintenance_active' => '0',
      'app_maintenance_text' => 'Estamos em manutenção, tente novamente mais tarde.',
      'app_page_404_text' => 'Erro 404 | Página não encontrada.',
      'page_503_image' => '',
      'page_404_image' => '',
    ];

    foreach ($create as $ref => $content) {
      $appContent = new AppContent();
      $appContent->ref = $ref;
      $appContent->content = $content;
      AppContent::save($appContent);
    }

  }
}