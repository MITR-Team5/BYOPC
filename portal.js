$(document).ready(
    function(){

      $("#userlogin").hide();
      $("#loginButton").click(login);
      // $("#logoutButton").click(logout);

    });

function login() {
  if($("#target").text() == "User not logged in!"){
	  $("#userlogin").show();
	  $("#loginButton").css("margin-top","30%");
	  $("#footer").css("margin-top", "10%");
	  $("#username").focus();
	}
}
