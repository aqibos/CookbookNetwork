<?php
	session_start();
    $user = $_SESSION["username"];

    include 'edit-recipe-form-handler.php';
    include 'create-recipe-form.php';

    //credentials
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "cookbooknetwork";

    //connect to db
    $conn = connectToDb($servername, $username, $password, $dbname);

    //get recipe id
    $recipeId = $_GET['recipe_id'];

    //get recipe name
    $recipeName = getRecipeNameFromDB($conn, $recipeId);

    //if ($recipeName == '')
    //{
      //  header('Location: fail.php');
    //}

    //get pic name
    $photoNamePrev = getImageNameFromDB($conn, $recipeId);

    //get number of ingredients 
    $numberIngredients = getNumberOfIngredientsFromDB($conn, $recipeId);

    //get each ingredient - format: ingredient1, ingredient2, ingredient3...
    $ingredientList = getAllIngredientsFromDB($conn, $recipeId);

    //get number of steps
    $numberSteps = getNumberOfStepsFromDB($conn, $recipeId);

    $stepList = getAllStepsFromDB($conn, $recipeId);
    //get tags
    $numberTags = getNumberOfTagsFromDB($conn, $recipeId);

    $tagList = getAllTagsFromDB($conn, $recipeId);
     
    //get flag count
    $flagCount = getFlagCount($conn, $recipeId);

    //get rating
    $rating = getRecipeRating($conn, $recipeId);
    $ratingCount = getRecipeRating($conn, $recipeId);

    //get author
    $author = getAuthorName($conn, $recipeId);

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
		
		<img class="background-image" src="<?php 
                if ($photoNamePrev == '' || $photoNamePrev == NULL)
                {
                    echo "images/delicious-pizza-food-1440x900.jpg";
                }
                else
                {
                    
                    echo $photoNamePrev;
                }?>
                                           
                                           
               " height="700"/>
		
		<div class="navigation-bar">				
			<?php include 'check-menu.php'; ?>
		</div>
		
		<div class="content" style="text-align:left">
			<h1><?php echo "$recipeName"; ?> 
                <img <?php 
                    if ($photoNamePrev == '' || $photoNamePrev == NULL)
                    {

                    }
                    else
                    {
                        echo "class='border' src=$photoNamePrev ";                
                    }
                 ?>
                 align="right" height="400" width="400" />
                                                           
            </h1>
			<p><i>Created by: <b><?php echo "$author" ?></b></i></p>
			<p class="flagfont">
                <?php 
                    if ($rating == 0)
                    {
                        echo "<p>Not rated.</p>";
                    }
                    else
                    {   
                        $rating = ceil($rating);
                        print "<img src='images/star$rating.png' width='10%' height='10%' title='rating'><br/>";
                    }
                ?>
				<?php echo "$flagCount"; ?>&nbsp;
                <img class="noflag" src="images/flag.png" width="12px" height="12px" title="flags">
            </p>
			<h2>Ingredients</h2>
            <ul>
                <?php

                $ingredientArray = explode('@', $ingredientList);


                for ($x = 0; $x < count($ingredientArray); $x++)
                {
                    echo "<li>$ingredientArray[$x]</li>";
                }

                ?>
            </ul>
			
			<h2>Directions</h2>
			<ol>
                
                <?php
    
                $stepArray = explode('@', $stepList);


                for ($x = 0; $x < count($stepArray); $x++)
                {
                    echo "<li>$stepArray[$x]</li>";
                }

                ?>
                
			</ol>
			<p>Tags: 
                <?php
    
                $tagArray = explode(',', $tagList);
                if ($tagArray == '')
                {
                    //do nothing
                }
                else
                {
                    for ($x = 0; $x < count($tagArray); $x++)
                    {
                        echo "<a class='tags'>$tagArray[$x]</a>";
                    }
                }

                ?>
                
            </p>

			<p class="center">
                <a href="edit-recipe.php?recipe_id=<?php echo $recipeId; ?>">Edit Recipe</a>&nbsp;&nbsp;|
                &nbsp;&nbsp;<a href="rate-recipe.php?recipe_id=<?php echo $recipeId; ?>">Rate Recipe</a>&nbsp;&nbsp;|
				&nbsp;&nbsp;<a href="recipe_to_cookbook.php?recipe_id=<?php echo $recipeId; ?>">Add to Cookbook</a>&nbsp;&nbsp;|
				&nbsp;&nbsp;<a href="flag.php?recipe_id=<?php echo $recipeId; ?>">Flag Recipe</a>&nbsp;&nbsp;|
                
            </p>

		</div>
		
		<div class="footer"><p>&#169; Cookbook Network, 2015. All Rights Reserved.</p></div>
		
	</body>
</html>
