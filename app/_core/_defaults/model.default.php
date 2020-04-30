<?php

require_once "../app/_core/Model.php";

class MODEL_NAME extends Model
{

  public $id;
  public $column;
  public $created_at;
  public $updated_at;

  private $table = 'TABLE_NAME';
  private $fillable = ['id', 'column', 'created_at', 'updated_at'];

  public static function find()
  {

  }

  public static function where()
  {

  }

  public static function save()
  {

  }

  public static function delete()
  {

  }

  public static function deleteWhere()
  {

  }

}