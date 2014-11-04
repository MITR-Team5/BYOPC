$(document).ready(
    function(){

      //$("#userlogin").hide();
      //$("#loginButton").click(login);
      // $("#logoutButton").click(logout);
      
      //ajax
      $("#login-button").on("click", function(e){
    	  $.ajax({
        	  url:"controller.php",
        	  accepts:"json",
        	  typr:"POST",
        	  data:{action:"login", username:$("#username").val(), password:$("#password").val()},
        	  success:function(data, textStatus, jqXHR){
        		  alert("Success: "+jqXHR.responseText);
        		  window.location.assign("login_success.php");
        	  },
        	  error:function(jqXHR, textStatus, errorThrown){
        		  alert(jqXHR.responseText + textStatus + errorThrown);
        	  }
          });
      });
      

    });

function login() {
  	if($("#target").text() == "User not logged in!"){
	    $("#userlogin").show();
	    $("#loginButton").css("margin-top","30%");
	    $("#footer").css("margin-top", "10%");
	    $("#username").focus();
	}
	else{
	    $("#userlogin").show();
	}

}
