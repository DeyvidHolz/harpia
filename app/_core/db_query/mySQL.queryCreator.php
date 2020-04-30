<?php

class MySQLQueryCreator
{

  public static function createTable(Array $arr)
  {

    if (!isset($arr['name']) || empty($arr['name'])) {
      return false;
    }

    if (!isset($arr['columns']) || empty($arr['columns'])) {
      return false;
    }

    if (!isset($arr['config.collate'])) $arr['config.collate'] = 'utf8_general_ci';
    if (!isset($arr['config.charset'])) $arr['config.charset'] = 'utf8';
    if (!isset($arr['config.engine'])) $arr['config.engine'] = 'InnoDB';
    
    if (!isset($arr['option.createTimestampColumns'])) $arr['option.createTimestampColumns'] = true;

    $query = "CREATE TABLE IF NOT EXISTS {table} ({columns}) ENGINE={engine} CHARACTER SET {charset} COLLATE {collate}";

    // Array to SQL: Columns

    if ($arr['option.createTimestampColumns']) {
      $arr['columns']['created_at'] = 'DATETIME DEFAULT CURRENT_TIMESTAMP';
      $arr['columns']['updated_at'] = 'TIMESTAMP';
    }

    $columns = '';
    foreach ($arr['columns'] as $index => $column) {
      $columns .= '`' . $index . '` ' . $column . ', ';
    }

    // Array to SQL: Foreign Keys
    if (isset($arr['foreignKeys']) && is_array($arr['foreignKeys']) && count($arr['foreignKeys']))  {
      foreach ($arr['foreignKeys'] as $index => $foreignKey) {
        $foreignKeyArr = explode('|', $foreignKey);
        $columns .= 'CONSTRAINT `fk_' . $index . '` FOREIGN KEY (`' . $index . '`) REFERENCES `' . $foreignKeyArr[0] . '`(`' . $foreignKeyArr[1] . '`) ';

        // onUpdate, onDelete, onChange
        foreach ($foreignKeyArr as $fk) {
          $fk = explode(':', $fk);
          $allowed = ['no action', 'cascade', 'set null', 'set default'];

          if (strtolower($fk[0]) === 'onupdate') {
            if (isset($fk[1]) && in_array(strtolower($fk[1]), $allowed)) {
              $columns .= 'ON UPDATE ' . $fk[1];
            } else {
              // @TODO: throw error here cause onUpdate clause is not valid.
            }
          } else if (strtolower($fk[0]) === 'ondelete') {
            if (isset($fk[1]) && in_array(strtolower($fk[1]), $allowed)) {
              $columns .= 'ON DELETE ' . $fk[1];
            } else {
              // @TODO: throw error here cause onUpdate clause is not valid.
            }
          } else if (strtolower($fk[0]) === 'onchange') {
            if (isset($fk[1]) && in_array(strtolower($fk[1]), $allowed)) {
              $columns .= 'ON DELETE ' . $fk[1] . ' ';
              $columns .= 'ON UPDATE ' . $fk[1];
            } else {
              // @TODO: throw error here cause onUpdate clause is not valid.
            }
          }
        }

        $columns .= ', ';
      }
    }

    $columns = substr($columns, 0, -2);

    // Replacing...
    $query = preg_replace('/\{table\}/i', $arr['name'], $query);
    $query = preg_replace('/\{columns\}/i', $columns, $query);
    $query = preg_replace('/\{engine\}/i', $arr['config.engine'], $query);
    $query = preg_replace('/\{charset\}/i', $arr['config.charset'], $query);
    $query = preg_replace('/\{collate\}/i', $arr['config.collate'], $query);

    $stmt = getConnection()->prepare($query);
    if ($stmt->execute()) {
      return true;
    }

    return false;
  }

}