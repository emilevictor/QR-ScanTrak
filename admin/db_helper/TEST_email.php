<?php

	require_once '3rdparty/Swift-4.0.6/lib/swift_required.php';

 
/* Of course write a valid gmail account, my problem was that gmail needs ssl option*/
      $transport = Swift_SmtpTransport::newInstance('mail.uc.mediahug.com')
      ->setPort(465)
      ->setEncryption('ssl')
      ->setUsername('zombie.master+uc.mediahug.com')
      ->setPassword('uc2011')
      ;

    //Create the Mailer using your created Transport
    $mailer = Swift_Mailer::newInstance($transport);

    //Create a message
    $message = Swift_Message::newInstance('Test')
      ->setFrom(array('zombie.master@uc.mediahug.com' => 'ZombieMaster'))
      ->setTo(array('emilevictor@gmail.com', 'emilevictor@gmail.com' => 'Emile'))
      ->setBody('Body')
      ;

    //Send the message
    $result = $mailer->send($message);
  