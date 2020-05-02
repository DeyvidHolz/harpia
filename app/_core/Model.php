<?php

require_once "../app/_core/db_query/mySQL.queryCreator.php";

abstract class Model
{

  public static function createDbTable(Array $data)
  {

    return MySQLQueryCreator::createTable($data);

  }

  public static function find($id, $idColumnReference = 'id')
  {

    // Preparing function variables
    if (!is_array($id)) $id = [$id];
    $table = static::$table;
    
    $fillable = join(',', static::$fillable);
    $fillable = preg_replace('/([^,]+)/i', '`{model_table}`.`$1`', $fillable);
    $fillable = preg_replace('/(\{model_table\})/', $table, $fillable);

    // Creating Query
    $query = sprintf("SELECT $fillable FROM `%s` WHERE $idColumnReference IN ({values})", $table);

    $values = '';
    foreach ($id as $i => $v) {
      $values .= '?,';
    }

    $query = preg_replace('/(\{values\})/', $values, $query);
    $query = preg_replace('/(,\))$/', ')', $query);

    // Creating statement
    $stmt = getConnection()->prepare($query);

    // Binding values...
    foreach ($id as $i => $v) {
      $stmt->bindValue(($i+1), $v);
    }

    if ($stmt->execute()) {
      if ($stmt->rowCount() > 0) {
        $models = [];
        foreach($stmt->fetchAll(PDO::FETCH_OBJ) as $value) {
          $models[] = createInstance(static::class, $value);
        }

        return $models;
      }
    } else {
      harpErr(['mySQL Error' => $stmt->errorInfo()[1] . ': ' . $stmt->errorInfo()[2], 'Query Sent' => $stmt->debugDumpParams(), 'Model Query' => $query],__LINE__,__FILE__);
    }
    
    return false;

  }


  public static function findOne($id, $idColumnReference = 'id') {
    $table = static::$table;
    
    $fillable = join(',', static::$fillable);
    $fillable = preg_replace('/([^,]+)/i', '`{model_table}`.`$1`', $fillable);
    $fillable = preg_replace('/(\{model_table\})/', $table, $fillable);

    $query = "SELECT $fillable FROM $table WHERE $idColumnReference = :$idColumnReference";
    $stmt = getConnection()->prepare($query);
    $stmt->bindValue(":$idColumnReference", $id);
    
    if ($stmt->execute()) {
      if ($stmt->rowCount()) return new static($stmt->fetch(PDO::FETCH_OBJ));
    } else {
      harpErr(['mySQL Error' => $stmt->errorInfo()[1] . ': ' . $stmt->errorInfo()[2], 'Query Sent' => $stmt->debugDumpParams(), 'Model Query' => $query],__LINE__,__FILE__);
    }

    return false;
  }


  public static function where(Array $arr, $fetchOne = false)
  {
    
    if (count($arr)) {
      if (!is_array($arr[0])) $arr = [[$arr[0], $arr[1], $arr[2]]];

      // Preparing function variables
      $binds = [];
      $table = static::$table;
      
      $fillable = join(',', static::$fillable);
      $fillable = preg_replace('/([^,]+)/i', '`{model_table}`.`$1`', $fillable);
      $fillable = preg_replace('/(\{model_table\})/', $table, $fillable);

      $query = sprintf("SELECT $fillable FROM `%s` WHERE ", $table);

      foreach($arr as $array) {
        if (is_array($array)) {
          $binds[$array[2]] = [$array[0], $array[1]];
        } else {
          harpErr(['Param Error' => 'Model::where -> Param passed is invalid. Param must to be an array of arrays.', 'Example' => 'YourModel::where([ ["id", "=", "1" ], ["name", "=", "Harpia"] ])'],__LINE__,__FILE__);die;
          die;
        }
      }
    } else {
      harpErr(['Warning: Param Empty' => 'Model::where -> Param passed is empty. Param must to be an array of arrays.', 'Example' => 'YourModel::where([ ["id", "=", "1" ], ["name", "=", "Harpia"] ])'], __LINE__, __FILE__);
      return false;
    }

    foreach ($binds as $value => $vArr) {
      $query .= sprintf("`%s`.`%s` %s ? AND ", $table, $vArr[0], $vArr[1]);
    }

    $query = substr($query, 0, -4);

    // Binding query
    $stmt = getConnection()->prepare($query);
    
    $i = 0;
    foreach($binds as $value => $vArr) {
      $i++;
      $stmt->bindValue($i, $value);
    }

    if ($stmt->execute()) {
      if ($stmt->rowCount() > 0) {
        $models = [];

        if ($fetchOne) {
          return createInstance(static::class, $stmt->fetch(PDO::FETCH_OBJ));
        } else {
          foreach($stmt->fetchAll(PDO::FETCH_OBJ) as $value) {
            $models[] = createInstance(static::class, $value);
          }
        }

        return $models;
      } else {
        return false;
      }
    }

    harpErr(['mySQL Error' => $stmt->errorInfo()[1] . ': ' . $stmt->errorInfo()[2], 'Query Sent' => $stmt->debugDumpParams(), 'Model Query' => $query],__LINE__,__FILE__);
    return false;

  }


  public static function whereOne(Array $arr) {
    $result = self::where($arr, 1); // 1 = fetch one
    return $result;
  }


  public static function save($modelClass, $primaryKey = 'id')
  {
    
    $table = static::$table;

    $fillable = [];
    foreach($modelClass as $prop => $val) {
      $fillable[] = $prop;
    }

    if (empty($modelClass->id)) {
      $index = array_search($primaryKey, $fillable);
      unset($fillable[$index]);
    }
    
    $fillable = join(',', $fillable);
    $fillable = preg_replace('/([^,]+)/i', '`{model_table}`.`$1`', $fillable);
    $fillable = preg_replace('/(\{model_table\})/', $table, $fillable);

    // Creating Query
    $query = '';
    $toBind = [];
    if (empty($modelClass->id)) {
      $query = sprintf("INSERT INTO `%s` ($fillable) VALUES ({{values}})", $table);

      $values = '';
      foreach($modelClass as $prop => $val) {
        $values .= ":$prop,";
        $toBind[] = $prop;
      }

      $index = array_search($primaryKey, $toBind);
      unset($toBind[$index]);
      $values = str_replace(":$primaryKey,", '', $values);
      $values = str_replace(",,", ',', $values);

      $values = substr($values, 0, -1);
      $query = preg_replace('/\{\{values\}\}/', $values, $query);

    } else {

      $query = sprintf("UPDATE `%s` SET {{values}} WHERE id = :id", $table);

      $values = '';
      foreach($modelClass as $prop => $val) {
        if ($prop !== $primaryKey) $values .= "`$prop` = :$prop,";
        $toBind[] = $prop;
      }

      $values = substr($values, 0, -1);
      $query = preg_replace('/\{\{values\}\}/', $values, $query);
    }

    $stmt = getConnection()->prepare($query);

    foreach($toBind as $bind) {
      $stmt->bindValue(":$bind", $modelClass->$bind);
    }

    if ($stmt->execute()) {
      if ($stmt->rowCount()) {
        return empty($modelClass->id) ? self::getLastRecord($primaryKey) : self::findOne($modelClass->id, $primaryKey);
      } else {
        return self::findOne($modelClass->id, $primaryKey);
      }
    } else {
      harpErr(['mySQL Error' => $stmt->errorInfo()[1] . ': ' . $stmt->errorInfo()[2], 'Query Sent' => $stmt->debugDumpParams(), 'Model Query' => $query],__LINE__,__FILE__);
    }
    return false;

  }


  public static function delete($id, $idColumnReference = 'id')
  {

    $table = static::$table;

    $query = "DELETE FROM $table WHERE $idColumnReference = :$idColumnReference";
    $stmt = getConnection()->prepare($query);
    $stmt->bindValue(":$idColumnReference", $id);
    
    if ($stmt->execute()) {
      if ($stmt->rowCount()) return true;
    } else {
      harpErr(['mySQL Error' => $stmt->errorInfo()[1] . ': ' . $stmt->errorInfo()[2], 'Query Sent' => $stmt->debugDumpParams(), 'Model Query' => $query],__LINE__,__FILE__);
    }

    return false;

  }


  public static function deleteWhere($where, $operator = null, $value = null)
  {

    if (!is_array($where)) $where = [[$where, $operator, $value]];
    $table = static::$table;

    $query = "DELETE FROM `$table` WHERE ";
    $binds = [];
    $count = 0;
    foreach($where as $index => $arr) {
      $count++;
      $query .= (strtolower($index) === 'and' || strtolower($index) === 'or') ? $index . ' ' : 'AND ';
      $query .= sprintf('%s %s %s ', $arr[0], $arr[1], ':' . $arr[0].$count);
      $binds[$arr[0].$count] = $arr[2];
    }

    $query = str_replace("DELETE FROM `$table` WHERE AND ", "DELETE FROM `$table` WHERE ", $query); // Removing First AND
    $query = str_replace("DELETE FROM `$table` WHERE OR ", "DELETE FROM `$table` WHERE ", $query); // Removing First OR
    $query = substr($query, 0, -1);

    $stmt = getConnection()->prepare($query);

    foreach($binds as $bind => $val) {
      $stmt->bindValue(":$bind", $val);
    }

    if ($stmt->execute()) {
      if ($stmt->rowCount()) return true;
    } else {
      harpErr(['mySQL Error' => $stmt->errorInfo()[1] . ': ' . $stmt->errorInfo()[2], 'Query Sent' => $stmt->debugDumpParams(), 'Model Query' => $query],__LINE__,__FILE__);
    }
    return false;
  }

  public static function getAll($parseObjectToJSON = false)
  {

    $table = static::$table;
    
    $fillable = join(',', static::$fillable);
    $fillable = preg_replace('/([^,]+)/i', '`{model_table}`.`$1`', $fillable);
    $fillable = preg_replace('/(\{model_table\})/', $table, $fillable);

    $query = "SELECT $fillable FROM $table";
    $stmt = getConnection()->prepare($query);

    if ($stmt->execute()) {
      if ($stmt->rowCount()) {
        $models = [];

        if ($parseObjectToJSON) {
          foreach($stmt->fetchAll(PDO::FETCH_OBJ) as $value) {
            $models[] = createInstance(static::class, $value)->getJSON();
          }
        } else {
          foreach($stmt->fetchAll(PDO::FETCH_OBJ) as $value) {
            $models[] = createInstance(static::class, $value);
          }
        }

        return $models;
      }
    } else {

    }
    
    return false;
  }


  public static function getLastRecord($primaryKey = 'id') {
    $table = static::$table;
    $fillable = static::$fillable;

    $fillable = join(',', $fillable);
    $fillable = preg_replace('/([^,]+)/i', '`{model_table}`.`$1`', $fillable);
    $fillable = preg_replace('/(\{model_table\})/', $table, $fillable);
    
    $query = "SELECT $fillable FROM $table WHERE 1 ORDER BY $primaryKey DESC LIMIT 1";
    $stmt = getConnection()->prepare($query);

    if ($stmt->execute()) {
      if ($stmt->rowCount()) {
        return new static($stmt->fetch(PDO::FETCH_OBJ));
      }
    } else {
      harpErr(['mySQL Error' => $stmt->errorInfo()[1] . ': ' . $stmt->errorInfo()[2], 'Query Sent' => $stmt->debugDumpParams(), 'Model Query' => $query],__LINE__,__FILE__);
    }
    return false;
  }


  public static function getTable() {
    return static::$table;
  }


  public function __construct(stdClass $object = null)
  {
    if (!empty($object)) {
      foreach($object as $prop => $val) {
        $this->__set($prop, $val);
      }
    }
  }


  public function __set($attr, $val) {
    $this->$attr = $val;
    return $this;
  }


  public function __get($attr) {
    return $this->$attr;
  }


  public function getJSON() {
    return json_encode($this);
  }


  public function getObject() {
    $object = new stdClass();
    foreach($this as $prop => $val) {
      $object->$prop = $val;
    }

    return $object;
  }

  public static function getAsArray($arr) {
    $users = [];

    foreach ($arr as $index => $user) {
      $users[] = (array) $user;
    }

    return $users;
  }

}