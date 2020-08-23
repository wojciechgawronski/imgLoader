<?php

namespace models;

use core\Config;

/**
 * 
 */
abstract class File
{

      /**
       * 
       */
      protected array $imagesAllowedTypes = ['image/jpg', 'image/jpeg', 'image/png'];

      /**
       * 
       */
      public function redirect($url){
            header("Location: " . Config::ROOT_URL . "/" . $url);
            exit;
      }

      /**
       * Get exension file from images allowed types from parent class
       */
      protected function getImagesAllowedExtensions() : array
      {
            foreach ($this->imagesAllowedTypes as $ext) {
                  $imagesAllowedExtensions[] = str_replace('image/', '', $ext);
            }
            // $this->imagesAllowedExtensions = $imagesAllowedExtensions;
            return $imagesAllowedExtensions;
      }

}
