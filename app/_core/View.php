<?php

$__VIEW_DATA = [];

class View
{
  
  public $filename;
  public $path;
  public $data;

  private $dir = '../app/view/';

  public function get() {
    global $__VIEW_DATA;
    
    $__VIEW_DATA = $this->data;
    require_once $this->path;
  }

  public function __construct($path, $data) {
    $this->path = $this->dir . $path . '.php';
    $this->filename = preg_replace('/(.*?)\//i', '', $path);
    $this->data = $data;
  }

}