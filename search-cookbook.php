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
			<table  class="navigation-bar-table">
				<tr>
					<td class="navigation-bar-table-left"><h1 class="navigation-bar-table-left-header">Cookbook Network</h1></td>
					<td class="navigation-bar-table-right">
						<ul class="upper-level-ul">
              <li><a href="signup.php">Search Recipe</a></li>
							<li><a href="signup.php">Search Cookbook</a></li>
							<li><a href="signup.php">Log In</a></li>
							<li><a href="signup.php">Sign Up</a></li>
            </ul>
						
					</td>
				</tr>
			</table>
		</div>
		
		<div class="content">
			<h1 class="center">Search Cookbook</h1>
			<table class="tableform">
				<form>
				<tr>
					<td><br/><h3>Search by name: </h3></td>
					<td colspan="3"><br/><input size="50" type="text" name="search"></td>
				</tr>
				<tr>
					<td><br/></td>
					<td><br/><input type="submit" value="Search"></td>
				</tr>
				<tr>
					<td><br/><br/></td>
				</tr>
				<tr>
  					<td> <h3>Browse tags:</h3></td>
  				</tr>
  					<td><br/></td>
  					<td><input type="checkbox" name="tags" value="Appetizer">Appetizer<br/></td>
  					<td><input type="checkbox" name="tags" value="Paleo">Paleo<br/></td>
  					<td><input type="checkbox" name="tags" value="American">American<br/></td>
  				</tr>
  				<tr>
  					<td><br/></td>
  					<td><input type="checkbox" name="tags" value="Beef">Beef<br/></td>
  					<td><input type="checkbox" name="tags" value="Pork">Pork<br/></td>
  					<td><input type="checkbox" name="tags" value="Asian">Asian<br/></td>
  				</tr>
  				<tr>
  					<td><br/></td>
  					<td><input type="checkbox" name="tags" value="Beverages">Beverages<br/></td>
  					<td><input type="checkbox" name="tags" value="Poultry">Poultry<br/></td>
  					<td><input type="checkbox" name="tags" value="Desi">Desi<br/></td>
  				</tr>
  				<tr>
  					<td><br/></td>
  					<td><input type="checkbox" name="tags" value="Breakfast">Breakfast<br/></td>
  					<td><input type="checkbox" name="tags" value="Salad">Salad<br/></td>
  					<td><input type="checkbox" name="tags" value="Greek">Greek<br/></td>
  				</tr>
  				<tr>
  					<td><br/></td>
  					<td><input type="checkbox" name="tags" value="Chicken">Chicken<br/></td>
  					<td><input type="checkbox" name="tags" value="Seafood">Seafood<br/></td>
  					<td><input type="checkbox" name="tags" value="Italian">Italian<br/></td>
  				</tr>
  				<tr>
  					<td><br/></td>
  					<td><input type="checkbox" name="tags" value="Desserts">Desserts<br/></td>
  					<td><input type="checkbox" name="tags" value="Soup">Soup<br/></td>
  					<td><input type="checkbox" name="tags" value="Jamaican">Jamaican<br/></td>
  				</tr>
  				<tr>
  					<td><br/></td>
  					<td><input type="checkbox" name="tags" value="Gluten">Gluten-free<br/></td>
  					<td><input type="checkbox" name="tags" value="Vegan">Vegan<br/></td>
  					<td><input type="checkbox" name="tags" value="Latin">Latin<br/></td>

  				</tr>
  				<tr>
  					<td><br/></td>
  					<td><input type="checkbox" name="tags" value="Lunch">Lunch<br/></td>
  					<td><input type="checkbox" name="tags" value="Vegetarian">Vegetarian<br/></td>

  				</tr>
  				<br/>
  				<tr>
  					<td><br/></td>
  					<td><br/><br/><input type="submit" value="Browse"></td>
				</form>
			</table>

		</div>
		
		<div class="footer"><p>&#169; Cookbook Network, 2015. All Rights Reserved.</p></div>
		
	</body>
</html>
