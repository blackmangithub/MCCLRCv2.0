<?php
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/vendor/phpmailer/phpmailer/src/Exception.php';
require 'phpmailer/vendor/phpmailer/phpmailer/src/PHPMailer.php';
require 'phpmailer/vendor/phpmailer/phpmailer/src/SMTP.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require 'admin/config/dbcon.php';

    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Invalid Email',
                    text: 'Please enter a valid MS 365 email address.',
                    confirmButtonText: 'OK'
                }).then(() => {
                    window.location.href = 'ms_verify.php';
                });
              </script>";
        exit();
    }

    $domain = substr(strrchr($email, "@"), 1);
    if ($domain !== 'mcclawis.edu.ph') {
        echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Invalid Domain',
                    text: 'Please enter an email address with the mcclawis.edu.ph domain.',
                    confirmButtonText: 'OK'
                }).then(() => {
                    window.location.href = 'ms_verify.php';
                });
              </script>";
        exit();
    }

    $stmt = $con->prepare("SELECT COUNT(*) FROM ms_account WHERE username = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();

    if ($count == 0) {
        echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Email Not Found',
                    text: 'If you don\'t have an MS 365 Account, go to the BSIT Office.',
                    confirmButtonText: 'OK'
                }).then(() => {
                    window.location.href = 'ms_verify.php';
                });
              </script>";
        exit();
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
            $mail->Username   = 'richmann276@gmail.com'; // Use environment variable
            $mail->Password   = 'higw jept zipw zrwn'; // Use environment variable
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port       = 465;

            $mail->setFrom('richmann276@gmail.com', 'MCC-LRC ADMIN');
            $mail->addAddress($email);"Please click the link below to create a MCC-LRC Account<br><br>
                               <a href='http://localhost/MCCLRCV2.0/signup.php?code=$verification_code'>Register</a>";

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
                        <p><a style='color: white;' href='http://localhost/MCCLRCV2.0/signup.php?code=$verification_code' class='button'>Register</a></p>
                        <p>If you did not request a link registration, please ignore this email.</p>
                    </div>
                </div>
            </body>
        </html>
        ";

            $mail->send();
            echo "<script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Registration link sent. Please check your email.',
                        confirmButtonText: 'OK'
                    }).then(() => {
                        window.location.href = 'ms_verify.php';
                    });
                  </script>";
        } catch (Exception $e) {
            echo "<script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Failed to send registration link. Please try again later.',
                        confirmButtonText: 'OK'
                    }).then(() => {
                        window.location.href = 'ms_verify.php';
                    });
                  </script>";
        }
    } else {
        echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Database Error',
                    text: 'Database error. Please try again later.',
                    confirmButtonText: 'OK'
                }).then(() => {
                    window.location.href = 'ms_verify.php';
                });
              </script>";
    }

    $stmt->close();
    $con->close();
} else {
    echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Invalid Request',
                text: 'Invalid request.',
                confirmButtonText: 'OK'
            }).then(() => {
                window.location.href = 'ms_verify.php';
            });
          </script>";
}
?>
