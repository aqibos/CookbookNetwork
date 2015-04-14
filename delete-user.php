<?php
	session_start();

	$emailerror = $success = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
    	$host="localhost";              // Host name 
        $username="root";               // Mysql username 
        $password="";                   // Mysql password 
        $db_name="cookbooknetwork";     // Database name 
        $tbl_name="Account"; // Table name 

        // Connect to server and select databse.
        $link = new mysqli($host, $username, $password, $db_name);
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
            //DELETE ACCOUNT
            $sql= "DELETE FROM $tbl_name WHERE email = '$useremail'";

            if ($link->query($sql) != true)     //unsuccessful query
            {
                $emailerror= "ERROR: Could not able to execute $sql. " . $link->connect_error;
            } 
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
					<input class="submitbutton" type="submit" value="Delete"></p>
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
            return true;
        }
        
    </script>
        

</html>