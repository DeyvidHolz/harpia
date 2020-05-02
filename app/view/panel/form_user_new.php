<?php Layout::use('panel') ?>
<?php Component::import('hpanel/sidebar') ?>

<div class="pt-5"></div>

<form method="post" action="<?= PUBLIC_PATH ?>painel/user/new">
  <div class="hp-container swift-box-shadow defined">
    <h2 class="text-center">Adicionar Novo Usuário</h2>
    <?php if (get('auth.error') !== 'undefined') { ?>
    <div class="text-center">
      <span class="text-danger"><?= get('auth.error') ?></span>
    </div>
    <?php unset($_SESSION['auth.error']); } ?>

    <div class="row">

      <div class="col-12">
        <div class="md-form">
          <input type="text" id="name" class="form-control" name="name">
          <label for="name">Nome</label>
          <?php if (get('auth.error.name') !== 'undefined') { ?>
            <div class="text-danger"><?= get('auth.error.name') ?></div>
          <?php unset($_SESSION['auth.error.name']); } ?>
        </div>
      </div>

      <div class="col-12">
        <div class="md-form">
          <input type="text" id="login" class="form-control" name="login">
          <label for="login">Nome de usuário</label>
          <?php if (get('auth.error.login') !== 'undefined') { ?>
            <div class="text-danger"><?= get('auth.error.login') ?></div>
          <?php unset($_SESSION['auth.error.login']); } ?>
        </div>
      </div>

      <div class="col-12">
        <div class="md-form">
          <input type="password" id="password" class="form-control" name="password">
          <label for="password">Senha</label>
          <?php if (get('auth.error.password') !== 'undefined') { ?>
            <div class="text-danger"><?= get('auth.error.password') ?></div>
          <?php unset($_SESSION['auth.error.password']); } ?>
        </div>
      </div>

      <div class="col-12 text-center">
        <button class="btn btn-primary" onclick="saveNewUser()">
          <span class="mdi mdi-account-plus"></span> Criar novo usuário
        </button>
      </div>

    </div>

  </div>
</form>

<?php Layout::use('panel.end') ?>