<?php
	//Start a session
	session_start();

	//If remember checkbox is checked, create a cookie
	if (isset($_POST['rememberme'])) {
		$rememberMe_cookie = "user";
		$remember_value = $_POST['username'];
		setcookie($rememberMe_cookie, $remember_value, time() + (86400 * 2), "/");
	}
	//Delete cookie when user clicks logout
	elseif (isset($_POST['logout'])) {
		setcookie("user", "", time() - 3600, "/");
	}
	

?>
	<!DOCTYPE html>
	<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Login</title>
		<link rel="stylesheet" type="text/css" href="style.css">
	</head>
	<body>
		<!-- Create the form to get user input-->
		<form id="loginForm" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
			<h1>Login</h1>

			<div id="messageBox"></div>
			

			<div class="formcontainer">
				<label for="username">Username</label>	
				<input type="text" name="username" placeholder="username" required>

				<label for="password">Password</label>
				<input type="password" name="password" placeholder="********" required>

				<button type="submit" name="submit">Login</button>	
				<br>
				<label>
					<input type="checkbox" name="rememberme" checked> Remember me
				</label>	
			</div>

			<div class="container" style="background-color:#f1f1f1">
				<!-- Cancel button redirects to homepage-->
			    <button type="button" class="cancelbtn" onclick="window.location.href='index.html';">Cancel</button>
			    <!-- Creates a link to reset password page-->
			    <span class="psw"><a href="resetpswd.php">Forgot password?</a></span>
		  	</div>
		</form>
	</body>
	</html>

<?php 
	if (isset($_POST['submit'])) {
		//Get the database configuration from dbconnect file
		require('dbconnect.php');

		//Get user input from form and store in variables
		$_SESSION['username'] = $_POST['username'];
		$password = $_POST['password'];

		//MySQL query to select user information from database, checks for match between user input and datbase records
		$querySelect = "SELECT * FROM users WHERE username = '{$_SESSION['username']}' AND password = '{$password}'";

		$results = mysqli_query($mp_conn, $querySelect);
		//If no records in the database match user input and error is outputed
		if($rowcount= mysqli_num_rows($results) == 0){ ?>
			<script type="text/javascript"> document.getElementById("messageBox").innerHTML = "<p style='color:red; text-align:center;'> Invalid username or password.</p> "; </script>
		<?php }
		//If records in the database match user input then a session variable is created to show user is logged in
		else {
			$_SESSION['loggedin'] = true;
		}
	  	  
	}
	//If session variable is set user will be directed to the Welcome Message
	if (isset($_SESSION['loggedin'])) { ?>
			<!-- Javascript innerhtml used to hide form and display only welcome message-->
	  		<script type="text/javascript">
	  			document.getElementById("loginForm").innerHTML = "";
	  		</script>
	  		<!-- Welcome message to be displayed when user logs in sucessfully -->
			<body>
		  		<form id='loginForm2' action='<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>' method='post'> 
		  			<div id = 'maincontainer'> 
		  				<section id='welcomebox'> 
		  					<h2 style="text-align: center; color: #436AF7; font-size: 45px;">Welcome <?php echo $_SESSION['username']; ?></h2> 
		  					<p style="text-align: center;">You are logged in successfully.</p> 
		  					<button type='submit' id="logoutBTN" name='logout' style="padding: 14px 20px; margin: 20px 25%; width: 50%; background-color: #E05376; font-size: 18px;"><b>Logout</b></button> 
		  				</section> 
		  			</div> 
		  		</form>
		  	</body>

		<?php 
			//If user clicks the logout button the session is unset and user redirected to login form
			if (isset($_POST['logout'])) {
				header("Location: login.php");
				// redirect_to('login.php');
				session_unset();
				session_destroy();
			}

	}	

	
?>


<!-- Author: Kamoy Saunders
	ID 20202957
	Date: 4/21/22
	Purpose: Major Project Internet Authoring 2
-->