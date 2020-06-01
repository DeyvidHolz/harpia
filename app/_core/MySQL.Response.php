<?php

class MySQLResponse
{

  public $query;
  public $errorCode;
  public $error;
  public $fetch;
  public $executed;

  public function __construct(Array $arr)
  {
    foreach ($arr as $index => $value) {
      if (property_exists($this, $index)) $this->$index = $value;
    }
  }

  public function duplicated() {
    return $this->errorCode === '1062' ? true : false;
  }

}
