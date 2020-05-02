<?php

Route::get('/', function () {
  view('index');
});

// Painel

// - Usuário
Route::get('/painel', 'PanelController@index');
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
// /Painel

// Authentication routes
Route::get('/login', function () {
  view('auth/login');
});

Route::get('/register', function() {
  view('auth/register');
});

Route::get('/logout', 'AuthController@logout');

Route::post('/auth/login', 'AuthController@checkLogin');
Route::post('/auth/register', 'AuthController@register');
// /Authentication routes