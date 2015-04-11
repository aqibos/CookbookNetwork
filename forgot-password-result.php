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
                $user_email = "";
                $output ="" ;
                if ($_SERVER["REQUEST_METHOD"] == "POST")
                {
                    $user_email = test_input($_POST["email"]);
                    if (!filter_var($user_email, FILTER_VALIDATE_EMAIL))
                    {
						$output = "Invalid email format";
					}
                    else 
                    {   
						$sent = send_to($user_email) ;
                    
						if($sent)
							$output = "A password was sent to ".$user_email;
						else
							$output = $user_email." was not found in our system";
					}
                }
                
                function test_input($data) 
                {
                    $data = trim($data);
                    $data = stripslashes($data);
                    $data = htmlspecialchars($data);
                    return $data;
                }
                
                function send_to($email)
                {
                    
                    $servername = 'localhost' ;
                    $username = 'root';
                    $pw = '';
                    $dbname = 'cookbooknetwork' ;

                    $conn = new mysqli($servername, $username, $pw, $dbname) or die("Unable to connect");
                    
                    $sql = "SELECT * FROM  Account WHERE email = '$email'" ;
                    
                    $result = $conn -> query($sql) ;
                    
                    if($result -> num_rows > 0) 
                    {
                        $new_pw = generate_pw() ;
                        $sql = "UPDATE Account SET password='$new_pw' WHERE email='$email'" ;
                        if ($conn->query($sql) === TRUE) 
                        {
                            $msg = "This is your new password. \n\nPassword:".$new_pw."\n\nPlease change your password through the 'Account Info' link as soon as possible!" ;
                            $msg = wordwrap($msg,70) ;
                            mail($email,"Cookbook Network: Reset Password",$msg,"From: password@cookbooknetwork.com");
                            
                            $emailERR = "none" ;
                        } 
                        else 
                            echo "Try again: Error updating record: " . $conn->error;
                                                
                        $conn -> close() ;
                        return  true;
                    } 
                    else 
                    { 
                        $conn -> close() ;
                        return  false;
                    }    
                }
                
                function generate_pw()
                {
                    $valid_chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789" ;
                    $pdubs = '' ;
                    for( $i = 0 ; $i < 20 ; $i++)
                    {
                        $pick = mt_rand( 0 , 61 ) ;
                        $pdubs .= $valid_chars[$pick] ;
                    }
                    
                    return $pdubs ;
                }
            ?>    
                
			<div class="content">
				<table class="content-table">
					<tr>
						<td class="content-table-left"><h1 class="content-table-left-header">Cookbook Network</h1></td>
						
                        <td class="content-table-right">
                             <h2><?php echo $output?></h2>
							 <a href="index-1.html"><button>Home</button></a>
							 <a href="forgot-password.php"><button>Back</button></a>
						</td>
					</tr>
					<tr>
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