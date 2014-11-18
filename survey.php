<?php 
session_start();
if(isset($_SESSION["user"]) && $_SESSION["user"]["role"]=="normal")
{
	
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
	<!--<script src="pong.js"> </script>
	<script src="jquery-2.0.3.min.js"></script>-->
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
	<script src="javascript/survey.js"></script>
	<title>BYO-PC @ BD
	</title>
	<link rel="stylesheet" type="text/css" href="css/survey.css">
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,600' rel='stylesheet' type='text/css'>
</head>

	<img src="bdlogo.png" height="90px" width="250px"> 
	<button id = "logoutButton">Logout</button>
    <div id="topbar"></div>
    <div id="middlebar"></div>
    <div id="bottombar"></div>

    <div id="content">

	    <div id= "intro">
	    <h2>Due to the success of the BYOD program at BD, we have decided to implement a BYO-PC program.<h2> 
	    <h2>The following surveys will be used to gauge your personal interest in and eligibility to participate in the program.</h2>
	    <input id = "nextPage" type="button" value="Continue" /> 
	    </div>
	    
	    <div id= "page0">
	    <form>Would you like to pay for your work laptop out of your own pocket?&nbsp;&nbsp;&nbsp;Yes<input id="yes1" type="radio" name="yes" value="1">&nbsp;&nbsp;No<input id = "no1" type="radio" name="no" value="0"></form>
	    <input id = "nextPage2" type="button" value="Continue" /> 
	    </div>

	    <div id= "page1">
	    <h2> BD is hoping to cut costs by making employees pay for their own laptops. </h2>
	    <form id="form0">Would you like to pay for your work laptop out of your own pocket?&nbsp;&nbsp;&nbsp;Yes<input id="yes1" type="radio" name="yes" value="1">&nbsp;&nbsp;No<input id = "no1" type="radio" name="no" value="0"></form>
	    <input id = "nextPage2" type="button" value="Continue" /> 
	    </div>

		<div id="page2">

		  <form id="form1">
		    <p>I am satisfied with my current BD issued laptop&nbsp;&nbsp;&nbsp;1<input type="radio" name="rating" value="1">2<input type="radio" name="rating" value="2">3<input type="radio" name="rating" value="3">4<input type="radio" name="rating" value="4">5<input type="radio" name="rating" value="5"></p>
		  </form>
		  <form id="form2">
		    <p>I currently own a personal laptop&nbsp;&nbsp;&nbsp;Yes<input type="radio" name="yes" value="1">&nbsp;&nbsp;No<input type="radio" name="no" value="0"></p>
		  </form>
		  <form id="form3">
		    <p>I would like to bring my personal laptop into the office &nbsp;&nbsp;&nbsp;Yes<input type="radio" name="yes" value="1">&nbsp;&nbsp;No<input type="radio" name="no" value="0"></p>
		  </form>

			<input id = "submitButton" type="button" value="Submit" /> 
			<input id = "nextPage3" type="button" value="Continue" /> 

		</div>
		
		<div id="page3">
			<form>
				<p>What's the model of your laptop?(If Other please specify)</p>
				<select id="model" name="model">
					<option value="ThinkPad 420">ThinkPad 420</option>
					<option value="DELL E7440">DELL E7440</option>
					<option value="DELL E7240">DELL E7240</option>
					<option value="HP Elitebook 840">HP Elitebook 840</option>
					<option value="Other"></option>
				</select>
				<input id="modelOther" type="text" />
				<p>What's the operating system that runs on your laptop?</p>
				<select id="os" name="os">
					<option value="Windows7">Windows7</option>
					<option value="Windows8">Windows8</option>
					<option value="MacOs">MacOs</option>
					<option value="Linux">Linux</option>
				</select>
				<p>Do you want to participate in the program?</p>&nbsp;&nbsp;&nbsp;Yes<input type="radio" name="yes" value="1">&nbsp;&nbsp;No<input type="radio" name="no" value="0">
			</form>
		</div>

		<div id= "pageEnd">
			<h2>Thank you for completing the survey! </h2>
		</div>

	</div>


<?php include 'footer.php'; ?>


	
