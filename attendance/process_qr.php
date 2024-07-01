<?php
include('config/dbcon.php');

if (isset($_POST['text'])) {
    $qr_code = $_POST['text'];

    // Query to select user based on QR code
    $query = "SELECT * FROM user WHERE student_id_no = '$qr_code'";
    $query_run = mysqli_query($con, $query);

    if (mysqli_num_rows($query_run) > 0) {
        $user = mysqli_fetch_assoc($query_run);

        // Insert user log into user_log table
        $student_id = $user['student_id_no'];
        $firstname = $user['firstname'];
        $middlename = $user['middlename'];
        $lastname = $user['lastname'];
        $time_log = date("H:i:s");
        $date_log = date("Y-m-d");

        $log_query = "INSERT INTO user_log (student_id, firstname, middlename, lastname, time_log, date_log) VALUES ('$student_id', '$firstname', '$middlename', '$lastname', '$time_log', '$date_log')";
        $log_query_run = mysqli_query($con, $log_query);

        if ($log_query_run) {
            header("Location:attendance_list.php");
        } else {
            header("Location:qr_scanner.php");
            echo "Student ID No. not exist."
        }
    } else {
        echo "User not found";
    }
} else {
    echo "No QR code provided";
}
?>
