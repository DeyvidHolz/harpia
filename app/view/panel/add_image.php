<?php Layout::use('panel') ?>
<?php Component::import('hpanel/sidebar') ?>

<div class="container mt-3">
  <h2 class="text-center">Adicionar imagem à galeria</h2>
  <hr>
</div>

<form method="post" action="<?= PUBLIC_PATH ?>painel/gallery/add" class="md-form" enctype="multipart/form-data">
<div class="hp-container swift-box-shadow defined-lg mb-5">
  <div class="row align-items-center">

    <div class="col-12">
      <div class="file-field">
        <div class="btn btn-success btn-sm float-left">
          <span>Imagem</span>
          <input type="file" name="imageFile">
        </div>
        <div class="file-path-wrapper">
          <input class="file-path validate" name="imageName" type="text" placeholder="Envie uma imagem">
        </div>
      </div>
    </div>

    <div class="col-12 text-right">
      <button type="submit" class="btn btn-primary">Salvar Imagem</button>
    </div>
      
  </div>
</div>
</form>

<?php Layout::use('panel.end') ?>