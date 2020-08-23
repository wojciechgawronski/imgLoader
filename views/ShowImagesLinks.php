<?php

namespace views;

use core\Config;
use models\File;

/**
 * Niestety tutaj widok będzie pełnił także funkcje modelu
 * Model w widoku!
 */
class ShowImagesLinks extends File
{
      /**
       * names of images in img directory
       */
      private array $images = [];

      /**
       * 
       */
      public function __construct()
      {
            $this->getImages();

            $this->showImages();
      }



      /**
       * Czy można użyć funckcji glob() do pobrania rozszeżeń plików ? 
       */
      public function getImages($filePath = Config::IMG_PATH)
      {
            if (file_exists(Config::IMG_PATH)) {

                  $dir = opendir($filePath);
                  $images = [];
                  while ($f = readdir($dir)) {

                        $fileType = strtolower(pathinfo($f, PATHINFO_EXTENSION));

                        if (in_array($fileType, $this->getImagesAllowedExtensions())) {
                              $images[] = $f;
                        }
                  }

                  closedir($dir);

                  if ($images)
                        $this->images = $images;
            }
      }

      /**
       * 
       */
      public function showImages(): void
      {
            echo "<div class='container'><div class='hr'></div></div>";

            if ($this->images == []) {
                  echo "<div class='container small text-muted'>Brak zdjęć</div>";
            } else {
                  echo "<div class='container small text-muted'><p>Dodane zdjęcia:</p>";

                  echo "<ul class='ul-square pl-3'>";

                  foreach ($this->images as $image) {
                        echo "<li><a href='images/$image' class='small blue'>$image</a></li>";
                  }
                  echo "</ul></div>";
            }
      }
}
