<?php 
// $host = "127.0.0.1";
// $username = "mcclrc";
// $password = "mcclrc";
// $database = "mcclrc";

 $host = "localhost";
 $username = "u510162695_mcclrc";
 $password = "1Mcclrc_pass";
 $database = "u510162695_mcclrc";

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