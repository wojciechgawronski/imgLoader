<?php

namespace models;


/**
 * Resize image (.jpg, .jpeg, .png) into thumbnails (exat size: width or height with scale) 
 * or scale image, eg. 1.5x or .5x
 */
class ResizeImage
{
      public function __construct()
      {
            
      }

      public static function resize() : string{
            
            $r = 'Resize!';
            return $r;
      }

}