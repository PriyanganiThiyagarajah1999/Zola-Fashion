<?php 
include 'configuration.php';
session_start();
error_reporting(0);
$item_name = $_POST['item_name'];
$item_price = $_POST['price'];
?>
<html>
<head>
<title>Join Us</title>
<link rel="stylesheet" type="text/css" href="style.css"/>
</head>
<body>
<div class="wrapper">
<div class="n1" >
	<div class="left">
		<div class="logo"><p><span>Zola</span>Fashion</p></div>	
		
	</div>
	<div class="right">
		<ul>
		<li><a href="login_form.php">Login</a></li>
		<li><a href="registration_form.php">SignUp</a></li>
		<li><a href="profile.php">Profile</a></li>
		</ul>
	</div>
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
<div class="join">
	<?php
		$sql = "SELECT * FROM item";
		$select = mysqli_query($conn, $sql);
	?>
		<?php
			while($row = mysqli_fetch_assoc($select)){
		?>
		<div class="display">
		<img src="./uploaded_img/<?php echo $row['item_image']; ?>"></br>
		<!---<font size="5px" color="black"><b><?php echo $row['item_name']; ?></b></font></br>-->
		<b><?php echo $row['price']; ?></b></br>
		<a href="order_form.php" class="button">Buy Now</a>
		</div>
		<?php } ?>
	</div>	
</div>			
</body>
</html>