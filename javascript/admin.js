$(document).ready(function(){
		$.ajax({
			url:"service.php",
			type:"POST",
			data:{"action":"get_users"},
			dataType:"json",
			success:function(data, textStatus, jqXHR){
				if(data["errors"].length==0)
				{
					for(var i=0; i!=data["data"]["participate"].length; i++)
					{
						var user=data["data"]["participate"][i];
						var row="<tr>";
						row+="<td>"+user["username"]+"</td>";
						row+="<td>"+user["model"]+"</td>";
						row+="<td>"+user["os"]+"</td>";
						row+="<td>"+user["comment"]+"</td>";
						row+="<td>"+(user["completed"]==1 ? "Yes":"No")+"</td>";
						row+="</tr>";
						$("#users-table-participate").append(row);
					}
					for(var i=0; i!=data["data"]["decline"].length; i++)
					{
						var user=data["data"]["decline"][i];
						var row="<tr>";
						row+="<td>"+user["username"]+"</td>";
						row+="<td>"+user["comment"]+"</td>";
						row+="<td>"+(user["completed"]==1 ? "Yes":"No")+"</td>";
						row+="</tr>";
						$("#users-table-decline").append(row);
					}
					for(var i=0; i!=data["data"]["undecided"].length; i++)
					{
						var user=data["data"]["undecided"][i];
						var row="<tr>";
						row+="<td>"+user["username"]+"</td>";
						row+="<td>"+user["model"]+"</td>";
						row+="<td>"+user["os"]+"</td>";
						row+="<td>"+user["comment"]+"</td>";
						row+="<td>"+(user["completed"]==1?"Yes":"No")+"</td>";
						row+="</tr>";
						$("#users-table-undecided").append(row);
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
									var chartData={
									    labels : ["Yes", "No"],
									    datasets : [
								    	    {
											    fillColor : "rgba(225,79,1,1)",
											    strokeColor : "rgba(220,220,220,1)",
											    data : [result[1], result[0]]
										    }
									    ]
									}
									var maxHeight=Math.max(result[1], result[0]);
									var desc=GetDescription(allQuestions, qid);
									$("#survey-results-container").append("<p>Result for question ID "+qid+": "+desc+"</p><canvas width='800' height='400'></canvas>");
									var canvas=$("#survey-results-container canvas").last().get(0);
									var ctx = canvas.getContext("2d");
									var chart = new Chart(ctx).Bar(chartData, {	
										scaleOverlay : false,
										scaleOverride : true,
										scaleSteps : maxHeight+2,
										scaleStepWidth : 1,
										scaleStartValue : 0
									});
								}
								for(var i=0; i!=data["data"]["numeric"].length; i++)
								{
									var qid=data["data"]["numeric"][i]["id"];
									var result=data["data"]["numeric"][i]["result"];
									var chartData={
									    labels : ["1", "2", "3", "4", "5"],
									    datasets : [
								    	    {
											    fillColor : "rgba(225,79,1,1)",
											    strokeColor : "rgba(220,220,220,1)",
											    data : [result["1"], result["2"], result["3"], result["4"], result["5"]]
										    }
									    ]
									};
									var maxHeight=Math.max(result["1"], result["2"], result["3"], result["4"], result["5"]);
									$("#survey-results-container").append("<p>Result for question ID "+qid+": "+desc+"</p><canvas width='800' height='400'></canvas>");
									var canvas=$("#survey-results-container canvas").last().get(0);
									var ctx = canvas.getContext("2d");
									var chart = new Chart(ctx).Bar(chartData, {	
										scaleOverlay : false,
										scaleOverride : true,
										scaleSteps : maxHeight+2,
										scaleStepWidth : 1,
										scaleStartValue : 0
									});
								}
							}
						}
					});
					
					setTimeout(function(){ getHeight();},100);
					
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

		function getHeight() {
			//alert($("#middlebar").height());
			//alert($("#survey-results").outerHeight());
			$("#middlebar").height($("#middlebar").height() + $("#content").innerHeight());
		}
	});