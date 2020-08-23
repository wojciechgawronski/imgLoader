<?php

namespace core\interfaces;

/**
 * 
 */
interface AddFileImgInterface
{

      /**
       * 
       */
      public function validateFile(array $file);
      
      /**
       * 
       */
      public function saveFile(array $file);

      /**
       * 
       */
      public function resize(array $file);
}