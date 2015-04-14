<?php
    session_start();
    $recipe_id = 1;
    $pwerror="";

    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $host="localhost";              // Host name 
        $username="root";               // Mysql username 
        $password="";                   // Mysql password 
        $db_name="cookbooknetwork";     // Database name 
        $tbl_name="Recipe";             // Table name 

        // Connect to server and select databse.
        $link = new mysqli($host, $username, $password, $db_name);
        if ($link -> connect_error)
            die("Connection failed: ".$link -> connect_error);

        // current and new password sent from form
        $ratestar = $_POST['rating'];

        $sql="SELECT * FROM $tbl_name WHERE recipe_id= '$recipe_id'";
        $result = $link -> query($sql);
        $count = $result->num_rows;

        if($count == 1)     //input of current password is incorrect
        {
            $newrating; 
            $row = $result->fetch_assoc();
            $currentrating = $row['rating'];    //get current rating
            $totalrate = $row['times_rated'];   //get total amount of rating
            
            if($ratestar == "star1")
                $newrating = 1; 
            else if($ratestar == "star2")
                $newrating = 2; 
            if($ratestar == "star3")
                $newrating = 3; 
            if($ratestar == "star4")
                $newrating = 4; 
            else    //star5
                $newrating = 5; 
            
            $totalrate++;
            $newrating = ($currentrating + $newrating) / $totalrate ;
            
            $sql = "UPDATE $tbl_name SET times_rated ='$totalrate', rating = '$newrating' WHERE `recipe_id`='$recipe_id'";
            if ($link->query($sql) != true)     //unsuccessful query
            {
                $pwerror= "ERROR: Could not able to execute $sql. " . $link->connect_error;
            } 
            redirect();
        }
        else
        {
            
        }
    }

    function redirect()
    {
        header('Location: recipe.php');
    }
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
		
		<div class="background-image"></div>

		<div class="navigation-bar">
			<?php include 'check-menu.php'; ?>
		</div>
		
		<div class="content">
			<h1 class="center">Rate Recipe</h1>
			<div class="center">
				<p>We would love to hear your feedback on "Yum, Yum Pizza"!</p>
				<form name="rate" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
					<input type="radio" name="rating" value="star1">&nbsp;&nbsp;<img src="images/star1.png"><br/><br/>
					<input type="radio" name="rating" value="star2">&nbsp;&nbsp;<img src="images/star2.png"><br/><br/>
					<input type="radio" name="rating" value="star3">&nbsp;&nbsp;<img src="images/star3.png"><br/><br/>
					<input type="radio" name="rating" value="star4">&nbsp;&nbsp;<img src="images/star4.png"><br/><br/>
					<input type="radio" name="rating" value="star5">&nbsp;&nbsp;<img src="images/star5.png"><br/><br/>
					<input type="submit" value="Rate!"> <input type="submit" value="Cancel">
				</form>
			</div>
		</div>
		
		<div class="footer"><p>&#169; Cookbook Network, 2015. All Rights Reserved.</p></div>
		
	</body>
</html>
