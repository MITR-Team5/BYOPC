<?php include 'header.php'; ?>
<?php include 'session.php'; ?>
	<img src="bdlogo.png" height="90px" width="250px"> 
    	
    <div id="topbar"></div>
    <div id="middlebar"></div>
    <div id="bottombar"></div>

    <div id="content">
    	<h1> Welcome to BD's BYO-PC Information Hub </h1>

	<div id="userlogin">

	  <form name="loginInput">
	    <p>Username: <input type="text" name="username" id="username" size="30" maxlength="40" class= "inputfield" required /></p>

	    <p>Password: <input type="password" name="password" id="password" size="30" maxlength="40" class= "inputfield" required /></p>
		
		<input id = "login-button" type="button" value="Log In" /> 
	  
	  </form>

	</div>


	


<?php include 'footer.php'; ?>


	
