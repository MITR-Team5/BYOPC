<?php 
session_start();
if(isset($_SESSION["user"]) && $_SESSION["user"]["role"]=="normal")
{
	header("Location: survey.php");
}
else if(isset($_SESSION["user"]) && $_SESSION["user"]["role"]=="admin")
{
	
}
else
{
	header("Location: index.php");
}
?>
<head>
	<title>BYO-PC @ BD
	</title>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
	<script src="javascript/survey.js"></script>
	<script src="javascript/Chart.js"></script>
	<script src="javascript/admin.js"></script>
	<link rel="stylesheet" type="text/css" href="css/admin.css">
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,600' rel='stylesheet' type='text/css'>

</head>


<img src="bdlogo.png" height="90px" width="250px"> 

<button id = "logoutButton" value = "Logout">Logout</button>
    	
<div id="topbar"></div>
<div id="middlebar"></div>



<div id="content">
	
	
	<div id="users-container">
		<p>Participating users:</p>
		<table id="users-table-participate">
			<th>User Name</th>
			<th>Model</th>
			<th>OS</th>
			<th>Comment</th>
			<th>Survey Completed</th>
		</table>
		<p>Declined users:</p>
		<table id="users-table-decline">
			<th>User Name</th>
			<th>Comment</th>
			<th>Survey Completed</th>
		</table>
		<p>Undecided users:</p>
		<table id="users-table-undecided">
			<th>User Name</th>
			<th>Model</th>
			<th>OS</th>
			<th>Comment</th>
			<th>Survey Completed</th>
		</table>
	</div>
	
	<p>
	<p>Survey Results:</p>
	<div id="survey-results">
		<div id="survey-results-container">
		</div>
	</div>
	
</div>

<div id="bottombar"></div>

<?php 
	include('footer.php');
?>