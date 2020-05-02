<?php

Core::useModel('User');

class AuthController
{

  public function checkLogin($request) {

    if (!empty($request->body->login) && !empty($request->body->password)) {
      $auth = User::auth($request->body->login, $request->body->password);
      if ($auth['status']) {
        return redirect('@/painel');
      }
      $_SESSION['auth.error'] = $auth['error'];
    } else {
      $_SESSION['auth.error'] = 'Preencha os campos necessários';
    }

    redirect('@/login');
  }

  public function register($request) {
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
        if (User::save($user)) {
          $_SESSION['auth.registered'] = 'Registrado com sucesso!';
          return redirect('@/login');
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

    redirect('@/register');
  }

  public function logout() {
    unset($_SESSION['auth']);
    unset($_SESSION['id']);
    unset($_SESSION['name']);
    redirect('@/login');
  }

}