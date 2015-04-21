<?php 
    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $pwerror="";
        include 'db-credentials.php';
        $tbl_name="Recipe";             // Table name 

        // get star
        $ratestar = $_POST['rating'];
        
        echo "RECIPE ID: $recipeID" ;
        
        // Connect to server and select databse.
        $link = new mysqli($servername, $username, $password, $dbname);
        if ($link -> connect_error)
        {    die("Connection failed: ".$link -> connect_error);}

        $sql="SELECT rating, times_rated FROM $tbl_name WHERE recipe_id= '$recipeID'";
        $result = $link -> query($sql);
        $row = $result->fetch_assoc();
        
        $currentrating = $row['rating'];    //get current rating
        $totalrate = $row['times_rated'];   //get total amount of rating


        //get star number
        $newrating = getValue($ratestar);

        $newrating = (($currentrating * $totalrate) + $newrating) / ($totalrate + 1);
        $totalrate++;

        $sql = "UPDATE $tbl_name SET times_rated ='$totalrate', rating = '$newrating' WHERE `recipe_id`='$recipeID'";
        
        if ($link->query($sql) == false)     //unsuccessful query
        {
            $pwerror= "ERROR: Could not able to execute $sql. " . $link->connect_error;
            header('Location: sign-up.php');
        } 
        else
        {
            //go back to recipe
            redirectToViewRecipe($recipeID);
        }
    }
        //mysqli_close($link);    

     //navigate to view recipe
    function redirectToViewRecipe($lastId)
    {
        header('Location: view-recipe.php?recipe_id=' . $lastId);
    }
    //Convert star value to number
    function getValue($ratestar)
    {
        if($ratestar == "star1")
            $newrating = 1; 
        else if($ratestar == "star2")
            $newrating = 2; 
        else if($ratestar == "star3")
            $newrating = 3; 
        else if($ratestar == "star4")
            $newrating = 4; 
        else    //star5
            $newrating = 5; 
        return $newrating;
    }
?>