<?php

class Resource
{

  public static function use($path, $dotPHP = true)
  {

    if ($dotPHP) {
      require_once "../app/resource/$path.php";
    } else {
      require_once "../app/resource/$path";
    }

  }

}