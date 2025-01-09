<?php
$host="localhost";
$user="root";
$pass="";
$db="eGovern";

$con=new mysqli($host,$user,$pass,$db);

if($con->connect_error){
    die("Connection failed: " . $con->connect_error);
}else{
    // echo "Database Connection Succesfull";
}

?>

