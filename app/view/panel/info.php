<?php Layout::use('panel') ?>
<?php Component::import('hpanel/sidebar') ?>

<div class="pb-5"></div>

<div class="container mt-3">
  <h2 class="text-center">Informações gerais</h2>
  <hr>
</div>

<div class="hp-container swift-box-shadow defined-lg mb-5">
  <div class="row">

    <div class="col-12">
      <p class="text-center">As alterações serão salvas automaticamente.</p>
    </div>

    <div class="col-12 col-md-6">
      <div class="md-form form-sm mt-5">
        <input type="text" id="email_main" class="form-control" placeholder="E-mail que aparecerá em seu site.">
        <label for="email_main">E-mail Principal</label>
      </div>
    </div>

    <div class="col-12 col-md-6">
      <div class="md-form form-sm mt-5">
        <input type="text" id="email_contact" class="form-control" placeholder="E-mail para recebimento de e-mails.">
        <label for="email_contact">E-mail de contato</label>
      </div>
    </div>

    <div class="col-12 col-md-6">
      <div class="md-form form-sm mt-5">
        <input type="text" id="email_noreply" class="form-control" placeholder="E-mail para envio de e-mails.">
        <label for="email_noreply">E-mail de envio</label>
      </div>
    </div>

    <div class="col-12 col-md-6">
      <div class="md-form form-sm mt-5">
        <input type="text" id="phone" class="form-control">
        <label for="phone">Telefone</label>
      </div>
    </div>

    <div class="col-12 col-md-6">
      <div class="md-form form-sm mt-5">
        <input type="text" id="whatsapp" class="form-control">
        <label for="whatsapp">WhatsApp</label>
      </div>
    </div>

    <div class="col-12 col-md-6">
      <div class="md-form form-sm mt-5">
        <input type="text" id="address" class="form-control">
        <label for="address">Endereço</label>
      </div>
    </div>

    <div class="col-12">
      <h3 class="mt-3 text-center">Redes sociais</h3>
    </div>

    <div class="col-12 col-md-6">
      <div class="md-form form-sm mt-5">
        <input type="text" id="social_facebook" class="form-control">
        <label for="social_facebook">Facebook</label>
      </div>
    </div>

    <div class="col-12 col-md-6">
      <div class="md-form form-sm mt-5">
        <input type="text" id="social_instagram" class="form-control">
        <label for="social_instagram">Instagram</label>
      </div>
    </div>

    <div class="col-12 col-md-6">
      <div class="md-form form-sm mt-5">
        <input type="text" id="social_linkedin" class="form-control">
        <label for="social_linkedin">Linkedin</label>
      </div>
    </div>

    <div class="col-12 col-md-6">
      <div class="md-form form-sm mt-5">
        <input type="text" id="social_youtube" class="form-control">
        <label for="social_youtube">Youtube</label>
      </div>
    </div>

  </div> <!-- /row -->
</div>

<script>
  let data = <?= get('appContent') ?>

  document.addEventListener('DOMContentLoaded', function() {
    setContent('email_main', data.email_main)
    setContent('email_contact', data.email_contact)
    setContent('email_noreply', data.email_noreply)
    setContent('phone', data.phone)
    setContent('whatsapp', data.whatsapp)
    setContent('address', data.address)
    setContent("social_facebook", data.social_facebook)
    setContent("social_instagram", data.social_instagram)
    setContent("social_linkedin", data.social_linkedin)
    setContent("social_youtube", data.social_youtube)

    $('#phone').mask('(00) 0000-0000');
    $('#whatsapp').mask('(00) 00000-0000');
  });

  function setContent(id, val) {
    document.getElementById(id).value = val.content;
    document.getElementById(id).addEventListener('keyup', function() {
      saveContent(id, this.value)
    })
  }

  function saveContent(id, val) {
    $.ajax({
      url: './info/save',
      type: 'post',
      data: { ref: id, content: val },
    });
  }
</script>

<?php Layout::use('panel.end') ?>