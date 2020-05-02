<?php Layout::use('panel') ?>
<?php Component::import('hpanel/sidebar') ?>

<div class="pt-5"></div>

<form method="post" action="<?= PUBLIC_PATH ?>painel/post/edit" enctype="multipart/form-data" class="md-form">
  <input type="hidden" name="id" value="<?= get('id') ?>">
  <div class="hp-container swift-box-shadow defined-lg">
    <h2 class="text-center">Criar nova postagem</h2>

    <?php if (get('view.message.error') !== 'undefined') { ?>
    <div class="text-center">
      <span class="text-danger"><?= get('view.message.error') ?></span>
    </div>
    <?php unset($_SESSION['view.message.error']); } ?>

    <div class="row">

      <div class="col-12">
        <div class="md-form">
          <input type="text" id="title" class="form-control" name="title" value="<?= get('title') ?>">
          <label for="title">Título</label>

          <?php if (get('view.message.error.title') !== 'undefined') { ?>
            <div class="text-danger"><?= get('view.message.error.title') ?></div>
          <?php unset($_SESSION['view.message.error.title']); } ?>

        </div>
      </div>

      <div class="col-12">
        <div class="md-form">
          <input type="text" id="subtitle" class="form-control" name="subtitle" value="<?= get('subtitle') ?>">
          <label for="subtitle">Subtítulo</label>
          <?php if (get('view.message.error.subtitle') !== 'undefined') { ?>
            <div class="text-danger"><?= get('view.message.error.subtitle') ?></div>
          <?php unset($_SESSION['view.message.error.subtitle']); } ?>
        </div>
      </div>

      <div class="col-12">
        <textarea rows="8" id="post-editor"><?= trim(get('content')) ?></textarea>
        <input type="hidden" name="content" id="content" value="<?= get('content') ?>">
      </div>

      <div class="col-12">
        <div class="md-form">
          <input type="text" id="categories" class="form-control" name="categories" placeholder="Exemplo: Tecnologia, TI, Marketing" value="<?= get('categories') ?>">
          <label for="categories">Categorias</label>
          <?php if (get('view.message.error.categories') !== 'undefined') { ?>
            <div class="text-danger"><?= get('view.message.error.categories') ?></div>
          <?php unset($_SESSION['view.message.error.categories']); } ?>
        </div>
      </div>

      <div class="col-12">
        <div class="md-form">
          <input type="text" id="slug" class="form-control" name="slug" value="<?= get('slug') ?>">
          <label for="slug">URL da Postagem</label>
          <?php if (get('view.message.error.slug') !== 'undefined') { ?>
            <div class="text-danger"><?= get('view.message.error.slug') ?></div>
          <?php unset($_SESSION['view.message.error.slug']); } ?>
        </div>
      </div>

      <div class="col-12">
        <div class="file-field">
          <div class="btn btn-success btn-sm float-left">
            <span>Imagem</span>
            <input type="file" name="image">
          </div>
          <div class="file-path-wrapper">
            <input class="file-path validate" type="text" placeholder="Enviar uma imagem">
          </div>
          <span class="text-primary">Deixe em branco para não alterar</span>
        </div>
      </div>

      <div class="col-12 text-center">
        <button class="btn btn-primary mt-5">
          <span class="mdi mdi-account-plus"></span> Salvar alterações
        </button>
      </div>

    </div>

  </div>
</form>

<script src="<?= asset('js/tinymce/tinymce.min.js') ?>"></script>
<script src="<?= asset('js/tinymce/jquery.tinymce.min.js') ?>"></script>
<script>
$(document).ready(function() {
  tinymce.init({
      selector: '#post-editor',
      theme: 'modern',
      plugins: [
      'advlist autolink lists link image charmap print preview hr anchor pagebreak',
      'searchreplace wordcount visualblocks visualchars code fullscreen',
      'insertdatetime media nonbreaking save table contextmenu directionality',
      'paste textcolor colorpicker textpattern imagetools codesample toc help emoticons hr'
      ],
      toolbar1: 'formatselect | fontsizeselect bold italic  strikethrough  forecolor backcolor | link | alignleft aligncenter alignright alignjustify  | numlist bullist outdent indent  | removeformat ',
      image_advtab: true,
      fontsize_formats: "8pt 10pt 12pt 14pt 18pt 24pt 36pt",
      language: 'pt_BR',
      init_instance_callback: function(editor) {
        editor.on('change', function(e) {
          $('#content').val(tinyMCE.activeEditor.getContent())
        });
      }
  });
});

let autofill = true;
let slug = document.querySelector('#slug')
document.addEventListener('DOMContentLoaded', function() {
  document.querySelector('#title').addEventListener('change', function () {
    if (autofill) {
      slug.value = getSlug(this.value);
      document.querySelector('label[for="slug"]').classList.add('active');
    }
  });

  document.querySelector('#slug').addEventListener('focus', function () {
    autofill = false;
  });
})

function getSlug(val) {

  // $title = preg_replace('/\s+/', '-', $title);
  // $title = preg_replace('/ç|Ç/', 'c', $title);
  // $title = preg_replace('/Á|á|À|à|â|Â|ã|Ã|ä|Ä/', 'a', $title);
  // $title = preg_replace('/É|é|È|è|ê|Ê|ë|Ë/', 'e', $title);
  // $title = preg_replace('/Í|í|Ì|ì|î|Î|ï|Ï/', 'i', $title);
  // $title = preg_replace('/Ó|ó|Ò|ò|ô|Ô|ö|Ö|õ|Õ/', 'o', $title);
  // $title = preg_replace('/Ú|ú|Ù|ù|û|Û|ü|Ü/', 'u', $title);
  // $title = preg_replace('/\-\-+/', '-', $title);
  val = val.replace(/\s+/g, '-');
  val = val.replace(/ç|Ç/g, '-');
  val = val.replace(/Á|á|À|à|â|Â|ã|Ã|ä|Ä/g, '-');
  val = val.replace(/É|é|È|è|ê|Ê|ë|Ë/g, '-');
  val = val.replace(/Í|í|Ì|ì|î|Î|ï|Ï/g, '-');
  val = val.replace(/Ó|ó|Ò|ò|ô|Ô|ö|Ö|õ|Õ/g, '-');
  val = val.replace(/Ú|ú|Ù|ù|û|Û|ü|Ü/g, '-');
  val = val.replace(/[^A-Za-z0-9\-]/g, '-');
  val = val.replace(/\-\-+/g, '-');
  val = val.replace(/\-$/, '');
  val = val.replace(/^\-/, '');
  val = val.toLowerCase()
  return val;
}
</script>

<?php Layout::use('panel.end') ?>