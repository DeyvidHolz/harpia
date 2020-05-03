<?php Layout::use('panel') ?>
<?php Component::import('hpanel/sidebar') ?>

<div class="pb-5"></div>

<div class="container mt-3">
  <h2 class="text-center">Condfigurações - Site</h2>
  <hr>
</div>

<div class="hp-container swift-box-shadow defined-lg mb-5">
  <div class="row">

    <div class="col-12">
      <p class="text-center">As alterações serão salvas automaticamente.</p>
    </div>

    <div class="col-12">
      <div class="md-form form-sm mt-5">
        <input type="text" id="app_maintenance_url" class="form-control">
        <label for="app_maintenance_url">URL em Manutenção (Use * para todas as páginas)</label>
      </div>
    </div>

    <div class="col-12">
      <div class="md-form form-sm mt-5">
        <input type="text" id="app_maintenance_text" class="form-control">
        <label for="app_maintenance_text">Texto que será exibido</label>
      </div>
    </div>

    <div class="col-12 text-right">
      <button type="button" class="btn btn-grey" id="maintenance-button" disabled onclick="toggleMaintenance()">Desabilitado</button>
    </div>

  </div> <!-- /row -->
</div>

<script>
  let data = <?= get('appContent') ?>

  document.addEventListener('DOMContentLoaded', function() {
    setContent('app_maintenance_url', data.app_maintenance_url)
    setContent('app_maintenance_text', data.app_maintenance_text)

    let button = document.getElementById('maintenance-button');

    if (data.app_maintenance_active.content === '1') {
      button.innerHTML = 'Desativar manutenção';
    } else {
      button.innerHTML = 'Ativar manutenção'
    }
    button.disabled = false;

  });

  function setContent(id, val) {
    document.getElementById(id).value = val.content;
    document.getElementById(id).addEventListener('keyup', function() {
      saveContent(id, this.value)
    })
  }

  function saveContent(id, val) {
    $.ajax({
      url: '../info/save',
      type: 'post',
      data: { ref: id, content: val },
    });
  }

  async function toggleMaintenance() {
    let maintenance = data.app_maintenance_active.content === '1' ? '0' : '1';
    await saveContent('app_maintenance_active', maintenance);
    location.reload();
  }
</script>

<?php Layout::use('panel.end') ?>