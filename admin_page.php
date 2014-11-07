<?php
	include('header.php');
?>
<script>
	$(document).ready(function(){
		$.ajax({
			url:"controller.php",
			type:"POST",
			data:{"action":"get_users"},
			dataType:"json",
			success:function(data, textStatus, jqXHR){
				alert(data);
			},
			error:function(jqXHR, textStatus, errorThrown){
				alert("error!");
			}
		});

	});
</script>
<p>Admin Page</p>

<?php 
	include('footer.php');
?>