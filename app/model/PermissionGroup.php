<?php

class PermissionGroup extends Model
{

  public $id;
  public $name;
  public $permissions;

  public static $table = 'permissions_group';
  public static $fillable = ['id', 'name', 'permissions'];

  public static function save($modelClass, $primaryKey = 'id') {
    if ($modelClass->permissions !== '*' && is_array($modelClass->permissions)) {
      $modelClass->permissions = json_encode($modelClass->permissions);
    }
    return parent::save($modelClass, $primaryKey);
  }

  public function create() {
    if ($this->permissions !== '*') $this->permissions = json_encode($this->permissions);
    $group = parent::whereOne(['name', '=', $this->name]);
    return ($group) ? false : parent::save($this);
  }

  public static function setPermissions($group, $permissions, $searchBy = 'name') {
    $group = parent::whereOne([$searchBy, '=', $group]);
    if ($group) {
      $group->permissions = $permissions;
      return self::save($group);
    }
    return false;
  }

  public static function addPermission($group, $permission, $searchBy = 'name') {
    if (!is_array($permission)) $permission = [$permission];
    $group = parent::whereOne([$searchBy, '=', $group]);
    
    if ($group) {
      if ($group->permissions !== '*' && is_string($group->permissions)) {
        $group->permissions = json_decode($group->permissions);
        
        foreach ($permission as $p) {
          if (!in_array($p, $group->permissions)) $group->permissions[] = $p;
        }
      }

      return self::save($group);
    }
    return false;
  }

  public static function removePermission($group, $permission, $searchBy = 'name') {
    if (!is_array($permission)) $permission = [$permission];
    $group = parent::whereOne([$searchBy, '=', $group]);

    if ($group) {
      if ($group->permissions !== '*' && is_string($group->permissions)) {
        $group->permissions = json_decode($group->permissions);
      }

      if (is_array($group->permissions)) {
        $temp = [];
        foreach ($group->permissions as $p) {
          if (!in_array($p, $permission)) $temp[] = $p;
        }
        $group->permissions = $temp;
      }


      // return $group;
      return self::save($group);
    }
    return false;
  }

  public static function getPermissions($group, $searchBy = 'name') {
    $group = parent::whereOne([$searchBy, '=', $group]);
    if ($group) {
      $group->permissions = json_decode($group->permissions);
      return $group;
    }
    return false;
  }

}