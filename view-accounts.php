<?php
session_start() ;
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
			<h1>View Accounts</h1>
			<?php 
			
				include 'db-credentials.php' ;
				
				$conn = new mysqli($servername, $username, $password, $dbname); 
				if($conn -> connect_error)
					die("Connection failed: ".$conn -> connect_error);
				
				$sql = "SELECT * FROM Account";
				$result = $conn -> query($sql) ;
				
				if($result -> num_rows > 0)
				{
					echo '<h2>'.$result->num_rows.' accounts: <h2><ul>' ;
					
					while($row = $result -> fetch_assoc())
					{
						echo '<li class="user-item"><a href="view-account-info.php?user_id='.$row["user_id"].'">email: '.$row["email"].'<br> username: '.$row["username"].'</a></li> ';
					}	
					echo '</ul>' ;
				}
				else
				{
					echo '0 accounts';
				}
				$conn -> close() ;
			?>
		</div>
		
		<div class="footer"><p>&#169; Cookbook Network, 2015. All Rights Reserved.</p></div>
		
	</body>
</html>