<?php 
session_start();
include('./admin/config/dbcon.php');
require_once('./qrcode/qrlib.php');

if (isset($_POST['register_btn'])) {
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
    $profile_image = $_FILES['profile_image'];

    // Validate mandatory fields
    if (empty($lastname) || empty($firstname) || empty($gender) || empty($birthdate) || empty($address) || empty($cell_no) || empty($email) || empty($student_id_no) || empty($password) || empty($cpassword) || empty($role_as) || empty($profile_image)) {
        $_SESSION['status'] = "Please fill up all fields";
        $_SESSION['status_code'] = "warning";
        header("Location: signup.php");
        exit(0);
    }

    // Check if passwords match
    if ($password !== $cpassword) {
        $_SESSION['status'] = "Password and Confirm Password do not match";
        $_SESSION['status_code'] = "warning";
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

    if (mysqli_num_rows($check_query_run) > 0) {
        $_SESSION['status'] = ($role_as == 'student') ? "Student ID No. already exists" : "Username already exists";
        $_SESSION['status_code'] = "warning";
        header("Location: signup.php");
        exit(0);
    } elseif (mysqli_num_rows($email_check_query_run) > 0) {
        $_SESSION['status'] = "Email already exists";
        $_SESSION['status_code'] = "warning";
        header("Location: signup.php");
        exit(0);
    }

    // Check email verification
    $check_verify = "SELECT used FROM email_verifications WHERE email = '$email'";
    $check_verify_run = mysqli_query($con, $check_verify);

    if (mysqli_num_rows($check_verify_run) > 0) {
        $row = mysqli_fetch_array($check_verify_run);
        $used = $row['used'];

        if ($used == 0) {
            // Hash the password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Handle image upload
            $image_path = "";
            if (isset($profile_image) && $profile_image['error'] == 0) {
                $target_dir = "./uploads/profile_images/";
                $image_name = basename($profile_image['name']);
                $target_file = $target_dir . $image_name;
                $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
                $check = getimagesize($profile_image['tmp_name']);
                
                // Check if image file is a actual image or fake image
                if($check !== false) {
                    // Check file size (limit to 2MB)
                    if ($profile_image["size"] <= 2097152) {
                        // Allow certain file formats
                        if($imageFileType == "jpg" || $imageFileType == "png" || $imageFileType == "jpeg" ) {
                            if (move_uploaded_file($profile_image["tmp_name"], $target_file)) {
                                $image_path = $image_name;
                            } else {
                                $_SESSION['status'] = "Sorry, there was an error uploading your file.";
                                $_SESSION['status_code'] = "error";
                                header("Location: signup.php");
                                exit(0);
                            }
                        } else {
                            $_SESSION['status'] = "Sorry, only JPG, JPEG & PNG files are allowed.";
                            $_SESSION['status_code'] = "error";
                            header("Location: signup.php");
                            exit(0);
                        }
                    } else {
                        $_SESSION['status'] = "Sorry, your file is too large. Maximum size is 2MB.";
                        $_SESSION['status_code'] = "error";
                        header("Location: signup.php");
                        exit(0);
                    }
                } else {
                    $_SESSION['status'] = "File is not an image.";
                    $_SESSION['status_code'] = "error";
                    header("Location: signup.php");
                    exit(0);
                }
            }

            // Prepare and execute INSERT query
            $insert_query = "";
            if ($role_as == 'student') {
                $insert_query = "INSERT INTO user (lastname, firstname, middlename, gender, course, address, cell_no, birthdate, email, year_level, student_id_no, password, role_as, status, user_added, profile_image) VALUES ('$lastname', '$firstname', '$middlename', '$gender', '$course', '$address', '$cell_no', '$birthdate', '$email', '$year_level', '$student_id_no', '$hashed_password', '$role_as', 'pending', NOW(), '$image_path')";
            } elseif ($role_as == 'faculty' || $role_as == 'staff') {
                $insert_query = "INSERT INTO faculty (lastname, firstname, middlename, gender, course, address, cell_no, birthdate, email, username, password, role_as, status, faculty_added, profile_image) VALUES ('$lastname', '$firstname', '$middlename', '$gender', '$course', '$address', '$cell_no', '$birthdate', '$email', '$student_id_no', '$hashed_password', '$role_as', 'pending', NOW(), '$image_path')";
            }

            if (mysqli_query($con, $insert_query)) {
                // Generate QR Code
                $identifier = $student_id_no; // Adjust username if needed for faculty
                $qrdata = "$identifier"; // Example data to encode in QR code
                $qrfile = "./qrcodes/$identifier.png"; // Path to save QR code image
                $qrimage = "$identifier.png";
                QRcode::png($qrdata, $qrfile); // Generate QR code

                // Insert QR code path into database
                $update_query = "";
                if ($role_as == 'student') {
                    $update_query = "UPDATE user SET qr_code = '$qrimage' WHERE student_id_no = '$student_id_no'";
                } elseif ($role_as == 'faculty' || $role_as == 'staff') {
                    $update_query = "UPDATE faculty SET qr_code = '$qrimage' WHERE username = '$student_id_no'";
                }

                if (mysqli_query($con, $update_query)) {
                    $update_verify = "UPDATE email_verifications SET used = 1 WHERE email = '$email'";
                    mysqli_query($con, $update_verify);
                    $_SESSION['status'] = "Registered successfully, wait for approval.";
                    $_SESSION['status_code'] = "success";
                    header("Location: login.php");
                    exit(0);
                } else {
                    $_SESSION['status'] = "Failed to update QR code path in database";
                    $_SESSION['status_code'] = "error";
                    header("Location: signup.php");
                    exit(0);
                }
            } else {
                $_SESSION['status'] = "Failed to register user";
                $_SESSION['status_code'] = "error";
                header("Location: signup.php");
                exit(0);
            }
        } else {
            $_SESSION['status'] = "Link already been used.";
            $_SESSION['status_code'] = "error";
            header("Location: signup.php");
            exit(0);
        }
    } else {
        $_SESSION['status'] = "Email verification not found.";
        $_SESSION['status_code'] = "error";
        header("Location: signup.php");
        exit(0);
    }
} else {
    $_SESSION['status'] = "Please fill up all the fields";
    $_SESSION['status_code'] = "warning";
    header("Location: signup.php");
    exit(0);
}
?>
