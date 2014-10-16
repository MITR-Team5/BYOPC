<?php
include("dbconnect.php");

session_start();
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

<!DOCTYPE html>
<html>
	<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  </head>
  <title>
    BD BYOPC | 
	<?php 
		if (basename($_SERVER['PHP_SELF']) == "index.php") echo "Welcome";
	?>
  </title>
  <body>
  </body>
</html>
