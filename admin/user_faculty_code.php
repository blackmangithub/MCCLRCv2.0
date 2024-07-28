<?php
include('authentication.php');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

// Function to send email notification
function sendEmail($email, $subject, $message) {
    $mail = new PHPMailer(true);
    try {
        //Server settings
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'richmann276@gmail.com';
        $mail->Password   = 'higw jept zipw zrwn';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        //Recipients
        $mail->setFrom('richmann276@gmail.com', 'MCC-LRC ADMIN');
        $mail->addAddress($email);

        //Content
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $message;

        $mail->send();
    } catch (Exception $e) {
        error_log("Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
    }
}

if(isset($_POST['deny'])) {
    $faculty_id = $_POST['faculty_id'];

    // Fetch faculty email
    $email_query = "SELECT email FROM faculty WHERE faculty_id='$faculty_id'";
    $email_result = mysqli_query($con, $email_query);
    $email_row = mysqli_fetch_assoc($email_result);
    $faculty_email = $email_row['email'];

    $query = "DELETE FROM faculty WHERE faculty_id = '$faculty_id'";
    $query_run = mysqli_query($con, $query);

    if($query_run) {
        // Send email notification
        $subject = "Account Denied Notification";
        $message = " <html>
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
                        <h1 style='color:#dc3545;text-align:center;'>Your Account has been Denied!!!</h1>
                        <p>Dear Faculty/Staff,</p>
                        <p>Your MCC-LRC account registration has been denied. Please contact the library for more details.</p>
                        <p>You can also contact us on our facebook page <a href='https://www.facebook.com/MCCLRC' target='_blank'>Madridejos Community College - Learning Resource Center</a>.</p>
                        <p>Thank you.</p>
                    </div>
                </div>
            </body>
        </html>
        ";

        sendEmail($faculty_email, $subject, $message);

        $_SESSION['message_success'] = 'Faculty Denied';
        header("Location: user_faculty_approval.php");
        exit(0);
    } else {
        $_SESSION['message_error'] = 'Faculty not Denied';
        header("Location: user_faculty_approval.php");
        exit(0);
    }
}

// Student Approval
if(isset($_POST['approved'])) {
    $faculty_id = $_POST['faculty_id'];

    // Fetch faculty email
    $email_query = "SELECT email FROM faculty WHERE faculty_id='$faculty_id'";
    $email_result = mysqli_query($con, $email_query);
    $email_row = mysqli_fetch_assoc($email_result);
    $faculty_email = $email_row['email'];

    $query = "UPDATE faculty SET status = 'approved' WHERE faculty_id = '$faculty_id'";
    $query_run = mysqli_query($con, $query);

    if($query_run) {
        // Send email notification
        $subject = "Account Approved Notification";
        $message = " <html>
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
                        <h1 style='color:#198754;text-align:center;'>Your Account has been Approved.</h1>
                        <p>Dear Faculty/Staff,</p>
                        <p>Your MCC-LRC account registration has been approved. You can now log in to your account.</p>
                        <p>Thank you.</p>
                    </div>
                </div>
            </body>
        </html>
        ";
        sendEmail($faculty_email, $subject, $message);

        $_SESSION['message_success'] = 'Faculty approved successfully';
        header("Location: user_faculty_approval.php");
        exit(0);
    } else {
        $_SESSION['message_error'] = 'Faculty not approved';
        header("Location: user_faculty_approval.php");
        exit(0);
    }
}

// Block faculty
if(isset($_POST['block_faculty'])) {
    $faculty_id = $_POST['block_faculty'];
    $query = "UPDATE faculty SET status='blocked' WHERE faculty_id='$faculty_id'";
    $query_run = mysqli_query($con, $query);

    if($query_run) {
        // Fetch faculty email
        $email_query = "SELECT email FROM faculty WHERE faculty_id='$faculty_id'";
        $email_result = mysqli_query($con, $email_query);
        $email_row = mysqli_fetch_assoc($email_result);
        $faculty_email = $email_row['email'];

        // Send email notification
        $subject = "Account Blocked Notification";
        $message = " <html>
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
                        <h1 style='color:#dc3545;text-align:center;'>Your Account has been Blocked!!!</h1>
                        <p>Dear Faculty/Staff,</p>
                        <p>Your MCC-LRC account has been blocked for a while. Please contact the library for more details.</p>
                        <p>You can also contact us on our facebook page <a href='https://www.facebook.com/MCCLRC' target='_blank'>Madridejos Community College - Learning Resource Center</a>.</p>
                        <p>Thank you.</p>
                    </div>
                </div>
            </body>
        </html>
        ";

        sendEmail($faculty_email, $subject, $message);

        $_SESSION['message'] = "Faculty staff has been blocked successfully.";
        header("Location: user_faculty.php");
        exit(0);
    } else {
        $_SESSION['message'] = "Something went wrong.";
        header("Location: user_faculty.php");
        exit(0);
    }
}

// Unblock faculty
if(isset($_POST['unblock_faculty'])) {
    $faculty_id = $_POST['unblock_faculty'];
    $query = "UPDATE faculty SET status='approved' WHERE faculty_id='$faculty_id'";
    $query_run = mysqli_query($con, $query);

    if($query_run) {
        // Fetch faculty email
        $email_query = "SELECT email FROM faculty WHERE faculty_id='$faculty_id'";
        $email_result = mysqli_query($con, $email_query);
        $email_row = mysqli_fetch_assoc($email_result);
        $faculty_email = $email_row['email'];

        // Send email notification
        $subject = "Account Unblocked Notification";
        $message = " <html>
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
                        <h1 style='color:#198754;text-align:center;'>Your Account has been Unblocked.</h1>
                        <p>Dear Faculty/Staff,</p>
                        <p>Your MCC-LRC account has been unblocked. You can now log in to your account.</p>
                        <p>Thank you.</p>
                    </div>
                </div>
            </body>
        </html>
        ";

        sendEmail($faculty_email, $subject, $message);

        $_SESSION['message'] = "Faculty staff has been unblocked successfully.";
        header("Location: user_faculty.php");
        exit(0);
    } else {
        $_SESSION['message'] = "Something went wrong.";
        header("Location: user_faculty.php");
        exit(0);
    }
}

// Delete Action
if(isset($_POST['delete_faculty'])) {
    $faculty_id = mysqli_real_escape_string($con, $_POST['delete_faculty']);
    $query = "DELETE FROM faculty WHERE faculty_id ='$faculty_id'";
    $query_run = mysqli_query($con, $query);

    if($query_run) {
        $_SESSION['message_success'] = 'Faculty deleted successfully';
        header("Location: user_faculty.php");
        exit(0);
    } else {
        $_SESSION['message_error'] = 'Faculty not deleted';
        header("Location: user_faculty.php");
        exit(0);
    }
}
?>
