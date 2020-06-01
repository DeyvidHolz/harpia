<?php Layout::use('panel') ?>
<?php Component::import('hpanel/sidebar') ?>

<div class="pb-5"></div>

<div class="container mt-3">
  <h2 class="text-center pointer"
    onclick="$notificate({ backgroundColor: colors.color_dark, icon: 'information-variant', description: 'Scripts para anúncios e outros' })"
  >Informações - Ads</h2>
  <hr>
</div>


<div class="hp-container swift-box-shadow defined-lg mb-4">
  <div class="row">

    <div class="col-12">
      <p class="text-center">As alterações serão salvas automaticamente.</p>
    </div>

    <div class="col-12 col-md-6">
      <div class="md-form form-sm mt-5">
        <input type="text" id="script_google_ads" class="form-control">
        <label for="script_google_ads">Script: Google Ads</label>
      </div>
    </div>

    <div class="col-12 col-md-6">
      <div class="md-form form-sm mt-5">
        <input type="text" id="script_facebook_pixel" class="form-control">
        <label for="script_facebook_pixel">Script: Facebook Pixel</label>
      </div>
    </div>

  </div> <!-- /row -->
</div>

<div class="container">
  <div class="hp-alert">Observação: alterar essas informações irá afetar o SEO do site.</div>
</div>

<script>
  let data = <?= get('appContent') ?>

  document.addEventListener('DOMContentLoaded', function() {
    setContent('script_google_ads', data.script_google_ads)
    setContent('script_facebook_pixel', data.meta_script_facebook_pixelkeywords)
  });

  function setContent(id, val) {
    document.getElementById(id).value = val && val.content ? val.content : '';
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