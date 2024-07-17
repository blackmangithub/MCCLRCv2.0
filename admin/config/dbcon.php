<?php 

 //$host = "localhost";
 //$username = "u510162695_mcclrc";
 //$password = "1Mcclrc_pass";
 //$database = "u510162695_mcclrc";

 $host = "localhost";
 $username = "root";
 $password = "";
 $database = "mcclrc";

$con = mysqli_connect("$host", "$username", "$password", "$database");

if(!$con)
{
  echo "Connection failed";
  die();
}
// else
// {
//   echo "Connected Successfully";
//   die();
// }
?>