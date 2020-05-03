<?php

class Permission extends Model
{

  public $id;
  public $group_id;
  public $user_id;

  public static $table = 'permissions';
  public static $fillable = ['id', 'group_id', 'user_id'];

  public static function hasPermission($user_id, $permission) {
    $data = self::join([
      'where' => [
        ['{table}.user_id', '=', $user_id],
      ],
      PermissionGroup::$table => ['clause' => '{t1}.group_id = {t2}.id', self::$fillable, PermissionGroup::$fillable, 't1_prefix' => 'permission_', 't2_prefix' => 'permission_group_'],
      User::$table => ['clause' => '{t1}.user_id = {t2}.id', self::$fillable, User::$fillable, 't1_prefix' => 'permission_', 't2_prefix' => 'user_'],
    ]);

    if (is_array($data) && count($data)) {
      $data = $data[0];
      if ($data->permission_group_permissions === '*') return true;
      
      $permissions = json_decode($data->permission_group_permissions);
      if (in_array($permission, $permissions)) return true;
    }

    return false;
  }

}