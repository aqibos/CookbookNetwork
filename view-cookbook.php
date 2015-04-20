<?php
session_start() ;
include 'recipe-search-handler.php' ; 
function printCookbook()
{
	$cookbook_id = $_GET["cookbook_id"] ;
	$conn = getConn() ;
	
	$sql = " SELECT cb_title FROM cookbook
				WHERE cookbook_id = '$cookbook_id'" ;
	
	$result = $conn -> query($sql) ;
	$row = $result -> fetch_assoc() ;
	echo '<h1>'.$row["cb_title"].'</h1>' ;	
	
	$sql = " SELECT  * FROM recipe
				WHERE recipe_id in (
					SELECT recipe_id FROM recipe_list
					WHERE cookbook_id = '$cookbook_id')";
	$result = $conn -> query($sql) ;
	printResult($result) ;	
}
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
		<img class="background-image" src="images/delicious-pizza-food-1440x900.jpg" height="700"/>
		<div class="background-image"></div>
		
		<div class="navigation-bar">
			<?php include 'check-menu.php'?>
		</div>
		
		<div class="content">
			<?php printCookbook();?>
		</div>
		
		<div class="footer"><p>&#169; Cookbook Network, 2015. All Rights Reserved.</p></div>
		
	</body>
</html>