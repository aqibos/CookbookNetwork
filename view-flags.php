<?php 
session_start();	
if((! isset( $_SESSION['loggedin'])) or $_SESSION['isAdmin'] == 0)
{
	header('Location:fail.php');
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
		
		<div class="navigation-bar">
			<?php include 'check-menu.php'?>
		</div>
		
		<div class="content">
			<h1>Flagged Recipes</h1>
			<table class="flag-table">
				<tr>
					<th>Recipe Title</th>
					<th>Flags</th>
					<th>Rating</th>
				</tr>
			<?php 
				$server = "localhost";
				$user = "root" ;
				$pw = "" ;
				$db = "cookbooknetwork" ;
				
				$conn = new mysqli($server, $user, $pw, $db) ; 
				if($conn -> connect_error){
					echo('Connection failed: '.$conn -> connect_error) ;
				}
				
				$sql = "	SELECT recipe_id, recipe_title, rating FROM recipe WHERE recipe_id IN (SELECT DISTINCT(recipe_id) FROM flag)" ;	
				$result = $conn -> query($sql) ;
	
				if($result -> num_rows > 0)
				{	
					
					while($row = $result -> fetch_assoc())
					{
						$flagCount = getFlagCount($row["recipe_id"]) ;
						$title = $row["recipe_title"] ;
						echo '<tr>
									<td><a href="flags_of_recipe.php?recipe_id='.$row["recipe_id"].'&flag_no='.$flagCount.'&title='.$title.'">'.$title.'</a></td>
									<td>'.printFlags($flagCount).'</td>
									<td><img src="images/star'.$row["rating"].'.png" /></td>
								</tr>' ;
					}
				}
				else
				{
					echo '<h2>No Flags Found</h2>';
				}
				
				$conn -> close() ;

				
				function getFlagCount($id)
				{
					$server = "localhost";
					$user = "root" ;
					$pw = "" ;
					$db = "cookbooknetwork" ;
					
					$conn = new mysqli($server, $user, $pw, $db) ; 
					if($conn -> connect_error){
						echo('Connection failed: '.$conn -> connect_error) ;
					}
					
					$sql = "	SELECT COUNT(*) AS flags FROM flag WHERE recipe_id = '$id'" ;
					$result = $conn -> query($sql) ;
					
					if($result -> num_rows > 0)
					{	
						$row = $result -> fetch_assoc();
						return $row["flags"];
					}
					else
					{
						return 0 ;
					}
					$conn -> close();
				}
				
				function printFlags($f)
				{  	
					$ret = "" ;
					while($f > 0)
					{
						$ret .= "<img src=\"images/flag.png\"/>" ;
						$f = $f - 1;
					}
					
					return $ret ;
				}
			?>
			</table>
		</div>
		
		<div class="footer"><p>&#169; Cookbook Network, 2015. All Rights Reserved.</p></div>
		
	</body>
</html>
