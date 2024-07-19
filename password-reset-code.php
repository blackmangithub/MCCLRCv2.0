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
        $mail->Password = 'higw jept zipw zrwn'; // Use an app-specific password
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
            <img src='http://localhost/MCCLRCv2.0/assets/img/mcc-logo.png' alt='MCC Logo'>
            <h2>Hello</h2>
            <h3>You are receiving this email because we received a password reset request for your account.</h3>
            <br/><br/>
            <button style='background-color: dodgerblue;border:none;border-radius:5px;padding:7px;'><a style='text-decoration:none;color:white;font-weight:800;' href='http://localhost/MCCLRCV2.0/password-change.php?token=$token&email=$get_email'>Click Me</a></button>
        ";

        $mail->send();
    } catch (Exception $e) {
        error_log("Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
    }
}

if (isset($_POST['password_reset_link'])) {
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $token = md5(rand());

    // User table check
    $check_email_user = "SELECT firstname, email FROM user WHERE email='$email' LIMIT 1";
    $check_email_run_user = mysqli_query($con, $check_email_user);

    if (mysqli_num_rows($check_email_run_user) > 0) {
        $row = mysqli_fetch_array($check_email_run_user);
        $get_name = $row['firstname'];
        $get_email = $row['email'];

        $update_token_user = "UPDATE user SET verify_token='$token', token_used=0 WHERE email='$get_email' LIMIT 1";
        $update_token_run_user = mysqli_query($con, $update_token_user);

        if ($update_token_run_user) {
            send_password_reset($get_name, $get_email, $token);
            $_SESSION['status'] = 'We e-mailed you a password reset link';
                $_SESSION['alert_type'] = 'success'; // Optional: Set the alert type if needed
                header('Location: password-reset.php');
                exit(0);
        }
    }

    // Faculty table check
    $check_email_faculty = "SELECT firstname, email FROM faculty WHERE email='$email' LIMIT 1";
    $check_email_run_faculty = mysqli_query($con, $check_email_faculty);

    if (mysqli_num_rows($check_email_run_faculty) > 0) {
        $row = mysqli_fetch_array($check_email_run_faculty);
        $get_name = $row['firstname'];
        $get_email = $row['email'];

        $update_token_faculty = "UPDATE faculty SET verify_token='$token', token_used=0 WHERE email='$get_email' LIMIT 1";
        $update_token_run_faculty = mysqli_query($con, $update_token_faculty);

        if ($update_token_run_faculty) {
            send_password_reset($get_name, $get_email, $token);
            $_SESSION['status'] = 'We e-mailed you a password reset link';
            $_SESSION['alert_type'] = 'success';
            header('Location: password-reset.php');
            exit(0);
        }
    } else {
        $_SESSION['status'] = 'No email found';
        $_SESSION['alert_type'] = 'danger';
        header('Location: password-reset.php');
        exit(0);
    }
}

if (isset($_POST['password-change'])) {
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $new_password = mysqli_real_escape_string($con, $_POST['new_password']);
    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
    $current_time = date("Y-m-d H:i:s");

    // User table check
    $check_email_user = "SELECT email, token_used FROM user WHERE email='$email' LIMIT 1";
    $check_email_run_user = mysqli_query($con, $check_email_user);

    if (mysqli_num_rows($check_email_run_user) > 0) {
        $row = mysqli_fetch_array($check_email_run_user);
        $get_email = $row['email'];
        $token_used = $row['token_used'];

        // Check if token is used
        if ($token_used == 0) {
            $update_password_user = "UPDATE user SET password='$hashed_password', token_used=1 WHERE email='$get_email' LIMIT 1";
            $update_password_run_user = mysqli_query($con, $update_password_user);

            if ($update_password_run_user) {
                $_SESSION['status'] = 'Password successfully changed.';
                $_SESSION['alert_type'] = 'success'; // Optional: Set the alert type if needed
                header('Location: login.php');
                exit(0);
            }
        } else {
            $_SESSION['status'] = 'Link already been used. Please request a new password reset link.';
            $_SESSION['alert_type'] = 'danger';
            header('Location: password-reset.php');
            exit(0);
        }
    }

    // Faculty table check
    $check_email_faculty = "SELECT email, token_used FROM faculty WHERE email='$email' LIMIT 1";
    $check_email_run_faculty = mysqli_query($con, $check_email_faculty);

    if (mysqli_num_rows($check_email_run_faculty) > 0) {
        $row = mysqli_fetch_array($check_email_run_faculty);
        $get_email = $row['email'];
        $token_used = $row['token_used'];

        // Check if token is used
        if ($token_used == 0) {
            $update_password_faculty = "UPDATE faculty SET password='$hashed_password', token_used=1 WHERE email='$get_email' LIMIT 1";
            $update_password_run_faculty = mysqli_query($con, $update_password_faculty);

            if ($update_password_run_faculty) {
                $_SESSION['status'] = 'Password successfully changed.';
                $_SESSION['alert_type'] = 'success'; // Optional: Set the alert type if needed
                header('Location: login.php');
                exit(0);
            }
        } else {
            $_SESSION['status'] = 'Link already been used. Please request a new password reset link.';
            header('Location: password-reset.php');
            exit(0);
        }
    } else {
        $_SESSION['status'] = 'Something went wrong.';
        header('Location: password-change.php');
        exit(0);
    }
}
?>
