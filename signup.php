<?php 
session_start();

//if(isset($_SESSION['auth']))
//{
//  $_SESSION['message_error'] = "You are already logged in";
//  header("Location: index.php");
//  exit(0);
//}

include('./admin/config/dbcon.php');
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
          #year_levelField{
               display: none;
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

.invalid-feedback {
    color: red;
    font-size: 12px;
    margin-top: 5px;
    display: none; /* Initially hide the feedback */
}

.is-invalid {
    border: 1px solid red; /* Example border color for invalid input */
}

.field {
    margin-bottom: 15px;
    position: relative; /* Ensure relative positioning for proper absolute positioning */
}

.invalid-feedback {
    position: absolute;
    bottom: -20px; /* Adjust the position as needed */
    left: 0;
    display: none; /* Show the feedback message when invalid */
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
                         <div class="label">Lastname</div>
                         <input type="text" name="lastname" id="lastname" />
                         <div class="invalid-feedback">
                              Last name must start with a capital letter.
                         </div>
                         </div>

                         <div class="field">
                         <div class="label">Firstname</div>
                         <input type="text" name="firstname" id="firstname" />
                         <div class="invalid-feedback">
                              First name must start with a capital letter.
                         </div>
                         </div>

                         <div class="field">
                         <div class="label">Middlename <span style="font-weight:200;color:gray;font-size:13px;">(optional)</span></div>
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
                              <div class="label" for="type">User Type</div>
                              <select name="role" id="role">
                                   <option value="" disabled selected>--Select Type--</option>
                                   <option value="student">Student</option>
                                   <option value="faculty">Faculty</option>
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
                              <div class="label" for="course">Year Level</div>
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
                              <input type="email" placeholder="example@gmail.com" name="email" />
                         </div>

                         <div class="field">
        <div class="label">Cellphone No.</div>
        <input type="text" id="cell_no" name="cell_no" class="format_number" maxlength="11" placeholder="09xxxxxxxxx" oninput="validateCellphone(this)">
    </div>
    <span id="warning_message" style="color:red;" class="warning"></span>


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
                    <input type="text" name="student_id_no" id="student_id_no" maxlength="9" oninput="formatStudentID(this)">
                    <div class="invalid-feedback">
                        Student ID must be in the format '1234-5678'.
                    </div>
                </div>

                <div class="field">
                    <div class="label">Password</div>
                    <input type="password" name="password" id="passwordInput" oninput="validatePassword(this)">
                    <span class="toggle-password" toggle="#passwordInput">
                        <i class="fas fa-eye toggle-password-icon"></i>
                    </span>
                    <div id="passwordLengthFeedback" class="invalid-feedback">
                        Password must be at least 8 characters long.
                    </div>
                </div>

                         <div class="field">
                              <div class="label">Confirm Password</div>
                              <input type="password" name="cpassword" id="confirmPasswordInput" />
                              <span class="toggle-password" toggle="#confirmPasswordInput">
                                   <i class="fas fa-eye toggle-password-icon"></i>
                              </span>
                         </div>

                         <div class="field btns">
                              <button class="prev-4 prev">Previous</button>
                              <button type="submit" class="submit" name="register_btn">Submit</button>
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
          document.addEventListener('DOMContentLoaded', (event) => {
    const roleSelect = document.getElementById('role');
    const courseLabel = document.getElementById('courseLabel');
    const stud_idLabel = document.getElementById('stud_idLabel');
    const optionLabel = document.getElementById('optionLabel');
    const year_levelField = document.getElementById('year_levelField');

    roleSelect.addEventListener('change', (event) => {
        if (event.target.value === 'faculty') {
          courseLabel.textContent = 'Department';
          stud_idLabel.textContent = 'Username';
          optionLabel.textContent = '--Select Department--';
          year_levelField.style.display = 'none';

        } else {
          courseLabel.textContent = 'Course';
          stud_idLabel.textContent = 'Student ID No.';
          optionLabel.textContent = '--Select Course--';
          year_levelField.style.display = 'block';
        }
    });
});

document.addEventListener('DOMContentLoaded', function() {
    const togglePassword = document.querySelectorAll('.toggle-password');

    togglePassword.forEach(function(toggle) {
        toggle.addEventListener('click', function() {
            const toggleIcon = this.querySelector('.toggle-password-icon');
            const toggleTarget = document.querySelector(this.getAttribute('toggle'));

            if (toggleTarget.type === 'password') {
                toggleTarget.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                toggleTarget.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        });
    });
});

function validateNameInput(inputElement, feedbackElement) {
        var name = inputElement.value.trim();
        
        // Check if input is empty
        if (name === '') {
            feedbackElement.style.display = 'none';
            inputElement.classList.remove('is-invalid');
            return;
        }
        
        // Check if the first character is uppercase
        if (/^[A-Z]/.test(name)) {
            feedbackElement.style.display = 'none';
            inputElement.classList.remove('is-invalid');
        } else {
            feedbackElement.style.display = 'block';
            inputElement.classList.add('is-invalid');
        }
    }

    document.getElementById('lastname').addEventListener('input', function () {
        validateNameInput(this, this.nextElementSibling);
    });

    document.getElementById('firstname').addEventListener('input', function () {
        validateNameInput(this, this.nextElementSibling);
    });

    document.getElementById('middlename').addEventListener('input', function () {
        validateNameInput(this, this.nextElementSibling);
    });

    function validateCellphone(input) {
            const phoneNumber = input.value.trim();

            if (phoneNumber === "") {
                document.getElementById('warning_message').textContent = ""; // Clear warning if input is empty
            } else if (!phoneNumber.startsWith('09')) {
                document.getElementById('warning_message').textContent = "Please enter a valid cellphone number starting with '09'.";
            } else {
                document.getElementById('warning_message').textContent = ""; // Clear warning if '09' prefix is correct
            }
        }

        // Prevent non-numeric input
        document.getElementById('cell_no').addEventListener('input', function(e) {
            this.value = this.value.replace(/\D/g, ''); // Remove non-numeric characters
        });

        function formatStudentID(input) {
        // Remove non-numeric characters
        let formatted = input.value.replace(/\D/g, '');

        // Apply formatting if there are more than 4 digits
        if (formatted.length > 4) {
            formatted = formatted.substring(0, 4) + '-' + formatted.substring(4, 8);
        } else if (formatted.length === 4 && !formatted.includes('-')) {
            formatted = formatted.substring(0, 4) + '-';
        }

        // Update the input field value
        input.value = formatted;
    }

    function validatePassword(input) {
        const password = input.value.trim(); // Trim whitespace from input
        
        if (password === '') {
            document.getElementById('passwordLengthFeedback').style.display = 'none'; // Hide feedback if password is empty
            input.classList.remove('is-invalid');
        } else if (password.length >= 8) {
            document.getElementById('passwordLengthFeedback').style.display = 'none';
            input.classList.remove('is-invalid');
        } else {
            document.getElementById('passwordLengthFeedback').style.display = 'block';
            input.classList.add('is-invalid');
        }
    }
     </script>

     <?php include('message.php'); ?>
</body>

</html>