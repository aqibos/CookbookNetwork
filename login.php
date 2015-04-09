<?php
session_start() ;
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
	
	<body>
		<p><img src="images/Pizza-Food-Delicious-1440x2560.jpg" name="slide" class="slideshow"/></p>
		
		<div class="full-body">
			
			<div class="content-transparent">
            
            <?php
                // define variables and set to empty values
                $emailERR = $passwordERR = "" ;
                $email = $user_password = "";
                
                if ($_SERVER["REQUEST_METHOD"] == "POST"){
                    if(empty($_POST["email"])){
                        $emailERR = "Email is required" ;
                    }
                    else{    
                        $user_email = test_input($_POST["email"]);
                        if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
                          $emailErr = "Invalid email format"; 
                        }
                    }
                    if(empty($_POST["password"])){
                        $passwordERR = "Password is required" ; 
                    }
                    else{
                        $user_password = test_input($_POST["password"]);
                    }
                    
                    $valid = validate_user($user_email, $user_password) ;
					
                    if($valid == true) {
                        header('Location: home-page-registered.php') ;
                    } else {
                        $emailERR = "Invalid email/password" ;
                    }
                }
                
                function test_input($data) 
                {
                    $data = trim($data);
                    $data = stripslashes($data);
                    $data = htmlspecialchars($data);
                    return $data;
                }
                
                function validate_user($email , $password)
                {
                    $servername="localhost" ;
					$username = "root" ;
					$pw = "" ;	
					$dbname = "cookbooknetwork" ;

					$conn = new mysqli($servername, $username, $pw, $dbname);

					if ($conn -> connect_error)
						die("Connection failed: ".$conn -> connect_error);
                    $sql = "SELECT * FROM  Account WHERE email = '$email' AND password = '$password'" ;
                    
                    $result = $conn -> query($sql) ;
                    
                    if($result->num_rows > 0) {
                        $row = $result -> fetch_assoc() ;
                        $_SESSION["loggedin"] = true ;
                        $_SESSION["username"] = $row["username"] ;
                        $_SESSION["isAdmin"] = $row["isAdmin"] ;
            
                        $conn -> close() ;
                        return true ;
                    } else {
                        $_SESSION["loggedin"] = false ;
					
                        $conn -> close() ;
                        return false ;
                    }    
                }
            ?>    
                
			<div class="content">
				<table class="content-table">
					<tr>
						<a href="index.php">
                        <td class="content-table-left"><h1 class="content-table-left-header"><a href="index.php">Cookbook Network</a></h1></td>
						
                        <td class="login_form">
                            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                                Email: <input type="text" name="email">
                                <span class="error"><?php echo $emailERR ;?></span><br>
                                Password: <input type="password" name="password">
                                <span class="error"><?php echo $passwordERR ;?></span><br>
                                <a class="forgot" href="forgot_password.php">forgot password?</a>
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