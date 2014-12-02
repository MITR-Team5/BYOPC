(function($){

  $(document).ready(function(){
    //get all the questions
    
    $.ajax({
      url:"service.php",
      type:"POST",
      dataType:"json",
      ajax:true,
      data:{"action":"survey_questions"},
      success:function(data, textStatus, jqXHR){
        if(data["errors"].length===0)
        {
          for(var i=0; i!=data["data"].length; i++)
          {
            var q=data["data"][i];
            var newQuestion=$("<div name='"+q["id"]+"' type='"+q["type"]+"'></div>");
            
            newQuestion.append("<input type='hidden' name='id'></input>");
            newQuestion.find("input[name='id']").val(q["id"]);
            newQuestion.append("<h3>"+q["desc"]+"</h3>");
            if(q["type"]=="YesNo")
            {
              newQuestion.append("Yes<input type='radio' value='1' required/>No<input type='radio' value='0' required/>");
              newQuestion.find("input[type='radio']").attr("name", q["id"]);
            }
            else if(q["type"]=="Numeric")
            {
              newQuestion.append("1<input type='radio' value='1' required>2<input type='radio' value='2' required>3" +
                  "<input type='radio' value='3' required>4<input type='radio' value='4' required>5<input type='radio' value='5' required>");
              newQuestion.find("input[type='radio']").attr("name", q["id"]);
            }
            else if(q["type"]=="Text")
            {
              newQuestion.append("<input type='text' required/>");
              newQuestion.find("input[type='text']").attr("name", q["id"]);
            }
            else
            {
              newQuestion.append("<input type='text' required/>");
              newQuestion.find("input[type='text']").attr("name", q["id"]);
            }
            
            //You can seperate the question into several pages by modifying this
            $("#questions").append(newQuestion);
            
              
          }
          
        }
        else
        {
          alert(data["msg"]);
        }
        
      },
      error:function(jqXHR, textStatus, errorThrown){
        alert("error");
      }
    });
    
      $("#page1").hide();
      $("#page2").hide();
      $("#page3").hide();
      $("#page4").hide();
      $("#page5").hide();
      $("#page6").hide();
      $("#page7").hide();
      $("#page8").hide();
      $("#page9").hide();
        
      $(".nextPage").click(nextpage);

      $("#submit-survey-btn").click(SubmitSurvey);
      $("#submit-decision-btn").click(SubmitDecision);
      $("#logoutButton").click(logout);
	});//Doc ready
	
	function SubmitSurvey(){
		var answers=[];
		$("#questions div").each(function(i, q){
			q=$(q);
			var ans={
				qid:0,
				value:0
			};
			ans.qid=q.attr("name");
			var qType=q.attr("type");
			if(qType=="YesNo")
			{
				ans.value=q.find("input[type='radio']:checked").val() || "0";
			}
			else if(qType=="Numeric")
			{
				ans.value=q.find("input[type='radio']:checked").val() || "0";
			}
			else if(qType=="Text")
			{
				ans.value=q.find("input[type='text']").val() || "None";
			}
			else
			{
				ans.value=q.find("input[type='text']").val() || "0";
			}
			answers.push(ans);
		});
		
		$.post("service.php", {
			action:"submit_survey",
			questions:answers,
		}, function(data, status){
			if(data["errors"].length==0)
			{
				//Go to the page where user would be asked for his model, os, and decision to participation
				nextpage();
			}
			else
			{
				alert(data["msg"]);
			}
		}, "json");
	}
	

  function nextpage() {
    if($("#intro").css("display")!="none")
    {
      $("#intro").hide();
      $("#page1").show("slow");
      return;
    }
    var done=false;
    $("div").each(function(i, e){
      if(e.id.substr(0, 4)==="page" && !isNaN(e.id.substr(4)) && e.style.display!='none' && !done)
      {
        $(e).hide();
        $("#page"+((parseInt(e.id.substr(4))+1).toString())).show("slow");
        done=true;
      }
    });

    

  }

  function SubmitSurvey(){
    var answers=[];
    $("#questions div").each(function(i, q){
      q=$(q);
      var ans={
        qid:0,
        value:0
      };
      ans.qid=q.attr("name");
      var qType=q.attr("type");
      if(qType=="YesNo")
      {
        ans.value=q.find("input[type='radio']:checked").val();
      }
      else if(qType=="Numeric")
      {
        ans.value=q.find("input[type='radio']:checked").val();
      }
      else if(qType=="Text")
      {
        ans.value=q.find("input[type='text']").val();
      }
      else
      {
        ans.value=q.find("input[type='text']").val();
      }
      answers.push(ans);
    });
    
    $.post("service.php", {
      action:"submit_survey",
      questions:answers,
    }, function(data, status){
      if(data["errors"].length==0)
      {
        //Go to the page where user would be asked for his model, os, and decision to participation
        nextpage();
      }
      else
      {
        alert(data["msg"]);
      }
    }, "json");
  }
  

  function SubmitDecision() {
    var willParticipate=($("#decision input[name='participate']:checked").val()=="1");
    if(willParticipate)
    {
      $.post("service.php",
      {
        action:"participate",
        model:$("#decision select[name='compBrand']").val(),
        os:$("#decision select[name='compOS']").val(),
        comment:$("#decision textarea[name='comment']").val()
      }, 
      function(data, status){
        if(data["errors"].length==0)
        {
          nextpage();
          complete();
        }
        else
        {
          alert("Submit failed: "+data["msg"]);
        }
      }, "json");
    }
    else
    {
      $.post("service.php",
      {
        action:"decline",
        comment:$("#decision textarea[name='comment']").val()
      },
      function(data, status){
        if(data["errors"].length==0)
        {
          nextpage();
          complete();
        }
        else
        {
          alert("Submit failed: "+data["msg"]);
        }
      },"json");
      
    }
    
  }


  function complete(){
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



