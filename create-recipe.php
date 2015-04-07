<!DOCTYPE html>
<html>
	
        <?php
            
            //tags
            $tags = [
                0 => "american",
                1 => "gluten-free",
                2 => "beef",
                3 => "appetizer",
                4 => "asian",
                5 => "paleo",
                6 => "chicken",
                7 => "beverages",
                8 => "greek",
                9 => "vegan",
                10 => "pork",
                11 => "breakfast & brunch",
                12 => "italian",
                13 => "vegetarian",
                14 => "poultry",
                15 => "desserts",
                16 => "jamaican",
                17 => "seafood",
                18 => "lunch",
                19 => "latin",
                20 => "salad",
                21 => "desi",
                22 => "soup",
            ];

            //if form submitted
            if($_SERVER['REQUEST_METHOD'] == "POST")
            {
                //credentials
                $servername = "localhost";
                $username = "root";
                $password = "";
                $dbname = "cookbooknetwork";

                //connect to db
                $conn = new mysqli($servername, $username, $password, $dbname);

                // Check connection
                if ($conn->connect_error) 
                {
                    echo '<script type="text/javascript">'
                        . 'alert("Sorry, could not connect to CookbookNetwork database.");'
                        . '</script>';
                    die("Connection failed: " . $conn->connect_error);
                }

                //privacy
                $numFriends = 0;
                $privacy = ($_POST['privacy-setting']);
                $allValidFriends = TRUE;
                $invalidFriend = "";
                
                //check all friends
                if ($privacy == "friendly")
                {
                    $validFriend = FALSE;
                    for ($x = 0; ;$x++)
                    {
                        if (!array_key_exists("friendName" . $x, $_POST))
                        {
                             break;
                        }

                        if (!empty($_POST["friendName" . $x]))
                        {
                            $currFriend = $_POST["friendName" . $x];

                            //check if currFriend is a registered user
                            $sql = "SELECT email FROM Account";
                            $result = mysqli_query($conn, $sql);

                            if (mysqli_num_rows($result) > 0) {
                                //get all email
                                while($row = mysqli_fetch_assoc($result)) 
                                {
                                    $currEmail = $row["email"];
                                    if ($currFriend == $currEmail) 
                                    {
                                        //echo "<br><p> Valid friend ... $currEmail ... </p><br>";
                                        $validFriend = TRUE;
                                        break;
                                    }
                                }
                            }

                            if (!$validFriend)
                            {
                                $invalidFriend = $currFriend;
                                $allValidFriends = FALSE;
                            }
                        }
                    }
                }

                if ($allValidFriends)
                {

                    //recipe name
                    $recipeName = ($_POST['recipe-name']);

                    //picture
                    $picture = ($_FILES['photo']['name']);

                    //steps
                    $allSteps = "";
                    for ($x = 1; ;$x++)
                    {
                        if (!array_key_exists("step" . $x, $_POST))
                        {
                             break;
                        }

                        if (!empty($_POST["step" . $x]))
                        {
                            $allSteps = $allSteps . ($_POST["step" . $x]) . ", ";
                        }
                    }

                    if (strlen($allSteps) > 0)
                    {
                        //remove extra comma and space
                        $allSteps = substr($allSteps, 0, strlen($allSteps) - 2);
                    }

                    //add recipe into db
                    $sql = "INSERT INTO Recipe (recipe_title, directions, rating, times_rated, visibility) 
                        VALUES ( '$recipeName', '$allSteps', 0.0, 0, '$privacy')";

                    if ($conn->query($sql) === TRUE) {
                        //echo "New record created successfully";
                    } else {
                        echo '<script type="text/javascript">'
                        . 'alert("Sorry, could not create recipe.");'
                        . '</script>';
                        exit();
                    }

                    //get recipe id
                    $lastId = mysqli_insert_id($conn);

                    //add friends to db
                    for ($x = 0; $x < $numFriends; $x++)
                    {
                        $currFriend = $_POST["friendName" . $x];

                        $sql = "INSERT INTO Friends (recipe_id, email) 
                                VALUES ( '$lastId', '$currFriend')";

                            if (!($conn->query($sql) === TRUE)) {
                                cleanDbTables($lastId, $conn);
                            }
                    }

                    //add ingredients to db
                    for ($x = 1; ; $x++) 
                    {
                        if (!array_key_exists("ingredient" . $x, $_POST))
                        {
                             break;
                        }

                        if (!empty($_POST["ingredient" . $x]))
                        {
                            $currIngredient = $_POST["ingredient" . $x];
                            $sql = "INSERT INTO Ingredient (name, recipe_id) 
                                VALUES ( '$currIngredient', '$lastId')";

                            if (!($conn->query($sql) === TRUE)) {
                                cleanDbTables($lastId, $conn);
                            }   
                        }

                    } 

                    

                    //add tags to db
                    for ($x = 0; $x < count($tags); $x++)
                    {
                        if (isset($_POST[$tags[$x]]))
                        {   
                            $tagName = $tags[$x];
                            $sql = "INSERT INTO Tag (name, type, type_id) 
                                VALUES ( '$tagName', 'RECIPE', '$lastId')";

                            if (!($conn->query($sql) === TRUE)) {
                                cleanDbTables($lastId, $conn);
                            }   

                        }
                    }
                    
                    //close connection
                    $conn->close();
                
                    //navigate to view recipe
                    header('Location: view-recipe.php?recipe_id=' . $lastId);
                }
                else
                {
                    //close connection
                    $conn->close();
                    
                    echo '<script type="text/javascript">'
                        . 'alert("Sorry, ' . $currFriend . ' does not have a CookbookNetwork account.");'
                        . '</script>';
                }

            }
            
            //in case of error, remove extranneous data from db
            function cleanDbTables($lastId, $conn)
            {
                removeFromDb("Friends", "recipe_id", $lastId, $conn);
                removeFromDb("Tag", "type_id", $lastId, $conn);
                removeFromDb("Recipe", "recipe_id", $lastId, $conn);
                removeFromDb("Ingredient", "recipe_id", $lastId, $conn);
            }

            //utility function to clean db
            function removeFromDb($tableName, $attributeName, $lastId, $conn)
            {
               
                $sql = "DELETE FROM " . $tableName . 
                        " WHERE " . $attributeName . "=" . $lastId . ";";

                if (!($conn->query($sql) === TRUE)) 
                {
                    //keep trying until success
                    removeFromDb($tableName, $attributeName, $lastId, $conn);
                }
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