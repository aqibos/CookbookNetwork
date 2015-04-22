<?php
    session_start();
?>
<!DOCTYPE html>
<html>
	
	<head>
		 <meta charset="UTF-8">
		<meta name="description" content="A virtual cookbook that allows user's to view, create and share recipes.">
		<meta name="keywords" content="recipe, cookbook, food, ingredients">
		<meta name="author" content="Cookbook Network Inc.">
        <link rel="stylesheet" type="text/css" href="index_style-1.css">
		<link href='http://fonts.googleapis.com/css?family=Tangerine:700' rel='stylesheet' type='text/css'>
		<link href='http://fonts.googleapis.com/css?family=IM+Fell+Double+Pica' rel='stylesheet' type='text/css'>
		
		<script type="text/javascript">
			var image1 = new Image()
			image1.src = "images/Pizza-Food-Delicious-1440x2560.jpg"
			var image2 = new Image()
			image2.src = "images/delicious-pizza-food-1440x900.jpg"
			var image3 = new Image()
			image3.src = "images/food_spaghetti_1920x1080_wallp_2560x1440_miscellaneoushi.com_.jpg"
			var image4 = new Image()
			image4.src = "images/Hot-and-Delicious-Food-Photos.jpg"
			var image5 = new Image()
			image5.src = "images/Food-Delicious-Pizza-Olives-Olives-1440x2560.jpg"
			var image6 = new Image()
			image6.src = "images/loaf-delicious-cake-with-strawberries-wallpapers-1440x900.jpg"
		</script>
		
	</head>
	 
    <?php
        $emailERR = $passwordERR = "";
        if ($_SERVER["REQUEST_METHOD"] == "POST")
        {
            include 'db-credentials.php';
            $tbl_name="Account"; // Table name 

            // Connect to server and select databse.
            $link = new mysqli($servername, $username, $password, $dbname);
            if ($link -> connect_error)
                die("Connection failed: ".$link -> connect_error);

            // username and password sent from form 
            $email=$_POST['email']; 
            $password=$_POST['password']; 


            $sql="SELECT * FROM $tbl_name WHERE email='$email' and password='$password'";
            $result = $link -> query($sql);
            $count = $result->num_rows;

            // result must be of one row, login successful
            if($count == 1)
            {
                session_start();
                $row = $result->fetch_assoc();
                $_SESSION['loggedin'] = true;
                $_SESSION['username'] = $row['username'];   //set session variables
                $_SESSION['userid'] = $row['user_id']; 
                $_SESSION['isAdmin'] = $row['isAdmin']; 
                 

                redirect();         //go to logged in page

            }
            else if($count == 0)        //no username or password combo exists
            {
                $emailERR = "* Invalid email/password";
            }

            mysql_free_result($result);
        }

        function redirect()
        {
            header('Location: home-page-registered.php');
        }
    ?>
    
	<body>
		
		<p><img src="Pizza-Food-Delicious-1440x2560.jpg" name="slide" class="slideshow"/></p>
		
		<div class="full-body">
			
			<div class="content-transparent">    
                
			<div class="content">
				<table class="content-table">
					<tr>
						<a href="index.php">
                        <td class="content-table-left"><h1 class="content-table-left-header"><a href="index.php">Cookbook Network</a></h1></td>
						
                        <td class="login_form">
                            <form name="login" method="post" onsubmit="return validateInput()" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                                Email: <input type="text" name="email">
                                <span class="error"><?php echo $emailERR ;?></span><br>
                                Password: <input type="password" name="password">
                                <span class="error"><?php echo $passwordERR ;?></span><br>
                                <a class="forgot" href="forgot-password.php">forgot password?</a>
                                <input type="submit" class="submit_button">
                                <!-- <div class="button"><input type="submit" value="Submit"></div>-->
                            </form>
						</td>
					</tr>
					<tr >
						<td class="content-table-left">&#169; Cookbook Network, 2015. All Rights Reserved.</td>
						<td class="content-table-right"><i>Find, create, and share <u>millions</u> of recipes!</i></td>
					</tr>
				</table>
			</div>
			</div>
			
		</div>
		
        
        
        <script>
            function validateInput() 
            {
                var email = document.forms["login"]["email"].value;
                var pass = document.forms["login"]["password"].value;				
                
                //Check for blank input
                if (email == null || email == "" || pass == null || pass == "")
                {
                    alert("A field was left blank. Please provide email and password.");
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
                return true;	//pass all requirements, form has correct input
            }
        </script>
        
        
        

		<!-- Slide Show -->
		<script type="text/javascript">
			var step=1;
			function slideit()
			{
				document.images.slide.src = eval("image"+step+".src");
				if(step<6)
					step++;
				else
					step=1;
				setTimeout("slideit()", 3000);
			}
			slideit();
		</script>
		
	</body>
</html>