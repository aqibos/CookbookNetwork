<?php session_start(); ?>
<!DOCTYPE html>
<html>
	
	<head>
		<title>Cookbook Network - Create Cookbook</title>
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
			<?php include 'check-menu.php' ;?>
		</div>
		
		<div class="content">
			<h1 class="center">Create Cookbook</h1>
			<table class="tableform">
				<tr>
  					<td colspan="2" width="60%"> <h3>Name of Cookbook: </h3><br/></td>
  					<td colspan="2" width="30%"><input size="35" type="text" name="cookbookname"><br/><br/></td>
  				</tr>
  				<tr>
  					<td colspan="2" width="20%"> <h3>Privacy: </h3><br/></td>
  					<td width="15%"><input type="radio" name="privacy" value="private">Private<br/><br/></td>
  					<td width="15%"><input type="radio" name="privacy" value="registered">Registered<br/><br/></td>
  					<td width="15%"><input type="radio" name="privacy" value="friendly">Friendly<br/><br/></td>
  					<td width="15%"><input type="radio" name="privacy" value="public">Public<br/><br/></td>
  				</tr>
  				<tr>
  					<td colspan="2" width="60%"><h3>Enter email of users to share: </h3></td>
  					<td colspan="2" width="30%"><br/><input type="text" size="35" name="email"><br/><br/></td>
  				</tr>
  				<tr>
  					<td width="45%"> <h3>Tags for Cookbook:</h3></td>
  				</tr>
  				<tr>
  					<td><br/></td>
  					<td><br/></td>
  					<td><input type="checkbox" name="tags" value="Appetizer">Appetizer<br/></td>
  					<td><input type="checkbox" name="tags" value="Paleo">Paleo<br/></td>
  					<td><input type="checkbox" name="tags" value="American">American<br/></td>
  				</tr>
  				<tr>
  					<td><br/></td>
  					<td><br/></td>
  					<td><input type="checkbox" name="tags" value="Beef">Beef<br/></td>
  					<td><input type="checkbox" name="tags" value="Pork">Pork<br/></td>
  					<td><input type="checkbox" name="tags" value="Asian">Asian<br/></td>
  				</tr>
  				<tr>
  					<td><br/></td>
  					<td><br/></td>
  					<td><input type="checkbox" name="tags" value="Beverages">Beverages<br/></td>
  					<td><input type="checkbox" name="tags" value="Poultry">Poultry<br/></td>
  					<td><input type="checkbox" name="tags" value="Desi">Desi<br/></td>
  				</tr>
  				<tr>
  					<td><br/></td>
  					<td><br/></td>
  					<td><input type="checkbox" name="tags" value="Breakfast">Breakfast<br/></td>
  					<td><input type="checkbox" name="tags" value="Salad">Salad<br/></td>
  					<td><input type="checkbox" name="tags" value="Greek">Greek<br/></td>
  				</tr>
  				<tr>
  					<td><br/></td>
  					<td><br/></td>
  					<td><input type="checkbox" name="tags" value="Chicken">Chicken<br/></td>
  					<td><input type="checkbox" name="tags" value="Seafood">Seafood<br/></td>
  					<td><input type="checkbox" name="tags" value="Italian">Italian<br/></td>
  				</tr>
  				<tr>
  					<td><br/></td>
  					<td><br/></td>
  					<td><input type="checkbox" name="tags" value="Desserts">Desserts<br/></td>
  					<td><input type="checkbox" name="tags" value="Soup">Soup<br/></td>
  					<td><input type="checkbox" name="tags" value="Jamaican">Jamaican<br/></td>
  				</tr>
  				<tr>
  					<td><br/></td>
  					<td><br/></td>
  					<td><input type="checkbox" name="tags" value="Gluten">Gluten-free<br/></td>
  					<td><input type="checkbox" name="tags" value="Vegan">Vegan<br/></td>
  					<td><input type="checkbox" name="tags" value="Latin">Latin<br/></td>

  				</tr>
  				<tr>
  					<td><br/></td>
  					<td><br/></td>
  					<td><input type="checkbox" name="tags" value="Lunch">Lunch<br/></td>
  					<td><input type="checkbox" name="tags" value="Vegetarian">Vegetarian<br/></td>

  				</tr>
  				<br/>
  				<tr>
  					<td><br/><br/></td>
  					<td><br/><br/></td>
  					<td colspan="2"><br/><br/><br/><div class="submitbutton"><input type="submit" value="Create"></div></td>
            <td colspan="2"><br/><br/><br/><div class="submitbutton"><input type="submit" value="Cancel"></div></td>

  				</tr>
			</form>
			</table>

		</div>
		
		<div class="footer"><p>&#169; Cookbook Network, 2015. All Rights Reserved.</p></div>
		
	</body>
</html>