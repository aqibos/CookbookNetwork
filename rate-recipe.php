<?php
    session_start();

    //get recipe_id to be rated
    $recipeID = $_GET['recipe_id'];
?>

<!DOCTYPE html>
<html>

	<head>
        <title>Rate recipe</title>
		<meta charset="UTF-8">
		<meta name="description" content="A virtual cookbook that allows user's to view, create and share recipes.">
		<meta name="keywords" content="recipe, cookbook, food, ingredients">
		<meta name="author" content="Cookbook Network Inc.">
		<link rel="stylesheet" type="text/css" href="page_style.css">
		<link href='http://fonts.googleapis.com/css?family=Tangerine:700' rel='stylesheet' type='text/css'>
		<link href='http://fonts.googleapis.com/css?family=IM+Fell+Double+Pica' rel='stylesheet' type='text/css'>
	</head>
	
	<body>
		<?php 
            $error="";
            
            include 'db-credentials.php';
    
            $tbl_name="Recipe";             // Table name 

            // Connect to server and select databse.
            $link = new mysqli($servername, $username, $password, $dbname);
            if ($link -> connect_error)
                die("Connection failed: " . $link -> connect_error);

            $sql="SELECT * FROM $tbl_name WHERE recipe_id= '$recipeID'";
            $result = $link -> query($sql);
            $row = $result->fetch_assoc();

            $title = $row['recipe_title'];      //get recipe name
            $currentrating = $row['rating'];    //get current rating
            $totalrate = $row['times_rated'];   //get total amount of rating
            $userid = $row['author'];           //get creator
                
            //do not allow author to rate their own recipe
            if($_SESSION['userid'] == $userid)
            {
                echo '<script type=text/javascript>alert("Can not rate own recipe.");
                        window.location.replace("fail.php");</script>';
            }
    

            if ($_SERVER["REQUEST_METHOD"] == "POST")
            {
                $ratestar = $_POST['rating'];           //get rating submitted by user
                $newrating = getValue($ratestar);       //convert to a number

                $newrating = (($currentrating * $totalrate) + $newrating) / ($totalrate + 1);      //update new rating
                $totalrate++;   //increment total
                
                //update db
                $sql = "UPDATE $tbl_name SET times_rated ='$totalrate', rating = '$newrating' WHERE `recipe_id`='$recipeID'";

                if ($link->query($sql) == false)     //unsuccessful query
                {
                    $error= "ERROR: Could not able to execute $sql. " . $link->connect_error;
                } 
                else
                {
                    //go back to recipe
                    header('Location: view-recipe.php?recipe_id=' . $recipeID);
                }
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
            mysqli_close($link); 
            
        ?>
		<div class="background-image"></div>

		<div class="navigation-bar">
			<?php include 'check-menu.php'; ?>
		</div>
		
		<div class="content">
			<h1 class="center">Rate Recipe</h1>
			<div class="center">
				<p>We would love to hear your feedback on <?php echo $title; ?>!</p>
                <p><?php echo $error; ?></p>
				<form name="rate" method="POST" onsubmit="return validate()" >
					<input type="radio" name="rating" value="star1">&nbsp;&nbsp;<img src="images/star1.png"><br/><br/>
					<input type="radio" name="rating" value="star2">&nbsp;&nbsp;<img src="images/star2.png"><br/><br/>
					<input type="radio" name="rating" value="star3">&nbsp;&nbsp;<img src="images/star3.png"><br/><br/>
					<input type="radio" name="rating" value="star4">&nbsp;&nbsp;<img src="images/star4.png"><br/><br/>
					<input type="radio" name="rating" value="star5">&nbsp;&nbsp;<img src="images/star5.png"><br/><br/>
				    <input type="submit" value="Cancel" onclick="window.history.back(); return false;">
                    <input type="submit" value="Rate!" />
				</form>
			</div>
		</div>
        
        <script type="text/javascript">
            
            function validate () 
            {
                var checkboxes = document.getElementsByName('rating');
                var i = checkboxes.length - 1;

                for ( ; i >= 0 ; i-- ) 
                {
                    if ( checkboxes[i].checked )   
                        return true;
                }

                alert("Must choose a rating.");
                return false;
            }
            
        </script>
                
		
		<div class="footer"><p>&#169; Cookbook Network, 2015. All Rights Reserved.</p></div>
		
	</body>
</html>
