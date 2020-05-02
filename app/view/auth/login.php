<?php Layout::use('header'); ?>

<div class="container full-screen center">
  <form method="POST" action="./auth/login">
    <div class="card defined">
      <div class="row">

        <div class="col-12">
          <div class="title center">
            Login
          </div>
        </div>

        <?php if (get('auth.registered') !== 'undefined') { ?>
        <div class="col-12 text-center">
          <span class="text-success"><?= get('auth.registered') ?></span>
        </div>
        <?php unset($_SESSION['auth.registered']); } ?>

        <?php if (get('auth.error') !== 'undefined') { ?>
        <div class="col-12 text-center">
          <span class="text-danger"><?= get('auth.error') ?></span>
        </div>
        <?php unset($_SESSION['auth.error']); } ?>

        <div class="col-12">
          <div class="md-form">
            <input type="text" id="login" class="form-control" name="login">
            <label for="login">Nome de usuário</label>
          </div>
        </div>

        <div class="col-12">
          <div class="md-form">
            <input type="password" id="password" class="form-control" name="password">
            <label for="password">Senha</label>
          </div>
        </div>

        <div class="col-6">
          <small>Não tem uma conta? <a class="text-primary font-weight-bold" href="./register">Clique aqui</a></small>
        </div>

        <div class="col-6 text-right">
          <button class="btn btn-primary">Entrar</button>
        </div>

      </div>
    </div>
  </form>
</div>

<?php Layout::use('header.end'); ?>