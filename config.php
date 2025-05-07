<?php
$con = mysqli_connect("localhost","your_username","your_password","your_database_namee");
if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error() ." | Seems like you haven't created the DATABASE with an exact name";
  }
?>
