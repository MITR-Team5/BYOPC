<?php

$ERRORS=array();

// These variables define the connection information for your MySQL database
if($_SERVER["HTTP_HOST"]=="localhost")
{
	$username = "root";
	$password = "ch6rles5";
	$host = "localhost";
	$dbname = "bd_byopc";
}
else if($_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"]=="remindme.go.myrpi.org" || $_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"]=="remindme.go.myrpi.org/index.php")
{
	$username = "";
	$password = "";
	$host = "";
	$dbname = "";
}
else
{
	array_push($ERRORS, "Host not recognized. Database connection failed");
}

$options = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');
 

try
{
	$db = new PDO("mysql:host={$host};dbname={$dbname};charset=utf8", $username, $password, $options);
}
catch(PDOException $ex)
{
	array_push($ERRORS, "Failed to connect to the database! Check host, dbname, username, and password in the dbconnect.php file. Error: ".$ex->getMessage());
}

if(count($ERRORS)==0)
{
	 
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

	 
	if(function_exists('get_magic_quotes_gpc') && get_magic_quotes_gpc())
	{
		if(!function_exists('undo_magic_quotes_gpc'))
		{
			function undo_magic_quotes_gpc(&$array)
			{
				foreach($array as &$value)
				{
					if(is_array($value))
					{
						undo_magic_quotes_gpc($value);
					}
					else
					{
						$value = stripslashes($value);
					}
				}
			}
		}

		undo_magic_quotes_gpc($_POST);
		undo_magic_quotes_gpc($_GET);
		undo_magic_quotes_gpc($_COOKIE);
	}
}

if(count($ERRORS)!=0)
{
	$_SESSION["ERRORS"]=$ERRORS;	
}

