<?php
include('../../database/dbconfig.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../../plugins/PHPMailer/src/Exception.php';
require '../../plugins/PHPMailer/src/PHPMailer.php';
require '../../plugins/phpmailer/src/SMTP.php';

if (isset($_POST['submit_btn'])){

    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    try{
        if(empty($email) || empty($subject) || empty($message)){
            $_SESSION['danger'] = 'All fields are required.';
            header("Location: ../mail/");
            exit();
        }else{
            $mail = new PHPMailer(true);

            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'timexwatch01@gmail.com';
            $mail->Password   = 'qafnrifmdskupnkl';
            $mail->SMTPSecure = 'ssl';
            $mail->Port       = 465;

            $mail->addAddress($email);
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body = $message;

            $sendMail = $mail->send();
            if($sendMail){
                $_SESSION['success'] = 'Email Successfully Sent';
                header("Location: ../mail/");
                exit();
            }else{
                $_SESSION['danger'] = 'Email Failed to Send';
                header("Location: ../mail/");
                exit();
            }
        }
    }catch(Exception $e){
        echo 'Exception: '.$e->getMessage();
    }

}



?>