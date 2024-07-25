<?php 
include('includes/header.php');
include('includes/navbar.php');
include('admin/config/dbcon.php');

if(empty($_SESSION['auth'])){
  header('Location: home.php');
  exit(0);
}

if($_SESSION['auth_role'] != "student" && $_SESSION['auth_role'] != "faculty" && $_SESSION['auth_role'] != "staff")
{
  header("Location:index.php");
  exit(0);
}

if (isset($_SESSION['auth_stud']['stud_id']))
{
     $id_session = $_SESSION['auth_stud']['stud_id'];
}

$name_session = $_SESSION['auth_stud']['stud_name']; 

$table = $_SESSION['auth_role'] == "student" ? "user" : "faculty";
?>

<style>
.password-container {
     position: relative;
}

.password-toggle {
     position: absolute;
     top: 50%;
     right: 50px;
     transform: translateY(-50%);
     cursor: pointer;
}
</style>

<div class="container">
     <div class="row">
          <div class="col-md-12">
               <div class="card mt-4" data-aos="fade-up">
                    <div class="card-header">
                         <h4 class="text-muted">My Profile</h4>
                    </div>
                    <div class="card-body">
                         <div class="row">
                              <div class="col-xl-4">
                                   <?php
                                   $query = "SELECT * FROM $table WHERE ".($table == 'user' ? 'user_id' : 'faculty_id')." = '$id_session'";
                                   $query_run = mysqli_query($con, $query);
                                   $row = mysqli_fetch_array($query_run);
                                   ?>
                                   <div class="card">
                                        <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
                                             <center>
                                                  <?php if($row['qr_code'] != ""): ?>
                                                       <a href="qrcodes/<?php echo $row['qr_code']; ?>" download>
                                                            <img src="qrcodes/<?php echo $row['qr_code']; ?>" alt="QR Code" width="200px" height="200px">
                                                       </a>
                                                  <?php else: ?>
                                                       <img src="uploads/books_img/book_image.jpg" alt="Book Image" width="200px" height="250px">
                                                  <?php endif; ?>
                                                  <h4 style="font-size:15px;margin-top:-18px;">Click the QR Code to download.</h4>
                                             </center>
                                             <br>
                                             <h3><?= strtoupper($row['role_as']); ?></h3>
                                        </div>
                                   </div>
                              </div>
                              <div class="col-xl-8">
                                   <div class="card">
                                        <div class="card-body pt-3">
                                             <ul class="nav nav-tabs nav-tabs-bordered">
                                                  <li class="nav-item">
                                                       <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-edit">Edit Profile</button>
                                                  </li>
                                                  <li class="nav-item">
                                                       <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-change-password">Change Password</button>
                                                  </li>
                                             </ul>
                                             <div class="tab-content pt-2">
                                                  <div class="tab-pane fade show active profile-edit pt-3" id="profile-edit">
                                                       <?php
                                                       if(mysqli_num_rows($query_run))
                                                       {
                                                            foreach($query_run as $user)
                                                            {
                                                       ?>
                                                       <form action="allcode.php" method="POST" enctype="multipart/form-data">
                                                            <div class="row mb-3">
                                                                 <label for="firstname" class="col-md-4 col-lg-3 col-form-label">Firstname</label>
                                                                 <div class="col-md-8 col-lg-9">
                                                                      <input name="firstname" type="text" class="form-control" id="firstname" value="<?=$user['firstname']?>" required>
                                                                      <div class="invalid-feedback">
                                                                           First name must start with a capital letter.
                                                                      </div>
                                                                 </div>
                                                            </div>
                                                            <div class="row mb-3">
                                                                 <label for="middlename" class="col-md-4 col-lg-3 col-form-label">Middlename</label>
                                                                 <div class="col-md-8 col-lg-9">
                                                                      <input name="middlename" type="text" id="middlename" class="form-control" value="<?=$user['middlename']?>">
                                                                      <div class="invalid-feedback">
                                                                           Middle name must start with a capital letter.
                                                                      </div>
                                                                 </div>
                                                            </div>
                                                            <div class="row mb-3">
                                                                 <label for="lastname" class="col-md-4 col-lg-3 col-form-label">Lastname</label>
                                                                 <div class="col-md-8 col-lg-9">
                                                                      <input name="lastname" type="text" class="form-control" id="lastname" value="<?=$user['lastname']?>" required>
                                                                      <div class="invalid-feedback">
                                                                           Last name must start with a capital letter.
                                                                      </div>
                                                                 </div>
                                                            </div>
                                                            <div class="row mb-3">
                                                                 <label for="Address" class="col-md-4 col-lg-3 col-form-label">Address</label>
                                                                 <div class="col-md-8 col-lg-9">
                                                                      <input name="address" type="text" class="form-control" id="Address" value="<?=$user['address']?>" required>
                                                                 </div>
                                                            </div>
                                                            <div class="row mb-3">
                                                                 <label for="Phone" class="col-md-4 col-lg-3 col-form-label">Phone</label>
                                                                 <div class="col-md-8 col-lg-9">
                                                                      <input type="text" class="form-control format_number" name="phone" id="Phone" placeholder="09xxxxxxxxx" maxlength="11" value="<?=$user['cell_no']?>" required>
                                                                      <div class="invalid-feedback">
                                                                           Phone number must start with "09" and be exactly 11 digits long.
                                                                      </div>
                                                                 </div>
                                                            </div>
                                                            <div class="row mb-3">
                                                                 <label for="Email" class="col-md-4 col-lg-3 col-form-label">Email</label>
                                                                 <div class="col-md-8 col-lg-9">
                                                                      <input name="email" type="email" class="form-control" id="Email" value="<?=$user['email']?>" required>
                                                                 </div>
                                                            </div>
                                                            <div class="text-center">
                                                                 <button type="submit" name="save_changes" class="btn btn-primary">Save Changes</button>
                                                            </div>
                                                       </form>
                                                       <?php
                                                            }
                                                       }
                                                       else
                                                       {
                                                            echo "No records found";
                                                       }                                           
                                                       ?>
                                                  </div>
                                                  <div class="tab-pane fade pt-3" id="profile-change-password">
                                                       <form action="allcode.php" method="POST" onsubmit="return validatePasswords()">
                                                            <div class="row mb-3">
                                                                 <label for="currentPassword" class="col-md-4 col-lg-3 col-form-label">Current Password</label>
                                                                 <div class="col-md-8 col-lg-9 position-relative">
                                                                      <input name="current_password" type="password" class="form-control" id="currentPassword">
                                                                      <i class="bi bi-eye-fill position-absolute password-toggle" id="toggleCurrentPassword" style="right: 23px; top: 50%; transform: translateY(-50%); cursor: pointer;"></i>
                                                                      <div class="invalid-feedback" id="currentPasswordWarning">
                                                                           Password must be at least 8 characters long.
                                                                      </div>
                                                                 </div>
                                                            </div>
                                                            <div class="row mb-3">
                                                                 <label for="newPassword" class="col-md-4 col-lg-3 col-form-label">New Password</label>
                                                                 <div class="col-md-8 col-lg-9 position-relative">
                                                                      <input name="newpassword" type="password" class="form-control" id="newPassword">
                                                                      <i class="bi bi-eye-fill position-absolute password-toggle" id="toggleNewPassword" style="right: 23px; top: 50%; transform: translateY(-50%); cursor: pointer;"></i>
                                                                 </div>
                                                                 <div class="invalid-feedback" id="newPasswordWarning" style="position: relative; left:180px;">
                                                                           Password must be at least 8 characters long.
                                                                      </div>
                                                            </div>
                                                            <div class="row mb-3">
                                                                 <label for="renewPassword" class="col-md-4 col-lg-3 col-form-label">Re-enter New Password</label>
                                                                 <div class="col-md-8 col-lg-9 position-relative">
                                                                      <input name="renewpassword" type="password" class="form-control" id="renewPassword">
                                                                      <i class="bi bi-eye-fill position-absolute password-toggle" id="toggleRenewPassword" style="right: 23px; top: 30%; transform: translateY(-50%); cursor: pointer;"></i>
                                                                 </div>
                                                                 <div class="invalid-feedback" id="renewPasswordWarning" style="position: relative; left:180px;top:-20px;">
                                                                           Password must be at least 8 characters long.
                                                                      </div>
                                                            </div>
                                                            <div class="text-center">
                                                                 <button type="submit" name="password_update" class="btn btn-primary">Change Password</button>
                                                            </div>
                                                       </form>
                                                  </div>
                                             </div>
                                        </div>
                                   </div>
                              </div>
                         </div>
                    </div>
               </div>
          </div>
     </div>
</div>

<script>
document.getElementById('Phone').addEventListener('input', function () {
    var phoneInput = this.value.trim();
    
    // Remove non-numeric characters
    phoneInput = phoneInput.replace(/\D/g, '');
    
    // Check if the number starts with "09" and is exactly 11 digits long
    if (/^09\d{9}$/.test(phoneInput)) {
        this.setCustomValidity('');
    } else {
        this.setCustomValidity('Phone number must start with "09" and be exactly 11 digits long.');
    }
    
    // Show or hide the validation message
    var isValid = /^09\d{9}$/.test(phoneInput);
    this.classList.toggle('is-invalid', !isValid);
    
    // Clear error message if "09" is typed again
    if (phoneInput.startsWith('09')) {
        this.setCustomValidity('');
        this.classList.remove('is-invalid');
    }
});

// Function to validate first name, middle name, and last name
function validateNameInput(inputId) {
    var input = document.getElementById(inputId);
    var value = input.value.trim();
    
    // Check if first character is uppercase
    if (/^[A-Z]/.test(value)) {
        input.setCustomValidity('');
    } else {
        input.setCustomValidity(input.placeholder + ' must start with a capital letter.');
    }
    
    // Show or hide the validation message
    var isValid = /^[A-Z]/.test(value);
    input.classList.toggle('is-invalid', !isValid);
}

// Add event listeners to validate on input for first name, middle name, and last name
document.getElementById('firstname').addEventListener('input', function () {
    validateNameInput('firstname');
});

document.getElementById('lastname').addEventListener('input', function () {
    validateNameInput('lastname');
});

document.getElementById('middlename').addEventListener('input', function () {
    validateNameInput('middlename');
});

// Add event listeners to clear validation when input is empty
document.getElementById('firstname').addEventListener('blur', function () {
    if (this.value.trim() === '') {
        this.setCustomValidity('');
        this.classList.remove('is-invalid');
    }
});

document.getElementById('lastname').addEventListener('blur', function () {
    if (this.value.trim() === '') {
        this.setCustomValidity('');
        this.classList.remove('is-invalid');
    }
});

document.getElementById('middlename').addEventListener('blur', function () {
    if (this.value.trim() === '') {
        this.setCustomValidity('');
        this.classList.remove('is-invalid');
    }
});

document.getElementById('toggleCurrentPassword').addEventListener('click', function() {
    togglePasswordVisibility('currentPassword', 'toggleCurrentPassword');
});

document.getElementById('toggleNewPassword').addEventListener('click', function() {
    togglePasswordVisibility('newPassword', 'toggleNewPassword');
});

document.getElementById('toggleRenewPassword').addEventListener('click', function() {
    togglePasswordVisibility('renewPassword', 'toggleRenewPassword');
});

function togglePasswordVisibility(passwordId, toggleIconId) {
    const passwordInput = document.getElementById(passwordId);
    const toggleIcon = document.getElementById(toggleIconId);

    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        toggleIcon.classList.remove('bi-eye-fill');
        toggleIcon.classList.add('bi-eye-slash-fill');
    } else {
        passwordInput.type = 'password';
        toggleIcon.classList.remove('bi-eye-slash-fill');
        toggleIcon.classList.add('bi-eye-fill');
    }
}

function validatePasswords() {
    const newPassword = document.getElementById('newPassword').value;
    const renewPassword = document.getElementById('renewPassword').value;

    let valid = true;

    if (newPassword.length < 8) {
        document.getElementById('newPasswordWarning').style.display = 'block';
        valid = false;
    } else {
        document.getElementById('newPasswordWarning').style.display = 'none';
    }

    if (renewPassword.length < 8) {
        document.getElementById('renewPasswordWarning').style.display = 'block';
        valid = false;
    } else {
        document.getElementById('renewPasswordWarning').style.display = 'none';
    }

    return valid;
}

// Add event listeners to validate passwords on input
document.getElementById('newPassword').addEventListener('input', function () {
    if (this.value.length >= 8) {
        document.getElementById('newPasswordWarning').style.display = 'none';
    } else {
        document.getElementById('newPasswordWarning').style.display = 'block';
    }
});

document.getElementById('renewPassword').addEventListener('input', function () {
    if (this.value.length >= 8) {
        document.getElementById('renewPasswordWarning').style.display = 'none';
    } else {
        document.getElementById('renewPasswordWarning').style.display = 'block';
    }
});
</script>

<?php
include('includes/footer.php');
include('includes/script.php');
include('message.php'); 
?>
