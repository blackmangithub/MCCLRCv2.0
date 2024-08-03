<?php
include('authentication.php');
use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    require 'phpmailer/vendor/phpmailer/phpmailer/src/Exception.php';
    require 'phpmailer/vendor/phpmailer/phpmailer/src/PHPMailer.php';
    require 'phpmailer/vendor/phpmailer/phpmailer/src/SMTP.php';

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

// Student Deny
if(isset($_POST['deny'])) {
    $student_id = $_POST['user_id'];

    // Fetch student email
    $email_query = "SELECT email FROM user WHERE user_id='$student_id'";
    $email_result = mysqli_query($con, $email_query);
    $email_row = mysqli_fetch_assoc($email_result);
    $student_email = $email_row['email'];

    $query = "DELETE FROM user WHERE user_id = '$student_id'";
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
                        <p>Dear Student,</p>
                        <p>Your MCC-LRC account registration has been denied. Please contact the library for more details.</p>
                        <p>You can also contact us on our facebook page <a href='https://www.facebook.com/MCCLRC' target='_blank'>Madridejos Community College - Learning Resource Center</a>.</p>
                        <p>Thank you.</p>
                    </div>
                </div>
            </body>
        </html>
        ";
        sendEmail($student_email, $subject, $message);

        $_SESSION['status'] = 'Student Denied';
        $_SESSION['status_code'] = "success";
        header("Location: user_student_approval.php");
        exit(0);
    } else {
        $_SESSION['status'] = 'Student not Denied';
        $_SESSION['status_code'] = "error";
        header("Location: user_student_approval.php");
        exit(0);
    }
}

// Student Approval
if(isset($_POST['approved'])) {
    $student_id = $_POST['user_id'];

    // Fetch student email
    $email_query = "SELECT email FROM user WHERE user_id='$student_id'";
    $email_result = mysqli_query($con, $email_query);
    $email_row = mysqli_fetch_assoc($email_result);
    $student_email = $email_row['email'];

    $query = "UPDATE user SET status = 'approved' WHERE user_id = '$student_id'";
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
                        <p>Dear Student,</p>
                        <p>Your MCC-LRC account registration has been approved. You can now log in to your account.</p>
                        <p><a href='http://mcc-lrc.com/login.php' class='btn btn-primary'>Login</a></p>
                        <p>Thank you.</p>
                    </div>
                </div>
            </body>
        </html>
        ";
        sendEmail($student_email, $subject, $message);

        $_SESSION['status'] = 'Student approved successfully';
        $_SESSION['status_code'] = "success";
        header("Location: user_student_approval.php");
        exit(0);
    } else {
        $_SESSION['status'] = 'Student not approved';
        $_SESSION['status_code'] = "error";
        header("Location: user_student_approval.php");
        exit(0);
    }
}

// Block student
if(isset($_POST['block_student'])) {
    $user_id = $_POST['block_student'];
    $query = "UPDATE user SET status='blocked' WHERE user_id='$user_id'";
    $query_run = mysqli_query($con, $query);

    if($query_run) {
        // Fetch student email
        $email_query = "SELECT email FROM user WHERE user_id='$user_id'";
        $email_result = mysqli_query($con, $email_query);
        $email_row = mysqli_fetch_assoc($email_result);
        $student_email = $email_row['email'];

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
                        <p>Dear Student,</p>
                        <p>Your MCC-LRC account has been blocked for a while. Please contact the library for more details.</p>
                        <p>You can also contact us on our facebook page <a href='https://www.facebook.com/MCCLRC' target='_blank'>Madridejos Community College - Learning Resource Center</a>.</p>
                        <p>Thank you.</p>
                    </div>
                </div>
            </body>
        </html>
        ";
        sendEmail($student_email, $subject, $message);

        $_SESSION['status'] = "Student has been blocked successfully.";
        $_SESSION['status_code'] = "success";
        header("Location: user_student.php");
        exit(0);
    } else {
        $_SESSION['status'] = "Something went wrong.";
        $_SESSION['status_code'] = "error";
        header("Location: user_student.php");
        exit(0);
    }
}

// Unblock student
if(isset($_POST['unblock_student'])) {
    $user_id = $_POST['unblock_student'];
    $query = "UPDATE user SET status='approved' WHERE user_id='$user_id'";
    $query_run = mysqli_query($con, $query);

    if($query_run) {
        // Fetch student email
        $email_query = "SELECT email FROM user WHERE user_id='$user_id'";
        $email_result = mysqli_query($con, $email_query);
        $email_row = mysqli_fetch_assoc($email_result);
        $student_email = $email_row['email'];

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
                        <p>Dear Student,</p>
                        <p>Your MCC-LRC account has been unblocked. You can now log in to your account.</p>
                        <p>Thank you.</p>
                    </div>
                </div>
            </body>
        </html>
        ";

        sendEmail($student_email, $subject, $message);

        $_SESSION['status'] = "Student has been unblocked successfully.";
        $_SESSION['status_code'] = "success";
        header("Location: user_student.php");
        exit(0);
    } else {
        $_SESSION['status'] = "Something went wrong.";
        $_SESSION['status_code'] = "error";
        header("Location: user_student.php");
        exit(0);
    }
}

// Delete Action
if (isset($_POST['delete_student'])) {
    $user_id = mysqli_real_escape_string($con, $_POST['delete_student']);

    // Fetch the email associated with the user_id
    $email_query = "SELECT email FROM user WHERE user_id = '$user_id'";
    $email_query_run = mysqli_query($con, $email_query);

    if ($email_query_run && mysqli_num_rows($email_query_run) > 0) {
        $email_row = mysqli_fetch_assoc($email_query_run);
        $email = $email_row['email'];

        // Delete from the user table
        $delete_user_query = "DELETE FROM user WHERE user_id = '$user_id'";
        $delete_user_query_run = mysqli_query($con, $delete_user_query);

        // Delete from the email_verifications table
        $delete_email_verification_query = "DELETE FROM email_verifications WHERE email = '$email'";
        $delete_email_verification_query_run = mysqli_query($con, $delete_email_verification_query);

        if ($delete_user_query_run && $delete_email_verification_query_run) {
            $_SESSION['status'] = 'Student deleted successfully';
            $_SESSION['status_code'] = "success";
        } else {
            $_SESSION['status'] = 'Student not deleted';
            $_SESSION['status_code'] = "error";
        }
    } else {
        $_SESSION['status'] = 'User ID not found';
        $_SESSION['status_code'] = "error";
    }

    header("Location: user_student.php");
    exit(0);
}
?>
