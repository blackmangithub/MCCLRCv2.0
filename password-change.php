<?php
session_start();
include('./admin/config/dbcon.php');

$email = $_GET['email'];

// Prepare and execute user query
$user_query = $con->prepare("SELECT * FROM user WHERE email = ?");
$user_query->bind_param("s", $email);
$user_query->execute();
$user_result = $user_query->get_result();
$user_row = $user_result->fetch_assoc();

// Prepare and execute faculty query
$faculty_query = $con->prepare("SELECT * FROM faculty WHERE email = ?");
$faculty_query->bind_param("s", $email);
$faculty_query->execute();
$faculty_result = $faculty_query->get_result();
$faculty_row = $faculty_result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="./assets/img/mcc-logo.png">
    <title>New Password</title>

    <!-- Alertify JS link -->
    <link rel="stylesheet" href="assets/css/alertify.min.css" />
    <link rel="stylesheet" href="assets/css/alertify.bootstraptheme.min.css" />
    <link rel="stylesheet" href="assets/css/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.1/font/bootstrap-icons.min.css">

    <!-- Iconscout CDN link -->
    <link rel="stylesheet" href="assets/css/line.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="assets/css/bootstrap5.min.css" />

    <!-- Bootstrap Icon -->
    <link rel="stylesheet" href="assets/font/bootstrap-icons.css">

    <!-- Custom CSS Styling -->
    <link rel="stylesheet" href="assets/css/login.css">

    <style>
        .back {
            position: fixed;
            left: 20px;
            top: 10px;
            font-size: 30px;
            color: black;
        }
        .back:hover {
            color: gray;
        }
        /* Custom styles for toggle password icon */
        .toggle-password {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #777; /* Adjust color as needed */
        }
        .toggle-password-icon {
            font-size: 16px; /* Adjust icon size */
        }
        /* Adjust icon color when hovered */
        .toggle-password:hover .toggle-password-icon {
            color: #333;
        }
    </style>
</head>

<body>
    <section class="d-flex mt-1 flex-column justify-content-center align-items-center">
        <div class="container-xl">
            <div class="col mx-auto rounded shadow bg-white">
                <div class="row">
                    <div class="col-md-6">
                        <div class="">
                            <img src="assets/img/mcc-logo.png" alt="logo" class="img-fluid d-none d-md-block p-5" />
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6 px-5" style="margin-top: 50px;">
                        <div class="mt-3 mb-4">
                            <center>
                                <h4 class="m-0">Set New Password</h4>
                                <p class="fs-4 fw-semibold text-primary">Enter new password.</p>
                            </center>
                        </div>
                        <form action="password-reset-code.php" method="POST" class="needs-validation" novalidate style="margin-top:30px;" onsubmit="return validatePassword()">
                            <!-- Add hidden input field to pass email -->
                            <input type="hidden" name="email" value="<?php echo htmlspecialchars($email); ?>"> 

                            <div class="col-md-12">
                                <div class="form-floating mb-3">
                                    <input type="password" id="passwordInput" class="form-control" name="new_password" placeholder="New Password" required>
                                    <label for="password">New Password</label>
                                    <span class="toggle-password" onclick="togglePasswordVisibility('passwordInput', 'passwordToggleIcon')">
                                        <i class="bi bi-eye toggle-password-icon" id="passwordToggleIcon"></i>
                                    </span>
                                    <div id="passwordLengthFeedback" class="invalid-feedback">
                                        Password must be at least 8 characters long.
                                    </div>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="password" id="confirmPasswordInput" class="form-control" name="cpassword" placeholder="Confirm New Password" required>
                                    <label for="cpassword">Confirm Password</label>
                                    <span class="toggle-password" onclick="togglePasswordVisibility('confirmPasswordInput', 'confirmPasswordToggleIcon')">
                                        <i class="bi bi-eye toggle-password-icon" id="confirmPasswordToggleIcon"></i>
                                    </span>
                                    <div id="passwordMatchFeedback" class="invalid-feedback">
                                        Passwords do not match.
                                    </div>
                                </div>
                            </div>
                            <div class="d-grid gap-2 md-3">
                                <button type="submit" name="password-change" class="btn btn-primary text-light font-weight-bolder btn-lg">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script>
        function validatePassword() {
            var password = document.getElementById("passwordInput").value;
            var cpassword = document.getElementById("confirmPasswordInput").value;
            var isValid = true;

            if (password.length < 8) {
                document.getElementById("passwordLengthFeedback").style.display = "block";
                isValid = false;
            } else {
                document.getElementById("passwordLengthFeedback").style.display = "none";
            }

            if (password !== cpassword) {
                document.getElementById("passwordMatchFeedback").style.display = "block";
                isValid = false;
            } else {
                document.getElementById("passwordMatchFeedback").style.display = "none";
            }

            return isValid;
        }

        function togglePasswordVisibility(inputId, iconId) {
            const passwordInput = document.getElementById(inputId);
            const passwordIcon = document.getElementById(iconId);
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                passwordIcon.classList.remove('bi-eye');
                passwordIcon.classList.add('bi-eye-slash');
            } else {
                passwordInput.type = 'password';
                passwordIcon.classList.remove('bi-eye-slash');
                passwordIcon.classList.add('bi-eye');
            }
        }
    </script>
</body>

</html>
