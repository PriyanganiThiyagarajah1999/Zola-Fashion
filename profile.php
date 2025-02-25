<?php
@include 'configuration.php';
session_start();
error_reporting(0);
$user_id = $_SESSION['user_id'];
if(!isset($user_id)){
	header('location:login_form.php');
};
if(isset($_GET['logout'])){
	unset($user_id);
	session_destroy();
	header('location: login_form.php');
}

?>

<html>
<head>
<title>Profile</title>
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

<form action="" method="POST" enctype="multipart/form-data">
<div class="main">
	<div class="profile">
	<?php
		$sql = "SELECT * FROM user WHERE id='$user_id'";
		$result = mysqli_query($conn, $sql);
		if(mysqli_num_rows($result)>0){
			$fetch = mysqli_fetch_assoc($result);
		}
		if($fetch['image']==''){
			echo '<img src="1.png">';
		}
		else{
			echo '<img src="uploaded_img/'.$fetch['image'].'">';
		}
	?>
	
	<h3><?php echo $fetch['name']; ?></h3>

	<div class="index">
		<table>
			<tr><td><span>User Name </span></td><td><input type="text" name="update_name" value="<?php echo $fetch['name']?>"></td></tr>
			<tr><td><span>Email </span></td><td><input type="email" name="update_email" value="<?php echo $fetch['email']?>" ></td></tr>
			<tr><td colspan="2"> <a href="update_profile.php" class="button">update profile</a></td></tr>
			<tr><td colspan="2"><a href="profile.php?logout=<?php echo $user_id; ?>" class="dltbutton">Logout</a></td></tr>
		</table>
	</div>
<?php
	if(isset($error)){
		foreach($error as $error){
			echo '<span class="error">'.$error.'</span>.<br>';
		};
	};
?>
<p>new <a href="login_form.php">login</a> or <a href="registration_form.php">register</a></p>
</div>
</form>
</body>
</html>