<?php Layout::use('panel') ?>
<?php Component::import('hpanel/sidebar') ?>

<div class="pt-5"></div>

<div class="container mt-3">
  <h2 class="text-center">Lista de Postagens</h2>
  <hr>

  <?php if (get('view.message') !== 'undefined') { ?>
  <h4 class="text-success text-center mb-5"><?= get('view.message') ?></h4>
  <?php unset($_SESSION['view.message']); } ?>

  <?php if (get('view.message.error') !== 'undefined') { ?>
  <h4 class="text-danger text-center mb-5"><?= get('view.message.error') ?></h4>
  <?php unset($_SESSION['view.message.error']); } ?>

  <div class="row">

  <?php foreach (get('posts') as $post) { ?>
  <div class="col-12 col-md-6 col-lg-4 pb-4">
    <div class="card hp-container-contain swift-box-shadow card-user post-adjust-height d-flex flex-column justify-content-between">
      
      <div>
        <h5 class="text-center font-weight-bold"><?= $post->title ?></h5>

        <div>
          <img class="adapt" src="<?= storage(@json_decode($post->images)[0]) ?>" alt="">
        </div>
      </div>

      <div class="footer">
        <form method="post" action="<?= PUBLIC_PATH ?>painel/post/delete" class="d-inline-block">
          <input type="hidden" name="id" value="<?= $post->id ?>">
          <button class="btn btn-danger btn-sm mr-2" onclick="return confirm('Deseja apagar esta postagem?')">
            <span class="mdi mdi-close mr-2"></span> Deletar
          </button>
        </form>

        <a class="btn btn-primary btn-sm" href="<?= PUBLIC_PATH ?>painel/post/editar/<?= $post->id ?>">
          <span class="mdi mdi-account-edit mr-2"></span> Alterar
        </a>
      </div>
    </div>

  </div>
  <?php } ?>

</div>

<script>
let heights = [];
let defaultHeight = null;

document.addEventListener('DOMContentLoaded', function() {
  let postsCards = document.querySelectorAll('.post-adjust-height');
  postsCards.forEach(el => {
    heights.push(el.offsetHeight);
  })

  defaultHeight = Math.max(...heights);

  postsCards.forEach(el => {
    el.style.height = `${defaultHeight}px`;
  })
})

</script>

<?php Layout::use('panel.end') ?>