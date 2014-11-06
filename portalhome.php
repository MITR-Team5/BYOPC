<?php include 'header.php'; ?>
<body>
	<img src="bdlogo.png" height="90px" width="250px"> 
    	
    <div id="topbar"></div>
    <div id="middlebar"></div>
    <div id="bottombar"></div>

    <div id="content">
    	<h1> Welcome to BD's BYO-PC Information Hub </h1>

	<div id="userlogin">

	  <form name="loginInput">
	    <p>Username: <input type="text" name="username" id="username" size="29" maxlength="40" class= "inputfield" required /></p>

	    <p>Password: <input type="password" name="password" id="pwd" size="30" maxlength="40" class= "inputfield" required /></p>

	    <input id = "userloginButton" type="button" value="Log In" />

	    <input id = "userRegisterButton" type="button" value="Register" />
	    
	  </form>

	</div>

	<input id = "loginButton" type="button" value="Log In" />

<!-- 	<div id="userRegister">

	  <form name="registerInput">
	    <p>Username: <input type="text" name="username" id="rusername" size="29" maxlength="40" class= "inputfield" required /></p>

	    <p>Password: <input type="password" name="password" id="rpwd" size="30" maxlength="40" class= "inputfield" required /></p>

	    <input id = "userRegisterButton" type="button" value="Register" />
	    

	  </form>

	</div> -->

	<!-- <input id = "registerButton" type="button" value="Register" /> -->

	


</div>

<?php include 'footer.php'; ?>

</body>

	
