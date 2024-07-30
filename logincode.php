<?php 
session_start();
include('./admin/config/dbcon.php');

if(isset($_POST['login_btn'])) {
    $user_id = $_POST['student_id'];
    $password = $_POST['password'];
    $role = $_POST['role_as'];

    // Determine the login query based on role
    if($role == 'student') {
        $login_query = "SELECT * FROM user WHERE student_id_no = ? LIMIT 1";
    } elseif ($role == 'faculty' || $role == 'staff') {
        $login_query = "SELECT * FROM faculty WHERE username = ? LIMIT 1";
    } else {
        $_SESSION['status'] = "Invalid role specified";
        $_SESSION['status_code'] = "warning";
        header("Location: login.php");
        exit(0);
    }

    // Prepare and execute the SQL statement
    $stmt = mysqli_stmt_init($con);
    if (mysqli_stmt_prepare($stmt, $login_query)) {
        mysqli_stmt_bind_param($stmt, "s", $user_id);
        mysqli_stmt_execute($stmt);
        $login_query_run = mysqli_stmt_get_result($stmt);

        if(mysqli_num_rows($login_query_run) == 1) {
            $data = mysqli_fetch_assoc($login_query_run);
            $hashed_password = $data['password'];

            // Verify the password
            if (password_verify($password, $hashed_password)) {
                if ($role == 'student') {
                    $user_id = $data['user_id'];  
                } else {
                    $user_id = $data['faculty_id'];
                }
                $user_name = $data['firstname'] . ' ' . $data['lastname'];  
                $user_email = $data['email'];
                $role_as = $role;
                $status = $data['status'];

                // Check account status
                if ($status == 'approved') {
                    $_SESSION['auth'] = true;
                    $_SESSION['auth_role'] = $role_as;
                    $_SESSION['auth_stud'] = [
                        'stud_id' => $user_id,
                        'stud_name' => $user_name,
                        'email' => $user_email,
                    ];

                    $_SESSION['message_success'] = "Welcome to Web OPAC";
                    header("Location: index.php");
                    exit(0);
                } elseif ($status == 'pending') {
                    $_SESSION['status'] = "Your account is still pending for approval! Please wait..";
                } elseif ($status == 'blocked') {
                    $_SESSION['status'] = "Your account has been blocked!";
                }
                else {
                    $_SESSION['status'] = "Your account is inactive or disabled";
                }
            } else {
                $_SESSION['status'] = "Incorrect ID no. or Password";
            }
        } else {
            $_SESSION['status'] = "Incorrect ID no. or Password";
        }
    } else {
        $_SESSION['status'] = "Database error: Could not prepare statement";
    }
    $_SESSION['status_code'] = "error";
    header("Location: login.php");
    exit(0);
} else {
    $_SESSION['status'] = "You are not allowed to access this file";
    $_SESSION['status_code'] = "warning";
    header("Location: login.php");
    exit(0);
}
?>
