<?php 
include('admin/config/dbcon.php');

if(isset($_POST['input']))
{
     
  
     $input = $_POST['input'];
     $query = "SELECT * FROM web_opac WHERE title LIKE '{$input}%'";
     $query_run = mysqli_query($con, $query);

     if(mysqli_num_rows($query_run) > 0)
     {
         ?>
<table class="table table-bordered mt-4">
     <tbody>
          <?php
                    
                    while($row = mysqli_fetch_assoc($query_run))
                    {
                         $title = $row['title'];
                         ?>
          <tr>
               <td>
                    <form action="web_opac_view_pdf.php" method="post">
                         <a href="web_opac_view_pdf.php?id=<?=$row['web_opac_id']; ?>"
                              class="alert alert-info p-1 text-decoration-none" name="viewpdf"><?=$title; ?></a>
                    </form>
               </td>
          </tr>
          <?php
                    }
                    ?>
     </tbody>
</table>
<?php

     }
     else
     {
          echo "<h6 class='text-danger text-center mt-3>No Book found</h6>";
     }
  }
    

  
?>