<?php 
session_start();
if(isset($_SESSION["user"]) && $_SESSION["user"]["role"]=="normal")
{
	header("Location: survey.php");
}
else if(isset($_SESSION["user"]) && $_SESSION["user"]["role"]=="admin")
{
	
}
else
{
	header("Location: index.php");
}
?>
<head>
	<!--<script src="pong.js"> </script>
	<script src="jquery-2.0.3.min.js"></script>-->
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
	<script src="survey.js"></script>
	<title>BYO-PC @ BD
	</title>
	<link rel="stylesheet" type="text/css" href="admin.css">
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,600' rel='stylesheet' type='text/css'>

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
									var chartData=
									// {
									//     labels : ["Yes", "No"],
									//     datasets : [
								 //    	    {
									// 		    fillColor : "rgba(225,79,1,1)",
									// 		    strokeColor : "rgba(220,220,220,1)",
									// 		    data : [result[1], result[0]]
									// 	    }
									//     ]
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
									//}
									//var maxHeight=Math.max(result[1], result[0]);
									var desc=GetDescription(allQuestions, qid);
									$("#survey-results-container").append("<p>Result for question ID "+qid+": "+desc+"</p><canvas width='400' height='400'></canvas>");
									var canvas=$("#survey-results-container canvas").last().get(0);
									var ctx = canvas.getContext("2d");
									var chart = new Chart(ctx).Pie(chartData);
									// , {	
									// 	scaleOverlay : false,
									// 	scaleOverride : true,
									// 	scaleSteps : maxHeight+2,
									// 	scaleStepWidth : 1,
									// 	scaleStartValue : 0
									// });
								}
								for(var i=0; i!=data["data"]["numeric"].length; i++)
								{
									var qid=data["data"]["numeric"][i]["id"];
									var result=data["data"]["numeric"][i]["result"];
									var chartData=
									// {
									//     labels : ["1", "2", "3", "4", "5"],
									//     datasets : [
								 //    	    {
									// 		    fillColor : "rgba(225,79,1,1)",
									// 		    strokeColor : "rgba(220,220,220,1)",
									// 		    data : [result["1"], result["2"], result["3"], result["4"], result["5"]]
									// 	    }
									//     ]
									// };
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
									]
									var maxHeight=Math.max(result["1"], result["2"], result["3"], result["4"], result["5"]);
									$("#survey-results-container").append("<p>Result for question ID "+qid+": "+desc+"</p><canvas width='400' height='400'></canvas>");
									var canvas=$("#survey-results-container canvas").last().get(0);
									var ctx = canvas.getContext("2d");
									var chart = new Chart(ctx).Pie(chartData);
									// 	, {	
									// 	scaleOverlay : false,
									// 	scaleOverride : true,
									// 	scaleSteps : maxHeight+2,
									// 	scaleStepWidth : 1,
									// 	scaleStartValue : 0
									// });
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
</script>


<img src="bdlogo.png" height="90px" width="250px"> 

<button id = "logoutButton" value = "Logout">Logout</button>
    	
<div id="topbar"></div>
<div id="middlebar"></div>



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

<div id="bottombar"></div>

<?php 
	include('footer.php');
?>