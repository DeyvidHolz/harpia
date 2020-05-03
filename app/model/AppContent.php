<?php

class AppContent extends Model
{

  public $id;
  public $ref;
  public $type;
  public $content;
  public $action;

  public static $table = 'app_content';
  public static $fillable = ['id', 'ref', 'type', 'content', 'action'];

  public static function getReferenced($parseJson = false) {
    $appContent = self::getAll();

    $temp = [];
    foreach ($appContent as $index => $content) {
      $temp[$content->ref] = $content;
    }
    $appContent = $temp;

    return $parseJson ? json_encode($appContent) : $appContent;
  }

}