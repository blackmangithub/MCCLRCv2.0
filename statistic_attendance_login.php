<?php 
session_start();
include('includes/header.php');  
include('admin/config/dbcon.php');  
?>
<style>
body {

     min-height: 100vh;
     overflow: hidden;
     background: url("assets/img/bg.png"),
          -webkit-linear-gradient(bottom, #0250c5, #05c3dd);
}
</style>
<nav class="navbar navbar-inverse navbar-fixed-top shadow-sm bg-white ">
     <div class="container-fluid">
          <div class="navbar-header d-flex ">
               <img src="assets/img/mcc-logo.png" class="mx-3" width="50px" height="50px" />
               <p class="navbar-text pull-right fw-semibold fs-4">MCC Learning Resource Center Attendance</p>
          </div>
     </div>
</nav>

<div class="container shadow-sm bg-white  my-5 p-5 rounded d-flex justify-content-center align-items-center">
     <div class="row">
          <h2 class="text-center text-uppercase mb-5">Attendance <span class="text-info">Login</span></h2>

          <form action="statistic_attendance_logincode.php" method="POST" class="mb-5">
               <div class="mb-3">
                    <label for="student_id" class="form-label fw-semibold">STUDENT LOGIN</label>
                    <input type="text" name="inputted_id" class="form-control" id="student_id"
                         placeholder="Please enter your Student ID">
               </div>
               <div class="d-grid gap-2 mb-3">
                    <button type="submit" name="login_btn" class="btn btn-primary" type="button">LOGIN</button>
               </div>
          </form>

     </div>
</div>

<?php 
include('includes/script.php');
include('message.php');
?>