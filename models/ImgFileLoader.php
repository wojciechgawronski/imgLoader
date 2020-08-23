<?php

namespace models;

use core\Config;
use models\FlashMessages;
use core\interfaces\AddFileImgInterface;
use DateTime;

/**
 * 
 */
class ImgFileLoader extends File implements AddFileImgInterface
{

      protected $file;

      /**
       * 
       */
      public function __construct($file)
      {
            // img - name of form field
            $this->file = $file['img'];

            if ($this->validateFile($this->file))
                  $this->saveFile($this->file);
      }

      /**
       * Redirect on main page in case of wrong type / size file or unexpected erros, othertweise return true
       *
       * @param array $file - superglobal array: $_FILES
       */
      public function validateFile(array $file)
      {

            if (!empty($file['name'])) {
                  if ($file['error'] == 0) {

                        $errorMessage = '';
                        /**
                         * size
                         */
                        $size = round($file['size'] / 1000, 3); // [kB]
                        if ($size > 1024) {
                              $errorMessage = '<li>Za duży rozmiar pliku. Max 1Mb</li>';
                        }

                        /**
                         * type
                         */
                        if (!in_array($file['type'], $this->imagesAllowedTypes)) {
                              $allowedExt = '';
                              foreach ($this->getImagesAllowedExtensions() as $value) {
                                    $allowedExt .= $value . ", ";
                              }
                              $allowedExt = rtrim($allowedExt, ", ");
                              $errorMessage .= "<li>Nieprawidłowy format pliku. Dozwolone: <b>$allowedExt</b>.</li>";
                        }

                        /**
                         * Savve od display errors
                         */
                        if ($errorMessage == '') {
                              return true;
                        } else {
                              FlashMessages::addMessage($errorMessage, 'warning');
                        }
                  } else {
                        FlashMessages::addMessage('Coś poszło nie tak, nie można dodać pliku!', 'danger');
                  }
            } else {
                  FlashMessages::addMessage("Nie dodano pliku. Dodaj plik.", 'warning');
            }

            $this->redirect('');
      }

      /**
       * 
       */
      public function saveFile(array $file)
      {

            $message = '';
            /**
             * Create a dir if not exists
             */
            $message .= self::_mkdir(Config::IMG_PATH);


            // new name:
            // $arr = explode('.', $file['name']);
            // $extension = end($arr);
            // $fileTargetPath = Config::IMG_PATH . '/' . date("Y_m_d__H.i.s") . "." . $extension;

            //  old name:
            $fileTargetPath = Config::IMG_PATH . '/' . $file['name'];

            // Check if image file is a actual image or fake image
            // getimagesize() - returns false on failure
            $check = getimagesize($file["tmp_name"]);
            if ($check) {

                  if (file_exists($fileTargetPath)) {
                        $message = 'P<li>lik o takiej nazwie już istnieje!</li>';
                        $type =  'warning';
                  } else {
                        if (move_uploaded_file($file["tmp_name"], $fileTargetPath)) {

                              $message .= "<li>Plik: <b>" . basename($file["name"]) . "</b> został dodany!</li>";
                        } else {

                              $message .= "<li>Nie można przennieść pliku z kataog</li>u tymczasowego!";
                              $type =  'warning';
                        }
                  }
            } else {
                  $message .= "<li>Coś poszło nie tak, nie można zapisaż zdjęcia.</li>";
                  $type =  'danger';
            }

            FlashMessages::addMessage($message, $type);
            $this->redirect('');
      }

      /**
       * 
       */
      public function resize(array $file)
      {
      }

      /**
       * Create dir if not exists
       *@param string $dir path to new dir
       */
      public static function _mkdir(string $dir)
      {
            if (!file_exists($dir)) {
                  if (mkdir($dir, 0777))
                        return "<li>Stworzono katalog: <b>$dir</b>.</li>";
            }
      }
}
