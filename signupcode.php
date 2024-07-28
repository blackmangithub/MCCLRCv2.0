<?php
session_start();
include('./admin/config/dbcon.php');
require_once('./qrcode/qrlib.php'); // Path to the QR Code library

if(isset($_POST['register_btn'])) {
    // Fetch and sanitize input
    $lastname = mysqli_real_escape_string($con, $_POST['lastname']);
    $firstname = mysqli_real_escape_string($con, $_POST['firstname']);
    $middlename = mysqli_real_escape_string($con, $_POST['middlename']);
    $gender = mysqli_real_escape_string($con, $_POST['gender']);
    $birthdate = mysqli_real_escape_string($con, $_POST['birthdate']);
    $address = mysqli_real_escape_string($con, $_POST['address']);
    $cell_no = mysqli_real_escape_string($con, $_POST['cell_no']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $year_level = mysqli_real_escape_string($con, $_POST['year_level']);
    $course = mysqli_real_escape_string($con, $_POST['course']);
    $student_id_no = mysqli_real_escape_string($con, $_POST['student_id_no']);
    $password = mysqli_real_escape_string($con, $_POST['password']);
    $cpassword = mysqli_real_escape_string($con, $_POST['cpassword']);
    $role_as = mysqli_real_escape_string($con, $_POST['role']);

    // Validate mandatory fields
    if(empty($lastname) || empty($firstname) || empty($gender) || empty($birthdate) || empty($address) || empty($cell_no) || empty($email) || empty($student_id_no) || empty($password) || empty($cpassword) || empty($role_as)) {
        $_SESSION['message_error'] = "Please fill up all fields";
        header("Location: signup.php");
        exit(0);
    }

    // Check if passwords match
    if($password !== $cpassword) {
        $_SESSION['message_error'] = "Password and Confirm Password do not match";
        header("Location: signup.php");
        exit(0);
    }

    // Check if student ID, username, or email already exists
    $check_query = "";
    $email_check_query = "SELECT email FROM user WHERE email = '$email' UNION SELECT email FROM faculty WHERE email = '$email'";

    if ($role_as == 'student') {
        $check_query = "SELECT student_id_no FROM user WHERE student_id_no = '$student_id_no'";
    } elseif ($role_as == 'faculty' || $role_as == 'staff') {
        $check_query = "SELECT username FROM faculty WHERE username = '$student_id_no'"; // Assuming username is used for faculty
    }

    $check_query_run = mysqli_query($con, $check_query);
    $email_check_query_run = mysqli_query($con, $email_check_query);

    if(mysqli_num_rows($check_query_run) > 0) {
        $_SESSION['message_error'] = ($role_as == 'student') ? "Student ID No. already exists" : "Username already exists";
        header("Location: signup.php");
        exit(0);
    } elseif (mysqli_num_rows($email_check_query_run) > 0) {
        $_SESSION['message_error'] = "Email already exists";
        header("Location: signup.php");
        exit(0);
    }

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Prepare and execute INSERT query
    $insert_query = "";
    if($role_as == 'student') {
        $insert_query = "INSERT INTO user (lastname, firstname, middlename, gender, course, address, cell_no, birthdate, email, year_level, student_id_no, password, role_as, status, user_added) VALUES ('$lastname', '$firstname', '$middlename', '$gender', '$course', '$address', '$cell_no', '$birthdate', '$email', '$year_level', '$student_id_no', '$hashed_password', '$role_as', 'pending', NOW())";
    } elseif($role_as == 'faculty' || $role_as == 'staff') {
        $insert_query = "INSERT INTO faculty (lastname, firstname, middlename, gender, course, address, cell_no, birthdate, email, username, password, role_as, status, faculty_added) VALUES ('$lastname', '$firstname', '$middlename', '$gender', '$course', '$address', '$cell_no', '$birthdate', '$email', '$student_id_no', '$hashed_password', '$role_as', 'pending', NOW())";
    }

    if(mysqli_query($con, $insert_query)) {
        // Generate QR Code
        $identifier = ($role_as == 'student') ? $student_id_no : $student_id_no; // Adjust username if needed for faculty
        $qrdata = "$identifier"; // Example data to encode in QR code
        $qrfile = "./qrcodes/$identifier.png"; // Path to save QR code image
        $qrimage = "$identifier.png";
        QRcode::png($qrdata, $qrfile); // Generate QR code

        // Insert QR code path into database
        $update_query = "";
        if($role_as == 'student') {
            $update_query = "UPDATE user SET qr_code = '$qrimage' WHERE student_id_no = '$student_id_no'";
        } elseif($role_as == 'faculty' || $role_as == 'staff') {
            $update_query = "UPDATE faculty SET qr_code = '$qrimage' WHERE username = '$student_id_no'";
        }

        if(mysqli_query($con, $update_query)) {
            $_SESSION['message_success'] = "Registered successfully, wait for approval.";
            header("Location: login.php");
            exit(0);
        } else {
            $_SESSION['message_error'] = "Failed to update QR code path in database";
            header("Location: signup.php");
            exit(0);
        }
    } else {
        $_SESSION['message_error'] = "Failed to register user";
        header("Location: signup.php");
        exit(0);
    }
} else {
    $_SESSION['message'] = "Please input all the fields";
    header("Location: signup.php");
    exit(0);
}
?>
