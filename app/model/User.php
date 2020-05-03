<?php

const AUTH_METHOD = 'SESSION';

class User extends Model
{

  public $id;
  public $name;
  public $login;
  public $email;
  public $password;

  public static $table = 'users';
  public static $fillable = ['id', 'name', 'login', 'email', 'password'];

  // public static $joinType = 'INNER';

  public function createHash() {
    $this->password = password_hash($this->password, PASSWORD_BCRYPT);
  }

  public static function auth($login, $password) {
    $status = [
      'status' => false,
      'error' => 'Credenciais inválidas.',
    ];

    $user = User::whereOne(['login', '=', $login]);
    if ($user) {
      if (password_verify($password, $user->password)) {
        $status['status'] = true;

        if (AUTH_METHOD === 'SESSION') self::createSession($user);

        return $status;
      }
    }

    return $status;
  }

  public static function initSession() {
    @session_start();
  }

  public static function createSession(User $user) {
    $_SESSION['auth'] = true;
    $_SESSION['id'] = $user->id;
    $_SESSION['name'] = $user->name;
  }

  public static function isAuth() {
    return (isset($_SESSION['auth']) && $_SESSION['auth'] === true) ? true : false;
  }

}