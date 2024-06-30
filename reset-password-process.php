<?php
session_start();
include('./admin/config/dbcon.php');

if(isset($_POST['reset_password_btn'])) {
    $token = $_POST['token'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    if($new_password === $confirm_password) {
        // Hash the new password
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

        // Update the user's password in the database
        $query = "UPDATE user SET password='$hashed_password', reset_token=NULL, token_expiry=NULL WHERE reset_token='$token' AND token_expiry > NOW()";
        $query_run = mysqli_query($con, $query);

        if($query_run) {
            $_SESSION['message'] = "Password has been reset successfully.";
            header('Location: login.php');
            exit(0);
        } else {
            $_SESSION['message_error'] = "Invalid token or token expired.";
            header('Location: reset-password.php');
            exit(0);
        }
    } else {
        $_SESSION['message_error'] = "Passwords do not match.";
header('Location: reset-password-confirm.php?token=' . $token);
exit(0);
}
}
?>