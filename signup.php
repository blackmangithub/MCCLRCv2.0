<?php 
session_start();
include('./admin/config/dbcon.php');

$code = $_GET['code'];

$code_query = "SELECT email FROM email_verifications WHERE verification_code = ?";
$code_stmt = $con->prepare($code_query);
$code_stmt->bind_param("s", $code);
$code_stmt->execute();
$code_result = $code_stmt->get_result();
$code_row = $code_result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="./assets/img/mcc-logo.png">
    <title>MCC Learning Resource Center</title>
    <style>
        #year_levelField {
            display: none;
        }

        .toggle-password {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #777;
        }

        .toggle-password-icon {
            font-size: 16px;
        }

        .toggle-password:hover .toggle-password-icon {
            color: #333;
        }

        .invalid-feedback {
            color: red;
            font-size: 12px;
            margin-top: 5px;
            display: none;
        }

        .is-invalid {
            border: 1px solid red;
        }

        .field {
            margin-bottom: 15px;
            position: relative;
        }

        .invalid-feedback {
            position: absolute;
            bottom: -20px;
            left: 0;
            display: none;
        }

        .warning {
            font-size: 11px;
            position: relative;
            top: -40px;
        }
    </style>
</head>

<!-- Alertify JS link -->
<link rel="stylesheet" href="assets/css/alertify.min.css" />
<link rel="stylesheet" href="assets/css/alertify.bootstraptheme.min.css" />

<!-- Custom CSS links -->
<link rel="stylesheet" href="assets/css/signup.css">

<body>
    <div class="container">
        <header>
            <h5>SIGN<span>UP</span></h5>
        </header>
        <!-- Multi Step Form start -->
        <div class="progress-bar">
            <div class="step">
                <p>Personal</p>
                <div class="bullet">
                    <span>1</span>
                </div>
                <div class="check fas fa-check"></div>
            </div>
            <div class="step hide">
                <p>Birth</p>
                <div class="bullet">
                    <span>2</span>
                </div>
                <div class="check fas fa-check"></div>
            </div>
            <div class="step">
                <p>Contact</p>
                <div class="bullet">
                    <span>3</span>
                </div>
                <div class="check fas fa-check"></div>
            </div>
            <div class="step hide">
                <p>Contact</p>
                <div class="bullet">
                    <span>4</span>
                </div>
                <div class="check fas fa-check"></div>
            </div>
            <div class="step">
                <p>Accounts</p>
                <div class="bullet">
                    <span>5</span>
                </div>
                <div class="check fas fa-check"></div>
            </div>
        </div>

        <!-- Multi Step Form end -->
        <div class="form-outer">
            <form action="./signupcode.php" method="POST" enctype="multipart/form-data">
                <!-- First Slide Page start-->
                <div class="page slide-page">
                    <div class="title">Personal Details:</div>

                    <div class="field">
                        <div class="label">Last Name</div>
                        <input type="text" name="lastname" id="lastname" />
                        <div class="invalid-feedback">
                            Last name must start with a capital letter.
                        </div>
                    </div>

                    <div class="field">
                        <div class="label">First Name</div>
                        <input type="text" name="firstname" id="firstname" />
                        <div class="invalid-feedback">
                            First name must start with a capital letter.
                        </div>
                    </div>

                    <div class="field">
                        <div class="label">Middle Name <span style="font-weight:200;color:gray;font-size:13px;">(optional)</span></div>
                        <input type="text" name="middlename" id="middlename" />
                        <div class="invalid-feedback">
                            Middle name must start with a capital letter.
                        </div>
                    </div>

                    <div class="field option">
                        <button class="firstNext next">Next</button>
                        <p>Already have an account? <a href="login.php">Login</a></p>
                    </div>
                </div>
                <!-- First Slide Page end-->

                <!-- Second Slide Page start-->
                <div class="page">
                    <div class="field">
                        <div class="label" for="role">User Type</div>
                        <select name="role" id="role">
                            <option value="" disabled selected>--Select Type--</option>
                            <option value="student">Student</option>
                            <option value="faculty">Faculty</option>
                            <option value="staff">Staff</option>
                        </select>
                    </div>

                    <div class="field">
                        <div class="label">Birthdate</div>
                        <input type="date" name="birthdate" />
                    </div>

                    <div class="field">
                        <div class="label">Address</div>
                        <input type="text" name="address" />
                    </div>

                    <div class="field btns">
                        <button class="prev-1 prev">Previous</button>
                        <button class="next-1 next">Next</button>
                    </div>
                </div>
                <!-- Second Slide Page end-->

                <!-- Third Slide Page start-->
                <div class="page">
                    <div class="field">
                        <div class="label" for="gender">Gender</div>
                        <select name="gender" id="gender">
                            <option value="" disabled selected>--Select Gender--</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                    </div>

                    <div class="field" id="year_levelField">
                        <div class="label" for="year_level">Year Level</div>
                        <select name="year_level" id="year_level">
                            <option value="" disabled selected>--Select Year Level--</option>
                            <option value="4th year">4th year</option>
                            <option value="3rd year">3rd year</option>
                            <option value="2nd year">2nd year</option>
                            <option value="1st year">1st year</option>
                        </select>
                    </div>

                    <div class="field">
                        <div class="label" for="course" id="courseLabel">Course</div>
                        <select name="course" id="course">
                            <option value="" id="optionLabel" disabled selected>--Select Course--</option>
                            <option value="BSIT">BSIT</option>
                            <option value="BSED">BSED</option>
                            <option value="BEED">BEED</option>
                            <option value="BSBA">BSBA</option>
                            <option value="BSHM">BSHM</option>
                        </select>
                    </div>

                    <div class="field btns">
                        <button class="prev-2 prev">Previous</button>
                        <button class="next-2 next">Next</button>
                    </div>
                </div>
                <!-- Third Slide Page end-->

                <!-- Fourth Slide Page start-->
                <div class="page">
                    <div class="title hides">Contact Info</div>

                    <div class="field">
                        <div class="label">Email</div>
                        <input type="email" placeholder="MS 365 Email" name="email" value="<?=$code_row['email'];?>" readonly />
                    </div>

                    <div class="field">
                        <div class="label">Cellphone No.</div>
                        <input type="text" id="cell_no" name="cell_no" class="format_number" maxlength="11" placeholder="09xxxxxxxxx" oninput="validateCellphone(this)">
                    </div>
                    <span id="warning_message" style="color:red;" class="warning"></span>

                    <div class="field">
                        <div class="label">Profile Image</div>
                        <input type="file" id="profile_image" name="profile_image" accept="image/*">
                    </div>

                    <div class="field btns">
                        <button class="prev-3 prev">Previous</button>
                        <button class="next-3 next">Next</button>
                    </div>
                </div>
                <!-- Fourth Slide Page end-->

                <!-- Fifth Slide Page start-->
                <div class="page">
                    <div class="title">Login Details:</div>

                    <div class="field">
                        <div class="label" id="stud_idLabel">Student ID No.</div>
                        <input type="text" name="student_id_no" id="student_id_no" maxlength="9" oninput="formatStudentID()">
                    </div>

                    <div class="field">
                        <div class="label">Password</div>
                        <input type="password" name="password" id="passwordInput" oninput="validatePassword(this)">
                        <span class="toggle-password" onclick="togglePasswordVisibility('passwordInput')">
                            <i class="fas fa-eye toggle-password-icon"></i>
                        </span>
                        <div id="passwordLengthFeedback" class="invalid-feedback">
                            Password must be at least 8 characters long.
                        </div>
                    </div>

                    <div class="field">
                        <div class="label">Confirm Password</div>
                        <input type="password" name="cpassword" id="confirmPasswordInput">
                        <span class="toggle-password" onclick="togglePasswordVisibility('confirmPasswordInput')">
                            <i class="fas fa-eye toggle-password-icon"></i>
                        </span>
                    </div>

                    <div class="field btns">
                        <button class="prev-4 prev">Previous</button>
                        <button type="submit" class="submit" name="register_btn">Signup</button>
                    </div>
                </div>
                <!-- Fifth Slide Page end-->
            </form>
        </div>
    </div>

    <!-- Format Number  -->
    <script src="assets/js/format_number.js"></script>

    <!-- Font Awesome Link -->
    <script src="assets/js/kit.fontawesome.js"></script>

    <!-- Alertify JS link -->
    <script src="assets/js/alertify.min.js"></script>

    <!-- Custom JS link -->
    <script src="assets/js/script.js"></script>

    <script>
        function togglePasswordVisibility(id) {
            const passwordInput = document.getElementById(id);
            const passwordIcon = passwordInput.nextElementSibling.querySelector('.toggle-password-icon');
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                passwordIcon.classList.remove('fa-eye');
                passwordIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                passwordIcon.classList.remove('fa-eye-slash');
                passwordIcon.classList.add('fa-eye');
            }
        }

        function formatStudentID() {
            const studentIDInput = document.getElementById('student_id_no');
            const roleSelect = document.getElementById('role');
            const selectedRole = roleSelect.value;

            if (selectedRole === 'student') {
                let studentID = studentIDInput.value.replace(/\D/g, '');

                if (studentID.length > 4) {
                    studentID = studentID.slice(0, 4) + '-' + studentID.slice(4);
                }

                studentIDInput.value = studentID;
            }
        }

        document.getElementById('role').addEventListener('change', function () {
            const yearLevelField = document.getElementById('year_levelField');
            const stud_idLabel = document.getElementById('stud_idLabel');
            const studentIDInput = document.getElementById('student_id_no');
            const selectedRole = this.value;

            if (selectedRole === 'student') {
                yearLevelField.style.display = 'block';
                stud_idLabel.textContent = 'Student ID No.';
                studentIDInput.value = '';
            } else {
                yearLevelField.style.display = 'none';
                stud_idLabel.textContent = 'Username';
                studentIDInput.value = '';
            }
        });

        function validateCellphone(input) {
            const value = input.value;
            const warningMessage = document.getElementById('warning_message');

            if (!/^09\d{9}$/.test(value)) {
                input.classList.add('is-invalid');
                warningMessage.textContent = "Invalid phone number. Please enter an 11-digit phone number starting with '09'.";
            } else {
                input.classList.remove('is-invalid');
                warningMessage.textContent = '';
            }
        }

        function validatePassword(input) {
            const passwordLengthFeedback = document.getElementById('passwordLengthFeedback');
            if (input.value.length < 8) {
                input.classList.add('is-invalid');
                passwordLengthFeedback.style.display = 'block';
            } else {
                input.classList.remove('is-invalid');
                passwordLengthFeedback.style.display = 'none';
            }
        }
    </script>

    <?php
    include('message.php'); 
    include('includes/script.php');
    ?>
</body>

</html>
