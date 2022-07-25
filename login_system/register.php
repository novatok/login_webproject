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
	<title>Register</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
	<form id="loginForm" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
		<h1>Register</h1>

		<div id="messageBox"></div>
		
		<div class="formcontainer">
			<label for="username">Username</label>	
			<input type="text" name="username" placeholder="username" required>

			<label for="phone">Phone</label>	
			<input type="tel" name="phone" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" placeholder="876-000-0000" required>

			<label for="email">Email</label>	
			<input type="email" name="email" placeholder="someone@example.com" required>

			<label for="password">Password</label>
			<input type="password" name="password" placeholder="********" required>

			<button type="submit" name="submit">Register</button>	
			<br>
		</div>

		<div class="container" style="background-color:#f1f1f1">
		    <button type="button" class="cancelbtn" onclick="window.location.href='index.html';">Cancel</button>
		    <span class="psw">Already have an account? <a href="login.php">Login</a></span>
	  	</div>
	</form>
</body>
</html>


<?php
	if (isset($_POST['submit'])) {
		require('dbconnect.php');

		$username = $_POST['username'];
		$phone = $_POST['phone'];
		$email = $_POST['email'];
		$password = $_POST['password'];

		$querySelect = "SELECT * FROM users WHERE Username = '{$username}' ";
		$results = mysqli_query($mp_conn, $querySelect);
		if ($rowcount= mysqli_num_rows($results) == 0) {
			$insertQuery = "INSERT INTO users (Username, Password, Phone, Email) ".
                        "VALUES ('$username', '$password', '$phone', '$email' )" ;

        	$ValuesInserted = mysqli_query($mp_conn, $insertQuery);
        	if (!$ValuesInserted) { ?>
        		<script type="text/javascript">document.getElementById("messageBox").innerHTML = "<p style='color:red; text-align:center;'>Error registering user. Try again. <?php echo mysqli_error($mp_conn)?> </p>" ;</script>
        	<?php }
        	else{ ?>
        		<script type="text/javascript">
        			document.getElementById("messageBox").innerHTML ="<p style='color:blue; text-align:center;'>Registration successful!</p> <p style='color:blue; text-align:center;'>Welcome <?php echo $username ?> your phone number is <?php echo $phone ?></p> <p style='color:blue; text-align:center;'>Go to <a href='login.php'>Login</a> page.</p>" ;
        		</script>
        	<?php }
		}

		else { ?>
			<script type="text/javascript">document.getElementById("messageBox").innerHTML = "<p style='color:red; text-align:center;'>This username already exists.</p>" ;</script>
		<?php }
				
	}

?>