<?php
session_start();
print_r($_SESSION);
if(isset($_SESSION["user"]) && $_SESSION["user"]["role"]=="normal")
{
	header("Location: survey.php");
}
else if(isset($_SESSION["user"]) && $_SESSION["user"]["role"]=="admin")
{
	header("Location: admin_page.php");
}
?>