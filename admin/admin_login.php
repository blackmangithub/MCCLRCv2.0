<?php
session_start();
include('config/dbcon.php');

if(isset($_POST['admin_login_btn']))
{
  $email = mysqli_real_escape_string($con, $_POST['email']);
  $password = mysqli_real_escape_string($con, $_POST['password']);
  $admin_types = mysqli_real_escape_string($con, $_POST['admin_type']);

  $admin_login_query = "SELECT * FROM admin WHERE email='$email' AND admin_type='$admin_types'";
  $admin_login_query_run = mysqli_query($con, $admin_login_query);

  if(mysqli_num_rows($admin_login_query_run) > 0)
  {
    $data = mysqli_fetch_array($admin_login_query_run);
    if(password_verify($password, $data['password'])) {
      $admin_id = $data['admin_id'];  
      $admin_name = $data['firstname'].' '.$data['lastname'];  
      $admin_email = $data['email'];
      $admin_type = $data['admin_type'];
    
      $_SESSION['auth'] = true;
      $_SESSION['auth_role'] = "$admin_type"; 
      $_SESSION['auth_admin'] = [
        'admin_id'=>$admin_id,
        'admin_name'=>$admin_name,
        'email'=>$admin_email,
        'admin_type'=>$admin_type,
      ];
      
      if($admin_type == 'Admin')  // Admin
      {
        $_SESSION['message_success'] = "<small>Welcome to Dashboard Admin!</small>";
        header("Location:index.php");
        exit(0);
      }
      elseif($admin_type == 'Staff')  // Staff
      {
        $_SESSION['message_success'] = "<small>Welcome to Dashboard Staff!</small>";
        header("Location:index.php");
        exit(0);
      }
    } else {
      $_SESSION['message_error'] = "Invalid email, password, or admin type";
      header("Location: admin_login.php");
      exit(0);
    }
  }
  else
  {  
    $_SESSION['message_error'] = "Invalid email, password, or admin type";
    header("Location: admin_login.php");
    exit(0);
  }
}
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
     <!-- Bootstrap CSS -->
     <link rel="stylesheet" href="assets/css/bootstrap5.min.css" />
     <!-- Bootstrap Icon -->
     <link rel="stylesheet" href="assets/font/bootstrap-icons.css">
     <!-- Iconscout cdn link -->
     <link rel="stylesheet" href="assets/css/line.css">
     <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
     <!-- Custom CSS Styling -->
     <link rel="stylesheet" href="assets/css/login.css">
</head>

<body>
     <section class="d-flex mt-4 flex-column justify-content-center align-items-center">
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
                              <div class="mt-4 mb-4">
                                   <center>
                                   <h4 class="m-0">Welcome to</h4>
                                   <h1 class="m-0"><strong>MCC</strong></h1>
                                   <p class="fs-4 fw-semibold text-info">Learning Resource Center</p>
                                   <p class="m-0">Admin Login</p>
                                   </center>
                              </div>

                              <form action="admin_login.php" method="POST" class="needs-validation" novalidate>
                                   <div class="col-md-12">
                                   <div class="form-floating mb-3">
                                             <select class="form-select" id="admin_type" name="admin_type" required>
                                                  <option value="" selected disabled>Select Admin Type</option>
                                                  <option value="Admin">Admin</option>
                                                  <option value="Staff">Staff</option>
                                             </select>
                                             <label for="admin_type">Admin Type</label>
                                             <div class="invalid-feedback">
                                                  Please select an admin type.
                                             </div>
                                        </div>
                                        <div class="form-floating mb-3">
                                             <input type="email" id="email" class="form-control" name="email"
                                                  placeholder="Email" autocomplete="off" required>
                                             <label for="email">Email</label>
                                             <div id="validationServerEmailFeedback" class="invalid-feedback">
                                                  Please enter your email
                                             </div>
                                        </div>
                                        <div class="form-floating mb-3 position-relative">
                                             <input type="password" id="password" class="form-control" name="password"
                                                  placeholder="Password" required>
                                             <label for="password">Password</label>
                                             <span class="password-show-toggle js-password-show-toggle">
                                                  <i class="bi bi-eye-slash" id="togglePassword"></i>
                                             </span>
                                             <div id="validationServerUsernameFeedback" class="invalid-feedback">
                                                  Please enter your password.
                                             </div>
                                        </div>
                                   </div>
                                   <div class="d-grid gap-2 md-3 mb-3">
                                        <button type="submit" name="admin_login_btn"
                                             class="btn btn-info text-light font-weight-bolder btn-lg">Login</button>
                                   </div>
                              </form>
                         </div>
                    </div>
               </div>
          </div>
     </section>
     <?php
     include('includes/script.php');
     include('message.php'); 
     ?>
     <script>
          document.getElementById('togglePassword').addEventListener('click', function (e) {
               const password = document.getElementById('password');
               const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
               password.setAttribute('type', type);
               this.classList.toggle('bi-eye');
               this.classList.toggle('bi-eye-slash');
          });
     </script>
</body>
</html>
