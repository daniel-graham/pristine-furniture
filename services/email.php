<?php

require('PHPMailerAutoload.php'); //php mailer

function sendRegistrationEmail($firstName='', $lastName='', $email='', $settings='')
{

    PHPMailerAutoload("SMTP");
    PHPMailerAutoload("PHPMailer");

    $mail = new PHPMailer;

    $mailErrors = array();

    if(empty($firstName)){
        $errors[] = 'First name parameter must not be empty';
    }

    if(empty($lastName)){
        $errors[] = 'Last name parameter must not be empty';
    }

    if(empty($email)){
        $errors[] = 'Email parameter must not be empty';
    }

    if(empty($email)){
        $errors[] = 'Settings parameter must not be empty';
    }

    $mail->SMTPDebug = 3;                               // Enable verbose debug output

    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = $settings['host'];                                   // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = $settings['user'];                               // SMTP username
    $mail->Password = $settings['secret'];                             // SMTP password
    $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
    $mail->Port = $settings['smtpPort'];                              // TCP port to connect to

    $mail->setFrom($settings['senderAddress'], $settings['senderName']);
    $mail->addAddress($email, $firstName);     // Add a recipient
    $mail->addBCC('danleeusa@yahoo.com');


    $mail->isHTML(true);                                  // Set email format to HTML

    $mail->Subject = 'Registration Successful';
    $mail->Body = '<h1>You have successfully created an account with Pristine Furniture Trading Company.</h1><br><h2>Thank You '.$firstName.'!</h2>';
    $mail->AltBody = 'You have successfully created an account with Pristine Furniture Trading Company. Thank You!';

    if (!$mail->send()) {
        $mailErrors[] = 'Message could not be sent.';
        $mailErrors[] = 'Mailer Error: ' . $mail->ErrorInfo;
        return array(false, $mailErrors); // sending email unsuccessful.
    } else {
        return array(true, 'Your Account Has Been Registered. Please Check Your Email.'); // email sent successfully. ;
    }
}