<?php

class GHelper {

  public static function isArray($var) {
    return (is_array($var) && count($var) > 0) ? true : false;
  }

}