<?php

class Component
{

  public static function import($path, $data = null)
  {

    require_once "../app/view/_component/$path.php";

  }

}