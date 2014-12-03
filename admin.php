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
	<title>BYOPC @ BD</title>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
	<script src="javascript/admin.js"></script>
	<script src="javascript/Chart.js"></script>
	<link rel="stylesheet" type="text/css" href="css/admin.css">
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,600' rel='stylesheet' type='text/css'>

</head>




<img src="bdlogo.png" height="90px" width="250px"> 

<button id = "logoutButton" value = "Logout">Logout</button>
    	
<div id="topbar"></div>
<!-- <div id="middlebar"></div> -->


<div id="user-content">
		<table id="user-table">
			<th>User Name</th>
			<th>Role</th>
			<th>Q1</th>
			<th>Q2</th>
			<th>Q3</th>
			<th>Q4</th>
			<th>Model</th>
			<th>OS</th>
			<th>Accepted</th>
			<th>Survey Completed</th>
			<th>Comment</th>
		</table>

		<p>&nbsp;</p>
		<p>&nbsp;</p>
		<h2 id="go-back"><a href="#"> Back to All Users </a></h2>

</div>

<div id="content">
	
	
	<div id="users-container">
		<h2>Users:</h2>
		<table id="users-table">
			<th>uID</th>
			<th>User Name</th>
			<th>Role</th>
			<th>Model</th>
			<th>OS</th>
			<th>Accepted</th>
			<th>Survey Completed</th>
			<th>Comment</th>
		</table>
<!-- 		<p>Declined users:</p>
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
		</table> -->
	</div>
	
	<p>&nbsp;</p>
	<p>&nbsp;</p>
	<h2 id="view-all"><a href="#">View All Survey Results</a></h2>
	
	<div id="survey-results">
		<h2>Survey Results:</h2>
		<div id="survey-results-container">
		</div>
	</div>
	
</div>

<div id="bottombar"></div>

<?php 
	include('footer.php');
?>
