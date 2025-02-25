<?php 
include 'configuration.php';
session_start();
error_reporting(0);
$user_id = $_SESSION['user_id'];
if(!isset($user_id)){
	header('location:login_form.php');
};

if(isset($_POST['add_product'])){
	$item_name = $_POST['item_name'];
	$item_price = $_POST['price'];
	$item_image = $_FILES['item_image']['name'];
	$image_size = $_FILES['item_image']['size'];
	$image_tmp_name = $_FILES['item_image']['tmp_name'];
	$item_image_folder = './uploaded_img/'.$item_image;

	$sql = "SELECT * FROM item WHERE item_name='$item_name'";
	$result = mysqli_query($conn, $sql);
	if(!mysqli_num_rows($result)>0){
		if($image_size>2000000){
			$error[] = 'Image size is too large';
		}else{
			$insert = "INSERT INTO item(item_name,price,item_image) VALUES('$item_name', '$item_price', '$item_image')";
			$upload = mysqli_query($conn, $insert);
			if($upload){
				move_uploaded_file($image_tmp_name, $item_image_folder);
				$error[] = 'New product added successfully';
				header('location: item.php');
			}
			else{
				$error[] = 'Could not add the product';
			}
		}
	}
	else{
		$error[] = 'user already exist';
	}	
};
	if(isset($_GET['delete'])){
		$id = $_GET['delete'];
		$sql = "DELETE FROM item WHERE id=$id ";
		mysqli_query($conn, $sql);
		echo $id;
		header('location: item.php');
	};

?>

<html>
<head>
<title>Products</title>
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
<div class="main-con">
	<form action="" method="POST" enctype="multipart/form-data">
		<h3> Add a New Product</h3>
		<input type="text" name="item_name" placeholder="enter product name" required>
		<input type="number" name="price" placeholder="enter product price" required>
		<input type="file" name="item_image" accept="image/jpg, image/webp, image/png" required>
		<input type="submit" name="add_product" value="Add Product"></br>

		<?php
			if(isset($error)){
				foreach($error as $error){
					echo '<span class="error">'.$error.'</span>.<br>';
				};
			};
		?>
	</form>
	<?php
		$sql = "SELECT * FROM item";
		$select = mysqli_query($conn, $sql);
	?>
	<div class="item-display">
		<table>
		<div class="table">
		<th>
		<tr class="t1">
		<td>Product Image</td>
		<td>Product Name</td>
		<td>Product Price</td>
		<td>Action</td>
		</tr>
		</th>
		</div>
		<?php
		while($row = mysqli_fetch_assoc($select)){
		?>
		<tr>
		<td><img src="./uploaded_img/<?php echo $row['item_image']; ?>"></td>
		<td><?php echo $row['item_name']; ?></td>
		<td><?php echo $row['price']; ?></td>
		<td>
		<a href="item_update.php?edit=<?php echo $row['id'];?>" class="button">edit</a>
		<a href="item.php?delete=<?php echo $row['id'];?>" class="dltbutton">delete</a>
		</td>
		</tr>
		<?php } ?>
		</table>
	<div>
</div>
</body>
</html>