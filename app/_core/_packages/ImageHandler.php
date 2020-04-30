<?php

define('KB', 1024);
define('MB', 1048576);
define('GB', 1073741824);
define('TB', 1099511627776);

class ImageHandler {

  public static $dir = '.'.DIRECTORY_SEPARATOR.'storage'.DIRECTORY_SEPARATOR;
  public static $formats = ['jpg', 'jpeg', 'png', 'gif', 'tiff'];
  public static $minSize = 25000; // 0.025MB
  public static $maxSize = 2500000; // 2.5MB
  public static $defaultFormat = 'jpg';

  public static function save($file, $dir = null, $generateName = true) {
    if (!$dir) $dir = self::$dir;

    if (!is_dir($dir)) {
      mkdir($dir, 0777, true);
    }

    $errors = [];

    $allowedExtensions = self::$formats;

    $fileName = $file['name'];
    $fileSize = $file['size'];
    $fileTmpName = $file['tmp_name'];
    // $fileType = $file['type']; // not using
    $fileExtension = explode('.', $fileName);
    $fileExtension = end($fileExtension);
    
    $newFileName = '';
    $uploadPath = $dir;

    if($generateName) {
      $tempPath = '';
      $generatedName = '';

      do {
        $generatedName = self::generateName();
        $tempPath = $dir . $generatedName . '.' . $fileExtension;
      } while (empty($tempPath) || file_exists($tempPath));

      $uploadPath .= $generatedName.'.'.$fileExtension;
      $newFileName = $generatedName.'.'.$fileExtension;
    } else {
      $uploadPath .= basename($fileName);
      $newFileName = basename($fileName);
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

  public static function convert($dirToSave, $newFileName, $fileName, $fileExtension) {
    
    // $image = imagecreatefrompng($filePath);
    // $bg = imagecreatetruecolor(imagesx($image), imagesy($image));
    // imagefill($bg, 0, 0, imagecolorallocate($bg, 255, 255, 255));
    // imagealphablending($bg, TRUE);
    // imagecopy($bg, $image, 0, 0, 0, 0, imagesx($image), imagesy($image));
    // imagedestroy($image);
    // $quality = 50; // 0 = worst / smaller file, 100 = better / bigger file 
    // imagejpeg($bg, $filePath . ".jpg", $quality);
    // imagedestroy($bg);
  }

  private static function generateName() {
    // Gerar um nome
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