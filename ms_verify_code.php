<?php
session_start();
include('./admin/config/dbcon.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/vendor/phpmailer/phpmailer/src/Exception.php';
require 'phpmailer/vendor/phpmailer/phpmailer/src/PHPMailer.php';
require 'phpmailer/vendor/phpmailer/phpmailer/src/SMTP.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['status'] = "Invalid Email: Please enter a valid MS 365 email address.";
        $_SESSION['status_code'] = "error";
        header("Location:ms_verify.php");
        exit(0);
    }

    $domain = substr(strrchr($email, "@"), 1);
    if ($domain !== 'mcclawis.edu.ph') {
        $_SESSION['status'] = "Invalid Domain: Please enter an email address with the mcclawis.edu.ph domain.";
        $_SESSION['status_code'] = "error";
        header("Location:ms_verify.php");
        exit(0);
    }

    $stmt = $con->prepare("SELECT COUNT(*) FROM ms_account WHERE username = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();

    if ($count == 0) {
        $_SESSION['status'] = "Email Not Found: If you don\'t have an MS 365 Account, go to the BSIT Office.";
        $_SESSION['status_code'] = "error";
        header("Location:ms_verify.php");
        exit(0);
    }

    $verification_code = bin2hex(random_bytes(16));

    $stmt = $con->prepare("INSERT INTO email_verifications (email, verification_code, created_at) VALUES (?, ?, NOW())");
    $stmt->bind_param("ss", $email, $verification_code);

    if ($stmt->execute()) {
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'richmann276@gmail.com';
            $mail->Password   = 'higw jept zipw zrwn';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port       = 465;

            $mail->setFrom('richmann276@gmail.com', 'MCC-LRC ADMIN');
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = 'MCC-LRC Creating Account';
            $mail->Body    = "
            <html>
            <head>
                <style>
                    body {
                        font-family: Arial, sans-serif;
                        background-color: #f4f4f4;
                        margin: 0;
                        padding: 0;
                    }
                    .container {
                        width: 80%;
                        margin: 20px auto;
                        padding: 20px;
                        background-color: #fff;
                        border-radius: 8px;
                        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
                    }
                    .header {
                        text-align: center;
                        padding-bottom: 20px;
                        border-bottom: 1px solid #ddd;
                    }
                    .logo {
                        max-width: 150px;
                        height: auto;
                    }
                    .content {
                        padding: 20px 0;
                    }
                    .button {
                        display: inline-block;
                        padding: 10px 20px;
                        background-color: #007bff;
                        text-decoration: none;
                        color: white;
                        border-radius: 4px;
                    }
                </style>
            </head>
            <body>
                <div class='container'>
                    <div class='header'>
                        <img src='https://mcc-lrc.com/images/mcc-logo.png' alt='Logo'>
                    </div>
                    <div class='content'>
                        <p>Hello,</p>
                        <p>Please click the button below to create a MCC-LRC Account:</p>
                        <p><a style='color: white;' href='http://mcc-lrc.com/signup.php?code=$verification_code' class='button'>Register</a></p>
                        <p>If you did not request a link registration, please ignore this email.</p>
                    </div>
                </div>
            </body>
        </html>
        ";

            $mail->send();
                $_SESSION['status'] = "Registration link sent. Please check email on outlook.";
                $_SESSION['status_code'] = "success";
                header("Location:ms_verify.php");
                exit(0);
        } catch (Exception $e) {
                $_SESSION['status'] = "Failed to send registration link. Please try again later.";
                $_SESSION['status_code'] = "error";
                header("Location:ms_verify.php");
                exit(0);
        }
    } else {
            $_SESSION['status'] = "Database error. Please try again later.";
            $_SESSION['status_code'] = "error";
            header("Location:ms_verify.php");
            exit(0);
    }

    $stmt->close();
    $con->close();
} else {
        $_SESSION['status'] = "Invalid request.";
        $_SESSION['status_code'] = "error";
        header("Location:ms_verify.php");
        exit(0);
}
?>
