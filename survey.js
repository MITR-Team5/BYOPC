$(document).ready(
    function(){

      $("#page1").hide();
      $("#page2").hide();
      $("#pageEnd").hide();
      $("#nextPage").click(nextpage);
      $("#nextPage2").click(nextpage2);
      $("#submitButton").click(submit);

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
  $.post("controller.php",
  {
  	action:"submit_survey",
    qid:1,
    value:form0
    type:"YesNo"
  },
  function(data,status){
	  if(data["errors"].length!==0)
	  {

		  alert("Login failed: "+data["msg"]);
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
  $.post("controller.php",
  {
  	action:"submit_survey",
    qid:2,
    value:form1
    type:"Numeric"
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
    qid:3,
    value:form2
    type:"YesNo"
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
    qid:4,
    value:form3
    type:"YesNo"
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


