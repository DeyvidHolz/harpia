<?php Layout::use('panel') ?>
<?php Component::import('hpanel/sidebar') ?>

<div class="container mt-3">
  <h2 class="text-center">Bem-vindo ao HPanel</h2>
  <hr>
</div>

<div class="container">
  <div class="hp-tooltips">

    <div class="hp-tooltip-card">
      <h4 class="hp-tooltip-icon-hover-info">Informações</h4>
      <div><span class="mdi mdi-information hp-tooltip-icon hp-tooltip-icon-hover-info"></span></div>
    </div>

    <div class="hp-tooltip-card">
      <h4 class="hp-tooltip-icon-hover-success">Usuários</h4>
      <div><span class="mdi mdi-account-multiple hp-tooltip-icon hp-tooltip-icon-hover-success"></span></div>
    </div>

    <div class="hp-tooltip-card">
      <h4>Postagens</h4>
      <div><span class="mdi mdi-folder-multiple hp-tooltip-icon"></span></div>
    </div>

    <div class="hp-tooltip-card">
      <h4 class="hp-tooltip-icon-hover-warning">Modo de Edição</h4>
      <div><span class="mdi mdi-pencil-box-multiple hp-tooltip-icon hp-tooltip-icon-hover-warning"></span></div>
    </div>

    <div class="hp-tooltip-card">
      <h4 class="hp-tooltip-icon-hover-power">Cores Padrões</h4>
      <div><span class="mdi mdi-palette hp-tooltip-icon hp-tooltip-icon-hover-power"></span></div>
    </div>

  </div>
</div>

<?php Layout::use('panel.end') ?>