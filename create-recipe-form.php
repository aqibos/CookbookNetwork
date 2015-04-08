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

    //get recipe name
    function getRecipeName()
    {
        return ($_POST['recipe-name']);
    }

    //get recipe photo
    function getPicture()
    {
        $picture = ($_FILES['photo']['name']);
    }

    //get all steps of recipe
    function getAllSteps()
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
                    $allSteps = $allSteps . ($_POST["step" . $x]) . ", ";
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
    function insertRecipeIntoDB($recipeName, $allSteps, $privacy, $conn)
    {
            //add recipe into db
            $sql = "INSERT INTO Recipe (recipe_title, directions, rating, times_rated, visibility) 
                VALUES ( '$recipeName', '$allSteps', 0.0, 0, '$privacy')";

            if ($conn->query($sql) === TRUE)
            {
                //get recipe id
                return mysqli_insert_id($conn);
            }
            else
            {
                //return a value to acknowledge failure
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
        for ($x = 0; $x < $numFriends; $x++)
        {
            $currFriend = $_POST["friendName" . $x];
            
            echo '<script type="text/javascript">'
                    . 'alert(' . $currFriend . ');'
                    . '</script>';

            $sql = "INSERT INTO Friends (recipe_id, email) 
                    VALUES ( '$lastId', '$currFriend')";

                if (!($conn->query($sql) === TRUE)) {
                    cleanDbTables($lastId, $conn);
                    
                    echo '<script type="text/javascript">'
                    . 'alert(' . $conn->error . ');'
                    . '</script>';
                    
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
                $currIngredient = $_POST["ingredient" . $x];
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