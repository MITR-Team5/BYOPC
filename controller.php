<?php
//For testing
/////////////////////////////////////
include("dbconnect.php");
// $_POST["action"]="register";
// $_POST["username"]="mikeogod";
// $_POST["password"]="crazymonkey";
// $_POST["password_again"]="crazymonkey";

// $_POST["action"]="login";
// $_POST["username"]="mikeogod";
// $_POST["password"]="crazymonkey";

// $_POST["action"]="submit_comment";
// $_POST["value"]="test comment";

// $_POST["action"]="get_comments";

// session_start();
// echo "SESSION: <br />";
// print_r($_SESSION);

////////////////////////////////////

//The response will take the following format:
$ret=array("action"=>null, "data"=>null, "msg"=>null, "errors"=>array());

if(!isset($_POST) || empty($_POST))
{
	$ret["msg"]="Invalid operation";
}



if(ReceiveCommand("login"))
{
	$ret["action"]="login";
	try
	{
		$db->beginTransaction();
		
		$query = " SELECT * FROM users WHERE username = :username";
		$query_params = array(
				':username' => $_POST['username']
		);
		$stmt=$db->prepare($query);
		$stmt->execute($query_params);
		$user=$stmt->fetch();
		
		$db->commit();
		
		$loginOk;
		if($user)
		{
			if(!validate_password("", "", $db, $user["id"], "login", $_POST['password']))
			{
				$ret["msg"]="The password is not correct";
				array_push($ret["errors"], "WrongPassword");
			}
			else
			{
				$loginOk=true;
				
			}
		}
		else 
		{
			$ret["msg"]="The user doens't exist";
			array_push($ret["errors"], "UserNameNotExist");
			$loginOk=false;
		}
		if($loginOk)
		{
			unset($user['salt']);
			unset($user['password']);
			$_SESSION["user"]=$user;
			
			$ret["msg"]="Login Success!";
		}
	}
	catch (PDOException $ex)
	{
		$db->rollBack();
		array_push($ret["errors"], $ex->getMessage());
		$ret["msg"]="Login failed due to an internal issue";
		
	}
	
}
else if(ReceiveCommand("register"))
{
	try
	{
		$db->beginTransaction();
		$query = "SELECT * FROM users WHERE username = :username";
		$query_params = array(
				':username' => $_POST['username']
		);
		$stmt=$db->prepare($query);
		$result=$stmt->execute($query_params);
		$user=$stmt->fetch();
		
		$db->commit();
		
		if($user)
		{
			$ret["msg"]="The user name already exists";
			array_push($ret['errors'], "UserNameExists");
		}
		else 
		{
			if(validate_password($_POST["password"], $_POST["password_again"], $db, "", "register"))
			{
				try 
				{
					$db->beginTransaction();
					$query="INSERT INTO `users`(`username`, `password`,`salt`) VALUES(:username, :password, :salt)";
					$stmt=$db->prepare($query);
				
					$salt = dechex(mt_rand(0, 2147483647)) . dechex(mt_rand(0, 2147483647));
					$password = hash('sha256', $_POST['password'] . $salt);
				
					$stmt->execute(array(":username" => $_POST["username"], ":password" => $password, ":salt" => $salt));
					$db->commit();
					
					$ret["msg"]="Register success!";
				}
				catch(PDOException $ex)
				{
					$db->rollBack();
					array_push($ret["errors"], $ex->getMessage());
					$ret["msg"]="Register failed due to an internal issue";
				}
			}
			else
			{
				$ret["msg"]="The two passwords entered don't match";
				array_push($ret["errors"], "WrongPasswords");
			}
		}
	}
	catch(PDOException $ex)
	{
		$db->rollBack();
		array_push($ret["errors"], $ex->getMessage());
		$ret["msg"]="Register failed due to an internal issue";
	}
}
else if(ReceiveCommand("submit_comment"))
{
	if(!isset($_SESSION["user"]))
	{
		array_push($ERRORS, "User is not logged in");
	}
	else
	{
		try
		{
			$db->beginTransaction();
		
			$query="INSERT INTO `comments`(`post_time`, `value`, `user`) VALUES(:post_time, :value, :username)";
			$stmt=$db->prepare($query);
			$postTime=strval(time());
			$stmt->execute(array(":post_time"=>$postTime, ":value"=>$_POST["value"], ":username"=>$_SESSION["user"]["username"]));
			$db->commit();
			
			$ret["msg"]="The comment has been successfully submitted";
		}
		catch(PDOException $ex)
		{
			$db->rollBack();
			array_push($ret["errors"], $ex->getMessage());
			$ret["msg"]="Comment submit failed due to an internal issue";
		}
	}
	
}
else if(ReceiveCommand("get_comments"))
{
	if(!isset($_SESSION["users"]))
	{
		$ret["msg"]="You are not signed in";
		array_push($ret["errors"], "UserNotSignedIn");
	}
	if($_SESSION["user"]["role"]!="admin")
	{
		$ret["msg"]="You are not an admin";
		array_push($ret["errors"], "UserNotAdmin");
	}
	try
	{
		$db->beginTransaction();
	
		$query="SELECT * FROM `comments`";
		$stmt=$db->prepare($query);
		$stmt->execute();
		$db->commit();
		
		$allComments=$stmt->fetchAll();
		$ret["data"]=$allComments;
	}
	catch(PDOException $ex)
	{
		$db->rollBack();
		array_push($ret["errors"], $ex->getMessage());
		$ret["msg"]="Comments retrieving failed due to an internal issue";
	}
}


echo json_encode($ret);

/////////

function ReceiveCommand($action)
{
	if(isset($_POST["action"]))
	{
		if($_POST["action"]==$action)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	else
	{
		return false;
	}
}

function validate_password($new_password, $new_password_again, $db, $uid, $mode, $old_password="")
{
	//if the user is registering
	if($mode=="register")
	{
		//Compare the new_password and new_password_again
		if($new_password!=$new_password_again)
		{
			return false;
		}

		//Check the length of the new_password_again
		if(strlen($new_password)<8)
		{
			$error_msg="Password is too short (needs to be at least 8 characters long)";
			return false;
		}

		return true;
	}

	//if the user is logging in
	else if($mode=="login")
	{
		
		//Get the hashed password and salt stored in the database for that user id
		try{
			$query="SELECT `password`, `salt` FROM `users` WHERE `id`=:uid";
			$query_params=array(":uid"=>$uid);
			$stmt=$db->prepare($query);
			$result=$stmt->execute($query_params);
		}
		catch(PDOException $ex)
		{
			return false;
		}

		$row=$stmt->fetch();

		//Hash the old_password concat with the salt
		$old_password = hash('sha256', $old_password . $row["salt"]);
		//Compare the hashed old_password and the hashed password in the database
		if($old_password!=$row["password"])
		{
			return false;
		}

		//return true
		return true;
	}
	else
	{
		return false;
	}
}