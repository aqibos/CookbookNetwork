<!DOCTYPE html>
<html>
    
    <?php
        session_start();
        
        include 'create-recipe-form.php';

        //credentials
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "cookbooknetwork";

        //if form submitted
        if($_SERVER['REQUEST_METHOD'] == "POST")
        {
            //connect to db
            $conn = connectToDb($servername, $username, $password, $dbname);
            
            $userId = getAuthorId($conn, $_SESSION["username"]);
            
            //if friend does not have account
            if (!checkPrivacy($conn))
            {
                exit("Sorry, your friend(s) is not a registered user.");
            }
            
            $recipeName = getRecipeName();
            $allSteps = getAllSteps();
            $privacy = getPrivacy();
            $recipeId = insertRecipeIntoDB($recipeName, $userId, $allSteps, $privacy, $conn);
            
            //if error in inserting recipe into db
            if ($recipeId < 0)
            {
               exit("Sorry, could not access database when adding recipe. Please try again.");
            }
            
            $photoPath = NULL;
            
            //check if image uploaded
            if (checkImageUploaded())
            {
                $photo = getImageTmpName();
                $photoPath = getImagePath($recipeId);

                if (!mkdir("images/" . $recipeId, 0777, true)) 
                {
                    exit('Could not upload image to server.');
                }
                
                if(!move_uploaded_file($photo, "images/" . $photoPath))
                {
                    exit('Could not create space on server for image.');
                }
                
                if (!updateImagePathInDB($conn, "images/" . $photoPath, $recipeId))
                {
                    exit('Could not connect image to account.');
                }
            }
           
            
            $numFriends = countFriends();
            $success = addFriendsToDB($conn, $numFriends, $recipeId);
            
            //if error in inserting friends into db
            if (!$success)
            {
                exit("Sorry, could not access database when adding friends. Please try again.");
            }
            
            $success = addIngredientsToDB($conn, $recipeId);
            
            //if error in inserting ingredients into db
            if (!$success)
            {
                exit("Sorry, could not access database when adding ingredients. Please try again.");
            }
            
            $success = addTagsToDB($conn, $recipeId);
            
            //if error in inserting tags into db
            if (!$success)
            {
                exit("Sorry, could not access database when adding tags. Please try again.");
            }
            
            closeDBConnection($conn);
            redirectToViewRecipe($recipeId);
        }

    ?>
    
    
	<head>
        <meta charset="UTF-8">
		<meta name="description" content="A virtual cookbook that allows user's to view, create and share recipes.">
		<meta name="keywords" content="recipe, cookbook, food, ingredients">
		<meta name="author" content="Cookbook Network Inc.">
		<link rel="stylesheet" type="text/css" href="page_style.css">
		<link href='http://fonts.googleapis.com/css?family=Tangerine:700' rel='stylesheet' type='text/css'>
		<link href='http://fonts.googleapis.com/css?family=IM+Fell+Double+Pica' rel='stylesheet' type='text/css'>
		<link href='http://fonts.googleapis.com/css?family=Indie+Flower' rel='stylesheet' type='text/css'>
        
        <script src="createRecipeFormHandler.js" type="text/javascript"></script>
		
		<title>Create New Recipe</title>
		
	</head>
	
	<body>
		
		<img class="background-image" src="images/delicious-pizza-food-1440x900.jpg" height="700"/>
		
		<div class="navigation-bar">				
			<?php include 'check-menu.php'; ?>
		</div>
		
		<div class="content">
			<h1>Create New Recipe</h1>
			
			<form method="post"  enctype="multipart/form-data" onsubmit="return validateForm()">
			
			<table class="content-table">
				<!-- RECIPE NAME -->
				<tr class="content-table-row">
					<td class="content-table-left"><h3>Recipe Name:</h3></td>
					<td class="content-table-right"><input type="text" class="textbox nameInput" name="recipe-name" id="recipe-name"  placeholder="Enter Recipe Name Here..."></td>
				</tr>
				<!-- PHOTO -->
				<tr class="content-table-row">
					<td class="content-table-left"><h3>Picture:</h3></td>
					<td class="content-table-right">
                        <p>Please select a picutre (only PNG and JPEG files is accepted):</p>
                        <input type="file" name="photo" size="400" accept="image/png, image/jpeg" /> </td>
				</tr>
				<!-- INGREDIENTS -->
				<tr class="content-table-row">
					<td class="content-table-left"><h3>Ingredients:</h3></td>
					<td class="content-table-right">
						<table class="content-table-ingredients-table">
							<tr class="ingredient" id="1">
								<td class="content-table-ingredients-table-left">Ingredient:</td>
								<td class="content-table-ingredients-table-right">
                                    <input type="text" class="textbox ingredientInput" name="ingredient1" id="ingredient1"  placeholder="Enter Ingredient Here"></td>
							</tr>
							<tr class="ingredient" id="2">
								<td class="content-table-ingredients-table-left">Ingredient:</td>
								<td class="content-table-ingredients-table-right">
                                    <input type="text" class="textbox ingredientInput" name="ingredient2" id="ingredient2"  placeholder="Enter Ingredient Here"></td>
							</tr>
							<tr class="ingredient" id="3">
								<td class="content-table-ingredients-table-left">Ingredient:</td>
								<td class="content-table-ingredients-table-right">
                                    <input type="text" class="textbox ingredientInput" name="ingredient3" id="ingredient3"  placeholder="Enter Ingredient Here"></td>
							</tr>
							<tr class="ingredient" id="4">
								<td class="content-table-ingredients-table-left">Ingredient:</td>
								<td class="content-table-ingredients-table-right">
                                    <input type="text" class="textbox ingredientInput" name="ingredient4" id="ingredient4"  placeholder="Enter Ingredient Here"></td>
							</tr>
						</table>
						<div class="wrapper-button">
                            <a href="javascript:void(0);" class="addLink" onclick="addIngredientField();"><div class="button">+ Add More Ingredients</div></a></div>
					</td>
				</tr>
				<!-- DIRECTIONS -->
				<tr class="content-table-row">
					<td class="content-table-left"><h3>Directions:</h3></td>
					<td class="content-table-right">
						<table class="content-table-ingredients-table">
							<tr class="step" id="1">
								<td class="content-table-ingredients-table-left">Step:</td>
								<td class="content-table-ingredients-table-right">
                                    <input type="text" class="textbox stepInput" id="step1" name="step1" placeholder="Enter Direction Here"></td>
							</tr>
							<tr class="step" id="2">
								<td class="content-table-ingredients-table-left">Step:</td>
								<td class="content-table-ingredients-table-right">
                                    <input type="text" class="textbox stepInput" id="step2" name="step2" placeholder="Enter Direction Here"></td>
							</tr>
							<tr class="step" id="3">
								<td class="content-table-ingredients-table-left">Step:</td>
								<td class="content-table-ingredients-table-right">
                                    <input type="text" class="textbox stepInput" id="step3" name="step3" placeholder="Enter Direction Here"></td>
							</tr>
							<tr class="step" id="4">
								<td class="content-table-ingredients-table-left">Step:</td>
								<td class="content-table-ingredients-table-right">
                                    <input type="text" class="textbox stepInput" id="step4" name="step4" placeholder="Enter Direction Here"></td>
							</tr>
						</table>
						<div class="wrapper-button">
                            <a href="javascript:void(0);" class="addLink" onclick="addStepField();"><div class="button">+ Add More Steps</div></a></div>
					</td>
				</tr>
				<!-- TAGS -->
				<tr class="content-table-row">
					<td class="content-table-left"><h3>Tags:</h3></td>
					<td class="content-table-right">
						<table class="content-table-tags-table">
							<tr>
									<td><b>Ethnicity</b><br /></td>
									<td><b>Diet</b><br /></td>
									<td><b>Meat/Main</b><br /></td>
									<td><b>Other</b><br /></td>
							</tr>
							<tr>
									<td><input type="checkbox" class="tag-value" name="american" value="American">American<br /></td>
									<td><input type="checkbox" class="tag-value" name="gluten-free" value="Gluten-free">Gluten-free<br /></td>
									<td><input type="checkbox" class="tag-value" name="beef" value="Beef">Beef<br /></td>
									<td><input type="checkbox" class="tag-value" name="appetizer" value="Appetizer">Appetizer<br /></td>
							</tr>
							<tr>
									<td><input type="checkbox" class="tag-value" name="asian" value="Asian">Asian<br /></td>
									<td><input type="checkbox" class="tag-value" name="paleo" value="Paleo">Paleo<br /></td>
									<td><input type="checkbox" class="tag-value" name="chicken" value="Chicken">Chicken<br /></td>
									<td><input type="checkbox" class="tag-value" name="beverages" value="Bevarages">Beverages<br /></td>
							</tr>
							<tr>
									<td><input type="checkbox" class="tag-value" name="greek" value="Greek">Greek<br /></td>
									<td><input type="checkbox" class="tag-value" name="vegan" value="Vegan">Vegan<br /></td>
									<td><input type="checkbox" class="tag-value" name="pork" value="Pork">Pork<br /></td>
									<td><input type="checkbox" class="tag-value" name="breakfast & brunch" value="Breakfast & Brunch">Breakfast & Brunch<br /></td>
							</tr>
							<tr>
									<td><input type="checkbox" class="tag-value" name="italian" value="Italian">Italian<br /></td>
									<td><input type="checkbox" class="tag-value" name="vegetarian" value="Vegitarian">Vegetarian<br /></td>
									<td><input type="checkbox" class="tag-value" name="poultry" value="Poultry">Poultry<br /></td>
									<td><input type="checkbox" class="tag-value" name="dessert" value="Dessert">Dessert<br /></td>
							</tr>
							<tr>
									<td><input type="checkbox" class="tag-value" name="jamaican" value="Jamaican">Jamaican<br /></td>
									<td><br /></td>
									<td><input type="checkbox" class="tag-value" name="seafood" value="Seafood">Seafood<br /></td>
									<td><input type="checkbox" class="tag-value" name="lunch" value="Lunch">Lunch<br /></td>
							</tr>
							<tr>
									<td><input type="checkbox" class="tag-value" name="latin" value="Latin">Latin<br /></td>
									<td><br /></td>
									<td><br /></td>
									<td><input type="checkbox" class="tag-value" name="salad" value="Salad">Salad<br /></td>
							</tr>
							<tr>
									<td><input type="checkbox" class="tag-value" name="desi" value="Desi">Desi<br /></td>
									<td><br /></td>
									<td><br /></td>
									<td><input type="checkbox" class="tag-value" name="soup" value="Soup">Soup<br /></td>
							</tr>
						</table>
					</td>
				</tr>
				<tr class="content-table-row">
					<td class="content-table-left"><h3>Privacy:</h3></td>
					<td class="content-table-right">
						<select name="privacy-setting" id="privacy" onchange="checkFriendly();">
  							<option name="public" value="public">Public</option>
  							<option name="registered" value="registered">Registered</option>
 			 				<option name="friendly" value="friendly">Friendly</option>
 	 						<option name="private" value="private">Private</option>
						</select>
                        
                        <div id="privacy-input"></div>
                        
                        <div class="wrapper-button" id="addFriend">
                            <a href="javascript:void(0);" class="addLink" onclick="addFriendInput();"><div class="button">+ Add More Friends</div></a></div>
                        
					</td>
                    
                    
                    
				</tr>
			</table>
			
			<!-- 
			Here are all of the tags:
			
			Ethnicity			Diet				Meat/Main Dish			Other	
			American			Gluten-free			Beef					Appetizer	
			Asian				Paleo				Chicken					Beverages	
			Greek				Vegan				Pork					Breakfast & Brunch	
			Italian				Vegeterian			Poultry					Desserts	
			Jamaican								Seafood					Lunch	
			Latin															Salad	
			Desi															Soup					
			#9b59b6				#2ecc71				#e74c3c					#1abc9c	
			-->
			
			
			<br />
			
				<div class="submit-button"><input type="submit" value="Submit"></div>
				<div class="submit-button wrapper-button"><a href="javascript:void(0);" onclick="window.history.back();" class="addLink"><div class="button">Cancel</div></a></div>
			</form>
			
			<script type="text/javascript">
                //set add friend button invisible
                document.getElementById("addFriend").style.visibility='hidden';
            </script>
			
		</div>
		
		<div class="footer"><p>&#169; Cookbook Network, 2015. All Rights Reserved.</p></div>
        
        
	</body>
</html>