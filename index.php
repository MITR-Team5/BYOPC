<?php
session_start();
include("dbconnect.php");


if(!isset($_SESSION["user"]))
{
	echo "User not logged in!";
}

if(isset($_SESSION["user"]) && $_SESSION["role"]=="admin")
{
	echo "Admin logged in!";
}

if(isset($_SESSION["user"]) && $_SESSION["role"]=="normal")
{
	echo "User logged in!";
}

if(count($ERRORS)==0)
{
	echo "Database connection successful!";
}
?>
<!doctype html>
<html>
  <?php include "header.php"; ?>
  <?php include "body.php"; ?>
</html>
