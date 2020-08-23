<?php

use models\FlashMessages;
use models\ImgFileLoader;
use views\ShowImagesLinks;

include_once '../core/utilieties.php';

/**
 * Session
 */
session_start();

/**
 * Errors handling
 */
error_reporting(E_ALL);
set_exception_handler('myException');
set_error_handler('myError');

/**
 * Autoloader
 */
spl_autoload_register('myAutoloader');

/**
 * Load Images to public/images directory
 */
if (isset($_GET['url']) && $_GET['url'] == 'imgLoader') {
      if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            new ImgFileLoader($_FILES);
      } else {
            FlashMessages::addMessage("Nieprawidłowa metoda dostępu", 'danger');
      }
}

/**
 * Create form view
 */
include_once '../views/formView.php';

/**
 * Footer: Show images links 
 */
new ShowImagesLinks();
