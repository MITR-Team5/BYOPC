$(document).ready(
    function(){

      $("#userlogin").hide();
      $("#loginButton").click(login);
      // $("#logoutButton").click(logout);
<<<<<<< HEAD

      });
    
=======
	  
      //$("#userRegister").hide();
      $("#loginButton").click(showlogin);
      // $("#logoutButton").click(logout);
      $("#userloginButton").click(sendlogin);
      //$("#registerButton").click(showregister);
      $("#userRegisterButton").click(sendreg);


>>>>>>> e0c21bbc3ff4d5cf5420a9622b2d87562c6c0a0c
});

function login() {

	$("#loginButton").hide();
	$("#userlogin").show();
	$("#footer").css("margin-top", "36%");

    $("#userloginButton").click(sendlogin);

    $("#userRegisterButton").click(sendreg);

}



function sendlogin() {
	var uname = $("#username").val();
	var pwd = $("#pwd").val();
  $.post("controller.php",
  {
  	action:"login",
    username:uname,
    password:pwd
  },
  function(data,status){
	  alert(data["msg"]);
	  
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

function sendreg() {
	var uname = $("#username").val();
	var pwd = $("#pwd").val();
  $.post("controller.php",
  {
  	action:"register",
    username:uname,
    password:pwd
  },
  function(data,status){
	  if(data["errors"].length===0)
      {
		  window.location.assign("index.php");
      }
	  else
	  {
		  alert("Login failed: "+data["msg"]);
	  }
  }, "json");
}
