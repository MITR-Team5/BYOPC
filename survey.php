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
	<title>BYOPC @ BD
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
		    <h2>Due to the success of the BYOD program at BD, we have decided to implement a BYOPC program.</h2> 
		    <h2>"Bring Your Own PC" is a new program offered by BD for employees to choose and use their own computer for work. Similar to BYOD at BD, employees will be able to do basic activities such as checking email, contacts, and calendars and well as do all of their all work related computing using their own computer through the procedures set up by BYOPC. </h2>
		    
		    <h2>The following surveys will be used to gauge your personal interest in and eligibility to participate in the program.</h2>
		    <p>&nbsp;</p><p>&nbsp;</p>
		    <input class= "nextPage" type="button" value="Continue" /> 
	    </div>

	    <div id= "page1">
	    <h2> The BYOPC program at BD gives employees the option to purchase a laptop for use in the office and at home, or to use a laptop they already own as their work laptop.  </h2>
	    <h3>Would you be interested in using a personal laptop for work?</h3>&nbsp;&nbsp;&nbsp;Yes<input id="yes1" type="radio" name="yes" value="1">&nbsp;&nbsp;No<input id = "no1" type="radio" name="no" value="0">
	    <p><input class = "nextPage" type="button" value="Continue"/> </p>
	    
 	    <div id= "page2">
	    	<div id="survey-questions">
	    		<div id="questions"></div>
	    	</div>
	    	<input class= "nextPage" type="button" value="Continue" /> 

	    </div> 
	    
		<div id="page3">
			
			
			<input class = "nextPage" type="button" value="Continue" /> 

		</div>
		

		<div id="page4">

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

			</form>

			<input class = "nextPage" type="button" value="Continue" /> 
		</div>



		<div id = "page5">
			<h2>In order to ensure maximum security of confidential BD information while allowing for flexibility for employees, a virtual machine "VM" will be used as the work desktop environment.  
			All information will be saved to a central server located at BD, rather than on the personal computer. 
			A company ID and password will securely allow users to login and access their virtual machine using the VMWare client installed on the employee computer. 
			Employees will not be allowed to access programs or confidential information associated with BD on their personal laptop without using the VM. 
 			</h2>
 			<input class = "nextPage" type="button" value="Continue" /> 
 		</div>

 		<div id = "page6">
 			<h2>
			All updates of the work desktop environment will be handled by the IT department / Workplace Engineering team and will follow the same patching schedule as the BD issued laptops.  
 
			Any additional hardware (such as docks, additional chargers, adapters, etc) that are proprietary will be the responsiblity of the employee to purchase. 
			All employees who choose to enroll in the BYOPC will have access to technical support provided by the Workplace Engineering Team, limited to topics that fall under their jurisdiction.
			Employees who enroll in the program will be entirely responsible for technical support that falls outside the jurisdiction of the Workplace Engineering Team, as well as any costs associated with the maintenance and repair of their personal computer.  
			To prevent any loss productivity, loaner laptops will be available at the help desk if extensive repairs of the employee's laptop are necessary. 
 
			</h2>
			<input class = "nextPage" type="button" value="Continue" /> 
		</div>

		<div id="page7">

				<h2>By participating in the BYOPC program, you are agreeing to be responsible for the cost associated with repair and upkeep of your personal laptop. Your laptop must meet certain performance measures in order for it to be eligible for the program.</h2>
			    <h3>I wish to participate in the BYOPC program</h3>  
			    <p>Yes<input type="radio" name="participate" value="1">&nbsp;&nbsp;No<input type="radio" name="participate" value="0"></p>
		  		<input id = "submit-decision-btn" type="button" value="Submit" />
		</div>		

		<div id= "pageEnd">
			<h2>Thank you for completing the survey! </h2>
		</div>

	</div>


<?php include 'footer.php'; ?>


	
