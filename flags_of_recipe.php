<?php 
	session_start();	
	if((! isset( $_SESSION['loggedin'])) or $_SESSION['isAdmin'] == 0)
	{
		header('Location:fail.php');
	}

	$server = "localhost";
	$user = "root" ;
	$pw = "" ;
	$db = "cookbooknetwork" ;
					
	$conn = new mysqli($server, $user, $pw, $db) ; 
	if($conn -> connect_error){
		echo('Connection failed: '.$conn -> connect_error) ;
	}
					
	$recipe_id = $_GET["recipe_id"];	
	$flag_no = $_GET["flag_no"] ;
	$recipe_title = $_GET["title"] ;
	
	$delim = "$%@" ;
	
	include 'flag-handler.php' ;
	$ids = getAuthorsID($conn, $recipe_id, $delim) ;
	$id_array = explode( $delim , $ids ) ;
	for($i = 0 ; $i < $flag_no ; $i++ ) $email_array[$i] = getEmail($conn, $id_array[$i]) ;
	
	$comments = getComments($conn, $recipe_id, $delim) ;
	$comment_array = explode($delim, $comments) ;
	
	$reasons = getReasons($conn, $recipe_id, $delim) ;
	$reason_array = explode( $delim, $reasons) ;
	
	$conn -> close() ;
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
			<h1>Flags of Recipe: <?php echo $recipe_title ?></h1>
			<table class="recipe-flags">
				<tr>
					<th>Author</th>
					<th>Reason</th>
					<th>Comment</th>
				</tr>
				
				<?php
					for($j = 0 ; $j < $flag_no ; $j++ )
					{
						echo '<tr>
									<td>'.$email_array[$j].'</td>
									<td>'.$reason_array[$j].'</td>
									<td>'.$comment_array[$j].'</td>
								</tr>';
					}
				?>
			</table>
		</div>
		
		<div class="footer"><p>&#169; Cookbook Network, 2015. All Rights Reserved.</p></div>
		
	</body>
</html>
