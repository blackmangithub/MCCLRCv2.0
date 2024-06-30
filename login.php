<?php 
session_start();

// Check if user is already authenticated
//if(isset($_SESSION['auth'])) {
//    $_SESSION['message_error'] = "You are already logged in";
//    header("Location: index.php");
//    exit(0);
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

     <!-- Alertify JS link -->
     <link rel="stylesheet" href="assets/css/alertify.min.css" />
     <link rel="stylesheet" href="assets/css/alertify.bootstraptheme.min.css" />

     <!-- Iconscout cdn link -->
     <link rel="stylesheet" href="assets/css/line.css">
     <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
     
     <!-- Bootstrap CSS -->
     <link rel="stylesheet" href="assets/css/bootstrap5.min.css" />

     <!-- Bootstrap Icon -->
     <link rel="stylesheet" href="assets/font/bootstrap-icons.css">

     <!-- Custom CSS Styling -->
     <link rel="stylesheet" href="assets/css/login.css">

     <style>
          .back{
               position: fixed;
               left:20px;
               top:10px;
               font-size: 30px;
               color: black;
          }
          .back:hover{
               color: gray;
          }
     </style>
</head>

<body>
     <section class="d-flex mt-1 flex-column justify-content-center align-items-center">
          <a href="home.php" class="back">
               <i class="bi bi-arrow-left-circle-fill"></i>
          </a>
          <div class="container-xl">
               <div class="col mx-auto rounded shadow bg-white">
                    <div class="row">
                         <div class="col-md-6 ">
                              <div class="">
                                   <img src="assets/img/mcc-logo.png" alt="logo"
                                        class="img-fluid d-none d-md-block  p-5" />
                              </div>
                         </div>
                         <div class="col-sm-12 col-md-6 px-5 ">
                              <div class="mt-3 mb-4">
                                   <center>
                                        <h4 class="m-0">
                                             Welcome to
                                        </h4>
                                        <h1 class="m-0"><strong>MCC</strong></h1>
                                        <p class="fs-4 fw-semibold text-info">Learning Resource Center</p>
                                        <p class="m-0">Student Login</p>
                                   </center>
                              </div>
                              <form action="logincode.php" method="POST" class="needs-validation" novalidate>
                                   <div class="col-md-12 mb-3">
                                        <label for="role_as" class="form-label">Login As:</label>
                                        <select class="form-select" id="role_as" name="role_as" required>
                                             <option value="" disabled selected>Select Role</option>
                                             <option value="student">Student</option>
                                             <option value="faculty">Faculty</option>
                                        </select>
                                        <div class="invalid-feedback">Please select your role.</div>
                                   </div>
                                   <div class="col-md-12">
                                        <div class="form-floating mb-3">
                                             <input type="text" id="student_id" class="form-control" name="student_id" placeholder="Student ID No" autocomplete="off" required maxlength="9" oninput="formatStudentID(this)">
                                             <label id="student_id_label" for="student_id">Student ID No.</label>
                                             <div id="validationServerUsernameFeedback" class="invalid-feedback">
                                                  Please enter your Student ID No.
                                             </div>
                                        </div>
                                        <div class="form-floating mb-3">
                                             <span class="password-show-toggle js-password-show-toggle"><span
                                                       class="uil"></span></span>
                                             <input type="password" id="password" class="form-control"
                                                  name="password" placeholder="Password" required>
                                             <label for="password">Password</label>
                                             <div id="validationServerUsernameFeedback" class="invalid-feedback">
                                                  Please enter your password.
                                             </div>
                                        </div>
                                   </div>
                                   <div class="d-grid gap-2 md-3">
                                        <button type="submit" name="login_btn"
                                             class="btn btn-info text-light font-weight-bolder btn-lg">Login</button>
                                        <div class="text-center mb-3">
                                             <p>
                                                  Don't have an account?
                                                  <a href="./signup.php" class="text-info">Signup</a>
                                             </p>
                                             <p>
                                                  <a href="reset-password.php" class="text-info">Forgot Password?</a>
                                             </p>
                                        </div>
                                   </div>
                              </form>
                         </div>
                    </div>
               </div>
          </div>
     </section>

     <!-- Alertify JS link -->
     <script src="assets/js/alertify.min.js"></script>

     <!-- Custom JS link -->
     <script src="assets/js/script.js"></script>

     <script>
          document.addEventListener('DOMContentLoaded', function() {
               const roleSelect = document.getElementById('role_as');
               const studentIdLabel = document.getElementById('student_id_label');
               const studentIdInput = document.getElementById('student_id');

               roleSelect.addEventListener('change', function() {
                    if (roleSelect.value === 'faculty') {
                         studentIdLabel.textContent = 'Username';
                         studentIdInput.placeholder = 'Enter your username';
                    } else {
                         studentIdLabel.textContent = 'Student ID No.';
                         studentIdInput.placeholder = 'Enter your Student ID No.';
                    }
               });
          });

          function formatStudentID(input) {
               let studentID = input.value.trim(); // Trim whitespace from input

               // Remove non-numeric characters except hyphen
               studentID = studentID.replace(/[^\d-]/g, '');

               // Remove hyphen if already present
               studentID = studentID.replace(/-/g, '');

               // Insert hyphen after the first 4 digits if necessary
               if (studentID.length > 4) {
                    studentID = studentID.substring(0, 4) + '-' + studentID.substring(4);
               }

               // Update the input field value
               input.value = studentID;
          }
     </script>

     <?php
     // Include scripts and message handling here
     include('includes/script.php');
     include('message.php'); 
     ?>
</body>

</html>
