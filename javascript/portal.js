(function($){
	$(document).ready(
	    function(){

	      $("#userlogin").hide();
	      $("#loginButton").click(login);
	});

	function login() {
		$("#loginButton").hide();
		$("#userlogin").show();
		$("#footer").css("margin-top", "36%");
	    $("#userloginButton").click(sendlogin);
	}

	function sendlogin() {
		var uname = $("#username").val();
		var pwd = $("#pwd").val();
	  $.post("service.php",
	  {
	  	action:"login",
	    username:uname,
	    password:pwd
	  },
	  function(data,status){
		  
		  if(data["errors"].length===0)
	      {
			  window.location.assign("login_success.php");
	      }
		  else
		  {
			  alert("Login failed: "+data["msg"]);
		  }
	  }, "json");
	}
}(jQuery));



