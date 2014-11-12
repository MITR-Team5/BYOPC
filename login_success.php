<?php
session_start();
if(isset($_SESSION["user"]) && $_SESSION["user"]["role"]=="normal")
{
	header("Location: survey.php");
}
else if(isset($_SESSION["user"]) && $_SESSION["user"]["role"]=="admin")
{
	header("Location: admin.php");
}
else
{
	header("Location: index.php");
}
?>