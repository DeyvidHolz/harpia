<?php Layout::use('header'); ?>

<div class="container full-screen center">
    <img src="<?= asset('img/503.png') ?>" alt="<?= get('text') ?>" width="350">
    <h2 class="mt-4"><?= get('text') ?></h2>
    <a href="./" class="btn btn-outline-primary mt-5"><span class="mdi mdi-undo mr-2"></span> Voltar</a>
</div>

<?php Layout::use('header.end'); ?>