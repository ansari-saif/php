<?php 
   $db = "db_name";
    $dbUser = "root";
    $dbPass = "";
    $conn = mysqli_connect("localhost",$dbUser, $dbPass,$db) or die("connection field --------->".mysqli_connect_error());
