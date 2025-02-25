<?php 
include 'configuration.php';
session_start();
error_reporting(0);
$user_id = $_SESSION['user_id'];
if(!isset($user_id)){
	header('location:login_form.php');
};
if(isset($_GET['delete'])){
	$id = $_GET['delete'];
	$sql = "DELETE FROM user WHERE id=$id ";
	mysqli_query($conn, $sql);
	echo $id;
	header('location: admin.php');
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
<div class="menu">
	
	<?php
		$sql = "SELECT * FROM user";
		$select = mysqli_query($conn, $sql);
	?>
	<div class="user">
		<table>
		<th>
			<tr class="t1">
				<td>Profile Picture</td>
				<td>User Name</td>
				<td>User Email</td>
				<td>User Type</td>
			<td colspan="2">Action</td>
			</tr>
		</th>
		<?php
		while($row = mysqli_fetch_assoc($select)){
		?>
		<tr>
			<td><img src="./uploaded_img/<?php echo $row['image']; ?>" class="img"></td>
			<td><?php echo $row['name']; ?></td>
			<td><?php echo $row['email']; ?></td>
			<td><?php echo $row['user_type']; ?></td>
			<td>
			<a href="admin.php?edit=<?php echo $row['id'];?>" class="button">edit</a>
			<a href="admin.php?delete=<?php echo $row['id'];?>" class="dltbutton">delete</a>
			</td>
		</tr>
		<?php } ?>
		</table>
	</div>	
</div>
</body>
</html>