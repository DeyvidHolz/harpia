<?php

class User extends Model
{

  public $id;
  public $name;
  public $email;
  public $password;

  public static $table = 'users';
  public static $fillable = ['id', 'name', 'email', 'password'];

}