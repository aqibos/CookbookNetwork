<?php
	session_start();
	$user = $_SESSION["username"];

    //get user id
    $userId;

    if (isset($_GET["user_id"]))
    {
        $userId = $_GET["user_id"];
        if ($userId == '')
        {
            header('Location: fail.php');
        }
    }
    else
    {
       header('Location: fail.php');
    }
    

    include 'create-recipe-form.php';

    //credentials
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "cookbooknetwork";

    //connect to db
    $conn = connectToDb($servername, $username, $password, $dbname);
    
    //get email
    $sql = "SELECT email
                FROM Account
                WHERE user_id = '$userId'";
        
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $userEmail = $row["email"];

    //check status
    $sql = "SELECT isAdmin
                FROM Account
                WHERE user_id = '$userId'";
        
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $isAdmin = $row["isAdmin"];
    $status = "";

    if ($isAdmin == 0)
    {
        $status = "Registered";
    }
    else
    {
        $status = "Administrator";
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
		
		<img class="background-image" src="images/food_spaghetti_1920x1080_wallp_2560x1440_miscellaneoushi.com_.jpg" height="700"/>
		
		<div class="navigation-bar">
			<?php include 'check-menu.php'; ?>
		</div>
		
		<div class="content">
			<h1>Account Information</h1>
			
			<table class="content-table">
				<tr class="content-table-row">
					<td class="content-table-left"><h3>User Name:</h3></td>
					<td class="content-table-right"><?php echo $user; ?></td>
				</tr>
				<tr class="content-table-row">
					<td class="content-table-left"><h3>E-mail:</h3></td>
					<td class="content-table-right"><?php echo $userEmail; ?></td>
				</tr>
				<tr class="content-table-row">
					<td class="content-table-left"><h3>Status:</h3></td>
					<td class="content-table-right"><?php echo $status; ?></td>
				</tr>
				<tr >
                    <td></td>
					<td >
                        <div class="wrapper-button">
                            <a href="delete-user.php"><div class="button">Delete User</div></a>
                        </div>
                    </td>
					<!--<td style="text-align:right"><a href="delete-user.php?user_id=<?php echo $userId; ?>"><div class="button">Delete User</div></a></td>-->
				</tr>
			</table>
			
		</div>
		
		<div class="footer"><p>&#169; Cookbook Network, 2015. All Rights Reserved.</p></div>
		
	</body>
</html>