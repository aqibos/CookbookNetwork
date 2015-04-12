<?php
session_start();
$username = $_SESSION["username"];
?>
<!DOCTYPE html>
<html>
	
	<head>
		 <meta charset="UTF-8">
		<meta name="description" content="A virtual cookbook that allows user's to view, create and share recipes.">
		<meta name="keywords" content="recipe, cookbook, food, ingredients">
		<meta name="author" content="Cookbook Network Inc.">
		<link rel="stylesheet" type="text/css" href="page_style.css">
		<link href='http://fonts.googleapis.com/css?family=Tangerine:700' rel='stylesheet' type='text/css'>
		<link href='http://fonts.googleapis.com/css?family=IM+Fell+Double+Pica' rel='stylesheet' type='text/css'>
	</head>
	
	<body>
		
		<div class="background-image"></div>
		
		<div class="navigation-bar">
			<?php include 'check-menu.php'; ?>
		</div>
		
		<div class="content">
			<h1 class="center">Change Password</h1>
			<br/>
			<table class="tableform">
			<form>
				<tr>
  					<td> Enter current password: <br/><br/> </td>
  					<td> <input type="password" name="currentpw"><br/><br/></td>
  				</tr>
  				<tr>
  					<td> Enter new password: <br/><br/></td>
  					<td><input type="password" name="newpw"><br/><br/></td>
  				</tr>
  				<tr>
  					<td> Confirm Password: <br/><br/></td>
  					<td> <input type="password" name="newpwconfirm"><br/><br/></td>
  				</tr>
  				<tr>
  					<td><br/></td>
  					<td><br/><br/><input type="submit" value="Save Changes"></td>
  				</tr>
			</form>
			</table>

		</div>
		
		<div class="footer"><p>&#169; Cookbook Network, 2015. All Rights Reserved.</p></div>
		
	</body>
</html>