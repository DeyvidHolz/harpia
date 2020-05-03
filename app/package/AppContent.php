<?php

// AppContent Package
Core::useModel('AppContent');
Core::useModel('PermissionGroup');
Core::useModel('Permission');
Core::useModel('User');


$appContentPackage = AppContent::getReferenced();
$inMaintenance = $appContentPackage['app_maintenance_active']->content === '1' ? true : false;
$urlMaintenance = $appContentPackage['app_maintenance_url']->content;
$textMaintenance = $appContentPackage['app_maintenance_text']->content;

$id = isset($_SESSION['id']) ? $_SESSION['id'] : null;
if ($id) {
  if (Permission::hasPermission($id, 'appContent.access.maintenanceRoute')) {
    $inMaintenance = false;
  }
}

define('APP_CONTENT_IN_MAINTENANCE', $inMaintenance);
define('APP_CONTENT_IN_MAINTENANCE_URL', $urlMaintenance);
define('APP_CONTENT_IN_MAINTENANCE_TEXT', $textMaintenance);
define('APP_CONTENT_PAGE_TITLE', $appContentPackage['page_title']->content);
