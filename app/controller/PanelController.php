<?php

Core::useModel('User');
Core::useModel('Post');
Core::useModel('PermissionGroup');
Core::useModel('Permission');

PanelController::checkAuth();

if (!Permission::hasPermission($_SESSION['id'], 'panel.access')) {
  redirect('@/');
}

class PanelController
{

  public function index() {
    view('panel/index', ['page_title' => 'Início - Painel - {app_name}']);
  }

  public function info() {
    $data = ['appContent' => AppContent::getReferenced(true)];
    $data['page_title'] = 'Informações Gerais - Painel - {app_name}';
    view('panel/info', $data);
  }

  public function infoSeo() {
    $data = ['appContent' => AppContent::getReferenced(true)];
    $data['page_title'] = 'Informações Gerais - SEO - Painel - {app_name}';
    view('panel/info_seo', $data);
  }

  public function infoAds() {
    $data = ['appContent' => AppContent::getReferenced(true)];
    $data['page_title'] = 'Informações Gerais - Ads - Painel - {app_name}';
    view('panel/info_ads', $data);
  }

  public function configSite() {
    $data = [
      'appContent' => AppContent::getReferenced(true),
    ];

    $data['page_title'] = 'Configurações - Painel - {app_name}';
    view('panel/config_site', $data);
  }

  public function saveAppContent($request) {
    $appContent = AppContent::whereOne(['ref', '=', $request->body->ref]);

    if (isset($request->file->imageFile)) {
      if (!empty($request->file->imageFile['name'])) {
        $img = ImageHandler::save($request->file->imageFile);
        $request->body->content = $img['fileName'];
        $appContent->content = $request->body->content;
        AppContent::save($appContent);
      }
      return redirect('@/painel/config/site');
    }
    
    $appContent->content = $request->body->content;
    response(AppContent::save($appContent));
  }

  public function viewAll() {
    $users = User::getAll();
    $data = [
      'users' => $users,
      'page_title' => 'Usuários - Painel - {app_name}'
    ];
    view('panel/user_list', $data);
  }

  public function newUser() {
    view('panel/form_user_new', ['page_title' => 'Novo usuário - Painel - {app_name}']);
  }

  public function newUserAction($request) {
    Package::use('harpia/Validator');

    $valid = Validator::get([
      [$request->body->name => 'required|letters:allowSpaces|length:4-60', 'nome' => 'field'],
      [$request->body->login => 'required|username|length:4-200', 'login' => 'field'],
      [$request->body->password => 'required|length:4-20', 'senha' => 'field'],
    ]);

    if ($valid === true) {
      $user = new User();
      $user->name = $request->body->name;
      $user->login = $request->body->login;
      $user->password = $request->body->password;
      $user->createHash();

      if (!User::where(['login', '=', $user->login])) {
        $user = User::save($user);
        if ($user) {
          $_SESSION['auth.registered'] = 'Registrado com sucesso!';
          return redirect('@/painel/usuarios');
        } else {
          $_SESSION['auth.error'] = 'Ocorreu um erro com seu cadastro';
        }
      } else {
        $_SESSION['auth.error.login'] = 'Já existe um usuário com esse login.';
      }
    } else {
      $_SESSION['auth.error.name'] = Validator::first($valid, 'nome');
      $_SESSION['auth.error.login'] = Validator::first($valid, 'login');
      $_SESSION['auth.error.password'] = Validator::first($valid, 'senha');
    }

    redirect('@/painel/usuario/novo');
  }

  public function editUser($request) {
    $user = User::findOne($request->param->id);

    if ($user) {
      $data = [];
      $data['id'] = $user->id;
      $data['name'] = $user->name;
      $data['login'] = $user->login;
      $data['email'] = $user->email;
      $data['page_title'] = 'Editar usuário: ' . $user->name . ' - Painel - {app_name}';
      return view('panel/form_user_edit', $data);
    }
    
    redirect('@/painel');
  }

  public function editUserAction($request) {
    Package::use('harpia/Validator');

    $toValidate = [
      [$request->body->id => 'required|digits', 'id' => 'field'],
      [$request->body->name => 'required|letters:allowSpaces|length:4-60', 'nome' => 'field'],
      [$request->body->login => 'required|username|length:4-200', 'login' => 'field'],
    ];

    if (isset($request->body->password) && !empty($request->body->password)) {
      $toValidate[] = [$request->body->password => 'required|length:4-20', 'senha' => 'field'];
    }

    $valid = Validator::get($toValidate);

    if ($valid === true) {
      $user = new User();
      $user->id = $request->body->id;
      $user->name = $request->body->name;
      $user->login = $request->body->login;

      $currentUser = User::findOne($request->body->id);
      $sameLogin = User::whereOne(['login', '=', $user->login]);

      if ($sameLogin) {
        if ($sameLogin->id !== $currentUser->id) {
          $_SESSION['auth.error.login'] = 'Já existe um usuário com esse login';
          redirect('@/painel/usuario/' . $request->body->id);
        }
      }

      if ($currentUser) {
        if (isset($request->body->password) && !empty($request->body->password)) {
          $user->password = $request->body->password;
          $user->createHash();
        } else {
          $user->password = $currentUser->password;
        }

        $user = User::save($user);
        if ($user) {
          $_SESSION['auth.userCreated'] = 'Alterações salvas com sucesso!';
          return redirect('@/painel/usuario/'.$user->id);
        } else {
          $_SESSION['auth.error'] = 'Erro ao criar usuário';
        }
      } else {
        $_SESSION['auth.error'] = 'Usuário não encontrado.';
      }
    } else {
      $_SESSION['auth.error.name'] = Validator::first($valid, 'nome');
      $_SESSION['auth.error.login'] = Validator::first($valid, 'login');
      $_SESSION['auth.error.password'] = Validator::first($valid, 'senha');
    }

    redirect('@/painel/usuario/'.$request->body->id);
  }

  public function deleteUserAction($request) {
    debug($request);
    if (User::delete($request->body->id)) {
      $_SESSION['view.message'] = 'Usuário deletado com sucesso';
    } else {
      $_SESSION['view.message.error'] = 'Erro ao deletar usuário';
    }

    redirect('@/painel/usuarios');
  }

  public function newPost() {
    view('panel/form_post_new', ['page_title' => 'Nova postagem - Painel - {app_name}']);
  }

  public function editPost($request) {
    $post = Post::findOne($request->param->id);

    if ($post) {
      $data = [];
      $data['id'] = $post->id;
      $data['title'] = $post->title;
      $data['subtitle'] = $post->subtitle;
      $data['categories'] = !empty($post->categories) && is_array($post->categories) ? join(', ', json_decode($post->categories)) : '';
      $data['content'] = $post->content;
      $data['images'] = @json_decode($post->images)[0];
      $data['slug'] = $post->slug;
      $data['page_title'] = 'Editar postagem: ' . $post->title . ' - Painel - {app_name}';
      return view('panel/form_post_edit', $data);
    }
    
    redirect('@/painel');
  }

  public function viewAllPosts() {
    $posts = Post::getAll();
    $data = [
      'posts' => $posts,
      'page_title' => 'Lista de postagens - Painel - {app_name}'
    ];

    view('panel/post_list', $data);
  }

  public function newPostAction($request) {
    Package::use('harpia/Validator');

    $toValidate = [
      [$request->body->title => 'required|length:6-256', 'title' => 'field'],
      [$request->body->content => 'minlength:6', 'content' => 'field'],
      [$request->body->slug => 'length:6-256', 'slug' => 'field'],
    ];

    if (!empty($request->body->subtitle)) $toValidate[] = [$request->body->subtitle => 'length:4-256', 'title' => 'field'];

    $valid = Validator::get($toValidate);
    
    if ($valid === true) {

      $post = new Post($request->body);

      // Saving image
      $image = null;
      if (!empty($request->file->image) && !empty($request->file->image['name'])) $image = ImageHandler::save($request->file->image, $post->slug);
      if ($image['status']) $post->images = [$image['fileName']];

      $post = Post::getFormatted($post);
      if (isset($_SESSION['id'])) $post->user_id = $_SESSION['id'];

      if (Post::save($post)) {
        $_SESSION['view.message'] = 'Postagem criada com sucesso';
        return redirect('@/painel/post/lista');
      } else {
        $_SESSION['view.message.error'] = 'Ocorreu um erro ao salvar a postagem';
      }

    } else {
      $_SESSION['view.message.error.title'] = Validator::first($valid, 'title');
      $_SESSION['view.message.error.content'] = Validator::first($valid, 'content');
      $_SESSION['view.message.error.slug'] = Validator::first($valid, 'slug');
      $_SESSION['view.message.error.subtitle'] = Validator::first($valid, 'subtitle');
      $_SESSION['view.message.error.user_id'] = Validator::first($valid, 'user_id');

      if (!$_SESSION['view.message.error.title']) unset($_SESSION['view.message.error.title']);
      if (!$_SESSION['view.message.error.content']) unset($_SESSION['view.message.error.content']);
      if (!$_SESSION['view.message.error.slug']) unset($_SESSION['view.message.error.slug']);
      if (!$_SESSION['view.message.error.subtitle']) unset($_SESSION['view.message.error.subtitle']);
      if (!$_SESSION['view.message.error.user_id']) unset($_SESSION['view.message.error.user_id']);
    }

    return redirect('@/painel/post/novo', ['post' => $request->body, 'validation' => $valid]);
  }

  public function editPostAction($request) {
    Package::use('harpia/Validator');

    $post = new Post($request->body);

    $toValidate = [
      [$request->body->title => 'required|length:6-256', 'title' => 'field'],
      [$request->body->content => 'minlength:6', 'content' => 'field'],
      [$request->body->slug => 'length:6-256', 'slug' => 'field'],
    ];

    if (!empty($request->body->subtitle)) $toValidate[] = [$request->body->subtitle => 'length:4-256', 'title' => 'field'];

    $valid = Validator::get($toValidate);
    
    if ($valid === true) {

      $currentPost = Post::findOne($request->body->id);

      if ($currentPost) $post->id = $currentPost->id;

      // Saving image
      $image = null;
      if (!empty($request->file->image) && !empty($request->file->image['name'])) {
        $image = ImageHandler::save($request->file->image, $post->slug);
        if ($image['status']) $post->images = [$image['fileName']];
      } else {
        $currentImage = @json_decode($currentPost->images)[0];
        $post->images = $currentImage;

        if (isset($request->body->removeImage) && !empty($request->body->removeImage)) {
          $post->images = [];
        }
      }

      $post = Post::getFormatted($post);
      if (isset($_SESSION['id'])) $post->user_id = $_SESSION['id'];

      if (Post::save($post)) {
        $_SESSION['view.message'] = 'Alterações salvas com sucesso';
        return redirect('@/painel/post/lista');
      } else {
        $_SESSION['view.message.error'] = 'Ocorreu um erro ao salvar a postagem';
      }

    } else {
      $_SESSION['view.message.error.title'] = Validator::first($valid, 'title');
      $_SESSION['view.message.error.content'] = Validator::first($valid, 'content');
      $_SESSION['view.message.error.slug'] = Validator::first($valid, 'slug');
      $_SESSION['view.message.error.subtitle'] = Validator::first($valid, 'subtitle');
      $_SESSION['view.message.error.user_id'] = Validator::first($valid, 'user_id');

      if (!$_SESSION['view.message.error.title']) unset($_SESSION['view.message.error.title']);
      if (!$_SESSION['view.message.error.content']) unset($_SESSION['view.message.error.content']);
      if (!$_SESSION['view.message.error.slug']) unset($_SESSION['view.message.error.slug']);
      if (!$_SESSION['view.message.error.subtitle']) unset($_SESSION['view.message.error.subtitle']);
      if (!$_SESSION['view.message.error.user_id']) unset($_SESSION['view.message.error.user_id']);
    }

    return redirect('@/painel/post/editar/'.$request->param->id);
  }

  public function deletePostAction($request) {
    if (Post::delete($request->body->id)) {
      $_SESSION['view.message'] = 'Postagem deletada com sucesso';
    } else {
      $_SESSION['view.message.error'] = 'Erro ao deletar postagem';
    }

    redirect('@/painel/post/lista');
  }

  public function viewAllStorageImages() {
    $s = DIRECTORY_SEPARATOR;
    $path = __DIR__ . sprintf("%s..%s..%spublic%sstorage", $s, $s, $s, $s);
    $ext = array('jpg', 'jpeg', 'png', 'gif', 'bmp', 'tiff');
    
    $data = [
      'page_title' => 'Galeria - Painel - {app_name}',
      'images' => getFilesOnDirectory($path, $ext),
    ];

    view('panel/gallery', $data);
  }

  public function deleteFileFromStorage($request) {
    $s = DIRECTORY_SEPARATOR;
    $path = __DIR__ . sprintf("%s..%s..%spublic%sstorage", $s, $s, $s, $s);
    $path .= $s . $request->body->filename;

    if (isset($request->body->filename) && file_exists($path)) {
      unlink($path);
    }
    
    redirect('@/painel/galeria');
  }

  function viewAddImage() {
    view('panel/add_image');
  }

  function addImageToStorage($request) {
    $fullFileName = $request->body->imageName;
    $request->body->imageName = preg_replace('/\.(.*?)$/', '', $request->body->imageName);

    if (isset($request->body->imageName) && isset($request->file->imageFile)) {
      if (file_exists("./storage/$fullFileName")) $request->body->imageName = '';
      ImageHandler::save($request->file->imageFile, $request->body->imageName);
    }

    redirect('@/painel/galeria');
  }

  public static function checkAuth() {
    if (!User::isAuth()) {
      $_SESSION['auth.error'] = 'Você precisa estar logado para acessar o Painel';
      redirect('@/login');
    }
  }

}