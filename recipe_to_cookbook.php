<?php
    session_start();
    $recipeID = $_GET['recipe_id'];
    include 'recipe-to-cookbook-form.php';
    
    if(isset($_SESSION['userid']))      //get user's id
        $userID = $_SESSION['userid'];
    else                            
        header('Location: fail.php');       //deny access to guest user to this page

    include 'db-credentials.php';
    $tbl_name="Recipe";             // Table name 

    // Connect to server and select databse.
    $link = new mysqli($servername, $username, $password, $dbname);
    if ($link -> connect_error)
        die("Connection failed: " . $link -> connect_error);

    //Get Recipe title
    $sql="SELECT recipe_title FROM $tbl_name WHERE recipe_id= '$recipeID'";
    $result = $link -> query($sql);
    $row = $result->fetch_assoc();
    $title = $row['recipe_title'];
$error="";
?>

<!DOCTYPE html>
<html>
	
	<head>
        <title>Add Recipe to Cookbook</title>
		 <meta charset="UTF-8">
		<meta name="description" content="A virtual cookbook that allows user's to view, create and share recipes.">
		<meta name="keywords" content="recipe, cookbook, food, ingredients">
		<meta name="author" content="Cookbook Network Inc.">
		<link rel="stylesheet" type="text/css" href="page_style.css">
		<link href='http://fonts.googleapis.com/css?family=Tangerine:700' rel='stylesheet' type='text/css'>
		<link href='http://fonts.googleapis.com/css?family=IM+Fell+Double+Pica' rel='stylesheet' type='text/css'>
	</head>
	
	<body>
		
		<img class="background-image" src="images/delicious-pizza-food-1440x900.jpg" height="700"/>

		
		<div class="navigation-bar">
            <?php include 'check-menu.php'?>
		</div>
		
		<div class="content">
			<h1>Add "<?php echo $title; ?>" Recipe To:</h1>
			<h3>Cookbook:</h3>
            <p class="errormsg"><?php echo $error; ?></p>
			<form method="POST"> 
				<select name="cookbook">
                    <!--PRINT LIST OF COOKBOOKS OF USER -->
                    <?php
                        $count=1;
                        include 'db-credentials.php';
                        $tbl_name="Cookbook_list";             // Table name 

                        // Connect to server and select databse.
                        $link = new mysqli($servername, $username, $password, $dbname);
                        if ($link -> connect_error)
                            die("Connection failed: " . $link -> connect_error);
                        
                        //get list of cookbook id's
                        $sql="SELECT cookbook_id FROM $tbl_name WHERE user_id= '$userID'";
                        $result = $link -> query($sql);

                        //get cookbook title for each id returned
                        while($row = $result->fetch_assoc())       
                        {
                            $cookbookID = $row['cookbook_id'];
                            $error = $cookbookID;
                            $sql="SELECT cb_title FROM Cookbook WHERE cookbook_id= '$cookbookID'";
                            $result2 = $link -> query($sql);
                            $row2 = $result2->fetch_assoc();
                            $cbTitle = $row2['cb_title'];
                            print '<option value="'. $cookbookID .'" selected>'. $cbTitle .'</option>';
                        }
                    
                    ?>
                    <option value="createnew">--Create New Cookbook--</option>
				</select>
				<br><br>
				<input type="submit" name="submit" value="Submit"> 
				<input type="submit" name="cancel" value="Cancel" onclick="window.history.back(); return false;"> 
			</form>
		</div>
		
		<div class="footer"><p>&#169; Cookbook Network, 2015. All Rights Reserved.</p></div>
		
	</body>
</html>