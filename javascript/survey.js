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
            newQuestion.append("<p>"+q["desc"]+"</p>");
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
        $(".nextPage").click(nextpage);
          $("#nextPage1").click(nextpage1);
    $("#nextPage2").click(nextpage2);
    $("#nextPage3").click(nextpage3);
        $("#submit-survey-btn").click(SubmitSurvey);
        $("#submit-decision-btn").click(SubmitDecision);
        $("#logoutButton").click(logout);

   });

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
function nextpage() {
  $("#intro").hide();
  $("#page1").show("slow");

}
function nextpage1() {
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

  // $("#intro").hide();
  // $("#page1").show("slow");
}

function nextpage2() {
  $("#page2").hide();
  $("#page3").show("slow");
  var form0 = $("#form0 input[type='radio']:checked").val();
  //alert(form0);
    $.post("service.php",
=======
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
            newQuestion.append("<p>"+q["desc"]+"</p>");
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
        
      $(".nextPage").click(nextpage);
      $("#submit-survey-btn").click(SubmitSurvey);
      $("#submit-decision-btn").click(SubmitDecision);
      $("#logoutButton").click(logout);

   });

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
    }, "json");

}

function nextpage3() {
  var form1 = $("#form1 input[type='radio']:checked").val();
  var form2 = $("#form2 input[type='radio']:checked").val();
  var form3 = $("#form3 input[type='radio']:checked").val();
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

   $("#page3").hide();
   $("#page4").show("slow");
}


function submit() {
  $("#page4").hide();
  $("#pageEnd").show("slow");
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



