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

if(isset($_SESSION["user"]) && $_SESSION["role"]=="admin")
{
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

if(isset($_SESSION["user"]) && $_SESSION["role"]=="normal")
{
?>
	<html>
		<div id="target" style="display:none;">
		<?php
			echo htmlspecialchars("User logged in!");
		?>
		</div>
	</html>
<!-- 	echo "User logged in!"; -->
<?php
	header("Location:survey.php");
}

if(count($ERRORS)==0)
{
?>
	<html>
		<div id="target" style="display:none;">
		<?php
			echo htmlspecialchars("Database connection successful!");
		?>
		</div>
	</html>
<!-- 	echo "Database connection successful!"; -->

<?php
}
?>
<!doctype html>
<html>
  <?php include "portalhome.php"; ?>
</html>
