<?php
@include 'configuration.php';
session_start();
error_reporting(0);

$user_id = $_SESSION['user_id'];
if($_SERVER['REQUEST_METHOD']=="POST"){
	if(isset($_POST['update_profile'])){
		$update_name = mysqli_real_escape_string($conn,$_POST['update_name']);
		$update_email = mysqli_real_escape_string($conn, $_POST['update_email']);
		
		mysqli_query($conn, "UPDATE user SET name='$update_name', email='$update_email' WHERE id='$user_id'");
		
		$old_pwd = md5($_POST['old_pwd']);
		$update_pwd = md5($_POST['update_pwd']);
		$new_pwd = md5($_POST['new_pwd']);
		$confirm_pwd = md5($_POST['confirm_pwd']);
		
		$sql = "UPDATE user SET password='$confirm_pwd' WHERE id='$user_id'";
		
		if(mysqli_query($conn, $sql)){
			$error[] = 'password updated successfully!!!';
			header('location: update_profile.php');
		}
		else{
			$error[] = 'password not matched!!!';
			header('location: login_form.php');
		}
		
		$update_image = $_FILES['update_image']['name'];
		$update_image_size = $_FILES['update_image']['size'];
		$update_image_tmp_name = $_FILES['update_image']['tmp_name'];
		$update_image_folder = 'uploaded_img/'.$update_image;
		
		$result = mysqli_query($conn, "UPDATE user SET image='$update_image' WHERE id='$user_id'");
		if($update_image_size>2000000){
				$error[] = 'Image size is too large';
		}else{		
			if($result){
				move_uploaded_file($update_image_tmp_name, $update_image_folder);
				$error[] = 'Image updated successfully';
			}
			else{
				$error[] = 'Image update failled';
			}
		}
	}
}
?>
<html>
<head>
<title>update profile</title>
<link rel="stylesheet" type="text/css" href="style.css"/>
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
<form action="" method="POST" enctype="multipart/form-data">
<div class="flex">
	<div class="index">
	<table>
<?php	
	if($fetch['image']==''){
			echo '<img src="1.png">';
	}
	else{
		echo '<img src="uploaded_img/'.$fetch['image'].'">';
	}
?>
		<tr><td><span>User Name </span></td><td><input type="text" name="update_name" value="<?php echo $fetch['name']?>"></td></tr>
		<tr><td><span>Your Email </span></td><td><input type="email" name="update_email" value="<?php echo $fetch['email']?>" ></td></tr>
		<tr><td><span>prevoius password </span></td><td><input type="password" name="update_pwd" placeholder="enter prevoius password" ></td>
		<tr><td><span>new password </span></td><td><input type="password" name="new_pwd" placeholder="enter new password"></td>
		<tr><td><span>confirm password  </span></td><td><input type="password" name="confirm_pwd" placeholder="confirm your new password"></td></tr>		
		<tr><td colspan="2"><input type="file" name="update_image" accept="image/jpg, image/webp, image/png"></td></tr>
	</table>
	</div>
<input type="submit" value="Update Profile" name="update_profile" class="button">
<a href="profile.php" class="dltbutton">Go Back</a>	</br></br>
<?php
	if(isset($error)){
		foreach($error as $error){
			echo '<span class="error">'.$error.'</span>.<br>';
		};
	};
?>
</form>
</div>
</div>
</body>
</html>