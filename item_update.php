<?php 
include 'configuration.php';
session_start();
error_reporting(0);
$user_id = $_GET['edit'];

if(isset($_POST['update_product'])){
	$update_item_name = $_POST['item_name'];
	$update_item_price = $_POST['price'];
	$update_item_image = $_FILES['item_image']['name'];
	$update_image_size = $_FILES['item_image']['size'];
	$update_image_tmp_name = $_FILES['item_image']['tmp_name'];
	$update_item_image_folder = './uploaded_img/'.$item_image;

	if($image_size>2000000){
		$error[] = 'Image size is too large';
	}
	else{
		$sql = "UPDATE item SET item_name='$update_item_name', price='$update_item_price', item_image='$update_item_image'  WHERE id='$user_id'";
		$upload = mysqli_query($conn, $sql);
		if($upload){
			move_uploaded_file($image_tmp_name, $item_image_folder);
			header('location: item.php');
		}
		else{
			$error[] = 'Could not update the product';
		}
	}
};
?>
<html>
<head>
<title>Product Update</title>
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
<?php
	$sql = "SELECT * FROM item WHERE id='$user_id'";
	$result = mysqli_query($conn, $sql); 
	if(mysqli_num_rows($result)>0){
		$fetch = mysqli_fetch_assoc($result);
	}
?>
	<form action="<?php $_SERVER['PHP_SELF']?>" method="POST" enctype="multipart/form-data">
	<div class="d1">
<?php	
	if($fetch['item_image']==''){
			echo '<img src="images/1.png">';
	}
	else{
		echo '<img src="uploaded_img/'.$fetch['item_image'].'">';
	}
?>
		
		<h3> Update the Product</h3>
		<input type="text" name="item_name" value="<?php echo $fetch['item_name']?>">
		<input type="number" name="price" value="<?php echo $fetch['price']?>">
		<input type="file" name="item_image" accept="image/jpg, image/webp, image/png">
		<input type="submit" name="update_product" value="Update Product"></br>
		<center><a href="item.php" class="btn">Go Back</a></center>
		<?php
			if(isset($error)){
				foreach($error as $error){
					echo '<span class="error">'.$error.'</span>.<br>';
				};
			};
		?>
		</div>
	</form>	
	<div>
</div>
</body>
</html>