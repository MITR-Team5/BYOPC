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
  	<?php include 'header.php'; ?>

	<img src="bdlogo.png" height="90px" width="250px"> 
    	
    <div id="topbar"></div>
    <div id="middlebar"></div>
    <div id="bottombar"></div>

    <div id="content">
    	<h1> Welcome to BD's BYO-PC Information Hub </h1>

	<div id="userlogin">

	  <form name="loginInput">
	    <p>Username: <input type="text" name="username" id="username" size="30" maxlength="40" class= "inputfield" required /></p>

	    <p>Password: <input type="password" name="password" id="pwd" size="30" maxlength="40" class= "inputfield" required /></p>

	  </form>

	</div>


	<input id = "loginButton" type="button" value="Log In" /> 


	<?php include 'footer.php'; ?>
</html>
