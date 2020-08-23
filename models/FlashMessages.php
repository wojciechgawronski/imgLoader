<?php

namespace models;

class FlashMessages
{
      /**
       * Add a message
       *
       * @param string $message  The message content
       *
       * @return void
       */
      public static function addMessage($message, $type = 'success')
      {
            if($type == '') $type = 'success';
            
            // Create array in the session if it doesn't already exist
            if (!isset($_SESSION['flash_notifications'])) {
                  $_SESSION['flash_notifications'] = [];
            }

            // Append the message to the array
            // $_SESSION['flash_notifications']['type'] = $type;
            
            $_SESSION['flash_notifications']['message'] = 
            "<div class='container'><div class='rounded-0 alert alert-$type alert-dismissible fade show' role='alert'>
            $message
            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
              <span aria-hidden='true'>&times;</span>
            </button>
          </div></div>";
      }

      /**
       * Get all the messages
       *
       * @return mixed  An array with all the messages or null if none set
       */
      public static function getMessages()
      {
            if (isset($_SESSION['flash_notifications'])) {
                  $messages = $_SESSION['flash_notifications']['message'];
                  unset($_SESSION['flash_notifications']);

                  return $messages;
            }
      }
}