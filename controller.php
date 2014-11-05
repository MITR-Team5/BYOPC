<?php
include("dbconnect.php");
session_start();
//For testing
/////////////////////////////////////
// $_POST["action"]="register";
// $_POST["username"]="mikeogod1";
// $_POST["password"]="crazymonkey";
// $_POST["password_again"]="crazymonkey";

// $_POST["action"]="login";
// $_POST["username"]="mikeogod";
// $_POST["password"]="crazymonkey";

// $_POST["action"]="submit_survey";
// $_POST["questions"]=[["qid"=>1, "value"=>1], ["qid"=>2, "value"=>3], ["qid"=>3, "value"=>2]];

// $_POST["action"]="survey_questions";

 $_POST["action"]="survey_result";
 $_POST["qid"]=1;

// $_POST["action"]="submit_comment";
// $_POST["value"]="test comment";

// $_POST["action"]="get_comments";

//  session_start();
//  echo "SESSION: <br />";
//  print_r($_SESSION);
//  echo "<br />";
//  echo "POST: <br />";
//  print_r($_POST);
//  echo "<br />";

////////////////////////////////////

//The response will take the following format:
$ret=array("action"=>null, "data"=>null, "msg"=>null, "errors"=>array());
if(count($ERRORS)!=0)
{
	$ret["msg"]="Some errors occurred while trying to connect to the database: <br />";
	foreach($error as $ERRORS)
	{
		array_push($ret["errors"], $error);
	}
}



if(!isset($_POST) || empty($_POST))
{
	$ret["msg"]="Invalid operation";
}



if(ReceiveCommand("login")) // expects POST {"username", "password"}
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
		
		$loginOk=false;
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
else if(ReceiveCommand("register")) // expects POST {username, password, password_again}
{
	$ret["action"]="register";
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
else if(ReceiveCommand("submit_survey")) // expects SESSION {user: {id}} POST{questions: [{"qid", "value"}]}
{
	$ret["action"]="submit_survey";
	if(!isset($_SESSION["user"]))
	{
		$ret["msg"]="You are not signed in";
		array_push($ret["errors"], "UserNotSignedIn");
	}
	else
	{
		try
		{
			$db->beginTransaction();
			
			$surveyQuestions=$_POST["questions"];
			foreach($surveyQuestions as $q)
			{
				$qid=$q["qid"];
				$value=$q["value"];
				$query="INSERT INTO `survey_results`(`userid`, `surveyid`, `value`) VALUES (:userid, :surveyid, :value)";
				$stmt=$db->prepare($query);
				$stmt->execute([":userid"=>$_SESSION["user"]["id"], ":surveyid"=>$qid, ":value"=>$value]);
			}
			$db->commit();
			$ret["msg"]="Survey has been successfully submitted";
		}
		catch(PDOException $ex)
		{
			$db->rollBack();
			array_push($ret["errors"], $ex->getMessage());
			$ret["msg"]="Survey submission failed due to an internal issue";
		}
	}
}
else if(ReceiveCommand("survey_questions")) // expects POST{}
{
	$ret["action"]="survey_questions";
	try 
	{
		$db->beginTransaction();
		$query="SELECT * FROM `survey_questions`";
		$stmt=$db->prepare($query);
		$stmt->execute();
		$questions=$stmt->fetchAll();
		$db->commit();
		
		$ret["data"]=$questions;
	}
	catch(PDOException $ex)
	{
		$db->rollBack();
		array_push($ret["errors"], $ex->getMessage());
		$ret["msg"]="Survey questions retrieval failed due to an internal issue";
	}
}
else if(ReceiveCommand("survey_result")) // expects: SESSION {"user":{"role":"admin"}}, POST {"qid"}
{
	$ret["action"]="survey_result";
	if(!isset($_SESSION["user"]))
	{
		$ret["msg"]="You are not signed in";
		array_push($ret["errors"], "UserNotSignedIn");
	}
	else if($_SESSION["user"]["role"]!="admin")
	{
		$ret["msg"]="You are not an admin";
		array_push($ret["errors"], "UserNotAdmin");
	}
	else{
		try
		{
			$db->beginTransaction();
			$query="SELECT * FROM `survey_results` WHERE `surveyid`=:qid";
			$stmt=$db->prepare($query);
			$stmt->execute([":qid"=>$_POST["qid"]]);
			$result=$stmt->fetchAll();
			$db->commit();
			
			$ret["data"]=$result;
		}
		catch(PDOException $ex)
		{
			$db->rollBack();
			array_push($ret["errors"], $ex->getMessage());
			$ret["msg"]="Survey result request failed due to an internal issue";
		}
	}
}
else if(ReceiveCommand("submit_comment")) //expects: SESSION{user:{username, }} POST{value}
{
	$ret["action"]="submit_comment";
	if(!isset($_SESSION["user"]))
	{
		$ret["msg"]="You are not signed in";
		array_push($ret["errors"], "UserNotSignedIn");
	}
	else
	{
		try
		{
			$db->beginTransaction();
		
			$query="INSERT INTO `comments`(`value`, `user`) VALUES(:value, :username)";
			$stmt=$db->prepare($query);
			$stmt->execute(array(":value"=>$_POST["value"], ":username"=>$_SESSION["user"]["username"]));
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
else if(ReceiveCommand("get_comments")) // expects SESSION {user:{role}}
{
	$ret["action"]="get_comments";
	if(!isset($_SESSION["user"]))
	{
		$ret["msg"]="You are not signed in";
		array_push($ret["errors"], "UserNotSignedIn");
	}
	else if($_SESSION["user"]["role"]!="admin")
	{
		$ret["msg"]="You are not an admin";
		array_push($ret["errors"], "UserNotAdmin");
	}
	else {
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