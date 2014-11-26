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
	    <h2>Due to the success of the BYOD program at BD, we have decided to implement a BYO-PC program.</h2> 
	    <h2>The following surveys will be used to gauge your personal interest in and eligibility to participate in the program.</h2>
	    <input class = "nextPage" type="button" value="Continue" /> 
	    </div>
	    
	    <div id= "page1">
	    	<div id="survey-questions">
	    		<div id="questions"></div>
	    	</div>
	    	<input id="submit-survey-btn" type="button" value="submit" />
	    </div>
	    
		<div id="page2">

			<h2>If you currently own a laptop, please answer the following questions</h2>

			<form id="decision">
				<p>What is the make of your laptop?
				<select name="compBrand">
					<option value="Acer">Acer</option>
					<option value="Apple">Apple</option>
					<option value="Asus">Asus</option>
					<option value="Dell">Dell</option>
					<option value="HP">HP</option>
					<option value="Lenovo">Lenovo</option>
					<option value="Samsung">Samsung</option>
					<option value="Toshiba">Toshiba</option>
					<option value="Other">Other</option>
				</select>
				</p>
				
				<p>What Operating System are you currently running on your laptop?
				<select name="compOS">
					<option value="Windows8">Windows 8</option>
					<option value="Windows7">Windows 7</option>
					<option value="WindowsVista">Windows Vista</option>
					<option value="WindowsXP">Windows XP</option>
					<option value="MacOSX">Mac OSx</option>
					<option value="Linux">Linux</option>
					<option value="Other">Other</option>
				</select>
				</p>
				
			    <h3>I wish to participate in the BYO-PC program</h3>  
			    <p>Yes<input type="radio" name="participate" value="1">&nbsp;&nbsp;No<input type="radio" name="participate" value="0"></p>
		  	
		  		<h3>Comment</h3>
		  		<textarea name="comment" rows="4" cols="30"></textarea>
		  	</form>
			<input id = "submit-decision-btn" type="button" value="Submit" /> 

		</div>

		

		<div id= "page3">
			<h2>Thank you for completing the survey! </h2>
		</div>

	</div>


<?php include 'footer.php'; ?>


	
