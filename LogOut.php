<?php
error_reporting(0);
include("Include.php");

$Name=$_SESSION['NAME'];
unset($_SESSION['NAME']);
unset($_SESSION['USERNAME']);
unset($_SESSION['USERTYPE']);
unset($_SESSION['UserId']);
unset($_SESSION['U']);
unset($_SESSION['USERTYPEID']);
unset($_SESSION['SCHOOLSTARTINGDATE']);
unset($_SESSION['Login']);
unset($_SESSION['CURRENTSESSION']);
unset($_SESSION['PASSWORD']);
unset($_SESSION['SCHOOLSESSION']);
$Message="$Name, You have been logged Out Successfully!!";
$Type="success";
SetNotification($Message,$Type);

$_SESSION['LogOut']=1;

header("Location:index.php");

?>