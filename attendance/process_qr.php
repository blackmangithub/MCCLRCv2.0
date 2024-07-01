<?php
include('config/dbcon.php');

if (isset($_POST['text'])) {
    $qr_code = $_POST['text'];

    // Query to select student based on student_id_no
    $student_query = "SELECT * FROM user WHERE student_id_no = '$qr_code'";
    $student_query_run = mysqli_query($con, $student_query);

    // Query to select faculty based on username
    $faculty_query = "SELECT * FROM user WHERE username = '$qr_code'";
    $faculty_query_run = mysqli_query($con, $faculty_query);

    if (mysqli_num_rows($student_query_run) > 0) {
        $user = mysqli_fetch_assoc($student_query_run);

        // Insert student log into user_log table
        $student_id = $user['student_id_no'];
        $firstname = $user['firstname'];
        $middlename = $user['middlename'];
        $lastname = $user['lastname'];
        $date_log = date("Y-m-d");

        $log_query = "INSERT INTO user_log (student_id, firstname, middlename, lastname, time_log, date_log) VALUES ('$student_id', '$firstname', '$middlename', '$lastname', NOW(), '$date_log')";
        $log_query_run = mysqli_query($con, $log_query);

        if ($log_query_run) {
            header("Location:attendance_list.php");
        } else {
            header("Location:qr_scanner.php");
            echo "Failed to insert log for student.";
        }
    } elseif (mysqli_num_rows($faculty_query_run) > 0) {
        $user = mysqli_fetch_assoc($faculty_query_run);

        // Insert faculty log into user_log table
        $username = $user['username'];
        $firstname = $user['firstname'];
        $middlename = $user['middlename'];
        $lastname = $user['lastname'];
        $date_log = date("Y-m-d");

        $log_query = "INSERT INTO user_log (username, firstname, middlename, lastname, time_log, date_log) VALUES ('$username', '$firstname', '$middlename', '$lastname', NOW(), '$date_log')";
        $log_query_run = mysqli_query($con, $log_query);

        if ($log_query_run) {
            header("Location:attendance_list.php");
        } else {
            header("Location:qr_scanner.php");
            echo "Failed to insert log for faculty.";
        }
    } else {
        echo "User not found";
    }
} else {
    echo "No QR code provided";
}
?>
