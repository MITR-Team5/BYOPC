<?php
session_start();
if(!isset($_SESSION["user"]))
{
?>
	<html>
		<div id="target" style="display:none;">
		<?php
			echo htmlspecialchars("User not logged in!");
		?>
		</div>
	</html>
	<!-- echo "User not logged in!"; -->
<?php
}

if(isset($_SESSION["user"]) && $_SESSION["user"]["role"]=="admin")
{
	header("Location:admin_page.php");
?>
	<html>
		<div id="target" style="display:none;">
		<?php
			echo htmlspecialchars("Admin logged in!");
		?>
		</div>
	</html>
	<!-- echo "Admin logged in!"; -->

<?php	
}

if(isset($_SESSION["user"]) && $_SESSION["user"]["role"]=="normal")
{
	header("Location:survey.php");
?>
	<html>
		<div id="target" style="display:none;">
		<?php
			echo htmlspecialchars("User logged in!");
		?>
		</div>
	</html>
<!-- 	echo "User logged in!"; -->

	

<?php } ?>

<!doctype html>
<html>

  <?php include "portalhome.php"; ?>
</html>