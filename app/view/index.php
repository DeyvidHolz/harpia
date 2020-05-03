<?php Layout::use('header'); ?>

<div class="container full-screen center">
  <img src="<?= asset('img/harpia.png') ?>" height="300" style="border-bottom-left-radius: 1rem">
  <h2 class="mt-4">Welcome to your new Harpia Application</h2>

  <div class="row">

    <div class="col-6">
      <a href="./logout" class="btn btn-danger">Logout</a>
    </div>
    <div class="col-6">
      <a href="./painel" class="btn btn-primary">Panel</a>
    </div>

  </div>

</div>

<?php Layout::use('header.end'); ?>
