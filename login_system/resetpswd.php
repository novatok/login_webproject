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
	<title>Reset Password</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
	<form id="loginForm" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
		<h1>Reset Password</h1>

		<div id="messageBox"></div>

		<div class="formcontainer">
			<label for="username">Username</label>	
			<input type="text" name="username" placeholder="username" required>

			<label for="phone">Phone</label>
			<input type="tel" name="phone" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" placeholder="876-000-0000" required>

			<button type="submit" name="submit">Reset</button>	
			<br>
				
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
		//connect database
		require('dbconnect.php');

		//Get user input 
		$username = $_POST['username'];
		$phone = $_POST['phone'];

		//SQL query to validate user input
		$querySelect = "SELECT * FROM users WHERE Username = '{$username}' AND Phone = '{$phone}'";
		$results = mysqli_query($mp_conn, $querySelect);

		//If user input not in DB output error
		if ($rowcount= mysqli_num_rows($results) == 0) { ?>
			<script> document.getElementById("messageBox").innerHTML = "<p style='color:red; text-align:center;'>The username or phone is incorrect. Try again. </p>"; </script>
		<?php }
		else {
			//Create query to get users email from database
			$emailSelectquery = "SELECT Email FROM users WHERE Username = '{$username}' AND Phone = '{$phone}'";
			$emailResult = mysqli_query($mp_conn, $emailSelectquery);
			$row = mysqli_fetch_assoc($emailResult);
			$userEmail = $row['Email'];

			//Generate a random string
			$randPswd = uniqid("majProj", false);
			//Create email content: to, from, subject and the body of the message 
			$to = $userEmail;
			$subject = "Reset Password"; 
			$headers = "From: <admin_majorproject@gmail.com>";
			$msg = "Hello ".$username.",\n\nHere is your temporary password: ".$randPswd.".\n\nPlease Update your password after logging in.\n\nRegards,\nAdmin.";

			//Email the user with random string password
			if (mail($to,$subject,$msg,$headers) ) { ?>
				<script type="text/javascript">
					document.getElementById("messageBox").innerHTML ="<p style='color:blue; text-align:center;'>A temporary password was sent to your email.</p> <p style='color:blue; text-align:center;'>Go to <a href='login.php'>Login</a> page.</p>" ;
				</script>
			<?php } 
			else { ?>
				<script type="text/javascript">document.getElementById("messageBox").innerHTML ="<p style='color:red; text-align:center;'>Error sending email.</p>" ;</script>

			<?php }
			//Update email field in database with the random string password
			$updateQuery = "UPDATE users SET Password='{$randPswd}' WHERE Username ='{$username}'";
			$updateResults = mysqli_query($mp_conn, $updateQuery);
			if (!$updateResults) { ?>
				<script type="text/javascript">document.getElementById("messageBox").innerHTML ="<p style='color:red; text-align:center;'>Password not reset. Try again.</p>" ;</script>
			<?php }  
			
		}
	}
?>