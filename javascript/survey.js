$(document).ready(
    function(){

      $("#page1").hide();
      $("#page2").hide();
      $("#page3").hide();
      $("#page4").hide();
      $("#pageEnd").hide();
      $("#nextPage").click(nextpage);
      $("#nextPage2").click(nextpage2);
      $("#nextPage3").click(nextpage3);
      $("#nextPage4").click(nextpage4);
      $("#submitButton").click(submit);
      $("#logoutButton").click(logout);

 });

function nextpage() {
<<<<<<< HEAD
  $("#intro").hide();
  $("#page1").show("slow");

}
function nextpage2() {
  $("#page1").hide();
  $("#page2").show("slow");
  var form0 = $("#form0 input[type='radio']:checked").val();
  //alert(form0);
  $.post("controller.php",
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
=======
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
>>>>>>> 70523df4fc46dbf53ae99f59164d0ce481f4b1ee
}

function nextpage3() {
  var form1 = $("#form1 input[type='radio']:checked").val();
  var form2 = $("#form2 input[type='radio']:checked").val();
  var form3 = $("#form3 input[type='radio']:checked").val();
  $.post("controller.php",
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
   $.post("controller.php",
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
   $.post("controller.php",
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
   $.post("service.php", 
  {
	   action:"complete_survey",
  },
  function(data, status){
	  if(data["errors"].length!==0)
      {
		  alert("Failure: "+data["msg"]);
	  }
  }
   );

   $("#page2").hide();
   $("#page3").show("slow");
}

function nextpage4() {
  $("#page3").hide();
  $("#page4").show("slow");
}

function submit() {
  $("#page4").hide();
  $("#pageEnd").show("slow");
}


function logout(){
  $.ajax({
    url:"controller.php",
    type:"POST",
    data:{"action":"logout"},
    dataType:"json",
    success:function(data, textStatus, jqXHR){
      window.location.assign("index.php");
    }
  });
}


