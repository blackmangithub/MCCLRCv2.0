<?php
session_start();
include('./admin/config/dbcon.php');

if(isset($_POST['reset_btn'])) {
    $email = $_POST['email'];
    
    // Check if email exists in the database
    $query = "SELECT * FROM user WHERE email='$email'";
    $query_run = mysqli_query($con, $query);

    if(mysqli_num_rows($query_run) > 0) {
        // Generate a unique token
        $token = bin2hex(random_bytes(50));
        
        // Store the token in the database with an expiry date
        $update_token_query = "UPDATE user SET reset_token='$token', token_expiry=DATE_ADD(NOW(), INTERVAL 1 HOUR) WHERE email='$email'";
        $update_token_query_run = mysqli_query($con, $update_token_query);

        if($update_token_query_run) {
            // Send the email with the reset link
            $reset_link = "http://localhost/mcclrc/reset-password-confirm.php?token=$token";
            $subject = "Password Reset Request";
            $body = "Hi, Click here to reset your password: $reset_link";
            $headers = "From: bman23382@gmail.com"; // Replace with your actual email address

            if(mail($email, $subject, $body, $headers)) {
                $_SESSION['message'] = "Password reset link has been sent to your email.";
                header('Location: login.php');
                exit();
            } else {
                $_SESSION['message_error'] = "Failed to send the reset link. Please try again later.";
                error_log("Failed to send email: " . error_get_last()['message']); // Log the error
                header('Location: reset-password.php');
                exit();
            }            
        } else {
            $_SESSION['message_error'] = "Something went wrong while updating the reset token. Please try again.";
            error_log("Database error: " . mysqli_error($con)); // Log the database error
            header('Location: reset-password.php');
            exit();
        }
    } else {
        $_SESSION['message_error'] = "No account found with that email.";
        header('Location: reset-password.php');
        exit();
    }
}
?>
