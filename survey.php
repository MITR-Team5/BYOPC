<head>
	<!--<script src="pong.js"> </script>
	<script src="jquery-2.0.3.min.js"></script>-->
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
	<script src="survey.js"></script>
	<title>BYO-PC @ BD
	</title>
	<link rel="stylesheet" type="text/css" href="survey.css">
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,600' rel='stylesheet' type='text/css'>
</head>

	<img src="bdlogo.png" height="90px" width="250px"> 

	<input id = "logoutButton" type="button" value = "Logout" />
    	
    <div id="topbar"></div>
    <div id="middlebar"></div>
    <div id="bottombar"></div>

    <div id="content">

    <div id= "intro">
    <h2>Due to the success of the BYOD program at BD, we have decided to implement a BYO-PC program.<h2> 
    <h2>The following surveys will be used to gauge your personal interest in and eligibility to participate in the program.</h2>
    <input id = "nextPage" type="button" value="Continue" /> 
    </div>

    <div id= "page1">
    <h2> BD is hoping to cut costs by making employees pay for their own laptops. </h2>
    <p>Would you like to pay for your work laptop out of your own pocket?&nbsp;&nbsp;&nbsp;Yes<input type="radio" name="yes" value="1">&nbsp;&nbsp;No<input type="radio" name="no" value="0"></p>
    <input id = "nextPage2" type="button" value="Continue" /> 
    </div>

	<div id="form1">

	  <form name="form1">
	    <p>I am satisfied with my current BD issued laptop&nbsp;&nbsp;&nbsp;1<input type="radio" name="rating" value="1">2<input type="radio" name="rating" value="2">3<input type="radio" name="rating" value="3">4<input type="radio" name="rating" value="4">5<input type="radio" name="rating" value="5"></p>
	    <p>I currently own a laptop&nbsp;&nbsp;&nbsp;Yes<input type="radio" name="yes" value="1">&nbsp;&nbsp;No<input type="radio" name="no" value="0"></p>
	    <p>I would like to bring my personal laptop into the office &nbsp;&nbsp;&nbsp;Yes<input type="radio" name="yes" value="1">&nbsp;&nbsp;No<input type="radio" name="no" value="0"></p>
	  </form>

		<input id = "submitButton" type="button" value="Submit" /> 

		</div>

	</div>


<?php include 'footer.php'; ?>


	