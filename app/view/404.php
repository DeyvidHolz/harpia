<?php Layout::use('header'); ?>
<?php $img = empty(APP_CONTENT_PAGE_404_IMAGE) ? asset('img/404.png') : storage(APP_CONTENT_PAGE_404_IMAGE); ?>

<div class="container full-screen center">
  <img src="<?= $img ?>" alt="<?= get('text') ?>" width="400">
  <h2 class="mt-4"><?= get('text') ?></h2>
  <a href="./" class="btn btn-outline-primary mt-5"><span class="mdi mdi-undo mr-2"></span> Voltar</a>
</div>

<?php Layout::use('header.end'); ?>