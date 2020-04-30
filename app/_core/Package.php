<?php

class Package
{
  public static $dir = '../app/package/';

  public static function use($path) {
    require_once self::$dir . $path . '.php';
  }

}