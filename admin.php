<?php
	include('header.php');
?>
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

		$.ajax({
			url:"controller.php",
			type:"POST",
			data:{"action":"all_survey_results"},
			dataType:"json",
			success:function(data, textStatus, jqXHR){
				if(data["errors"].length==0)
				{
					for(var i=0; i!=data["data"]["yesno"].length; i++)
					{
						var qid=data["data"]["yesno"][i]["id"];
						var result=data["data"]["yesno"][i]["result"];
						var chartData={
						    labels : ["Yes", "No"],
						    datasets : [
					    	    {
								    fillColor : "rgba(220,220,220,0.5)",
								    strokeColor : "rgba(220,220,220,1)",
								    data : [result[1], result[0]]
							    }
						    ]
						}
						$("#survey-results-container").append("<p>Result for question ID: "+qid+"</p><canvas width='800' height='400'></canvas>");
						var canvas=$("#survey-results-container canvas").last().get(0);
						var ctx = canvas.getContext("2d");
						var chart = new Chart(ctx).Bar(chartData, {	
							scaleOverlay : false,
							scaleOverride : true,
							scaleSteps : 6,
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
								    fillColor : "rgba(220,220,220,0.5)",
								    strokeColor : "rgba(220,220,220,1)",
								    data : [result["1"], result["2"], result["3"], result["4"], result["5"]]
							    }
						    ]
						}
						$("#survey-results-container").append("<p>Result for question ID: "+qid+"</p><canvas width='800' height='400'></canvas>");
						var canvas=$("#survey-results-container canvas").last().get(0);
						var ctx = canvas.getContext("2d");
						var chart = new Chart(ctx).Bar(chartData, {	
							scaleOverlay : false,
							scaleOverride : true,
							scaleSteps : 6,
							scaleStepWidth : 1,
							scaleStartValue : 0
						});
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

	});
</script>

<img src="bdlogo.png" height="90px" width="250px"> 

<input id = "logoutButton" type="button" value = "Logout" />
    	
<div id="topbar"></div>
<div id="middlebar"></div>
<div id="bottombar"></div>


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
		</table>
	</div>
	
</div>
<?php 
	include('footer.php');
?>