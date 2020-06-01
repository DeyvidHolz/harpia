<style type="text/css">
/* Only for snippet */
.double-nav .breadcrumb-dn {
  color: #fff;
}
.button-collapse i {
  color: #fff
}
</style>

<header>
  <div id="slide-out" class="side-nav fixed black-skin">
    <ul class="custom-scrollbar">
      
      <li>
        <div class="logo-wrapper waves-light">
          <a href="<?= PUBLIC_PATH ?>painel"><img src="<?= asset('img/hpanel/hpanel-logo.png') ?>" class="img-fluid flex-center mx-auto" style="max-height:90px !important"></a>
        </div>
      </li>
      
      
      <li>
        <ul class="social">
          <li><a target="_blank" href="<?= APP_URL_SOCIAL_FACEBOOK ?>" class="icons-sm text-light"><span class="mdi mdi-facebook" style="font-size: 1.2rem"></span></a></li>
          <li><a target="_blank" href="<?= APP_URL_SOCIAL_INSTAGRAM ?>" class="icons-sm text-light"><span class="mdi mdi-instagram" style="font-size: 1.2rem"></span></a></li>
          <li><a target="_blank" href="<?= APP_URL_SOCIAL_TWITTER ?>" class="icons-sm text-light"><span class="mdi mdi-twitter" style="font-size: 1.2rem"></span></a></li>
          <li><a target="_blank" href="<?= APP_URL_SOCIAL_LINKEDIN ?>" class="icons-sm text-light"><span class="mdi mdi-linkedin" style="font-size: 1.2rem"></span></a></li>
        </ul>
      </li>
      
      
      <!-- <li>
        <form class="search-form" role="search">
          <div class="form-group md-form mt-0 pt-1 waves-light">
            <input type="text" class="form-control" placeholder="Pesquisar" style="color: #fff !important">
          </div>
        </form>
      </li> -->
      
      
      <li>
        <ul class="collapsible collapsible-accordion">

          <li>
            <a class="collapsible-header waves-effect arrow-r">
              <span class="mdi mdi-view-dashboard mr-2"></span> Informações Padrões
            </a>

            <div class="collapsible-body">
              <ul class="list-unstyled">
                <li><a href="<?= PUBLIC_PATH ?>painel/info" class="waves-effect"><span class="mdi mdi-view-dashboard-outline mr-2"></span> Informações gerais</a></li>
                <li><a href="<?= PUBLIC_PATH ?>painel/info/seo" class="waves-effect"><span class="mdi mdi-google mr-2"></span> SEO</a></li>
                <li><a href="<?= PUBLIC_PATH ?>painel/info/ads" class="waves-effect"><span class="mdi mdi-google-ads mr-2"></span> Ads</a></li>
              </ul>
            </div>
          </li>

          <li>
            <a class="collapsible-header waves-effect arrow-r">
              <span class="mdi mdi-account-multiple mr-2"></span> Usuários
            </a>

            <div class="collapsible-body">
              <ul class="list-unstyled">
                <li><a href="<?= PUBLIC_PATH ?>painel/usuario/novo" class="waves-effect"><span class="mdi mdi-account-plus mr-2"></span> Criar novo usuário</a></li>
                <li><a href="<?= PUBLIC_PATH ?>painel/usuarios" class="waves-effect"><span class="mdi mdi-account-multiple mr-2"></span> Ver todos</a></li>
              </ul>
            </div>
          </li>

          <li>
            <a class="collapsible-header waves-effect arrow-r">
              <span class="mdi mdi-folder-open mr-2"></span> Blog
            </a>

            <div class="collapsible-body">
              <ul class="list-unstyled">
                <li><a href="<?= PUBLIC_PATH ?>painel/post/novo" class="waves-effect"><span class="mdi mdi-folder-plus mr-2"></span> Nova postagem</a></li>
                <li><a href="<?= PUBLIC_PATH ?>painel/post/lista" class="waves-effect"><span class="mdi mdi-folder-multiple mr-2"></span> Ver todas</a></li>
              </ul>
            </div>
          </li>

          <li>
            <a class="collapsible-header waves-effect arrow-r">
              <span class="mdi mdi-folder-multiple-image mr-2"></span> Galeria
            </a>

            <div class="collapsible-body">
              <ul class="list-unstyled">
                <li><a href="<?= PUBLIC_PATH ?>painel/galeria/add" class="waves-effect"><span class="mdi mdi-image-plus mr-2"></span> Adicionar imagem</a></li>
                <li><a href="<?= PUBLIC_PATH ?>painel/galeria" class="waves-effect"><span class="mdi mdi-image-multiple mr-2"></span> Ver todos</a></li>
              </ul>
            </div>
          </li>

          <li>
            <a class="collapsible-header waves-effect arrow-r">
              <span class="mdi mdi-image-move mr-2"></span> Slides
            </a>

            <div class="collapsible-body">
              <ul class="list-unstyled">
                <li><a href="<?= PUBLIC_PATH ?>painel/#" class="waves-effect"><span class="mdi mdi-image-plus mr-2"></span> Criar novo slide</a></li>
                <li><a href="<?= PUBLIC_PATH ?>painel/#" class="waves-effect"><span class="mdi mdi-folder-multiple-image mr-2"></span> Ver todos</a></li>
              </ul>
            </div>
          </li>

          <li>
            <a class="collapsible-header waves-effect arrow-r">
              <span class="mdi mdi-cogs mr-2"></span> Configurações
            </a>

            <div class="collapsible-body">
              <ul class="list-unstyled">
                <li><a href="<?= PUBLIC_PATH ?>painel/config/site" class="waves-effect"><span class="mdi mdi-cog mr-2"></span> Configurações do Site</a></li>
              </ul>
            </div>
          </li>

        </ul>
      </li>
      
    </ul>
    <div class="sidenav-bg mask-strong"></div>
    <div class="panel-version"><?= PANEL_VERSION ?></div>
  </div>
      

  <nav class="navbar bg-dark text-light fixed-top navbar-toggleable-md navbar-expand-lg scrolling-navbar double-nav">
    <!-- SideNav slide-out button -->
    <div class="float-left">
      <a href="#" data-activates="slide-out" class="button-collapse"><span class="mdi mdi-menu" style="font-size: 1.4rem"></span></a>
    </div>
    <!-- Breadcrumb-->
    <div class="breadcrumb-dn ml-4 mr-auto">
      <a href="<?= PUBLIC_PATH ?>painel">
        <img src="<?= asset('img/hpanel/hpanel-logo.png') ?>" height="54">
      </a>
    </div>
    <ul class="nav navbar-nav nav-flex-icons ml-auto">
      <li hcp-navbar-item class="nav-item"></li>
      <li class="nav-item">
        <a href="<?= PUBLIC_PATH ?>logout" class="nav-link d-flex align-items-center">
          <span class="mdi mdi-logout-variant mr-1" style="font-size: 1.3rem"></span>
          <span class="clearfix d-none d-sm-inline-block">Sair</span>
        </a>
      </li>
      <!-- <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown"
          aria-haspopup="true" aria-expanded="false">
          Dropdown
        </a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
          <a class="dropdown-item" href="#">Action</a>
          <a class="dropdown-item" href="#">Another action</a>
          <a class="dropdown-item" href="#">Something else here</a>
        </div>
      </li> -->
    </ul>
  </nav>

  <div style="width:100%; height:1px; margin-top: 80px;"></div>
</header>

<script>
document.addEventListener('DOMContentLoaded', function() {
  // SideNav Initialization
  $(".button-collapse").sideNav();
  new WOW().init();
})
</script>

<div class="powered-by-harpia">Powered by Harpia</div>