<?php

class ImageHandler {

  public static $dir = '.'.DIRECTORY_SEPARATOR.'storage'.DIRECTORY_SEPARATOR;
  public static $formats = ['jpg', 'jpeg', 'png', 'gif', 'tiff'];
  public static $minSize = KB*5;
  public static $maxSize = MB*2;
  public static $defaultFormat = 'jpg';

  public static function save($file, $fname = '', $dir = null, $generateName = true) {
    if (!$dir) $dir = self::$dir;

    if (!is_dir($dir)) {
      mkdir($dir, 0777, true);
    }

    $errors = [];

    $allowedExtensions = self::$formats;

    $fileName = $file['name'];
    $fileSize = $file['size'];
    $fileTmpName = $file['tmp_name'];
    $fileExtension = explode('.', $fileName);
    $fileExtension = end($fileExtension);
    
    $newFileName = '';
    $uploadPath = $dir;

    if($generateName && empty($fname)) {
      $tempPath = '';
      $generatedName = '';

      do {
        $generatedName = self::generateName();
        $tempPath = $dir . $generatedName . '.' . $fileExtension;
      } while (empty($tempPath) || file_exists($tempPath));

      $uploadPath .= $generatedName.'.'.$fileExtension;
      $newFileName = $generatedName.'.'.$fileExtension;
    } else {
      $newFileName = $fname . '.' . $fileExtension;
      $uploadPath .= $newFileName;
    }

    if (!in_array($fileExtension, $allowedExtensions)) $errors[] = 'File extension is not allowed.';
    if ($fileSize > self::$maxSize) $errors[] = 'The file cannot be larger than '.number_format((self::$maxSize / MB), 2, '.', '').'MB.';
    if ($fileSize < self::$minSize) $errors[] = 'The file cannot be less than '.number_format((self::$minSize / MB), 2, '.', '').'MB.';

    if (empty($errors)) {
      if (move_uploaded_file($fileTmpName, $uploadPath)) {
        return ['status' => true, 'fileName' => $newFileName];
      } else {
        $errors[] = 'Error while trying to move the file.';
      }
    }
    return $errors;
  }

  private static function generateName() {
    $chars = [
      'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p',
      'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z', '0', '1', '2', '3', '4', '5',
      '6', '7', '8', '9'
    ];

    $generatedName = '';
    for ($i = 0; $i < 30; $i++) {
      $generatedName .= $chars[rand(0, sizeof($chars) -1)];
    }

    return $generatedName;
  }

}