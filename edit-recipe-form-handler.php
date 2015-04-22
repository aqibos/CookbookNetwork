<?php

    //get recipe name stored on db
    function getRecipeNameFromDB($conn, $recipeId)
    {
        $sql = "SELECT recipe_title
                FROM Recipe
                WHERE recipe_id = '$recipeId'";
        
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        
        return $row["recipe_title"];
    }

    function getPrivacyFromDB($conn, $recipeId)
    {
        $sql = "SELECT visibility
                FROM Recipe
                WHERE recipe_id = '$recipeId'";
        
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        
        return $row["visibility"];
    }
    
    //get name of image stored on db
    function getImageNameFromDB($conn, $recipeId)
    {
        $sql = "SELECT img_path
                FROM Recipe
                WHERE recipe_id = '$recipeId'";
        
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        
        return $row["img_path"];
        //$imgArray = explode('/', $path);
        //return $imgArray[count($imgArray) -1];
    }

    //get number of ingredients on db
    function getNumberOfIngredientsFromDB($conn, $recipeId)
    {
        $sql = "SELECT ingredient_id
                FROM Ingredient
                WHERE recipe_id = '$recipeId'";
        
        $result = mysqli_query($conn, $sql);
        
        return mysqli_num_rows($result);
    }

    //get number of steps on db
    function getNumberOfStepsFromDB($conn, $recipeId)
    {
        $sql = "SELECT directions
                FROM Recipe
                WHERE recipe_id = '$recipeId'"; 
        
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        $allSteps = $row["directions"];
        $stepArray = explode(',', $allSteps);
        return count($stepArray);
    }
    
    //get number of tags on db
    function getNumberOfTagsFromDB($conn, $recipeId)
    {
        $sql = "SELECT name
                FROM Tag
                WHERE type_id = '$recipeId'";
        
        $result = mysqli_query($conn, $sql);
        
        return mysqli_num_rows($result);
    }

    //get all the ingredients 
    function getAllIngredientsFromDB($conn, $recipeId)
    {
        $allIngredients = "";
        $sql = "SELECT name
                FROM Ingredient
                WHERE recipe_id = '$recipeId'";
        
        $result = mysqli_query($conn, $sql);
        while($row = mysqli_fetch_assoc($result)) 
        {
            $currIngredient = $row["name"];
            $allIngredients .= $currIngredient . "@ ";
        }
        
        $allIngredients = substr($allIngredients, 0, strlen($allIngredients) - 2);
        
        return $allIngredients;
    }

    //get all steps
    function getAllStepsFromDB($conn, $recipeId)
    {   
        $sql = "SELECT directions
                FROM Recipe
                WHERE recipe_id = '$recipeId'"; 
        
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        return $row["directions"];
    }

    function getAllTagsFromDB($conn, $recipeId)
    {
        $allTags = "";
        $sql = "SELECT name
                FROM Tag
                WHERE type_id = '$recipeId'"; 
        
        $result = mysqli_query($conn, $sql);
        while($row = mysqli_fetch_assoc($result)) 
        {
            $currTag = $row["name"];
            $allTags .= $currTag . ", ";
        }
        
        $allTags = substr($allTags, 0, strlen($allTags) - 2);
        
        return $allTags;
    }

    function getPriv($conn, $recipeId)
    {
        $sql = "SELECT visibility
                FROM Recipe
                WHERE recipe_id = '$recipeId'"; 
        
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        return $row["visibility"];
    }

    function getAllFriends($conn, $recipeId)
    {
        $userId = $_SESSION['userid'];
        
        $sql = "SELECT email
                FROM Account
                WHERE user_id = '$userId' ";
        
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        $emailAddr = $row["email"];
        
        $allFriends = "";
        $sql = "SELECT email
                FROM Friends
                WHERE type_id = '$recipeId' AND type = 'RECIPE'";
        
        $result = mysqli_query($conn, $sql);
        while($row = mysqli_fetch_assoc($result)) 
        {
            $currFriend = $row["email"];
            
            if ($currFriend != $emailAddr)
            {
                $allFriends .= $currFriend . ", ";
            }
        }
        
        $allFriends = substr($allFriends, 0, strlen($allFriends) - 2);
        
        return $allFriends;
    }

    function getFlagCount($conn, $recipeId)
    {
        $sql = "SELECT flag_id
                FROM Flag
                WHERE recipe_id = '$recipeId'";
        
        $result = mysqli_query($conn, $sql);
        
        return mysqli_num_rows($result);
    }

    function getRecipeRating($conn, $recipeId)
    {
        $sql = "SELECT rating
                FROM Recipe
                WHERE recipe_id = '$recipeId'"; 
        
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        return $row["rating"];
    }

    function getRecipeRatingCount($conn, $recipeId)
    {
        $sql = "SELECT times_rated
                FROM Recipe
                WHERE recipe_id = '$recipeId'"; 
        
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        return $row["times_rated"];
    }

    function getAuthorName($conn, $recipeId)
    {
        $sql = "SELECT username
                FROM Account, Recipe
                WHERE recipe_id = '$recipeId'AND  user_id = author";
        
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        return $row["username"];
    }

    function getEmailAddr($conn, $username)
    {
        $sql = "SELECT email
                FROM Account
                WHERE username = '$username' ";
        
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        return $row["email"];
    }

    function fixFlag($conn, $oldRecipeId, $newRecipeId)
    {
        $sql = "UPDATE Flag
                SET recipe_id = '$newRecipeId'
                WHERE recipe_id = '$oldRecipeId'";
                
        $result = mysqli_query($conn, $sql);
    }



?>