<?php
  require 'phpmailer/PHPMailerAutoload.php';
  
  function sendemail($emailparams) {
    $mail = new PHPMailer;
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'kartaymail@gmail.com';
    $mail->Password = 'kartaymail!@#';
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;
    $mail->setFrom('gajali@gajali.com', 'Gajali Team');
    $mail->addReplyTo('gajali@gajali.com', 'Gajali Team');
    $mail->addAddress($emailparams['to']);
    $mail->Subject = $emailparams['subject'];
    $mail->msgHTML($emailparams['message']);

    if (!$mail->send()) {
        echo "Mailer Error: " . $mail->ErrorInfo;
    } else {
        echo "Message sent!";
    }

  }
?>
