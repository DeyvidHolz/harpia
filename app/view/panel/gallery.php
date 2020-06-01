<?php Layout::use('panel') ?>
<?php Component::import('hpanel/sidebar') ?>

<div class="container mt-3">
  <h2 class="text-center">Sua galeria de imagens</h2>

  <?php if (count(get('images')) === 1) { ?>
  <p class="text-center"><strong><?= count(get('images')) ?> imagem encontrada</strong></p>
  <?php } else { ?> 
  <p class="text-center"><strong><?= count(get('images')) ?> imagens encontradas</strong></p>
  <?php } ?>

  <hr>
</div>

<div class="container">
  <?php if (is_array(get('images')) && count(get('images'))) { ?>
    <div class="row">
    <?php foreach(get('images') as $imageName) { ?>
        <div class="col-12 col-md-6 col-lg-4 mb-2">
          <div class="gallery-defined d-flex flex-column justify-content-between">
            <img img-view src="<?= storage($imageName) ?>">
            <div class="gallery-footer text-right">
              <form method="POST" action="./gallery/delete">
                <input type="hidden" name="filename" value="<?= $imageName ?>">
                <button class="btn btn-danger" onclick="return confirm('Tem certeza que deseja deletar esse arquivo?')">Excluir</button>
              </form>
            </div>
          </div>

        </div>
    <?php } ?>
  </div>
  <?php } ?>
</div>

<?php Layout::use('panel.end') ?>