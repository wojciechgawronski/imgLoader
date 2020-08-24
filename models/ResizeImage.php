<?php

namespace models;

use core\Config;

/**
 * Resize image (.jpg, .jpeg, .png) into thumbnails (exact size: width or height with scale) 
 * or scale image, eg. 1.5x or .5x
 *  
 * GD LIBRARY
 * https://www.php.net/manual/en/function.gd-info.php
 * GD jest biblioteką graficzną służącą do dynamicznej manipulacji obrazami.
 * _print(gd_info());
 * echo GD_VERSION;
 * echo 'Biblioteka GD jest '.(extension_loaded('gd') ? 'dostępna' : 'niedostępna');
 */
class ResizeImage
{
      /**
       * 
       */
      public function __construct()
      {
      }

      /**
       * @param string $filePath
       * @param string $fileName
       * @param float $scale
       * 
       * http://www.ajarunthomas.com/tutorials/php/resize-an-image-in-php-using-the-gd-library/
       */
      public static function createScaleImage(string $filePath, string $fileName, float $scale = .75)
      {

            $source = imagecreatefromjpeg($filePath);
            list($width, $height) = getimagesize($filePath);

            $newwidth = $width * $scale;
            $newheight = $height * $scale;

            $destination = imagecreatetruecolor($newwidth, $newheight);
            imagecopyresampled($destination, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

            $extension = strtolower(substr($filePath, strrpos($filePath, '.')));

            $filePath = Config::ROOT_FOLDER . '/' . Config::IMG_PATH . '/' . rtrim($fileName, $extension) . '_scaled' . $extension;

            imagejpeg($destination, $filePath, 100);

      }

      /**
       * Resize an image - create a new image - thimbnail of img
       * 
       * @param string $file path of image to change
       * @param int $maxSize max size of thimb
       * @return image thumb of image
       */
      public static function createThumbnail(string $filePath, int $maxSize = 150)
      {
            $fileInfo = getimagesize($filePath);

            $type = isset($fileInfo['type']) ? $fileInfo['type'] : $fileInfo[2];


            // is file compatybile with server ?
            if (!imagetypes() && $type) {
                  return false;
            }

            $width = isset($fileInfo['width']) ? $fileInfo['width'] : $fileInfo[0];
            $height = isset($fileInfo['height']) ? $fileInfo['height'] : $fileInfo[0];

            // proportion
            $widthRatio = $maxSize / $width;
            $heightRatio = $maxSize / $height;


            //  open file and create thumb
            $sourceImage = imagecreatefromstring(file_get_contents($filePath));

            // thumb dimensions
            if ($width <= $maxSize && $height <= $maxSize) {
                  return $sourceImage;
            }
            // obrazek leżący
            else if ($widthRatio * $height < $maxSize) {
                  $thumbHeight = ceil($widthRatio * $height);
                  $thumbWidth = $maxSize;
            }
            // obrazek vertykalny (pionowy)
            else {
                  $thumbHeight = $maxSize;
                  $thumbWidth = ceil($heightRatio * $width);
            }

            /**
             * Create thumb by GD Library
             */
            $thumb = imagecreatetruecolor($thumbWidth, $thumbHeight);

            if ($sourceImage === false) {
                  return false;
            }

            // kopia i resamplowanie obrazka $sourceImage  do obrazka $thumb
            imagecopyresampled($thumb, $sourceImage, 0, 0, 0, 0, $thumbWidth, $thumbHeight, $width, $height);

            return $thumb;
      }

      /**
       * @param $image
       * @param string $fileName
       * @param string $shortcut eg _thumb or _scaled_
       * @param int $quality quality of image
       * 
       * @return bool true if iamge is loaded, false otherweise
       */
      public static function saveNewImg($image, $fileName, $shortcut, $quality = 80)
      {
            $extension = strtolower(substr($fileName, strrpos($fileName, '.')));

            $filePath = Config::ROOT_FOLDER . '/' . Config::IMG_PATH . '/' . rtrim($fileName, $extension) . $shortcut . $extension;

            if (!$image || file_exists($filePath)) {
                  return false;
            }

            switch ($extension) {
                  case '.jpg':
                  case '.jpeg':
                        imagejpeg($image, $filePath, $quality);
                        break;
                  case '.png':
                        imagepng($image, $filePath);
                        break;
                  default:
                        return false;
            }

            return true;
      }
}
