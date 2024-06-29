<?php
include('admin/config/dbcon.php');
if(isset($_GET['id']))
{
     $book_id = mysqli_real_escape_string($con, $_GET['id']);

     $query = "SELECT * FROM web_opac WHERE web_opac_id ='$book_id'"; 
     $query_run = mysqli_query($con, $query);

     if(mysqli_num_rows($query_run) > 0)
     {
          $ebook = mysqli_fetch_array($query_run);

          header("content-type: application/pdf");
          readfile('uploads/ebook/'.$ebook['ebook']);

      }
          
     else
     {
          echo "No such ID found";
     }
} 
?>