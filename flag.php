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
					<td class="navigation-bar-table-left"><h1 class="navigation-bar-table-left-header"><a href="index.php">Cookbook Network</a></h1></td>
					<td class="navigation-bar-table-right">
						<ul class="upper-level-ul">
							<!--  
								<li> <?php echo $_SESSION["username"]; ?>
							-->
							<?php include 'registered_nav.php'?>
							
						</ul>
						
					</td>
				</tr>
			</table>
		</div>
		
		<div class="content">
			<h1>Flag Form</h1>
			<h2>Recipe: Yum, Yum Pizza!</h2>
			<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"> 
				<select name="reason">
					<option value="select" selected>-Reason-</option>
			  		<option value="language">Inappropriate Language</option>
			  		<option value="tag">Incorrect Tag</option>
			  		<option value="ingredients">Incorrect Ingredients</option>
			  		<option value="directions">Incorrect Directions</option>
				</select>
				<br><br>
				<h3>Comment: </h3><textarea name="comment" rows="5" cols="40"></textarea>
				<br><br>
				<input type="submit" name="submit" value="Submit"> 
                <input type="submit" name="cancel" value="Cancel"> 
			</form>
		</div>
		
		<div class="footer"><p>&#169; Cookbook Network, 2015. All Rights Reserved.</p></div>
		
	</body>
</html>