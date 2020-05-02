<?php Layout::use('panel') ?>
<?php Component::import('hpanel/sidebar') ?>

<div class="pt-5"></div>

<div class="container mt-3">
  <h2 class="text-center">Lista de usuários</h2>
  <hr>

  <?php if (get('view.message') !== 'undefined') { ?>
  <h4 class="text-success text-center mb-5"><?= get('view.message') ?></h4>
  <?php unset($_SESSION['view.message']); } ?>

  <?php if (get('view.message.error') !== 'undefined') { ?>
  <h4 class="text-danger text-center mb-5"><?= get('view.message.error') ?></h4>
  <?php unset($_SESSION['view.message.error']); } ?>

  <div class="row">

  <?php foreach (get('users') as $user) { ?>
  <div class="col-12 col-md-6 col-lg-4">
    <div class="card hp-container-contain swift-box-shadow card-user">
      <h3><?= $user->name ?></h3>
      <p>
        <strong>Login:</strong> <?= $user->login ?><br>
      </p>

      <div class="footer">
        <form method="post" action="<?= PUBLIC_PATH ?>painel/user/delete" class="d-inline-block">
          <input type="hidden" name="id" value="<?= $user->id ?>">
          <button class="btn btn-danger btn-sm mr-2" onclick="return confirm('Deseja apagar este usuário?')"
          <?php echo ($user->id === '1' || $user->id === 1) ? 'disabled' : '' ?>
          >
            <span class="mdi mdi-close mr-2"></span> Deletar
          </button>
        </form>

        <a class="btn btn-primary btn-sm" href="<?= PUBLIC_PATH ?>painel/usuario/<?= $user->id ?>">
          <span class="mdi mdi-account-edit mr-2"></span> Alterar
        </a>
      </div>
    </div>

  </div>
  <?php } ?>

</div>

<?php Layout::use('panel.end') ?>