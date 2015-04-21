<?php
    session_start();
    
    include 'edit-recipe-form-handler.php';
    include 'create-recipe-form.php';

    include 'db-credentials.php';

    //check if valid url or logged in
    if (!isset($_GET['recipe_id']) || !isset($_SESSION['loggedin']))
    {
        header('Location: fail.php');
    }

    //get recipe id
    $recipeId = $_GET['recipe_id'];

    //get logged username
    $user = $_SESSION["username"];

    //connect to db
    $conn = connectToDb($servername, $username, $password, $dbname);

    //get recipe name
    $recipeName = getRecipeNameFromDB($conn, $recipeId);

    //get author name
    $authorName = getAuthorName($conn, $recipeId);

    //check if valid id or not original author
    if ($recipeName == '' || $authorName != $user)
    {
        header('Location: fail.php');
    }

    //if submit
    if($_SERVER['REQUEST_METHOD'] == "POST")
    {
        //delete everything
        removeRecipe($conn, $recipeId);
        header('Location: my-recipes.php');
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
		
		<img class="background-image" src="images/food_spaghetti_1920x1080_wallp_2560x1440_miscellaneoushi.com_.jpg" height="700"/>
		
		<div class="navigation-bar">
			<?php include 'check-menu.php'; ?>
		</div>
		
		<div class="content">
			<h1>Delete Recipe: <?php echo $recipeName; ?></h1>
            <h3>Are you sure you want to delete this recipe?</h3>
            <i>This action cannot be undone!</i>
            
            <br /><br /><br />
            
            <form method="post">
                <input type="submit" value="Cancel" onclick="window.history.back(); return false;">
                <input type="submit" value="Submit" onclick="return true;">
            </form>
			
			
			
		</div>
		
		<div class="footer"><p>&#169; Cookbook Network, 2015. All Rights Reserved.</p></div>
		
	</body>
</html>