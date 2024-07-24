<?php 
include('includes/header.php');
include('includes/navbar.php');
include('admin/config/dbcon.php');

if(empty($_SESSION['auth'])){
//   $_SESSION['message_error'] = "<small>Login your Credentials to Access</small>";
  header('Location: home.php');
  exit(0);
}
if ($_SESSION['auth_role'] != "student" && $_SESSION['auth_role'] != "faculty" && $_SESSION['auth_role'] != "staff") 
{
  header("Location:index.php");
  exit(0);
}
?>

<div class="container">
  <div class="row">
    <div class="col-12">
      <div class="card mt-4" data-aos="fade-up">
        <div class="card-header">
          <div class="d-flex align-items-center justify-content-center mt-2">
            <div class="mx-2">
            <img src="assets/img/mcc-logo.png" class="d-sm-none d-md-block me-4" style="height: 100px; width: 100px;" alt="MCC Logo">
            </div>
            <div class="col-8 mt-2">
              <center>
                <h3 class="fw-semibold">Madridejos Community College</h3>
                <h4 class="fw-semibold">Learning Resource Center</h4>
              </center>
              <form class=" " method="GET">
                <div class="d-flex">
                  <div class="input-group mb-3 me-6">
                    <input type="text" name="search" value="<?php if(isset($_GET['search'])) { echo htmlspecialchars($_GET['search']); } ?>" class="form-control" placeholder="Type here to search" required>
                    <button class="btn btn-primary px-md-5 px-sm-1">Search</button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>