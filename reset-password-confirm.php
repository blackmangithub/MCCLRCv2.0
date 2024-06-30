<?php 
session_start();
if(isset($_GET['token'])) {
    $token = $_GET['token'];
} else {
    $_SESSION['message_error'] = "No token provided.";
    header('Location: login.php');
    exit(0);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
     <meta charset="UTF-8">
     <meta http-equiv="X-UA-Compatible" content="IE=edge">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <link rel="icon" href="./assets/img/mcc-logo.png">
     <title>Reset Password</title>
     
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

     <!-- Custom CSS Styling -->
     <style>
          .password-container {
               position: relative;
          }

          .password-toggle {
               position: absolute;
               top: 50%;
               right: 20px;
               transform: translateY(-50%);
               cursor: pointer;
          }
     </style>
</head>

<body>
     <section class="d-flex mt-1 flex-column justify-content-center align-items-center">
          <div class="container-xl">
               <div class="col mx-auto rounded shadow bg-white">
                    <div class="row">
                         <div class="col-md-6 ">
                              <div class="">
                                   <img src="assets/img/mcc-logo.png" alt="logo"
                                        class="img-fluid d-none d-md-block  p-5" />
                              </div>
                         </div>
                         <div class="col-sm-12 col-md-6 px-5 " style="margin-top:50px;">
                              <div class="mt-3 mb-4">
                                   <center>
                                        <h4 class="m-0">
                                             Reset Your Password
                                        </h4>
                                        <p class="fs-4 fw-semibold text-info">Enter your new password</p>
                                   </center>
                              </div>
                              <form action="reset-password-process.php" method="POST" class="needs-validation" novalidate>
                                   <input type="hidden" name="token" value="<?php echo $token; ?>">
                                   <div class="col-md-12">
                                        <div class="form-floating mb-3 password-container">
                                             <input type="password" id="new_password" class="form-control"
                                                  name="new_password" placeholder="New Password" required
                                                  pattern=".{8,}" title="Minimum 8 characters required">
                                             <label for="new_password">New Password</label>
                                             <span class="password-toggle" onclick="togglePassword('new_password')">
                                                  <i class="bi bi-eye-slash-fill" id="new_password_eye"></i>
                                             </span>
                                             <div class="invalid-feedback">
                                                  Please enter a valid password (minimum 8 characters).
                                             </div>
                                        </div>
                                        <div class="form-floating mb-3 password-container">
                                             <input type="password" id="confirm_password" class="form-control"
                                                  name="confirm_password" placeholder="Confirm Password" required
                                                  pattern=".{8,}" title="Minimum 8 characters required">
                                             <label for="confirm_password">Confirm Password</label>
                                             <span class="password-toggle" onclick="togglePassword('confirm_password')">
                                                  <i class="bi bi-eye-slash-fill" id="confirm_password_eye"></i>
                                             </span>
                                             <div class="invalid-feedback">
                                                  Please confirm your new password (minimum 8 characters).
                                             </div>
                                        </div>
                                   </div>
                                   <div class="d-grid gap-2 md-3">
                                        <button type="submit" name="reset_password_btn"
                                             class="btn btn-info text-light font-weight-bolder btn-lg">Reset Password</button>
                                   </div>
                              </form>
                         </div>
                    </div>
               </div>
          </div>
     </section>

     <!-- JavaScript to toggle password visibility -->
     <script>
          function togglePassword(inputId) {
               var passwordInput = document.getElementById(inputId);
               var passwordEye = document.getElementById(inputId + '_eye');

               if (passwordInput.type === "password") {
                    passwordInput.type = "text";
                    passwordEye.classList.remove("bi-eye-slash-fill");
                    passwordEye.classList.add("bi-eye-fill");
               } else {
                    passwordInput.type = "password";
                    passwordEye.classList.remove("bi-eye-fill");
                    passwordEye.classList.add("bi-eye-slash-fill");
               }
          }
     </script>
</body>

</html>
