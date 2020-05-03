<?php Layout::use('panel') ?>
<?php Component::import('hpanel/sidebar') ?>

<div class="pb-5"></div>

<div class="container mt-3">
  <h2 class="text-center">Configurações - Site</h2>
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

<div class="hp-container swift-box-shadow defined-lg mb-5">
  <div class="row">

    <div class="col-12">
      <h5 class="text-center">Página 404: Texto</h5>
    </div>

    <div class="col-12">
      <div class="md-form form-sm mt-5">
        <input type="text" id="app_page_404_text" class="form-control">
        <label for="app_page_404_text">Texto que será exibido</label>
      </div>
    </div>

  </div> <!-- /row -->
</div>

<div class="hp-container swift-box-shadow defined-lg mb-5">
  <h5 class="text-center">Página de manutenção: Imagem</h5>
  <div class="text-center">
    <img id="img_503" src="" width="200">

    <div>
      <button type="button" class="btn btn-success btn-sm mt-2" onclick="getImageChanger('page_503_image')">Alterar</button>
    </div>
  </div>

  <h5 class="text-center mt-5">Página 404: Imagem</h5>
  <div class="text-center">
    <img id="img_404" src="" width="200">
    <div>
      <button type="button" class="btn btn-success btn-sm mt-2"  onclick="getImageChanger('page_404_image')">Alterar</button>
    </div>
  </div>
</div>

<script>
  let data = <?= get('appContent') ?>;
  let public_path = '<?= PUBLIC_PATH ?>';

  document.addEventListener('DOMContentLoaded', function() {
    setContent('app_maintenance_url', data.app_maintenance_url)
    setContent('app_maintenance_text', data.app_maintenance_text)
    setContent('app_page_404_text', data.app_page_404_text)

    let button = document.getElementById('maintenance-button');

    if (data.app_maintenance_active.content === '1') {
      button.innerHTML = 'Desativar manutenção';
    } else {
      button.innerHTML = 'Ativar manutenção'
    }
    button.disabled = false;

    document.querySelector('#img_503').src = data.page_503_image.content !== '' ? `${public_path}storage/${data.page_503_image.content}` : `${public_path}assets/img/503.png`;
    document.querySelector('#img_404').src = data.page_404_image.content !== '' ? `${public_path}storage/${data.page_404_image.content}` : `${public_path}assets/img/404.png`;

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

  function getImageChanger(ref) {
    $dialog({
      icon: 'close',
      title: 'Alterar imagem',
      description: `
        <form action="../info/save" method="post" enctype="multipart/form-data" class="md-form">
          <input type="hidden" name="ref" value="${ref}">
          <div class="file-field">
            <div class="btn btn-success btn-sm float-left">
              <span>Escolher imagem</span>
              <input type="file" name="imageFile">
            </div>
            <div class="file-path-wrapper">
              <input class="file-path validate" type="text" placeholder="Envie uma imagem">
            </div>
          </div>

          <div class="text-right mt-4" style="margin-bottom: -1rem">
            <button type="button" class="btn btn-danger btn-sm" onclick="$dialogClose()">Fechar</button>
            <button type="submit" class="btn btn-primary btn-sm">Salvar</button>
          </div>
        </form>
      `,
    })
  }
</script>

<?php Layout::use('panel.end') ?>