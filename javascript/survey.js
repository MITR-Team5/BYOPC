(function($){
	$(document).ready(
	    function(){

	      $("#page1").hide();
	      $("#page2").hide();
	      $("#page3").hide();
	      $("#page4").hide();
	      $("#page5").hide();
	      $("#pageEnd").hide();
	      $("#nextPage").click(nextpage);
	      $("#nextPage2").click(nextpage2);
	      $("#nextPage3").click(nextpage3);
	      $("#nextPage4").click(nextpage4);
	      $("#nextPage5").click(nextpage5);
	      
	      $("#logoutButton").click(logout);

	 });

	function nextpage() {
	  $("#intro").hide();
	  $("#page1").show("slow");

	}

	function nextpage2() {
		//Submit the answers on the last page
		var form1 = $("#form1 input[type='radio']:checked").val();
		
		  $.post("service.php",
		  {
		  	action:"submit_survey",
		  	questions:[
		  	           {
				  		 qid:1,
				  	     value:form1
				  	   }
		  	          ]
		    
		  },
		  function(data,status){
			  if(data["errors"].length!==0)
			  {
				  alert("Submission failed: "+data["msg"]+data["errors"][0]);
			  }
			  else
			  {
				//If everything went well, move ahead
				$("#page1").hide();
				$("#page2").show("slow");
			  }
		  }, "json");
		  
		  

	}

	function nextpage3(){
		
		//Submit the answers on the last page
		var form2 = $("#form2 input[type='radio']:checked").val();
		$.post("service.php",
		  {
		  	action:"submit_survey",
		  	questions:[
		  	           {
				  		 qid:2,
				  	     value:form2
				  	   }
		  	          ]
		  },
		  function(data,status){
			  if(data["errors"].length!==0)
			  {
				  alert("Submission failed: "+data["msg"]+data["errors"][0]);
			  }
			  else
			  {
				  //If everything went well, move ahead
				  $("#page2").hide();
				  $("#page3").show("slow");
			  }
		  }, "json");
		
		
	}

	function nextpage4() {
	  //Submit the answers on the last page
	  var form31 = $("#form31 input[type='radio']:checked").val();
	  var form32 = $("#form32 input[type='radio']:checked").val();
	  var form33 = $("#form33 input[type='radio']:checked").val();
	  $.post("service.php",
	  {
	    action:"submit_survey",
	    questions:[
	               {
	            	   qid:2,
	            	   value:form31 
	               },
	               {
	            	   qid:3,
	            	   value:form32
	               },
	               {
	            	   qid:4,
	            	   value:form33
	               }
	              ]
	  },
	  function(data,status){
	    if(data["errors"].length!==0)
	    {
	    	alert("Submit failed: "+data["msg"]);
	    }
	    else
	    {
	    	//If everythin went well, move ahead
	    	$("#page3").hide();
	    	$("#page4").show("slow");
	    }
	  }, "json");
	   
	}

	function nextpage5() {
		var willParticipate=($("#form43 input[type='radio']:checked").val()=="1");
		if(willParticipate)
		{
			$.post("service.php",
			{
				action:"participate",
				model:$("#form41 select").val(),
				os:$("#form42 select").val(),
				comment:$("#form44 textarea").val()
			}, 
			function(data, status){
				if(data["errors"].length!==0)
				{
					alert("Submit failed: "+data["msg"]);
				}
				else
				{
					complete();
				}
			}, "json");
		}
		else
		{
			$.post("service.php",
			{
				action:"decline",
				comment:$("#form44 input").val()
			},
			function(data, status){
				if(data["errors"].length!==0)
				{
					alert("Submit failed: "+data["msg"]);
				}
				else
				{
					complete();
				}
			},"json");
			
		}
		
	}

	function complete(){
		$("#page4").hide();
		$("#pageEnd").show("slow");
		$.post("service.php", 
		{
			 action:"complete_survey",
		},
		function(data, status){
			if(data["errors"].length!==0)
		    {
				alert("Failure: "+data["msg"]);
			}
		});
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
}(jQuery));



