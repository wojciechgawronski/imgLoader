<?php

namespace core\interfaces;

/**
 * 
 */
interface AddFileImgInterface
{

      /**
       * @param array $file global variable $_FILES
       * 
       * @return mixed
       */
      public function validateFile(array $file);
      
      /**
       * @param array $file global variable $_FILES
       */
      public function saveFile(array $file);

      /**
       * Resize an loaded image, depends on scale
       * 
       * @param array $file global variable $_FILES
       * 
       * @return string 
       */
      public function resize(array $file);
}