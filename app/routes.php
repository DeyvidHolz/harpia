<?php

Route::get('/', function () {
  view('index', ['page_title' => 'Página Inicial - {app_name}']);
});

// Painel
Route::get('/painel', 'PanelController@index');
Route::get('/painel/info/save', 'PanelController@saveAppContent');
Route::get('/painel/info/ads', 'PanelController@infoAds');
Route::get('/painel/info/seo', 'PanelController@infoSeo');
Route::get('/painel/info', 'PanelController@info');

// - Usuário
Route::get('/painel/usuarios', 'PanelController@viewAll');
Route::get('/painel/usuario/{id}', 'PanelController@editUser');
Route::get('/painel/usuario/novo', 'PanelController@newUser');

Route::post('/painel/user/new', 'PanelController@newUserAction');
Route::post('/painel/user/edit', 'PanelController@editUserAction');
Route::post('/painel/user/delete', 'PanelController@deleteUserAction');

// - Blog
Route::get('/painel/post/novo', 'PanelController@newPost');
Route::get('/painel/post/editar/{id}', 'PanelController@editPost');
Route::get('/painel/post/lista', 'PanelController@viewAllPosts');

Route::post('/painel/post/new', 'PanelController@newPostAction');
Route::post('/painel/post/edit', 'PanelController@editPostAction');
Route::post('/painel/post/delete', 'PanelController@deletePostAction');

// - Gallery
Route::post('/painel/gallery/add', 'PanelController@addImageToStorage');
Route::post('/painel/gallery/delete', 'PanelController@deleteFileFromStorage');
Route::get('/painel/galeria/add', 'PanelController@viewAddImage');
Route::get('/painel/galeria', 'PanelController@viewAllStorageImages');

// - Configurations
Route::get('/painel/config/site', 'PanelController@configSite');

// /Painel

// Authentication routes
Route::get('/login', function () {
  view('auth/login', ['page_title' => 'Login - {app_name}']);
});

Route::get('/register', function() {
  view('auth/register', ['page_title' => 'Crie uma conta - {app_name}']);
});

Route::get('/logout', 'AuthController@logout');

Route::post('/auth/login', 'AuthController@checkLogin');
Route::post('/auth/register', 'AuthController@register');
// /Authentication routes