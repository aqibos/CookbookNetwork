<?php
session_start() ;
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
							<?php include 'registered_nav.php'?>
							
						</ul>
						
					</td>
				</tr>
			</table>
		</div>
		
		<div class="content">
			<h1>Add 'Yum, Yum Pizza!' to:</h1>
			<h3>Cookbook:</h3>
			<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"> 
				<select name="cookbook">
					<option value="cb1" selected>First Cookbook</option>
			  		<option value="cb2">Second Cookbook</option>
			  		<option value="cb3">Third Cookbook</option>
			  		<option value="cb4">Fourth Cookbook</option>
			  		<option value="cb5">Fifth Cookbook</option>
				</select>
				<br><br>
				<input type="submit" name="submit" value="Submit"> 
				<input type="submit" name="cancel" value="Cancel"> 
			</form>
		</div>
		
		<div class="footer"><p>&#169; Cookbook Network, 2015. All Rights Reserved.</p></div>
		
	</body>
</html>