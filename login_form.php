<?php
include 'configuration.php';
session_start();

if($_SERVER['REQUEST_METHOD']=="POST"){
	if(isset($_POST['submit'])){
		$email = mysqli_real_escape_string($conn, $_POST['email']);
		$pwd =  md5($_POST['password']);
		
		$sql="SELECT * FROM  user WHERE email='$email' AND password='$pwd'";
		$result = mysqli_query($conn, $sql);
		$count = mysqli_num_rows($result);
		
		if($count == 1){
			$row= mysqli_fetch_assoc($result);
			if($row['user_type'] == 'Admin'){
				$_SESSION['user_id'] = $row['id'];
				header('Location: item.php');
			}
			else if($row['user_type'] == 'User'){
				$_SESSION['user_id'] = $row['id'];
				header('Location: profile.php');
			}
		}
		else{
			$error[] = 'Incorrect email or password!!!';
		}
	}	 	
};
?>
<html>
<head>
<title>login form</title>
<link rel = "stylesheet" type="text/css" href="style.css"/>
</head>
<body>
<div class="wrapper">
<div class="n1" >
	<div class="left">
		<div class="logo"><p><span>Zola</span>Fashion</p></div>	
		
	</div>
</div>
<div class="n2">
		<ul>
			<li><a href="home.php">Home</a></li>
			<li><a href="about.php">About Us</a></li>
			<li><a href="services.php">Services</a></li>
			<li><a href="contact.php">Contact</a></li>
		</ul>
</div>
<div class="main">
	<form action="" method="POST">
		<h3> Login Now</h3>
		
		<input type="email" name="email" placeholder="enter your email" required>
		<input type="password" name="password" placeholder="enter your password" required>
		<input type="submit" name="submit" value="Login">
		<p>Don't have an account? <a href="registration_form.php"> register now</a></p></br>
		<?php
			if(isset($error)){
				foreach($error as $error){
					echo '<span class="error">'.$error.'</span>.<br>';
				};
			};
		?>
	</form>
</div>
</body>
</html>