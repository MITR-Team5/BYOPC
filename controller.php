<?php
include("dbconnect.php");
session_start();
//For testing
/////////////////////////////////////
//  $_POST["action"]="register";
//  $_POST["username"]="Kat";
//  $_POST["role"]="normal";
//  $_POST["password"]="crazymonkey";
//  $_POST["password_again"]="crazymonkey";

// $_POST["action"]="login";
// $_POST["username"]="mikeogod";
// $_POST["password"]="crazymonkey";

// $_POST["action"]="participate";
// $_POST["model"]="ThinkPad 420";
// $_POST["os"]="WIN7";
// $_POST["comment"]="I want to participate!";

// $_POST["action"]="decline";
// $_POST["comment"]="That's too expensive!";

// $_POST["action"]="submit_survey";
// $_POST["questions"]=[["qid"=>1, "value"=>4, "type"=>"Others"], ["qid"=>2, "value"=>3, "type"=>"Others"], ["qid"=>3, "value"=>2, "type"=>"Others"]];

// $_POST["action"]="complete_survey";

// $_POST["action"]="survey_questions";

//  $_POST["action"]="survey_result";
//  $_POST["qid"]=1;

// $_POST["action"]="all_survey_results";

// $_POST["action"]="get_users";

// $_POST["action"]="logout";

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
else if(ReceiveCommand("register")) // expects POST {username, role, password, password_again}
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
					$query="INSERT INTO `users`(`username`, `role`, `password`,`salt`) VALUES(:username, :role, :password, :salt)";
					$stmt=$db->prepare($query);
				
					$salt = dechex(mt_rand(0, 2147483647)) . dechex(mt_rand(0, 2147483647));
					$password = hash('sha256', $_POST['password'] . $salt);
				
					$stmt->execute(array(":username" => $_POST["username"], ":role"=>$_POST["role"], ":password" => $password, ":salt" => $salt));
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
else if(ReceiveCommand("participate"))// expects SESSION {user: {id}} POST{model, os, comment}
{
	$ret["action"]="participate";
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
			$query="UPDATE `users` SET `model`=:model, `os`=:os, `comment`=:comment, `participate`=1 WHERE `id`=:id";
			$stmt=$db->prepare($query);
			$succ=$stmt->execute([":id"=>$_SESSION["user"]["id"], ":model"=>$_POST["model"], ":os"=>$_POST["os"], ":comment"=>$_POST["comment"]]);
			if($succ)
			{
				$db->commit();
				$ret["msg"]="You have successfully registered your information to BYOPC program";
			}
			else
			{
				$db->rollBack();
				$errors=$stmt->errorInfo();
				array_push($ret["errors"], implode("|", $errors));
				$ret["msg"]="Participation information submission failed due to an internal error";
			}
		}
		catch(PDOException $ex)
		{
			$db->rollBack();
			array_push($ret["errors"], $ex->getMessage());
			$ret["msg"]="Participation information failed due to an internal issue";
		}
	}
}
else if(ReceiveCommand("decline"))// expects SESSION {user: {id}} POST{comment}
{
	$ret["action"]="decline";
	try
	{
		$db->beginTransaction();
		$query="UPDATE `users` SET `comment`=:comment, `participate`=0 WHERE `id`=:id";
		$stmt=$db->prepare($query);
		$succ=$stmt->execute([":id"=>$_SESSION["user"]["id"], ":comment"=>$_POST["comment"]]);
		if($succ)
		{
			$db->commit();
			$ret["msg"]="You have declined to participate in BYOPC program";
		}
		else
		{
			$db->rollBack();
			$errors=$stmt->errorInfo();
			array_push($ret["errors"], implode("|", $errors));
			$ret["msg"]="Declination failed due to an internal error";
		}
	}
	catch(PDOException $ex)
	{
		$db->rollBack();
		array_push($ret["errors"], $ex->getMessage());
		$ret["msg"]="Declination failed due to an internal issue";
	}
}
else if(ReceiveCommand("submit_survey")) // expects SESSION {user: {id}} POST{questions: [{"qid", "value", "type"}]}
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
			
			
			$dupAnswer=false;
			$surveyQuestions=$_POST["questions"];
			foreach($surveyQuestions as $q)
			{
				$qid=$q["qid"];
				
				$query="SELECT * FROM `survey_results` WHERE `userid`=:userid AND `surveyid`=:surveyid";
				$stmt=$db->prepare($query);
				$stmt->execute([":userid"=>$_SESSION["user"]["id"], ":surveyid"=>$qid]);
				if($stmt->fetch()==true)
				{
					$dupAnswer=true;
					$ret["msg"].="You have already answered question $qid\n";
					array_push($ret["errors"], "ResubmittingAnswer");
				}
				else 
				{
					$value=$q["value"];
					$query="INSERT INTO `survey_results`(`userid`, `surveyid`, `value`) VALUES (:userid, :surveyid, :value)";
					$stmt=$db->prepare($query);
					$stmt->execute([":userid"=>$_SESSION["user"]["id"], ":surveyid"=>$qid, ":value"=>$value]);
				}
			}
			$db->commit();
			if(!$dupAnswer)
			{
				$ret["msg"]="Survey has been successfully submitted";
			}
			
		}
		catch(PDOException $ex)
		{
			$db->rollBack();
			array_push($ret["errors"], $ex->getMessage());
			$ret["msg"]="Survey submission failed due to an internal issue";
		}
	}
}
//Call this after the last question of the survey is submitted
else if(ReceiveCommand("complete_survey"))// expects SESSION {user: {id}}
{
	$ret["action"]="complete_survey";
	try
	{
		$db->beginTransaction();

		$query="UPDATE `users` SET `completed`=1 WHERE `id`=:id";
		$stmt=$db->prepare($query);
		$succ=$stmt->execute([":id"=>$_SESSION["user"]["id"]]);
		if($succ)
		{
			$db->commit();
				
		}
		else
		{
			$db->rollBack();
			$errors=$stmt->errorInfo();
			array_push($ret["errors"], implode("|", $errors));
			$ret["msg"]="Survey completion failed due to an internal error";
		}
	}
	catch(PDOException $ex)
	{
		$db->rollBack();
		array_push($ret["errors"], $ex->getMessage());
		$ret["msg"]="Survey completion failed due to an internal issue";
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
else if(ReceiveCommand("all_survey_results")) // expects: SESSION {"user":{"role":"admin"}}
{
	$ret["action"]="all_survey_results";
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
			$query="SELECT `survey_questions`.`id`, `survey_questions`.`desc`, `survey_questions`.`type`, `survey_results`.`surveyid`, `survey_results`.`value` 
					FROM `survey_questions` INNER JOIN `survey_results` WHERE `survey_questions`.`id`=`survey_results`.`surveyid`";
			$stmt=$db->prepare($query);
			$stmt->execute();
			$rawResult=$stmt->fetchAll();
			$db->commit();
			
			$numberCounts=array_fill(1, 1000, array_fill(1, 5, 0));
			$boolCounts=array_fill(1, 1000, array(0=>0, 1=>0));
			$maxId=0;
			foreach($rawResult as $record)
			{
				if($maxId<$record["surveyid"])
				{
					$maxId=$record["surveyid"];		
				}
				
				
				if($record["type"]=="Numeric" || $record["type"]=="Others")
				{
					$numberCounts[intval($record["surveyid"])][intval($record["value"])]+=1;
				}
				else if($record["type"]=="YesNo")
				{
					if(intval($record["value"])==0)
					{
						$boolCounts[intval($record["surveyid"])][0]+=1;
					}
					else 
					{
						$boolCounts[intval($record["surveyid"])][1]+=1;
					}
					
				}
			}
			
			
			$startingId=1;
			$endingId=$maxId;
			
			$ret["data"]=array("yesno"=>array(), "numeric"=>array(), "text"=>array(), "others"=>array());
			foreach($boolCounts as $qid=>$qResult)
			{
				if($qResult[0]+$qResult[1]!=0)
				{
					array_push($ret["data"]["yesno"], array("id"=>$qid, "result"=>$qResult));
				}
				
			}
			foreach($numberCounts as $qid=>$qResult)
			{
				if(array_sum($qResult)!=0)
				{
					array_push($ret["data"]["numeric"], array("id"=>$qid, "result"=>$qResult));
				}
			}
			
			
		}
		catch(PDOException $ex)
		{
			$db->rollBack();
			array_push($ret["errors"], $ex->getMessage());
			$ret["msg"]="All survey results request failed due to an internal issue";
		}
	}
}
else if(ReceiveCommand("get_users")) // expects SESSION{user:{role}} returns: {"particiate"=>array of users, "decline"=>array of user, "undecided"=>array of user}
{
	$ret["action"]="get_users";
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
			$users=["participate"=>[], "decline"=>[], "undecided"=>[]];
			
			$query="SELECT * FROM `users` WHERE `participate`=1";
			$stmt=$db->prepare($query);
			$stmt->execute();
			$users["participate"]=$stmt->fetchAll();
			
			$query="SELECT * FROM `users` WHERE `participate`=0";
			$stmt=$db->prepare($query);
			$stmt->execute();
			$users["decline"]=$stmt->fetchAll();
			
			$query="SELECT * FROM `users` WHERE `participate`=-1";
			$stmt=$db->prepare($query);
			$stmt->execute();
			$users["undecided"]=$stmt->fetchAll();
			
			$db->commit();
				
			$ret["data"]=$users;
		}
		catch(PDOException $ex)
		{
			$db->rollBack();
			array_push($ret["errors"], $ex->getMessage());
			$ret["msg"]="Users retrieving failed due to an internal issue";
		}
	}
}
else if(ReceiveCommand("logout"))
{
	$ret["action"]="logout";
	unset($_SESSION["user"]);
	setcookie(session_name(), '', time() - 72000);
	session_destroy();
	$ret["msg"]="You are logged out";
	
}
else 
{
	$ret["msg"]="Action not valid";
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