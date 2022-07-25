<!-- Author: Kamoy Saunders
	ID 20202957
	Date: 4/21/22
	Purpose: Major Project Internet Authoring 2
-->

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Change Password</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
	<form id="loginForm" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
		<h1>Change Password</h1>

		<div id="messageBox"></div>

		<div class="formcontainer">
			<label for="username">Username</label>	
			<input type="text" name="username" placeholder="username" required>

			<label for="password">Current Password</label>
			<input type="password" name="oldpassword" placeholder="********" required>

			<label for="password">New Password</label>
			<input type="password" name="newpassword" placeholder="********" required>

			<button type="submit" name="submit">Update</button>	
				
		</div>

		<div class="container" style="background-color:#f1f1f1">
		    <button type="button" class="cancelbtn" onclick="window.location.href='index.html';">Cancel</button>
		    <span class="psw">New User? <a href="register.php">Register</a></span>
	  	</div>
	</form>
</body>
</html>


<?php
	if (isset($_POST['submit'])) {
		require('dbconnect.php');

		$username = $_POST['username'];
		$oldpswd = $_POST['oldpassword'];
		$newpswd = $_POST['newpassword'];

		$querySelect = "SELECT * FROM users WHERE Username = '{$username}' AND Password = '{$oldpswd}'";
		$results = mysqli_query($mp_conn, $querySelect);
		if ($rowcount= mysqli_num_rows($results) == 0) { ?>
			<script type="text/javascript">document.getElementById("messageBox").innerHTML = "<p style='color:red; text-align:center;'>The username or current password is incorrect. Try again.</p>" ;</script>
		<?php }
		else {
			$updateQuery = "UPDATE users SET Password='{$newpswd}' WHERE Username ='{$username}'";
			$updateResults = mysqli_query($mp_conn, $updateQuery);
			if (!$updateResults) { ?>
				<script type="text/javascript">document.getElementById("messageBox").innerHTML = "<p style='color:red; text-align:center;'>Password not updated. Try again.</p>" ;</script>
			<?php }
			else { ?>
				<script type="text/javascript">
					document.getElementById("messageBox").innerHTML = "<p style='color:blue; text-align:center;'>Your password was updated.</p> <p style='color:blue; text-align:center;'>Go to <a href='login.php'>Login</a> page.</p>";
				</script>
			<?php }
		}


	}
?>


