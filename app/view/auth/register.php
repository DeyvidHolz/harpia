<?php Layout::use('header'); ?>

<div class="container full-screen center">
  <form method="POST" action="./auth/register">
    <div class="card defined">
      <div class="row">

        <div class="col-12">
          <div class="title center">
            Registre-se
          </div>
        </div>

        <?php if (get('auth.error') !== 'undefined') { ?>
        <div class="col-12 text-center">
          <span class="text-danger"><?= get('auth.error') ?></span>
        </div>
        <?php unset($_SESSION['auth.error']); } ?>

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

        <div class="col-6">
          <small>Já tem uma conta? <a class="text-primary font-weight-bold" href="./login">Entrar</a></small>
        </div>

        <div class="col-6 text-right">
          <button class="btn btn-success">Cadastrar</button>
        </div>

      </div>
    </div>
  </form>
</div>

<?php Layout::use('header.end'); ?>