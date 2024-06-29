<?php
session_start();
include('admin/config/dbcon.php');   
          
          if(isset($_POST['login_btn']))
          {
               $inputted_id = mysqli_real_escape_string($con, $_POST['inputted_id']);

               if($inputted_id == NULL)
               {
                    $_SESSION['status'] = "Please enter your Student ID";
                    $_SESSION['status_code'] = "warning";
                    header("Location:statistic_attendance_login.php");
                    exit(0);
               }
               else
               {
                    $checkstudent_id_no ="SELECT * FROM user WHERE student_id_no ='$inputted_id'";
                    $checkstudent_id_no_run = mysqli_query($con, $checkstudent_id_no);

                    if(mysqli_num_rows($checkstudent_id_no_run) > 0)
                    {
                         $query = "SELECT * FROM user WHERE student_id_no ='$inputted_id'";
                         $query_run  = mysqli_query($con, $query);

                         $user = mysqli_fetch_array($query_run);

                         $student_id = $user['student_id_no'];
                         $lastname = $user['lastname'];
                         $firstname = $user['firstname'];
                         $middlename = $user['middlename'];
                        

                         $student_query = "INSERT INTO user_log(student_id, lastname, firstname, middlename, time_log, date_log) VALUES('$student_id', '$lastname', '$firstname', '$middlename', NOW(),  NOW())";
                         $student_query_run = mysqli_query($con, $student_query);
                         
                         if($student_query_run)
                         {         
                                  $_SESSION['status'] = "You are now Login";
                                   $_SESSION['status_code'] = "success";
                                   header("Location:statistic_attendance_login.php");
                                   exit(0);

                         }
                         else
                         {
                              $_SESSION['status'] = "Something Went Wrong";
                              $_SESSION['status_code'] = "error";
                              header("Location:statistic_attendance_login.php");
                              exit(0);
                         }
                    }
                    else
                    {
                         $_SESSION['status'] = "No Student ID Found";
                         $_SESSION['status_code'] = "error";
                         header("Location:statistic_attendance_login.php");
                         exit(0);
                    }
               }
          }
          ?>