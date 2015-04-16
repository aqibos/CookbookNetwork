<?php
    session_start();

    //get recipe_id to be rated
    $recipeID = $_GET['recipe_id'];
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
		<?php 
            $pwerror="";
            $host="localhost";              // Host name 
            $username="root";               // Mysql username 
            $password="";                   // Mysql password 
            $db_name="cookbooknetwork";     // Database name 
            $tbl_name="Recipe";             // Table name 

            // Connect to server and select databse.
            $link = new mysqli($host, $username, $password, $db_name);
            if ($link -> connect_error)
                die("Connection failed: " . $link -> connect_error);

            $sql="SELECT recipe_title FROM $tbl_name WHERE recipe_id= '$recipeID'";
            $result = $link -> query($sql);
            $row = $result->fetch_assoc();
            $title = $row['recipe_title'];
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
                <p><?php echo $pwerror; ?></p>
				<form name="rate" method="POST" onsubmit="return validate()" action="rate-recipe-form.php">
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
