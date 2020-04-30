<?php

// URL Dinamica (Parametros)
Route::get('/post/:post', function($request) {
  $postagens = [
    'postagem-muito-legal' => [
      'titulo' => 'Postagem muito legal, título legal também!',
      'conteudo'  => 'Lorem ipsum dolor sit amet...'
    ],
    'postagem-top' => [
      'titulo' => 'Postagem top de linha!',
      'conteudo'  => 'Outro lorem ipsum dolor sit amet...'
    ],
    'postagem-usios'  => [
      'titulo' => 'Sobre a Usios',
      'conteudo'  => 'Mais um lorem ipsum dolor sit amet...'
    ],
  ];

  if (isset($postagens[$request->param->post])) {
    $postagem = $postagens[$request->param->post];

    echo sprintf("<h1 style='color:green'>%s</h1><div>%s</div>", $postagem['titulo'], $postagem['conteudo']);
    echo '<hr>';
    echo '<h3>Deixa eu adivinhar, na URL está "<span style="color:red">' . $request->param->post . '</span>", certo?! ;)';
  } else {
    echo '<div style="width: 100vw; height: 100vh; display: flex; align-items: center; justify-content: center"> <h1 style="color:red">Oops, postagem não encontrada :(</h1> </div>';
  }
});

// Views com layouts
Route::get('/', 'MainController@index');

// Manutenção em path específico
Route::get('/painel', function() {
  echo '<h1>Painel: início</h1>';
});

Route::get('/painel/usuarios', function() {
  echo '<h1>Painel: lista</h1>';
});

// Vendo usuário dinamicamente
Route::get('/painel/usuario/:user', function($req) {
  Layout::use('header');
  echo '<h1>Painel: visualizando usuario '.$req->param->user.'</h1>';
  Layout::use('header.end');
});

// Rota sem view, retornando função
Route::get('/sem-view', function() {
  echo '<h1>Rota sem view</h1>';
});

// Rota com Controller sem método (demonstração de erro)
Route::get('/erro1', 'MainController');

// Rota com método de controller inválido (demonstração de erro)
Route::get('/erro2', 'MainController@metodoCoronavirus');

// Passando dados para rota e exibindo na view
Route::get('/dados', function() {
  return view('index', [
    'nome' => 'Harpia',
    'versao' => '1.1'
  ]);
});

// Permitido apenas post (envio de dados)
Route::post('/cadastrar', function() {
  response('Cadastrado com sucesso!');
});