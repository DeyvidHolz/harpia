<?php Layout::use('header'); ?>
<h1 style="text-align:center">Welcome to the new Harpia</h1>

<?php
if (!empty(get('nome')) && get('nome') !== '[null]') {
  echo '<h2>Nome: '.get('nome').'</h2>';
  echo '<h2>Versão: '.get('versao').'</h2>';
}
?>
<?php Layout::use('header.end'); ?>