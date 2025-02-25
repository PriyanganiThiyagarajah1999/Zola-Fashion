<?php 
include 'configuration.php';
session_start();
error_reporting(0);
if(isset($_SESSION['name'])){
    header("Location: home.php");
}

if(isset($_POST['submit'])){
	$name = mysqli_real_escape_string($conn,$_POST['name']);
	$email = mysqli_real_escape_string($conn, $_POST['email']);
	$pwd = md5($_POST['password']);
	$cpwd = md5($_POST['cpassword']);
	$user_type = $_POST['user_type'];
	$image = $_FILES['image']['name'];
	$image_size = $_FILES['image']['size'];
	$image_tmp_name = $_FILES['name']['tmp_name'];
	$image_folder = 'uploaded_img/'.$image;

	if($pwd == $cpwd){
		$sql = "SELECT * FROM user WHERE email='$email'";
		$result = mysqli_query($conn, $sql);
		if(!$result->num_rows > 0){
			$sql = "INSERT INTO user (name, email, password, user_type, image) VALUES ('$name', '$email', '$pwd', '$user_type', '$image')";
			$result = mysqli_query($conn, $sql);
			if($result){
				$error[] = 'Wow! User Registration Completed.';
				$username = "";
				$email = "";
				$_POST['password'] = "";
				$_POST['cpassword'] = "";
				header('location: login_form.php');
			}else if($image_size>2000000){
				$error[] = 'Image size is too large';
			}else{
				if($result){
					move_uploaded_file($image_tmp_name, $image_folder);
					$error[] = 'Registered successfully';
					}
				else{
					$error[] = 'Registered Failled';
				}
			}
		}else{
			$error[] = 'User already exist!!!';
		}	
	}else{
		$error[] = 'password not matched!!!';
	}
}

?>

<html>
<head>
<title>registration form</title>
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
	<form action="" method="post" enctype="multipart/form-data">
	<?php	
		if($fetch['image']==''){
				echo '<img src="1.png">';
		}
		else{
			echo '<img src="uploaded_img/'.$fetch['image'].'">';
		}
	?>
		<h3> Register Now</h3>
		<input type="text" name="name" placeholder="enter your name" required>
		<input type="email" name="email" placeholder="enter your email" required>                            
		<input type="password" name="password" placeholder="enter your password" required>
		<input type="password" name="cpassword" placeholder="confirm your password" required>
		<br><select name="user_type">
		<option name="user">User</option>
		<option name="admin">Admin</option>
		</select><br>
		<input type="file" name="image" accept="image/jpg, image/webp, image/png">
		<input type="submit" name="submit" value="Register" required>
		<p>already have an account? <a href="login_form.php"> login now</a></p></br>
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