<head>
	<!--<script src="pong.js"> </script>
	<script src="jquery-2.0.3.min.js"></script>-->
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
	<script src="survey.js"></script>
	<title>BYO-PC @ BD
	</title>
	<link rel="stylesheet" type="text/css" href="survey.css">
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,600' rel='stylesheet' type='text/css'>
	<style>
		#content{
			color: black;
		}
		#users-table{
			width: 60%;
			margin: auto;
			border-collapse: collapse;
		}
		#users-table td, #users-table th{
			border: 1px solid black;
    		text-align:center;
		}
		#survey-results-container{
			width: 60%;
			margin: auto;
			
		}
	</style>
	<script>
		
	</script>
</head>
<!-- Chart -->
<script src="Chart.js"></script>
<script>
	$(document).ready(function(){
		$.ajax({
			url:"controller.php",
			type:"POST",
			data:{"action":"get_users"},
			dataType:"json",
			success:function(data, textStatus, jqXHR){
				if(data["errors"].length==0)
				{
					for(var i=0; i!=data["data"].length; i++)
					{
						var row="<tr>";
						row+="<td>"+data["data"][i]["username"]+"</td>";
						row+="<td>"+data["data"][i]["role"]+"</td>";
						row+="</tr>";
						$("#users-table").append(row);
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
			url:"controller.php",
			type:"POST",
			data:{"action":"all_survey_results"},
			dataType:"json",
			success:function(data, textStatus, jqXHR){
				if(data["errors"].length==0)
				{
					//Get all survey questions
					$.ajax({
						url:"controller.php",
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
											    fillColor : "rgba(0,220,220,0.5)",
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
											    fillColor : "rgba(0,220,220,0.5)",
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

	});
</script>

<img src="bdlogo.png" height="90px" width="250px"> 

<button id = "logoutButton" value = "Logout">Logout</button>
    	
<div id="topbar"></div>


<div id="content">
	
	<p>All users:</p>
	<div id="users-container">
		<table id="users-table">
			<th>User Name</th>
			<th>Role</th>
		</table>
	</div>
	<p>Survey Results:</p>
	<div id="survey-results">
		<div id="survey-results-container">
		</div>
	</div>
	
</div>
<?php 
	include('footer.php');
?>