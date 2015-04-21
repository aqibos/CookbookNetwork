<?php
            
    //connect to db
    function connectToDb($servername, $username, $password, $dbname)
    {
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) 
        {
            echo '<script type="text/javascript">'
                . 'alert("Sorry, could not connect to CookbookNetwork database.");'
                . '</script>';
            die("Connection failed: " . $conn->connect_error);
        }
        
        return $conn;
    }

    //check privacy
    function checkPrivacy($conn)
    {
        //privacy
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
                        
                        //get all emails
                        while($row = mysqli_fetch_assoc($result)) 
                        {
                            $currEmail = $row["email"];
                            if ($currFriend == $currEmail) 
                            {
                                $validFriend = TRUE;
                                break;
                            }
                        }
                    }

                    if (!$validFriend)
                    {
                        $invalidFriend = $currFriend;
                        return FALSE;
                    }
                }
            }
        }

        return TRUE;
    }

    //get temp name given by php
    function getImageTmpName()
    {
        return $_FILES['photo']['tmp_name'];
    }

    //get file name given by owner
    function getImageFullName()
    {
        return $_FILES['photo']['name'];
    }
    
    //check if file was uploaded
    function checkImageUploaded()
    {
        if ($_FILES['photo']['size'] == 0 && strlen($_FILES['photo']['name']) == 0) {
            return FALSE;
        }
        return TRUE;
    }

    //return the path on the server of img
    function getImagePath($recipeId)
    {
        return $recipeId . '/' . $_FILES['photo']['name'];
    }

    //update the img path in db
    function updateImagePathInDB($conn, $path, $recipeId)
    {
        $sql = "UPDATE Recipe 
                SET img_path='$path' 
                WHERE recipe_id='$recipeId';";
        
        if (!($conn->query($sql) === TRUE))
        {
            echo "$conn->error";
            cleanDbTables($recipeId, $conn);
            return FALSE;
        }
        
        return TRUE;
    }

    //get recipe name
    function getRecipeName($conn)
    {
        return $conn->real_escape_string(($_POST['recipe-name']));
    }

    //get recipe photo
    function getPicture()
    {
        $picture = $conn->real_escape_string(($_FILES['photo']['tmp_name']));
    }

    //get all steps of recipe
    function getAllSteps($conn)
    {
        $allSteps = "";
            for ($x = 1; ;$x++)
            {
                if (!array_key_exists("step" . $x, $_POST))
                {
                     break;
                }

                if (!empty($_POST["step" . $x]))
                {
                    $allSteps = $allSteps . $conn->real_escape_string(($_POST["step" . $x])) . "@ ";
                }
            }

            if (strlen($allSteps) > 0)
            {
                //remove extra comma and space
                $allSteps = substr($allSteps, 0, strlen($allSteps) - 2);
            }

            return $allSteps;
    }

    //get privacy
    function getPrivacy()
    {
        return ($_POST['privacy-setting']);
    }

    //insert recipe into db
    function insertRecipeIntoDB($recipeName, $authorName, $allSteps, $privacy, $conn)
    {
            //add recipe into db
            $sql = "INSERT INTO Recipe (recipe_title, author, directions, rating, times_rated, visibility) 
                VALUES ( '$recipeName', '$authorName','$allSteps', 0.0, 0, '$privacy')";

            if ($conn->query($sql) === TRUE)
            {
                //get recipe id
                return mysqli_insert_id($conn);
            }
            else
            {
                //return a value to acknowledge failure
                echo "$conn->error";
                return -1;
            }
    }
    
    //count number of friend inputs
    function countFriends()
    {
        $numFriends = 0;
        for ($x = 0; ;$x++)
        {
            if (!array_key_exists("friendName" . $x, $_POST))
            {
                 break;
            }

            if (!empty($_POST["friendName" . $x]))
            {
                $numFriends++;
            }
        }
        return $numFriends;
    }
    

    //add friends to db
    function addFriendsToDB($conn, $numFriends, $lastId)
    {
        /*
        //FRIENDS
        $sql = "CREATE TABLE Friends(
            email VARCHAR(50) NOT NULL,
            type enum('RECIPE', 'COOKBOOK') NOT NULL,
            type_id INT(7) UNSIGNED NOT NULL,
            friend_id INT(7) UNSIGNED AUTO_INCREMENT,
            PRIMARY KEY(friend_id),
            CONSTRAINT fk_AccFriends FOREIGN KEY (email)
            REFERENCES Account(email)
            ON DELETE CASCADE
		)" ;
        
        */
        
        
        for ($x = 0; $x < $numFriends; $x++)
        {
            $currFriend = $conn->real_escape_string($_POST["friendName" . $x]);
            
            $currFriendId = getAuthorIdFrmEmail($conn, $currFriend);

            $sql = "INSERT INTO Friends (email, type, type_id, friend_id) 
                    VALUES ('$currFriend', 'RECIPE','$lastId', '$currFriendId')";

                if (!($conn->query($sql) === TRUE)) {
                    cleanDbTables($lastId, $conn);
                    
                    return false;
                }
        }
        return true;
    }

    //add ingredients to db
    function addIngredientsToDB($conn, $lastId)
    {
        for ($x = 1; ; $x++) 
        {
            if (!array_key_exists("ingredient" . $x, $_POST))
            {
                 break;
            }

            if (!empty($_POST["ingredient" . $x]))
            {
                $currIngredient = $conn->real_escape_string($_POST["ingredient" . $x]);
                $sql = "INSERT INTO Ingredient (name, recipe_id) 
                    VALUES ( '$currIngredient', '$lastId')";

                if (!($conn->query($sql) === TRUE)) {
                    cleanDbTables($lastId, $conn);
                    return false;
                }   
            }
        } 
        return true;
    }

    //add tags to db
    function addTagsToDB($conn, $lastId)
    {
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
            11 => "breakfast/brunch",
            12 => "italian",
            13 => "vegetarian",
            14 => "poultry",
            15 => "dessert",
            16 => "jamaican",
            17 => "seafood",
            18 => "lunch",
            19 => "latin",
            20 => "salad",
            21 => "desi",
            22 => "soup",
        ];
        
        //for each tag, check if selected
        for ($x = 0; $x < count($tags); $x++)
        {
            if (isset($_POST[$tags[$x]]))
            {   
                $tagName = $tags[$x];
                $sql = "INSERT INTO Tag (name, type, type_id) 
                    VALUES ( '$tagName', 'RECIPE', '$lastId')";

                if (!($conn->query($sql) === TRUE)) {
                    cleanDbTables($lastId, $conn);
                    return false;
                }   

            }
        }
        return true;
    }

    //navigate to view recipe
    function redirectToViewRecipe($lastId)
    {
        header('Location: view-recipe.php?recipe_id=' . $lastId);
    }

    //close connection
    function closeDBConnection($conn)
    {
        $conn->close();
    }

    //in case of error, remove extranneous data from db
    function cleanDbTables($lastId, $conn)
    {
        removeFromDbType("Friends", "type_id", $lastId, $conn);
        removeFromDbType("Tag", "type_id", $lastId, $conn);
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
            echo "Failed it: $sql<br>";
            echo "$conn->error<br>";
            removeFromDb($tableName, $attributeName, $lastId, $conn);
        }
    }

    function removeFromDbType($tableName, $attributeName, $lastId, $conn)
    {
        $sql = "DELETE FROM " . $tableName . 
                " WHERE " . $attributeName . "=" . $lastId . " AND type = 'RECIPE';";

        if (!($conn->query($sql) === TRUE)) 
        {
            //keep trying until success
            echo "Failed it: $sql<br>";
            echo "$conn->error<br>";
            removeFromDb($tableName, $attributeName, $lastId, $conn);
        }
    }

    function getAuthorId($conn, $authorName)
    {
        $sql = "SELECT user_id
                FROM Account
                WHERE username = '$authorName'";
        
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        return $row["user_id"];
    }

    function getAuthorIdFrmEmail($conn, $email)
    {
        $sql = "SELECT user_id
                FROM Account
                WHERE email = '$email'";
        
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        return $row["user_id"];
    }

    function updateRecipe($conn, $recipeName, $authorName, $allSteps, $privacy, $recipeId)
    {
        //add recipe into db
            $sql = "UPDATE Recipe
                    SET recipe_title = '$recipeName', author = '$authorName', directions = '$allSteps', visibility = '$privacy') 
                    WHERE recipe_id = '$recipeId'";

            $conn->query($sql);
    }

    /*function cleanInput($stra)
    {
        $modStr = trim($stra);
        $modStr = stripslashes($stra);
        $modStr = htmlspecialchars($stra);
        
        return $modStr;
    }*/

?>