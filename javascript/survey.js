$(document).ready(
    function(){

      $("#page1").hide();
      $("#page2").hide();
      $("#pageEnd").hide();
      $("#nextPage").click(nextpage);
      $("#nextPage2").click(nextpage2);
      $("#submitButton").click(submit);
      $("#logoutButton").click(logout);

 });

function nextpage() {
	$("#intro").hide();
	$("#page1").show("slow");

}
function nextpage2() {
	$("#page1").hide();
	$("#page2").show("slow");
	var form0 = $("#form0 input[type='radio']:checked").val();
	//alert(form0);
  $.post("service.php",
  {
  	action:"submit_survey",
  	questions:[
  	           {
		  		 qid:1,
		  	     value:form0
		  	   }
  	          ]
    
  },
  function(data,status){
	  if(data["errors"].length!==0)
	  {
		  alert("Submission failed: "+data["msg"]+data["errors"][0]);
	  }
  }, "json");
}

function submit() {
	var form1 = $("#form1 input[type='radio']:checked").val();
	var form2 = $("#form2 input[type='radio']:checked").val();
	var form3 = $("#form3 input[type='radio']:checked").val();
	//alert(form1);
	//alert(form2);
	//alert(form3);
  $.post("service.php",
  {
  	action:"submit_survey",
  	questions:[
  	           {
  	        	 qid:2,
  	             value:form1 
  	           }
  	          ]
    
  },
  function(data,status){
	  if(data["errors"].length!==0)

	  {
		  alert("Submit failed: "+data["msg"]);
	  }
  }, "json");
   $.post("service.php",
  {
  	action:"submit_survey",
  	questions: [
  	            {
  	              qid:3,
  	              value:form2
  	            }
  	           ]
    
  },
  function(data,status){
	  if(data["errors"].length!==0)

	  {
		  alert("Submit failed: "+data["msg"]);
	  }
  }, "json");
   $.post("service.php",
  {
  	action:"submit_survey",
  	questions:[
  	           {
  	        	 qid:4,
  	             value:form3
  	           }
  	          ]
    
  },
  function(data,status){
	  if(data["errors"].length!==0)
      {
		  alert("Submit failed: "+data["msg"]);
	  }
  }, "json");

   $("#page2").hide();
   $("#pageEnd").show("slow");
}

function logout(){
	$.ajax({
		url:"service.php",
		type:"POST",
		data:{"action":"logout"},
		dataType:"json",
		success:function(data, textStatus, jqXHR){
			window.location.assign("index.php");
		}
	});
}


