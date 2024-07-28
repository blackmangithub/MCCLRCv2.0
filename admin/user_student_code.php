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
        $message = "<html><body>";
        $message .= "<h1>Your Account has been Denied</h1>";
        $message .= "<p>Dear Student,</p>";
        $message .= "<p>Your MCC-LRC account registration has been denied. Please contact the library for more details.</p>";
        $message .= "<p>You can also contact us on our <a href='https://www.facebook.com/MCCLRC' target='_blank'>Facebook page</a>.</p>";
        $message .= "<p>Thank you.</p>";
        $message .= "</body></html>";

        sendEmail($student_email, $subject, $message);

        $_SESSION['message_success'] = 'Student Denied';
        header("Location: user_student_approval.php");
        exit(0);
    } else {
        $_SESSION['message_error'] = 'Student not Denied';
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
        $message = "<html><body>";
        $message .= "<h1>Your Account has been Approved</h1>";
        $message .= "<p>Dear Student,</p>";
        $message .= "<p>Your MCC-LRC account registration has been approved. You can now log in to your account.</p>";
        $message .= "<p>Thank you.</p>";
        $message .= "</body></html>";

        sendEmail($student_email, $subject, $message);

        $_SESSION['message_success'] = 'Student approved successfully';
        header("Location: user_student_approval.php");
        exit(0);
    } else {
        $_SESSION['message_error'] = 'Student not approved';
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
        $message = "<html><body>";
        $message .= "<h1>Your Account has been Blocked</h1>";
        $message .= "<p>Dear Student,</p>";
        $message .= "<p>Your MCC-LRC account has been blocked for a while. Please contact the library for more details.</p>";
        $message .= "<p>You can also contact us on our <a href='https://www.facebook.com/MCCLRC' target='_blank'>Facebook page</a>.</p>";
        $message .= "<p>Thank you.</p>";
        $message .= "</body></html>";

        sendEmail($student_email, $subject, $message);

        $_SESSION['message'] = "Student has been blocked successfully.";
        header("Location: user_student.php");
        exit(0);
    } else {
        $_SESSION['message'] = "Something went wrong.";
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
        $message = "<html><body>";
        $message .= "<h1>Your Account has been Unblocked</h1>";
        $message .= "<p>Dear Student,</p>";
        $message .= "<p>Your MCC-LRC account has been unblocked. You can now log in to your account.</p>";
        $message .= "<p>Thank you.</p>";
        $message .= "</body></html>";

        sendEmail($student_email, $subject, $message);

        $_SESSION['message'] = "Student has been unblocked successfully.";
        header("Location: user_student.php");
        exit(0);
    } else {
        $_SESSION['message'] = "Something went wrong.";
        header("Location: user_student.php");
        exit(0);
    }
}

// Delete Action
if(isset($_POST['delete_student'])) {
    $user_id = mysqli_real_escape_string($con, $_POST['delete_student']);
    $query = "DELETE FROM user WHERE user_id ='$user_id'";
    $query_run = mysqli_query($con, $query);

    if($query_run) {
        $_SESSION['message_success'] = 'Student deleted successfully';
        header("Location: user_student.php");
        exit(0);
    } else {
        $_SESSION['message_error'] = 'Student not deleted';
        header("Location: user_student.php");
        exit(0);
    }
}
?>
