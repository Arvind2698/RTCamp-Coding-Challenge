<?php
    require '../vendor/autoload.php';

    ini_set('display_errors', 1);

    function sendMail($to,$subject,$body){
      $transport = (new Swift_SmtpTransport('smtp.gmail.com', 587,'tls'))
      ->setUsername("USERNAME")
      ->setPassword("PASSWORD");

      // Create the Mailer using your created Transport
      $mailer = new Swift_Mailer($transport);

    // Create a message
      $message = (new Swift_Message($subject))
        ->setFrom(['rctarvind@gmail.com' => 'XKCD Email Verification'])
        ->setTo($to)
        ->setBody($body);

      $message->setContentType("text/html");
    // Send the message
      $result = $mailer->send($message);

      if($result){
        return true;
      }

      return false;

    }

?>