<head>

	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
	<script src="javascript/portal.js"></script>
	<title>BYOPC @ BD
	</title>
	<link rel="stylesheet" type="text/css" href="css/portal.css">
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,600' rel='stylesheet' type='text/css'>
</head>

<body>
	<img src="bdlogo.png" height="90px" width="250px"> 
    	
    <div id="topbar"></div>
    <div id="middlebar"></div>
    <div id="bottombar"></div>

    <div id="content">
    	<h1> Welcome to BD's BYOPC Information Hub </h1>

	<div id="userlogin">

	  <form name="loginInput">
	    <p>Username: <input type="text" name="username" id="username" size="29" maxlength="40" class= "inputfield" required /></p>

	    <p>Password: <input type="password" name="password" id="pwd" size="30" maxlength="40" class= "inputfield" required /></p>

	    <input id = "userloginButton" type="button" value="Log In" />

	   <!--  <input id = "userRegisterButton" type="button" value="Register" /> -->
	    
	  </form>

	</div>

	<input id = "loginButton" type="button" value="Log In" />

	


</div>

<?php include 'footer.php'; ?>

</body>

	
