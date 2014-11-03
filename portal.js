$(document).ready(
    function(){

      $("#userlogin").hide();
      //$("#userRegister").hide();
      $("#loginButton").click(showlogin);
      // $("#logoutButton").click(logout);
      $("#userloginButton").click(sendlogin);
      //$("#registerButton").click(showregister);
      $("#userRegisterButton").click(sendreg);

    });

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
    alert("Data: " + data + "\nStatus: " + status);
  });
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
    alert("Data: " + data + "\nStatus: " + status);
  });
}