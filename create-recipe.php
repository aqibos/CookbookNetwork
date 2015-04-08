<!DOCTYPE html>
<html>
    
    <?php
        
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
            
            //if friend does not have account
            if (!checkPrivacy($conn))
            {
                exit("Sorry, your friend(s) is not a registered user.");
            }
            
            $recipeName = getRecipeName();
            $allSteps = getAllSteps();
            $privacy = getPrivacy();
            $recipeId = insertRecipeIntoDB($recipeName, $allSteps, $privacy, $conn);

            //if error in inserting recipe into db
            if ($recipeId < 0)
            {
               exit("Sorry, could not access database when adding recipe. Please try again.");
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
		
		<title>Create New Recipe</title>
		
	</head>
	
	<body>
		
		<div class="background-image"></div>
		
		<div class="navigation-bar">
			<table  class="navigation-bar-table">
				<tr>
					<td class="navigation-bar-table-left"><h1 class="navigation-bar-table-left-header">Cookbook Network</h1></td>
					<td class="navigation-bar-table-right">
						<ul class="upper-level-ul">
							<li>Account
								<ul>
									<li><a href="">Account Info</a></li>
									<li><a href="">Log Out</a></li>
								</ul>
							</li>
							
							<li>Recipe
								<ul>
									<li><a href="">Create Recipe</a></li>
									<li><a href="">Edit Recipe</a></li>
									<li><a href="">MyRecipes</a></li>
								</ul>
							</li>
							
							<li>Cookbook
								<ul>
									<li><a href="">Create Cookbook</a></li>
									<li><a href="">Edit Cookbook</a></li>
									<li><a href="">MyCookbooks</a></li>
								</ul>
							</li>
							
							<li>Search
								<ul>
									<li><a href="">Search Recipe</a></li>
									<li><a href="">Search Cookbook</a></li>
								</ul>
							</li>
							
						</ul>
						
					</td>
				</tr>
			</table>
		</div>
		
		<div class="content">
			<h1>Create New Recipe</h1>
			
			<form method="post"  enctype="multipart/form-data" onsubmit="return validateForm()">
			
			<table class="content-table">
				<!-- RECIPE NAME -->
				<tr class="content-table-row">
					<td class="content-table-left"><h3>Recipe Name:</h3></td>
					<td class="content-table-right"><input type="text" class="textbox" name="recipe-name" id="recipe-name"  placeholder="Enter Recipe Name Here..."></td>
				</tr>
				<!-- PHOTO -->
				<tr class="content-table-row">
					<td class="content-table-left"><h3>Picture:</h3></td>
					<td class="content-table-right">
                        <p>Please select a picutre (only PNG and JPEG files is accepted):</p>
                        <input type="file" name="photo" size="400" accept="image/png image/jpeg" /> </td>
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
				<div class="submit-button wrapper-button"><a href=""><div class="button">Cancel</div></a></div>
			</form>
			
			
			
		</div>
		
		<div class="footer"><p>&#169; Cookbook Network, 2015. All Rights Reserved.</p></div>
		
        <script type="text/javascript">
            
            //set add friend button invisible
            document.getElementById("addFriend").style.visibility='hidden';
            
			var ingredientIdNum = 5;             //no. of ingredients on page + 1
            var stepIdNum = 5;                   //no. of steps on page + 1
            var friends = 0;                     //no. of friends
            var isFriendly = false;
            
            //adds ingredient input to page
            function addIngredientField() {
                var allIngredients = document.getElementsByClassName("ingredient");
                var lastIngredient = allIngredients[allIngredients.length - 1];
                var clone = lastIngredient.cloneNode(true);
                clone.id= "ingredient" + ingredientIdNum;
                lastIngredient.parentNode.appendChild(clone);
                fixIngredientInputName();
            }
            
            //fixes the last added ingredient's name
            function fixIngredientInputName()
            {
                var allIngredientInputs = document.getElementsByClassName("ingredientInput");
                var lastIngredientInput = allIngredientInputs[allIngredientInputs.length - 1];
                lastIngredientInput.name = "ingredient" + ingredientIdNum++;
            }
            
            //adds step input on page
            function addStepField() {
                var allSteps = document.getElementsByClassName("step");
                var lastStep = allSteps[allSteps.length - 1];
                var clone = lastStep.cloneNode(true);
                clone.id= "step" + stepIdNum;
                lastStep.parentNode.appendChild(clone);
                fixStepInputName();
            }
            
            //fixes the last added step's name
            function fixStepInputName()
            {
                var allStepInputs = document.getElementsByClassName("stepInput");
                var lastStepInput = allStepInputs[allStepInputs.length - 1];
                lastStepInput.name = "step" + stepIdNum++;
            }
            
            //check if the privacy is set to friendly and add input fields
            function checkFriendly()
            {
                var privacyDropdown = document.getElementById("privacy");
                var selectedString = privacyDropdown.options[privacyDropdown.selectedIndex].value;
                
                if (selectedString == "friendly")
                {
                    isFriendly = true;
                    var privacyInput = document.getElementById("privacy-input");
                    privacyInput.insertAdjacentHTML( 'beforeBegin', '<p id="friendText">Enter the email address of your friends:</p>' );
                    addFriendInput();
                    document.getElementById("addFriend").style.visibility='visible';
                }
                else
                {
                    removeInputs();
                    friends = 0;
                    document.getElementById("addFriend").style.visibility='hidden';
                    var friendText = document.getElementById("friendText");
                    if (friendText != null)
                    {
                        var parent = friendText.parentNode;
                        parent.removeChild(friendText);
                    }
                    isFriendly = false;
                    
                }
            }
            
            //add more friend input on page
            function addFriendInput()
            {
                var newTextBox = document.createElement("input");
                newTextBox.setAttribute("type", "text");
                newTextBox.setAttribute("name", "friendName" + friends);
                newTextBox.setAttribute("placeholder", "Enter Friend Email Here");
                newTextBox.setAttribute("id", "friendName" + friends++);
                newTextBox.style.width = '100%';
                newTextBox.style.display = 'block';
                var containerDiv = document.getElementById("privacy-input");
                containerDiv.appendChild(newTextBox);
            }
            
            //remove all friend input on page
            function removeInputs()
            {
                var i;
                for (i = 0; i < friends; i++)
                {
                    var currFriendInput = document.getElementById("friendName" + i);
                    var parent = currFriendInput.parentNode;
                    parent.removeChild(currFriendInput);
                }
            }
            
            //validate form before submission
            function validateForm()
            {
                if (checkNameInput()
                    && checkIngredientInputs()
                    && checkStepInputs()
                    && checkFriendInputs()
                    && confirmSubmission())
                {
                    return true;
                }
                else
                {
                    return false;
                }
            }
            
            //recipe name can not be empty
            function checkNameInput()
            {
                var recipeName = document.getElementById("recipe-name").value;
                if (recipeName.trim() === "")
                {
                    alert("Recipe name can not be empty!");
                    return false;
                }
                return true;
            }
                
            
            //must have at least one ingredient 
            function checkIngredientInputs()
            {
                var i;
                var emptyIngredients = true;
                for (i = 1; i < ingredientIdNum; i++)
                {
                    var currIngredient = document.getElementById("ingredient" + i).value;
                    if (currIngredient.trim() != "")
                    {
                        emptyIngredients = false;
                    }
                }
                
                if (emptyIngredients)
                {
                    alert("Recipe must contain at least one ingredient.");
                    return false;
                }
                
                return true;
            }
            
            //must have at least one step
            function checkStepInputs()
            {
                var emptySteps = true;
                for (i = 1; i < stepIdNum; i++)
                {
                    var currStep = document.getElementById("step" + i).value;
                    if (currStep.trim() != "")
                    {
                        emptySteps = false;
                    }
                }
                
                if (emptySteps)
                {
                    alert("Recipe must contain at least one step.");
                    return false;
                }
                return true;
            }
            
            //must have at least one friend email address if 'friendly'
            function checkFriendInputs()
            {
                var emptyFriends = true;
                if (isFriendly)
                {
                    var i;
                    for (i = 0; i < friends; i++)
                    {
                        var currFriend = document.getElementById("friendName" + i).value;
                        //check if empty
                        if (currFriend.trim() != "")
                        {
                            emptyFriends = false;
                        
                            //check if valid format
                            var re = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
                            if (!re.test(currFriend))
                            {
                                alert("'" + currFriend + "' is not a valid email address.");
                                return false;
                            }
                        }
                    }
                    
                    if (emptyFriends)
                    {
                        alert("You must specify at least one friend for 'FRIENDLY' privacy." +
                              "\nYou can use 'PRIVATE' privacy, if you want the recipe hidden." +
                              "\nYou can change this later using 'Edit Recipe'.");
                        return false;
                    }
                }
                return true;
            }
            
            function confirmSubmission()
            {
                var recipeName = document.getElementById("recipe-name").value;
                if (confirm("Are you sure you want to create recipe '" + recipeName + "'?"))
                {
                    return true;
                }
                else
                {
                    return false;
                }
            }
            
		</script>
        
        
	</body>
</html>