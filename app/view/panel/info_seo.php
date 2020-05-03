<?php Layout::use('panel') ?>
<?php Component::import('hpanel/sidebar') ?>

<div class="pb-5"></div>

<div class="container mt-3">
  <h2 class="text-center">Informações - SEO</h2>
  <hr>
</div>

<div class="hp-container swift-box-shadow defined-lg mb-5">
  <div class="row">

    <div class="col-12">
      <p class="text-center">As alterações serão salvas automaticamente.</p>
    </div>

    <div class="col-12 col-md-6">
      <div class="md-form form-sm mt-5">
        <input type="text" id="page_title" class="form-control">
        <label for="page_title">Título das paginas</label>
      </div>
    </div>

    <div class="col-12 col-md-6">
      <div class="md-form form-sm mt-5">
        <input type="text" id="meta_description" class="form-control">
        <label for="meta_description">Meta Description</label>
      </div>
    </div>

    <div class="col-12 col-md-6">
      <div class="md-form form-sm mt-5">
        <input type="text" id="meta_keywords" class="form-control">
        <label for="meta_keywords">Meta Keywords</label>
      </div>
    </div>

  </div> <!-- /row -->
</div>

<script>
  let data = <?= get('appContent') ?>

  document.addEventListener('DOMContentLoaded', function() {
    setContent('page_title', data.page_title)
    setContent('meta_description', data.meta_description)
    setContent('meta_keywords', data.meta_keywords)
  });

  function setContent(id, val) {
    document.getElementById(id).value = val.content;
    document.getElementById(id).addEventListener('keyup', function() {
      saveContent(id, this.value)
    })
  }

  function saveContent(id, val) {
    $.ajax({
      url: './save',
      type: 'post',
      data: { ref: id, content: val },
    });
  }
</script>

<?php Layout::use('panel.end') ?>