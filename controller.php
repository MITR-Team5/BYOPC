<?php
//For testing
/////////////////////////////////////
// include("dbconnect.php");
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

session_start();
echo "SESSION: <br />";
print_r($_SESSION);

////////////////////////////////////

if(!isset($_POST) || empty($_POST))
{
	return;
}

$ERRORS=array();
$_SESSION["ERRORS"]=$ERRORS;

if(ReceiveCommand("login"))
{
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
				$loginOk=false;
			}
			else
			{
				$loginOk=true;
				
			}
		}
		else 
		{
			$loginOk=false;
		}
		if($loginOk)
		{
			unset($user['salt']);
			unset($user['password']);
			$_SESSION["user"]=$user;
		}
		else
		{
			array_push($ERRORS, "Login failed!");
		}
	}
	catch (PDOException $ex)
	{
		$db->rollBack();
		array_push($ERRORS, $ex->getMessage());
		
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
			array_push($ERRORS, "User name already exists");
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
				}
				catch(PDOException $ex)
				{
					$db->rollBack();
					array_push($ERRORS, $ex->getMessage());
				}
			}
			else
			{
				array_push($ERRORS, "Passwords don't match");
			}
		}
	}
	catch(PDOException $ex)
	{
		$db->rollBack();
		array_push($ERRORS, $ex->getMessage());
	}
}
else if(ReceiveCommand("submit_comment"))
{
	if(!isset($_SESSION["user"]))
	{
		array_push($ERRORS, "User is not logged in");
		//
		echo "user not logged in!";
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
			//
			echo "success!";
		}
		catch(PDOException $ex)
		{
			$db->rollBack();
			array_push($ERRORS, $ex->getMessage());
			//
			echo $ex->getMessage();
		}
	}
	
}
else if(ReceiveCommand("get_comments"))
{
	if(!isset($SESSION["users"]))
	{
		array_push($ERRORS, "User is not signed in");
	}
	if($_SESSION["user"]["role"]!="admin")
	{
		array_push($ERRORS, "User is not an admin!");
	}
	try
	{
		$db->beginTransaction();
	
		$query="SELECT * FROM `comments`";
		$stmt=$db->prepare($query);
		$stmt->execute();
		$db->commit();
		$allComments=$stmt->fetchAll();
		
		echo json_encode(array("all_comments"=>$allComments));
	}
	catch(PDOException $ex)
	{
		$db->rollBack();
		array_push($ERRORS, $ex->getMessage());
	}
}

if(count($ERRORS)!=0)
{
	$_SESSION["errors"]=$ERRORS;
}

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