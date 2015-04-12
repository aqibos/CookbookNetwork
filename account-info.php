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
			<table  class="navigation-bar-table">
				<tr>
					<td class="navigation-bar-table-left"><h1 class="navigation-bar-table-left-header">Cookbook Network</h1></td>
					<td class="navigation-bar-table-right">
						<ul class="upper-level-ul">
							
							<li>Search
								<ul>
									<li><a href="">Search Recipe</a></li>
									<li><a href="">Search Cookbook</a></li>
								</ul>
							</li>
							
							<li>Recipe
								<ul>
									<li><a href="">Create Recipe</a></li>
									<li><a href="">Edit Recipe</a></li>
									<li><a href="">MyRecipes</a></li>
								</ul>
							</li>
							
							<li>Cookbook
								<ul>
									<li><a href="">Create Cookbook</a></li>
									<li><a href="">Edit Cookbook</a></li>
									<li><a href="">MyCookbooks</a></li>
								</ul>
							</li>
							
							<li>JohnDoe
								<ul>
									<li><a href="">Account Info</a></li>
									<li><a href="">Log Out</a></li>
								</ul>
							</li>
							
						</ul>
						
					</td>
				</tr>
			</table>
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
					<td style="text-align:right"><a href=""><div class="button">Change password?</div></a></td>
					<td style="text-align:right"><a href=""><div class="button">Delete User</div></a></td>
				</tr>
			</table>
			
		</div>
		
		<div class="footer"><p>&#169; Cookbook Network, 2015. All Rights Reserved.</p></div>
		
	</body>
</html>