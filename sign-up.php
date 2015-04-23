<?php
	session_start();

    if(isset($_SESSION['userid']))      //deny access to registered users to sign up
        header('Location: fail.php');
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
        <?php include 'sign-up-form.php' ?>
		<img class="background-image" src="images/loaf-delicious-cake-with-strawberries-wallpapers-1440x900.jpg" height="700"/>
		<div class="navigation-bar">
			<?php include 'check-menu.php'; ?>
		</div>
		<div class="content">
			<h1 class="center">Create your Cookbook Network Account!</h1>
			<p class="center"><i>Share your recipes with others! It's fast and easy!</i></p>
			<br/>
			<form name="signup" method="post" onsubmit="return validateForm()">
			<table class="tableform">
				<tr>
					<td><h3>Choose your username:</h3><br/></td>
					<td><input type="text" name="username" size="35" required><br/><br/></td>
					<td class="errormsg"><?php echo $nameerror; ?><br/></td>
				</tr>
				<tr>
					<td><h3>Create a password: </h3><br/></td>
					<td><input type="password" name="password" size="35" required><br/><br/></td>
				</tr>
				<tr>
					<td><h3>Confirm your password: </h3><br/></td>
					<td><input type="password" name="pwconfirm" size="35" required><br/><br/></td>
				</tr>
				<tr>
					<td><h3>Enter your email address: </h3><br/></td>
					<td><input type="text" name="email" size="35" required><br/><br/></td>
					<td class="errormsg"><?php echo $emailerror; ?><br/></td>
				</tr>
			</table>
					<p class="center"><br/><br/> 
                        <input type="submit" value="Cancel" onclick="window.location.replace('index-1.php'); return false;">
                        <input class="submitbutton" type="submit" value="Create My Account">&nbsp;&nbsp;&nbsp;&nbsp;
                    </p>
				</form>

				<script>
				function validateForm() 
				{
                    var user = document.forms["signup"]["username"].value;
                    var pass = document.forms["signup"]["password"].value;
                    var pwc = document.forms["signup"]["pwconfirm"].value;
                    var email = document.forms["signup"]["email"].value;	

                    var illegalPassChars = /[\W_]/;     //only letters and numbers
                    var illegalUserChars = /^[0-9a-zA-Z_.-]+$/; //only letters, numbers, '_' , '-', '.'

                    //Check each field for blank input
                    if (isEmpty(user) || isEmpty(pass) || isEmpty(pwc) || isEmpty(email)) 
                    {
                        alert("No inputs can be left blank.");
                        return false;
                    }

                    //Check for mismatch password
                    if (pass != pwc)
                    {
                        alert("Password does not match.");
                        return false;
                    }

                    //Check for password to be atleast 6 chars and has correct format
                    if (pass.length < 6 || illegalPassChars.test(pass))
                    {
                        alert("Password must be at least 6 characters long and consist of letters and/or numbers.");
                        return false;
                    }

                    //Username can't be same as password
                    if (pass == user)
                    {
                        alert("Username and password must be different.");
                        return false;
                    }

                    //Check for username to be >= 6 chars
                    if (user.length < 6 || !illegalUserChars.test(user))
                    {
                        alert("Choose a different username. Username must be at least 6 characters long and consist of letters and numbers.");
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
                   
                //Check for blank input    
                function isEmpty(input)
                {
    				return (input == null || input == "" );
                }
                    
				</script>
		</div>	
		<div class="footer"><p>&#169; Cookbook Network, 2015. All Rights Reserved.</p></div>	
	</body>
</html>