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
			<h1 class="center">Rate Recipe</h1>
			<div class="center">
				<p>We'd love to hear your feedback on "Yum, Yum Pizza"!</p>
				<form>
					<input type="radio" name="rating" value="star1">&nbsp;&nbsp;<img src="star1.png"><br/><br/>
					<input type="radio" name="rating" value="star2">&nbsp;&nbsp;<img src="star2.png"><br/><br/>
					<input type="radio" name="rating" value="star3">&nbsp;&nbsp;<img src="star3.png"><br/><br/>
					<input type="radio" name="rating" value="star4">&nbsp;&nbsp;<img src="star4.png"><br/><br/>
					<input type="radio" name="rating" value="star5">&nbsp;&nbsp;<img src="star5.png"><br/><br/>
					<input type="submit" value="Rate!"> <input type="submit" value="Cancel">
				</form>
			</div>
		</div>
		
		<div class="footer"><p>&#169; Cookbook Network, 2015. All Rights Reserved.</p></div>
		
	</body>
</html>
