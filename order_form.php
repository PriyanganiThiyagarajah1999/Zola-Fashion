<?php 
include 'configuration.php';
session_start();
error_reporting(0);
if(isset($_SESSION['name'])){
    header("Location: home.php");
}

if(isset($_POST['buy_now'])){
	$cname = mysqli_real_escape_string($conn,$_POST['customer_name']);
	$cemail = mysqli_real_escape_string($conn, $_POST['customer_email']);
	$item = mysqli_real_escape_string($conn, $_POST['item']);
	$price =  $_POST['price'];
	$order_date= $_POST['order_date'];
	$quantity=  $_POST['quantity'];

	if($pwd == $cpwd){
		$sql = "SELECT * FROM order WHERE cemail='$cemail'";
		$result = mysqli_query($conn, $sql);
		if(!$result->num_rows > 0){
			$sql = "INSERT INTO order (customer_name, customer_email, order_date, quantity) VALUES ('$cname', '$cemail', '$order_date','$quantity')";
			$result = mysqli_query($conn, $sql);
			if($result){
				$error[] = 'Wow! User Registration Completed.';
				$username = "";
				$email = "";
				$_POST['password'] = "";
				$_POST['cpassword'] = "";
				header('location: login_form.php');
			}else{
				$error[] = 'Woops! Something Wrong Went.';
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
<title>order form</title>
<link rel = "stylesheet" type="text/css" href="style.css"/>
</head>
<body>	
<div class="update">
<?php
	$sql = "SELECT * FROM user WHERE id='$user_id'";
	$result = mysqli_query($conn, $sql); 
	if(mysqli_num_rows($result)>0){
		$fetch = mysqli_fetch_assoc($result);
	}
?>	
	<form action="" method="POST" >
	<div class="flex">
		<div class="index">
			<h3> Buy Now</h3>
			<table>
			<tr><td><span>Customer Name </span></td><td><input type="text" name="customer_name" value="<?php echo $fetch['name']?>"></td></tr>
			<tr><td><span>Customer Email </span></td><td><input type="email" name="customer_email" value="<?php echo $fetch['email']?>" ></td></tr>
			<tr><td><span>Item </span></td><td><input type="item" name="item" value="<?php echo $fetch['item']?>" ></td>
			<tr><td><span>Price </span></td><td><input type="price" name="price" value="<?php echo $fetch['price']?>" ></td>
			<tr><td><span>Order date </span></td><td><input type="date" name="order_date" required ></td>
			<tr><td><span>Quantity </span></td><td><input type="number" name="quantity" required ></td>
			</table>			
		</div>
			<tr><td><input type="submit" value="Buy Now" name="buy_now" class="button"></td></tr>
			<?php
				if(isset($error)){
					foreach($error as $error){
						echo '<span class="error">'.$error.'</span>.<br>';
					};
				};
			?>
	</div>
	</form>
</div>
</body>
</html>
</html>