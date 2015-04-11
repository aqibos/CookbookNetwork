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
    
    //get name of image stored on db
    function getImageNameFromDB($conn, $recipeId)
    {
        $sql = "SELECT img_path
                FROM Recipe
                WHERE recipe_id = '$recipeId'";
        
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        
        $path = $row["img_path"];
        $imgArray = explode('/', $path);
        return $imgArray[count($imgArray) -1];
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
            $allIngredients .= $currIngredient . ", ";
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

?>