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
			<table  class="navigation-bar-table">
				<tr>
					<td class="navigation-bar-table-left"><h1 class="navigation-bar-table-left-header">Cookbook Network</h1></td>
					<td class="navigation-bar-table-right">
						<ul class="upper-level-ul">
                    <li>Search
                      <ul>
                        <li><a href="">Search Recipe</a></li>
                          <li><a href="">Search Cookbook</a></li>
                      </ul>
                    </li>
              
                    <li>Recipe
                      <ul>
                          <li><a href="">Create Recipe</a></li>
                          <li><a href="">View myRecipes</a></li>
                      </ul>
                    </li>
              
                    <li>Cookbook
                      <ul>
                          <li><a href="">Create Cookbook</a></li>
                          <li><a href="">View myCookbooks</a></li>
                      </ul>
                    </li>
              
                    <li>Account
                      <ul>
                          <li><a href="">Account Info</a></li>
                          <li><a href="">Log Out</a></li>
                      </ul>
                    </li>
                 </ul>
						
					</td>
				</tr>
			</table>
		</div>
		
		<div class="content">
			<h1 class="center">Create Cookbook</h1>
			<table class="tableform">
				<tr>
  					<td colspan="2"> <h3>Name of Cookbook: </h3><br/></td>
  					<td colspan="3"><input size="35" type="text" name="cookbookname"><br/><br/></td>
  				</tr>
  				<tr>
  					<td colspan="2"> <h3>Privacy: </h3><br/></td>
  					<td><input type="radio" name="privacy" value="private">Private<br/><br/></td>
  					<td><input type="radio" name="privacy" value="registered">Registered<br/><br/></td>
  					<td><input type="radio" name="privacy" value="friendly">Friendly<br/><br/></td>
  					<td><input type="radio" name="privacy" value="public">Public<br/><br/></td>
  				</tr>
  				<tr>
  					<td colspan="2"><h3>Enter email of users to share: </h3></td>
  					<td><br/><input type="text" size="35" name="email"><br/><br/></td>
  				</tr>
  				<tr>
  					<td colspan="2"> <h3>Tags for Cookbook:</h3></td>
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
