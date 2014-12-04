(function($){
	$(document).ready(function(){
		
		
		//Get all the users
		$.ajax({
			url:"service.php",
			type:"POST",
			data:{"action":"get_users"},
			dataType:"json",
			success:function(data, textStatus, jqXHR){
				if(data["errors"].length==0)
				{
					for(var i=0; i!=data["data"].length; i++)
					{
						var row="<tr>";
						if(data["data"][i]["role"] != "admin"){
							row+="<td class='userlink'>" + data["data"][i]["id"]+"</td>";
						}
						else{
							row+="<td>"+data["data"][i]["id"]+"</td>";
						}
						row+="<td>"+data["data"][i]["username"]+"</td>";
						row+="<td>"+data["data"][i]["role"]+"</td>";
						row+="<td>"+data["data"][i]["model"]+"</td>";
						row+="<td>"+data["data"][i]["os"]+"</td>";
						var participate;
						if(data["data"][i]["participate"]=="1")
						{
							participate="Yes";
						}
						else if(data["data"][i]["participate"]=="0")
						{
							participate="No";
						}
						else
						{
							participate="Undecided";
						}
						row+="<td>"+participate+"</td>";
						var completed;
						if(data["data"][i]["completed"]=="1")
						{
							completed="Yes";
						}
						else
						{
							completed="No";
						}
						row+="<td>"+completed+"</td>";
						row+="<td>"+(data["data"][i]["comment"] || "None")+"</td>";
						row+="</tr>";
						$("#users-table").append(row);
					}
					//Adjust the position of the footer
					//getHeight();
					$(".userlink").click(getUserData);
				
				}
				else
				{
					alert(data["msg"]);
				}
			},
			error:function(jqXHR, textStatus, errorThrown){
				alert("error!");
			}
		});
		//Get all survey results
		$.ajax({
			url:"service.php",
			type:"POST",
			data:{"action":"all_survey_results"},
			dataType:"json",
			success:function(data, textStatus, jqXHR){
				if(data["errors"].length==0)
				{
					//Get all survey questions
					$.ajax({
						url:"service.php",
						type:"POST",
						data:{"action":"survey_questions"},
						dataType:"json",
						success:function(questionsData, textStatus, jqXHR){
							if(data["errors"].length==0)
							{
								var allQuestions=questionsData["data"];
								for(var i=0; i!=data["data"]["yesno"].length; i++)
								{
									var qid=data["data"]["yesno"][i]["id"];
									var result=data["data"]["yesno"][i]["result"];
									var chartData=
									    [
									    	{
										    	value: result[0],
										    	color: "#F7464A",
										    	highlight: "#FF5A5E",
										    	label: "No"
										    },
										    {
										    	value: result[1],
										    	color: "#46BFBD",
	    										highlight: "#5AD3D1",
	    										label: "Yes"
										    }
										];
									
									var desc=GetDescription(allQuestions, qid);
									$("#survey-results-container").append("<p>Result for question ID "+qid+": "+desc+"</p>" +
										"<div>Yes: <div class='legend-color' style='background-color:#46BFBD'></div> No: <div class='legend-color' style='background-color:#F7464A'></div></div>"+	
										"<canvas width='800' height='400'></canvas>");
									
									var canvas=$("#survey-results-container canvas").last().get(0);
									var ctx = canvas.getContext("2d");
									var chart = new Chart(ctx).Pie(chartData);

								}
								for(var i=0; i!=data["data"]["numeric"].length; i++)
								{
									var qid=data["data"]["numeric"][i]["id"];
									var result=data["data"]["numeric"][i]["result"];
									var chartData=
									[
										{
											value: result["1"],
											color: "#CC66FF",
											highlight: "#D685FF",
											label: "1"

										},
									    {
										   	value: result["2"],
										   	color: "#F7464A",
										   	highlight: "#FF5A5E",
										   	label: "2"
										},
										{
										   	value: result["3"],
										   	color: "#46BFBD",
	    									highlight: "#5AD3D1",
	    									label: "3"
										},
										{
											value: result["4"],
											color: "#33AD5C",
											highlight: "#5CBD7D",
											label: "4"
										},
										{
											value: result["5"],
											color: "#FF9933",
											highlight: "#FFAD5C",
											label: "5"
										}
									];
									var desc=GetDescription(allQuestions, qid);
									$("#survey-results-container").append("<p>Result for question ID "+qid+": "+desc+"</p>" +
										"<div>" +
										" 1: <div class='legend-color' style='background-color:#CC66FF'></div>" +
										" 2: <div class='legend-color' style='background-color:#F7464A'></div>" +
										" 3: <div class='legend-color' style='background-color:#46BFBD'></div>" +
										" 4: <div class='legend-color' style='background-color:#33AD5C'></div>" +
										" 5: <div class='legend-color' style='background-color:#FFAD5C'></div>" +
										"</div>"+	
										"<canvas width='800' height='400'></canvas>");
									var canvas=$("#survey-results-container canvas").last().get(0);
									var ctx = canvas.getContext("2d");
									var chart = new Chart(ctx).Pie(chartData);

								}
								
							}
							else
							{
								alert(data["msg"]);
							}
						},
						error:function(jqXHR, textStatus, errorThrown){
							alert("error!");
						}
					});
					
					
				}
				else
				{
					alert(data["msg"]);
				}
			},
			error:function(jqXHR, textStatus, errorThrown){
				alert("error!");
			}
		});
		
		$("#user-content").hide();
		$("#survey-results").hide();
		$(".userlink").click(getUserData);
		$("#view-all").click(surveyShow);
		$("#logoutButton").click(logout);
		
	});//Doc Ready

	function getUserData() {
		$("#content").hide();

		var txt = $(this).text();
		alert(txt);
			$.ajax({
			url:"service.php",
			type:"POST",
			data:{"action":"get_users", "id":txt},
			dataType:"json",
			success:function(data, textStatus, jqXHR){
				if(data["errors"].length==0)
				{
					for(var i=0; i!=data["data"].length; i++)
					{
						var row="<tr>";
						row+="<td>"+data["data"][i]["role"]+"</td>";
						row+="<td>"+data["data"][i]["model"]+"</td>";
						row+="<td>"+data["data"][i]["os"]+"</td>";
						row+="</tr>";
						$("#users-table").append(row);
					}
					//Adjust the position of the footer
					//getHeight();
				
				}
				else
				{
					alert(data["msg"]);
				}
			},
			error:function(jqXHR, textStatus, errorThrown){
				alert("error!");
			}
		});

		$("#user-content").show();
	}

	function GetDescription(questions, id)
	{
		for(var i=0; i!=questions.length; i++)
		{
			if(questions[i]["id"]==id)
			{
				return questions[i]["desc"];
			}
		}
		return "Unknown question";
	}

	function surveyShow() {
		$("#view-all").hide();
		$("#survey-results").show(400, getHeight);
		
	}

	function getHeight() {
	    $(window).load($("#footer").css("margin-top",$("#footer").outerHeight()+$("#content").outerHeight()+50));
	    $(window).load($("#bottombar").css("margin-top",$("#bottombar").outerHeight()+$("#content").outerHeight()+20));
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

