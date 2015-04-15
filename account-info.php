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
			<h1>Account Information</h1>
			
			<table class="content-table">
				<tr class="content-table-row">
					<td class="content-table-left"><h3>User Name:</h3></td>
					<td class="content-table-right">JohnDoe</td>
				</tr>
				<tr class="content-table-row">
					<td class="content-table-left"><h3>E-mail:</h3></td>
					<td class="content-table-right">johndoe@gmail.com</td>
				</tr>
				<tr class="content-table-row">
					<td class="content-table-left"><h3>Status:</h3></td>
					<td class="content-table-right">Registered</td>
				</tr>
				<tr class="content-table-row">
					<td class="content-table-left"><h3>Date Joined:</h3></td>
					<td class="content-table-right">03/30/2015</td>
				</tr>
				<tr style="text-align:right">
					<td style="text-align:right"><a href="change-pw.php"><div class="button">Change password?</div></a></td>
					<td style="text-align:right"><a href="delete-user.php"><div class="button">Delete User</div></a></td>
				</tr>
			</table>
			
		</div>
		
		<div class="footer"><p>&#169; Cookbook Network, 2015. All Rights Reserved.</p></div>
		
	</body>
</html>