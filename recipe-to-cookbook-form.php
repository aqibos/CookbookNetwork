<?php 
    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        include 'db-credentials.php'; 
        $tbl_name="Recipe_list"; // Table name 

        // Connect to server and select databse.
        $link = new mysqli($servername, $username, $password, $dbname);
        if ($link -> connect_error)
            die("Connection failed: ".$link -> connect_error);

        // get chosen cookbook
        $cookbookID = $_POST['cookbook'];

        //user selected to create a new cookbook
        if($cookbookID == "createnew")
        {
            header('Location: create-cookbook.php');
        }
        else
        {
            //Check if recipe is already stored in that cookbook
            $sql = "SELECT * FROM $tbl_name WHERE cookbook_id = '$cookbookID' AND recipe_id = '$recipeID'";
            $result = $link -> query($sql);
            $count = $result->num_rows;

            //recipe does not exist in that cookbook, add to db
            if($count == 0)
            {
                //store recipe to cookbook in db
                $sql="INSERT INTO $tbl_name (cookbook_id, recipe_id) VALUES ('$cookbookID', '$recipeID')";

                if ($link->query($sql) != true)     //unsuccessful query
                {
                    $error= "ERROR: Could not able to execute $sql. " . $link->connect_error;
                    header('Location: fail.php');
                } 
                else    //successful, go back to recipe
                {
                    header('Location: view-recipe.php?recipe_id=' . $recipeID );
                }
            }
            else    //recipe exists already, do nothing to db and go back to recipe
            {
                echo '<script type=text/javascript>alert("Recipe already stored in this cookbook.");
                        window.location.replace("view-recipe.php?recipe_id=' . $recipeID . '");</script>';
            }
        }
        mysqli_close($link); 
    } 
?>