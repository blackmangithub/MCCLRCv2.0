<?php
session_start();
include('./admin/config/dbcon.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require 'vendor/autoload.php';

$mail = new PHPMailer(true);

function send_password_reset($get_name, $get_email, $token)
{
    global $mail;

    try {
        // SMTP server configuration
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'richmann276@gmail.com';
        $mail->Password = 'richmann1234!?'; // Use an app-specific password
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        // Sender and recipient settings
        $mail->setFrom('richmann276@gmail.com', 'Rich Mann');
        $mail->addAddress($get_email, $get_name);
        $mail->addReplyTo('richmann276@gmail.com', 'Rich Mann');

        // Email content settings
        $mail->isHTML(true);
        $mail->Subject = 'Reset Password Notification';
        $mail->Body = "
            <h2>Hello</h2>
            <h3>You are receiving this email because we received a password reset request for your account.</h3>
            <br/><br/>
            <a href='http://localhost/MCCLRCV2.0/password-change.php?token=$token&email=$get_email'>Click Me</a>
        ";

        $mail->send();
    } catch (Exception $e) {
        error_log("Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
    }
}

if (isset($_POST['password_reset_link'])) {
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $token = md5(rand());

    $check_email = "SELECT firstname, email FROM user WHERE email='$email' LIMIT 1";
    $check_email_run = mysqli_query($con, $check_email);

    if (mysqli_num_rows($check_email_run) > 0) {
        $row = mysqli_fetch_array($check_email_run);
        $get_name = $row['firstname'];
        $get_email = $row['email'];

        $update_token = "UPDATE user SET verify_token='$token' WHERE email='$get_email' LIMIT 1";
        $update_token_run = mysqli_query($con, $update_token);

        if ($update_token_run) {
            send_password_reset($get_name, $get_email, $token);
            $_SESSION['status'] = 'We e-mailed you a password reset link';
            header('Location: password-reset.php');
            exit(0);
        } else {
            $_SESSION['status'] = 'Something went wrong.';
            header('Location: password-reset.php');
            exit(0);
        }
    } else {
        $_SESSION['status'] = 'No email found';
        header('Location: password-reset.php');
        exit(0);
    }
}
?>
