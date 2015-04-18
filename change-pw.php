<?php
    session_start();
    $user = $_SESSION["username"];
    include 'change-pw-form.php';
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
			<h1 class="center">Change Password</h1>
			<br/>
			<table class="tableform">
			<form name="changepw" method="post" onsubmit="return validateForm()">
				<tr>
  					<td> <h3>Enter current password:</h3> <br/><br/> </td>
  					<td> <input type="password" name="currentpw"><br/><br/></td>
                    <td class="errormsg"> <?php echo $pwerror; ?> <br/><br/></td>
  				</tr>
  				<tr>
                    <td> <h3>Enter new password: </h3> <br/><br/></td>
  					<td><input type="password" name="newpw"><br/><br/></td>
  				</tr>
  				<tr>
                    <td><h3> Confirm Password: </h3> <br/><br/></td>
  					<td> <input type="password" name="newpwconfirm"><br/><br/></td>
  				</tr>
  				<tr>
  					<td><br/><br/><input type="submit" value="Cancel" onclick="window.history.back(); return false;"></td>
  					<td><br/><br/><input type="submit" value="Save Changes"></td>
  				</tr>
			</form>
			</table>

		</div>
        
        
        <script>
            function validateForm()
            {
                var current = document.forms["changepw"]["currentpw"].value;
                var password = document.forms["changepw"]["newpw"].value;
                var pwconfirm = document.forms["changepw"]["newpwconfirm"].value;
                
                
                if(checkBlankInput(current) || checkBlankInput(password) || checkBlankInput(pwconfirm))
                {    
                    alert("Fields cannot be left blank.");
                    return false;
                }
                
                if(password != pwconfirm)
                {
                    alert("Passwords does not match.");
                    return false;
                }
                
                if(password == current)
                {
                    alert("New desired password is the same as current password.");
                    return false;
                }
                if(password.length < 6 || validatePassword(password))
                {
                    alert("New password must be at least 6 characters long and consist of letters and numbers.");
                    return false;
                }
                
                return true;
            }
            
            function checkBlankInput(field)
            {
                return (field=="" || field == null);
            }
            
            function validatePassword(password)
            {
                var illegalPassChars = /[\W_]/;     //only letters and numbers
                return illegalPassChars.test(password);
            }
        </script>
        
		
		<div class="footer"><p>&#169; Cookbook Network, 2015. All Rights Reserved.</p></div>
		
	</body>
</html>