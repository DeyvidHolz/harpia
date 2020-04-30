<?php

class Layout
{

  public static function use($path)
  {

    require_once "../app/layout/$path.php";

  }

}