<?php
session_start() ;

/*
flag_id INT(7) UNSIGNED AUTO_INCREMENT,
recipe_id INT(7) UNSIGNED NOT NULL,
reason varchar(50) NOT NULL,
comment TEXT,
user_id INT(6) UNSIGNED NOT NULL,
*/

include 'edit-recipe-form-handler.php';
include 'create-recipe-form.php';

//check if logged in 
if (!isset($_GET["recipe_id"]) || !$_SESSION['loggedin'])
{
    header('Location: fail.php');
}

//use db credentials
include 'db-credentials.php';

//get user id
$userId = $_SESSION['userid'];

//connect to db
$conn = connectToDb($servername, $username, $password, $dbname);

//get recipe id
$recipeId = $_GET['recipe_id'];

//get recipe name
$recipeName = getRecipeNameFromDB($conn, $recipeId);

//if invalid recipe id
if ($recipeName == '')
{
    header('Location: fail.php');
}

//check if submit form
if($_SERVER['REQUEST_METHOD'] == "POST")
{
    //get reason - dropdown
    $reason = $_POST['reason'];
    
    //get comments
    $comment = $_POST['comment'];

    //insert into db
    $sql = "INSERT INTO Flag (recipe_id, reason, comment, user_id) 
            VALUES ( '$recipeId', '$reason', '$comment', '$userId')";
    
    if (!($conn->query($sql) === TRUE)) 
    {
        //echo "$conn->error";
        header('Location: fail.php');
    }

    //redirect to view recipe
    header('Location: view-recipe.php?recipe_id=' . $recipeId);
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
			<h1>Flag Form</h1>
			<h2>Recipe: <?php echo $recipeName; ?></h2>
			<form method="post"> 
				<select name="reason">
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