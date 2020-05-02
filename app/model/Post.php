<?php

class Post extends Model
{

  public $id;
  public $user_id;
  public $title;
  public $subtitle;
  public $categories;
  public $content;
  public $images;
  public $slug;

  public static $table = 'blog';
  public static $fillable = ['id', 'user_id', 'title', 'subtitle', 'categories', 'content', 'images', 'slug'];

  public static function getSlug($title) {
    
    $title = preg_replace('/\s+/', '-', $title);
    $title = preg_replace('/ç|Ç/', 'c', $title);
    $title = preg_replace('/Á|á|À|à|â|Â|ã|Ã|ä|Ä/', 'a', $title);
    $title = preg_replace('/É|é|È|è|ê|Ê|ë|Ë/', 'e', $title);
    $title = preg_replace('/Í|í|Ì|ì|î|Î|ï|Ï/', 'i', $title);
    $title = preg_replace('/Ó|ó|Ò|ò|ô|Ô|ö|Ö|õ|Õ/', 'o', $title);
    $title = preg_replace('/Ú|ú|Ù|ù|û|Û|ü|Ü/', 'u', $title);
    $title = preg_replace('/[^A-Za-z0-9\-]/', '', $title);
    $title = preg_replace('/\-\-+/', '-', $title);

    $title = strtolower($title);
    return $title;
  }

  public static function save($modelClass, $primaryKey = 'id') {
    if (!empty($modelClass->categories)) $modelClass->categories = json_encode($modelClass->categories);
    if (!empty($modelClass->images)) $modelClass->images = json_encode($modelClass->images);
    $modelClass->slug = self::getSlug($modelClass->title);

    $posts = parent::where(['slug', 'LIKE', '%'.$modelClass->slug.'%']);
    
    if ($posts && count($posts)) $modelClass->slug .= '-' . count($posts);

    return parent::save($modelClass, $primaryKey);
  }

  public static function getFormatted (Post $post) {

    if (!is_array($post->categories)) {
      $arr = [];
      $post->categories = explode(',', $post->categories);
  
      foreach ($post->categories as $category) {
        if (!empty($category)) $arr[] = trim($category);
      }
      $post->categories = $arr;
    }

    if (!is_array($post->images)) {
      $arr = [];
      $post->images = explode(',', $post->images);
      foreach ($post->images as $image) {
        if (!empty($image)) $arr[] = trim($image);
      }
      $post->images = $arr;
  
      if (!is_array($post->categories)) $post->categories = [];
      if (!is_array($post->images)) $post->images = [];
    }

    return $post;
  }

}