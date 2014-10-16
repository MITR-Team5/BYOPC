$(document).ready(
    function(){

      $("#userlogin").hide();
      $("#loginButton").click(login);
      // $("#logoutButton").click(logout);

    });

function login() {
  $("#userlogin").show();
  $("#loginbutton").css({'margin-top':'35%'});
  $("#username").focus();
}
