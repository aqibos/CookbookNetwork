<?php
session_start() ;
include 'cookbook-search-handler.php' ;
function printMyCookbooks()
{
	$userid = $_SESSION["userid"];
	
	$conn = getConn() ;
	$sql = " SELECT * FROM cookbook 
				WHERE cookbook_id in (
					SELECT cookbook_id FROM cookbook_list
					WHERE user_id = '$userid')";
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
		<title>My Cookbooks</title>
	</head>
	
	<body>
		<img class="background-image" src="images/delicious-pizza-food-1440x900.jpg" height="700"/>
		<div class="navigation-bar">
			<?php include 'check-menu.php'?>
		</div>
		
		<div class="content">
		<?php
			printMyCookbooks() ;
		?>
		</div>
		
		<div class="footer"><p>&#169; Cookbook Network, 2015. All Rights Reserved.</p></div>
	</body>
</html>