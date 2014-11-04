$(document).ready(
    function(){

      $("#userlogin").hide();
      $("#loginButton").click(login);
      // $("#logoutButton").click(logout);
	  
      //$("#userRegister").hide();
      $("#loginButton").click(showlogin);
      // $("#logoutButton").click(logout);
      $("#userloginButton").click(sendlogin);
      //$("#registerButton").click(showregister);
      $("#userRegisterButton").click(sendreg);


});

function login() {
 //  	if($("#target").text() == "User not logged in!"){
	//     $("#userlogin").show();
	//     $("#loginButton").css("margin-top","30%");
	//     $("#footer").css("margin-top", "10%");
	//     $("#username").focus();
	// }
	// else{
	$("#loginButton").hide();
	$("#userlogin").show();
	$("#footer").css("margin-top", "36%");
	//}
    //$("#userlogin").hide();
    //$("#userRegister").hide();
    //$("#loginButton").click(showlogin);
    // $("#logoutButton").click(logout);
    //$("#userloginButton").click(sendlogin);
    //$("#registerButton").click(showregister);
    //$("#userRegisterButton").click(sendreg);

}

function showlogin() {
	$("#userlogin").show();
	$("#loginButton").hide();
	$("#username").focus();
	$("#footer").css("margin-top", "36%");

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
