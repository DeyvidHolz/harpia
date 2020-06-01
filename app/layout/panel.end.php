
  <!-- jQuery -->
  <script type="text/javascript" src="<?= asset('js/jquery/jquery-3.4.1.min.js') ?>"></script>
  <script type="text/javascript" src="<?= asset('js/jquery/jquery.mask.js') ?>"></script>
  <script type="text/javascript" src="<?= asset('js/jquery/jcrop/jquery.Jcrop.min.js') ?>"></script>

  <!-- Harpia Components -->
  <script type="text/javascript" src="<?= asset('js/harpia.components.js') ?>"></script>
  
  <!-- Main Script  -->
  <script type="text/javascript" src="<?= asset('js/main.js') ?>"></script>
  <script type="text/javascript" src="<?= asset('js/formize.min.js') ?>"></script>

  <!-- Autonav  -->
  <script type="text/javascript" src="<?= asset('js/autonav.js') ?>"></script>
  
  <!-- HarpiaJS  -->
  <script type="text/javascript" src="<?= asset('js/harpia.js') ?>"></script>
  
  <!-- Bootstrap -->
  <script type="text/javascript" src="<?= asset('js/bootstrap/bootstrap.min.js') ?>"></script>
  <script type="text/javascript" src="<?= asset('js/bootstrap/bootstrap.bundle.min.js') ?>"></script>

  <!-- Material Design Bootstrap -->
  <script type="text/javascript" src="<?= asset('js/mdb/mdb.min.js') ?>"></script>

  <script>
    <?php if (get('view.message') !== 'undefined') { ?>
    document.addEventListener('DOMContentLoaded', function() {
      $notificate({ icon: 'information-variant', backgroundColor: colors.color_success, description: '<?= get('view.message') ?>' })
    })
    <?php unset($_SESSION['view.message']); } ?>

    <?php if (get('view.message.error') !== 'undefined') { ?>
      document.addEventListener('DOMContentLoaded', function() {
      $notificate({ icon: 'information-variant', backgroundColor: colors.color_danger, description: '<?= get('view.message.error') ?>' })
    })
    <?php unset($_SESSION['view.message.error']); } ?>
  </script>
</body>
</html>