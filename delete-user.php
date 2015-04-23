<?php
	session_start();

	$emailerror = $success = "";
    include 'db-credentials.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {

        // Connect to server and select databse.
        $link = new mysqli($servername, $username, $password, $dbname);
        if ($link -> connect_error)
			die("Connection failed: ".$link -> connect_error);
        
        // useremail to be deleted sent from form
        $useremail = $_POST['useremail'];
        
        $sql="SELECT * FROM Account WHERE email='$useremail'";
        $result = $link -> query($sql);
        $count = $result->num_rows;
        
        // if account is found
        if($count == 1)
        {
            $row = $result->fetch_assoc();
            $user_id = $row['user_id'];
            
            deleteRecipes($user_id, $link);     //delete all recipe information
                
            deleteCookbooks($user_id, $link);   //delete all cookbook information

            $sql = "DELETE FROM Account WHERE user_id = '$user_id'";
            if ($link->query($sql) != true)     //unsuccessful query
                    echo "ERROR: Could not able to execute $sql. " . $link->connect_error;
            else    //success message
            {
                $success="User with email: ". $useremail . " has been deleted.";
            }
            
        }
        else          //no account found to delete, error message
        {
            $emailerror = "* No account exists with this email"; 
            
        }
        mysqli_close($link);            //close connection
    }

    function deleteRecipes($user_id, $link)
    {
        //SELECT RECIPES BY USER
        $sql= "SELECT recipe_id FROM Recipe WHERE author = '$user_id'";    
        $result = $link -> query($sql);
        $count = $result->num_rows;
        if($count > 0)
        {
            while($row = $result->fetch_assoc())    //get each recipe of user
            {
                $recipe_id = $row['recipe_id'];
                
                deleteTags("RECIPE", $recipe_id, $link);    //delete tags of recipe
            
                deleteFriends("RECIPE", $recipe_id, $link);
            
                deleteFromCookbook($recipe_id, $link);      //delete from cookbook

                deleteFlags($recipe_id, $link);             //delete flags if recipe is flagged

                $sql2 = "DELETE FROM Recipe WHERE recipe_id = '$recipe_id'";    //finally, delete recipe
                if ($link->query($sql2) != true)     //unsuccessful query
                    echo "ERROR: Could not able to execute $sql. " . $link->connect_error;
            }
            
        }
    }

    function deleteCookbooks($user_id, $link)
    {
        $sql = "SELECT cookbook_id FROM Cookbook_list WHERE user_id = '$user_id'";
        $result = $link -> query($sql);
        $count = $result->num_rows;
        $i = 0;
        if($count > 0)      //check if have cookbook
        {
            while($row = $result->fetch_assoc())
            {
                $cb_id[$i]= $row['cookbook_id'];     //store all cookbook ids to array
                
                deleteTags("COOKBOOK", $cb_id[$i], $link);      //delete cookbook tags
            
                
                deleteFriends("COOKBOOK", $cb_id[$i], $link);   //check privacy to delete friends
                
                $i++;
            }
            
            for($j=0; $j < $i; $j++)
            {
                $current = $cb_id[$j];
                $sql4 = "DELETE FROM Cookbook WHERE cookbook_id = '$current'";    //delete cookbook
                if ($link->query($sql4) != true)     //unsuccessful query
                    echo "ERROR: Could not able to execute $sql3. " . $link->connect_error;
            }
        }
    }

    function deleteTags($type, $type_id, $link)
    {
        $sql = "DELETE FROM Tag WHERE type='$type' AND type_id = '$type_id'";
        if ($link->query($sql) != true)     //unsuccessful query
            echo "ERROR: Could not able to execute $sql. " . $link->connect_error;
    }

    function deleteFriends($type, $type_id, $link)
    {
        $sql = "DELETE FROM Friends WHERE type='$type' AND type_id = '$type_id'";
        if ($link->query($sql) != true)     //unsuccessful query
            echo "ERROR: Could not able to execute $sql. " . $link->connect_error;
    }

    function deleteFromCookbook($recipe_id, $link)
    {
        $sql = "DELETE FROM Recipe_list WHERE recipe_id='$recipe_id'";
        if ($link->query($sql) != true)     //unsuccessful query
            echo "ERROR: Could not able to execute $sql. " . $link->connect_error;
    }
    
    function deleteFlags($recipe_id, $link)
    {
        $sql = "DELETE FROM Flag WHERE recipe_id='$recipe_id'";
        if ($link->query($sql) != true)     //unsuccessful query
            echo "ERROR: Could not able to execute $sql. " . $link->connect_error;
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
			<h1 class="center"> Delete User </h1>
            <p class="center errormsg"> <?php echo $success; ?></p>
			<form name="delete" method="post" onsubmit="return validate()" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
			<table class="tableform center">
				<tr>
					<td><br/><h3>Enter email of user to be deleted:</h3></td>
					<td><br/><input type="text" size="35" name="useremail"></td>
                    <td><br/><?php echo '<div class="errormsg">' . $emailerror . '</div>'; ?></td>
				</tr>
			</table>
			<br/><br/>
			<p class="center"><input class="submitbutton" type="submit" value="Cancel" onclick="window.location.replace('account-info.php'); return false;">&nbsp;&nbsp;&nbsp;&nbsp;
					<input class="submitbutton" type="submit" value="Delete" onclick='return confirm("Are you sure you want to delete?")'></p>
            </form>
		</div>
		
		<div class="footer"><p>&#169; Cookbook Network, 2015. All Rights Reserved.</p></div>
		
	</body>
    
    <script type="text/javascript">
        function validate()
        {
            var email = document.forms["delete"]["useremail"].value;
            
            if(email==null || email == "")
            {
                alert("Field cannot be left blank.");
                return false;
            }
            
            //Check for correct email
            arrobaIndex = email.indexOf("@");
            periodIndex = email.lastIndexOf(".");
            //email can't have "@" be first char or "@." be consecutive chars
            if (arrobaIndex == 0 || (periodIndex - arrobaIndex <= 1 )|| periodIndex+1 == email.length) 
            {
                alert("Invalid email. Please enter a correct email.");
                return false;
            }
        }
        
    </script>
        

</html>