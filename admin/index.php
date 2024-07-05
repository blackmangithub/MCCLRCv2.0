<?php 
include('authentication.php');
include('includes/header.php'); 
include('./includes/sidebar.php'); 
?>

<style>
.data_table {
     background: #fff;
     padding: 15px;
     border-radius: 5px;
}

.data_table .btn {
     padding: 5px 10px;
     margin: 10px 3px 10px 0;
}
</style>
<main id="main" class="main">
     <div class="pagetitle" data-aos="fade-down">
          <h1>Dashboard</h1>
          <nav>
               <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item active">Dashboard</li>
               </ol>
          </nav>
     </div>

     <section class="section dashboard">
          <div class="row">
               <div class="col-lg-12">
                    <div class="row">
                         <div class="col-xxl-4 col-md-4" data-aos="fade-down">
                              <div class="card info-card books-card border-3 border-top border-warning">
                                   <div class="card-body">
                                        <h5 class="card-title">Books</h5>
                                        <div class="d-flex align-items-center">
                                             <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                                  <i class="bi bi-book"></i>
                                             </div>
                                             <div class="ps-3">
                                                  <?php
                                                  $query = "SELECT * FROM book";
                                                  $query_run = mysqli_query($con, $query); 
                                                  $total_books = mysqli_num_rows($query_run);
                                                  echo '<h6>' . $total_books . '</h6>';
                                                  ?>
                                                  <span class="text-warning small pt-2 fw-bold">Total books available</span>
                                             </div>
                                        </div>
                                   </div>
                              </div>
                         </div>
                         <div class="col-xxl-4 col-md-4" data-aos="fade-down">
                              <div class="card info-card students-card border-3 border-top border-primary">
                                   <div class="card-body">
                                        <h5 class="card-title">Students</h5>
                                        <div class="d-flex align-items-center">
                                             <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                                  <i class="bi bi-people"></i>
                                             </div>
                                             <div class="ps-3">
                                                  <?php
                                                  $query = "SELECT * FROM user WHERE role_as = 'student' AND status = 'approved'";
                                                  $query_run = mysqli_query($con, $query); 
                                                  $total_borrowers = mysqli_num_rows($query_run);
                                                  echo '<h6>' . $total_borrowers . '</h6>';
                                                  ?>
                                                  <span class="text-primary small pt-2 fw-bold">Total borrowers</span>
                                             </div>
                                        </div>
                                   </div>
                              </div>
                         </div>
                         <div class="col-xxl-4 col-md-4" data-aos="fade-down">
                              <div class="card info-card students-card border-3 border-top border-danger">
                                   <div class="card-body">
                                        <h5 class="card-title">Faculty/Staff</h5>
                                        <div class="d-flex align-items-center">
                                             <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                                  <i class="bi bi-people"></i>
                                             </div>
                                             <div class="ps-3">
                                                  <?php
                                                  $query = "SELECT * FROM faculty WHERE (role_as = 'faculty' OR role_as = 'staff') AND status = 'approved'";
                                                  $query_run = mysqli_query($con, $query); 
                                                  $total_borrowers = mysqli_num_rows($query_run);
                                                  echo '<h6>' . $total_borrowers . '</h6>';
                                                  ?>
                                                  <span class="text-danger small pt-2 fw-bold">Total borrowers</span>
                                             </div>
                                        </div>
                                   </div>
                              </div>
                         </div>
                         <div class="col-xxl-4 col-md-4" data-aos="fade-down">
                              <div class="card info-card borrowed-card  border-3 border-top border-success">
                                   <div class="card-body">
                                        <h5 class="card-title">Book Borrowed</h5>
                                        <div class="d-flex align-items-center">
                                             <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                                  <i class="bi bi-box-arrow-up-right"></i>
                                             </div>
                                             <div class="ps-3">
                                                  <?php
                                                  $query = "SELECT * FROM borrow_book WHERE borrowed_status = 'borrowed'";
                                                  $query_run = mysqli_query($con, $query); 
                                                  $total_borrowed = mysqli_num_rows($query_run);
                                                  echo '<h6>' . $total_borrowed . '</h6>';
                                                  ?>
                                                  <span class="text-success small pt-2 fw-bold">Total borrowed books</span>
                                             </div>
                                        </div>
                                   </div>
                              </div>
                         </div>

                         <div class="row">
                              <div data-aos="fade-down" class="col-lg-6">
                                   <div class="card">
                                        <div class="card-body">
                                             <?php
                                             $students = [];
                                             $total_student_attendance = [];
                                             $query = "SELECT *, COUNT(student_id) as total FROM `user_log` WHERE role = 'student' GROUP BY student_id ORDER BY COUNT(student_id) DESC LIMIT 5";
                                             $query_run = mysqli_query($con, $query); 

                                             foreach ($query_run as $student) {
                                                 $students[] = $student['firstname'] . ' ' . $student['lastname'];
                                                 $total_student_attendance[] = $student['total'];
                                             }
                                             ?>
                                             <h5 class="card-title">TOP STUDENTS LIBRARY USER</h5>
                                             <canvas id="pieChartStudents" style="max-height: 220px;"></canvas>
                                             <script>
                                             document.addEventListener("DOMContentLoaded", () => {
                                                  new Chart(document.querySelector('#pieChartStudents'), {
                                                       type: 'pie',
                                                       data: {
                                                            labels: <?php echo json_encode($students)?>,
                                                            datasets: [{
                                                                 label: 'My First Dataset',
                                                                 data: <?php echo json_encode($total_student_attendance)?>,
                                                                 backgroundColor: [
                                                                      'rgb(255, 99, 132)',
                                                                      'rgb(242, 146, 29)',
                                                                      'rgb(255, 205, 86)',
                                                                      'rgb(134, 200, 188)',
                                                                      'rgb(0, 129, 201)',
                                                                 ],
                                                                 hoverOffset: 4
                                                            }]
                                                       }
                                                  });
                                             });
                                             </script>
                                        </div>
                                   </div>
                              </div>

                              <div data-aos="fade-down" class="col-lg-6">
                                   <div class="card">
                                        <div class="card-body">
                                             <?php
                                             $faculty = [];
                                             $total_faculty_attendance = [];
                                             $query = "SELECT *, COUNT(student_id) as total FROM `user_log` WHERE role = 'faculty' OR role = 'staff' GROUP BY student_id ORDER BY COUNT(student_id) DESC LIMIT 5";
                                             $query_run = mysqli_query($con, $query); 

                                             foreach ($query_run as $student) {
                                                 $faculty[] = $student['firstname'] . ' ' . $student['lastname'];
                                                 $total_faculty_attendance[] = $student['total'];
                                             }
                                             ?>
                                             <h5 class="card-title">TOP FACULTY/STAFF LIBRARY USER</h5>
                                             <canvas id="pieChartFaculty" style="max-height: 220px;"></canvas>
                                             <script>
                                             document.addEventListener("DOMContentLoaded", () => {
                                                  new Chart(document.querySelector('#pieChartFaculty'), {
                                                       type: 'pie',
                                                       data: {
                                                            labels: <?php echo json_encode($faculty)?>,
                                                            datasets: [{
                                                                 label: 'My First Dataset',
                                                                 data: <?php echo json_encode($total_faculty_attendance)?>,
                                                                 backgroundColor: [
                                                                      'rgb(255, 99, 132)',
                                                                      'rgb(242, 146, 29)',
                                                                      'rgb(255, 205, 86)',
                                                                      'rgb(134, 200, 188)',
                                                                      'rgb(0, 129, 201)',
                                                                 ],
                                                                 hoverOffset: 4
                                                            }]
                                                       }
                                                  });
                                             });
                                             </script>
                                        </div>
                                   </div>
                              </div>

                              <div data-aos="fade-down" class="col-lg-12">
                                   <div class="card">
                                        <div class="card-body">
                                             <?php
                                             $courses = [];
                                             $total_student_course = [];
                                             $query = "SELECT course, COUNT(course) FROM  `user_log` GROUP BY course";
                                             $query_run = mysqli_query($con, $query); 

                                             foreach ($query_run as $course) {
                                                 $courses[] = $course['course'];
                                                 $total_student_course[] = $course['COUNT(course)'];
                                             }
                                             ?>
                                             <h5 class="card-title">MOST PROGRAM VISITED</h5>
                                             <canvas id="barChart" style="max-height: 400px;"></canvas>
                                             <script>
                                             document.addEventListener("DOMContentLoaded", () => {
                                                  new Chart(document.querySelector('#barChart'), {
                                                       type: 'bar',
                                                       data: {
                                                            labels: <?php echo json_encode($courses)?>,
                                                            datasets: [{
                                                                 label: 'Program',
                                                                 data: <?php echo json_encode($total_student_course)?>,
                                                                 backgroundColor: [
                                                                      'rgba(255, 99, 132, 0.2)',
                                                                      'rgba(255, 159, 64, 0.2)',
                                                                      'rgba(255, 205, 86, 0.2)',
                                                                      'rgba(75, 192, 192, 0.2)',
                                                                      'rgba(54, 162, 235, 0.2)',
                                                                      'rgba(153, 102, 255, 0.2)',
                                                                      'rgba(201, 203, 207, 0.2)'
                                                                 ],
                                                                 borderColor: [
                                                                      'rgb(255, 99, 132)',
                                                                      'rgb(255, 159, 64)',
                                                                      'rgb(255, 205, 86)',
                                                                      'rgb(75, 192, 192)',
                                                                      'rgb(54, 162, 235)',
                                                                      'rgb(153, 102, 255)',
                                                                      'rgb(201, 203, 207)'
                                                                 ],
                                                                 borderWidth: 1
                                                            }]
                                                       },
                                                       options: {
                                                            scales: {
                                                                 y: {
                                                                      beginAtZero: true,
                                                                      ticks: {
                                                                           stepSize: 1
                                                                      }
                                                                 }
                                                            }
                                                       }
                                                  });
                                             });
                                             </script>
                                        </div>
                                   </div>
                              </div>

                              <div class="col-lg-12" data-aos="fade-down">
                                   <div class="card">
                                        <div class="card-body">
                                             <?php
                                             $months = [];
                                             $total_student_month = [];
                                             $query = "SELECT MONTHNAME(date_log) as `monthname`, COUNT(*) as `count` FROM `user_log` GROUP BY MONTH(`date_log`) ORDER BY date_log ASC";
                                             $query_run = mysqli_query($con, $query); 

                                             foreach ($query_run as $month) {
                                                 $months[] = $month['monthname'];
                                                 $total_student_month[] = $month['count'];
                                             }
                                             ?>
                                             <h5 class="card-title">MONTHLY ATTENDANCE</h5>
                                             <canvas id="lineChart" style="max-height: 300px;"></canvas>
                                             <script>
                                             document.addEventListener("DOMContentLoaded", () => {
                                                  new Chart(document.querySelector('#lineChart'), {
                                                       type: 'line',
                                                       data: {
                                                            labels: <?php echo json_encode($months)?>,
                                                            datasets: [{
                                                                 label: 'Attendance',
                                                                 data: <?php echo json_encode($total_student_month)?>,
                                                                 fill: false,
                                                                 borderColor: 'rgb(75, 192, 192)',
                                                                 tension: 0.1
                                                            }]
                                                       },
                                                       options: {
                                                            scales: {
                                                                 y: {
                                                                      beginAtZero: true,
                                                                      ticks: {
                                                                           stepSize: 1
                                                                      }
                                                                 }
                                                            }
                                                       }
                                                  });
                                             });
                                             </script>
                                        </div>
                                   </div>
                              </div>
                         </div>
                    </div>
               </div>
          </div>
     </section>
</main>

<?php 
include('./includes/footer.php');
include('./includes/script.php');
include('../message.php');
?>
