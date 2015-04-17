<?php
    session_start();
    $user = $_SESSION["username"];

    include 'create-recipe-form.php';

    //credentials
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "cookbooknetwork";

    //connect to db
    $conn = connectToDb($servername, $username, $password, $dbname);

    //get user id
    $userId = getAuthorId($conn, $user);
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
		
		<img class="background-image" src="images/food_spaghetti_1920x1080_wallp_2560x1440_miscellaneoushi.com_.jpg" height="700"/>
		
		<div class="navigation-bar">
			<?php include 'check-menu.php'; ?>
		</div>
		
		<div class="content">
			<h1>Welcome, <?php echo $_SESSION['username']; ?></h1>
			
			<div class="content-div">
				<a href="account-info.php?user_id=<?php echo $userId; ?>"><div class="content-div-row1">Account Info</div></a>
				<a href="my-recipes.php?user_id=<?php echo $userId; ?>"><div class="content-div-row1">MyRecipes</div></a>
				<a href="my-cookbooks.php?user_id=<?php echo $userId; ?>"><div class="content-div-row1">MyCookbooks</div></a>
			</div>

		</div>
		
		<div class="footer"><p>&#169; Cookbook Network, 2015. All Rights Reserved.</p></div>
		
	</body>
</html>
