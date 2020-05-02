<?php Layout::use('panel') ?>
<?php Component::import('hpanel/sidebar') ?>

<div class="pt-5"></div>

<form method="post" action="<?= PUBLIC_PATH ?>painel/user/edit">
  <input type="hidden" name="id" value="<?= get('id') ?>">

  <div class="hp-container swift-box-shadow defined">
    <h2 class="text-center">Editar Usuário</h2>

    <?php if (get('auth.userCreated') !== 'undefined') { ?>
    <div class="text-center">
      <span class="text-success"><?= get('auth.userCreated') ?></span>
    </div>
    <?php unset($_SESSION['auth.userCreated']); } ?>

    <?php if (get('auth.error') !== 'undefined') { ?>
    <div class="text-center">
      <span class="text-danger"><?= get('auth.error') ?></span>
    </div>
    <?php unset($_SESSION['auth.error']); } ?>

    <div class="row">

      <div class="col-12">
        <div class="md-form">
          <input type="text" id="name" class="form-control" name="name" value="<?= get('name') ?>">
          <label for="name">Nome</label>
          <?php if (get('auth.error.name') !== 'undefined') { ?>
            <div class="text-danger"><?= get('auth.error.name') ?></div>
          <?php unset($_SESSION['auth.error.name']); } ?>
        </div>
      </div>

      <div class="col-12">
        <div class="md-form">
          <input type="text" id="login" class="form-control" name="login" value="<?= get('login') ?>">
          <label for="login">Nome de usuário</label>
          <?php if (get('auth.error.login') !== 'undefined') { ?>
            <div class="text-danger"><?= get('auth.error.login') ?></div>
          <?php unset($_SESSION['auth.error.login']); } ?>
        </div>
      </div>

      <div class="col-12">
        <div class="md-form">
          <input type="password" id="password" class="form-control" name="password" placeholder="Mantenha em branco para não alterar">
          <label for="password">Senha</label>
          <?php if (get('auth.error.password') !== 'undefined') { ?>
            <div class="text-danger"><?= get('auth.error.password') ?></div>
          <?php unset($_SESSION['auth.error.password']); } ?>
        </div>
      </div>

      <div class="col-12 text-center">
        <button class="btn btn-primary" onclick="saveNewUser()">
          <span class="mdi mdi-content-save"></span> Salvar
        </button>
      </div>

    </div>

  </div>
</form>

<?php Layout::use('panel.end') ?>