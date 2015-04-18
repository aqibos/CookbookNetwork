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
		<link rel="stylesheet" type="text/css" href="page_style.css">
		<link href='http://fonts.googleapis.com/css?family=Tangerine:700' rel='stylesheet' type='text/css'>
		<link href='http://fonts.googleapis.com/css?family=IM+Fell+Double+Pica' rel='stylesheet' type='text/css'>
	</head>
	
	<body>
		<div class="background-image"></div>
		
		<div class="navigation-bar">
			<?php include 'check-menu.php' ?>
		</div>
		
		<div class="content">
			<h1>Oops! What you were trying to do didn't work.</h1>
            <h2>Go back and try again!</h2>
            <form>
				<input type="submit" value="Go Back" onclick="window.history.back(); return false;">
			</form>
		</div>
		
		<div class="footer"><p>&#169; Cookbook Network, 2015. All Rights Reserved.</p></div>
		<script type="text/javascript">
			function goBack()
			{
				window.history.back();
			}
		</script>
	</body>
</html>