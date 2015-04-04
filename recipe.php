<?php
	$user_logged_in = true;
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
			<table  class="navigation-bar-table">
				<tr>
					<td class="navigation-bar-table-left"><h1 class="navigation-bar-table-left-header">Cookbook Network</h1></td>
					<td class="navigation-bar-table-right">
						<ul class="upper-level-ul">
							
							<?php include 'menu.php'; ?>
							
						</ul>
						
					</td>
				</tr>
			</table>
		</div>
		
		<div class="content">
			<h1>Yum, Yum Pizza! <img class="border" src="pizza.jpg" class="setsize" align="right" /></h1>
			<p><i>Created by: <a href="">Aqib Shah</a></i></p>
			<p class="flagfont"><img src="star5.png" width="10%" height="10%" title="rating"><br/>
				0&nbsp;<img class="noflag" src="flag.png" width="12px" height="12px" title="flags"></p>
			<h2>Ingredients</h2>
			<ul>
				<li>1 package (1/4 ounce) active dry yeast</li>
				<li>1 teaspoon sugar</li>
				<li>1-1/4 cups warm water (110° to 115°)</li>
				<li>1/4 cup canola oil</li>
				<li>1 teaspoon salt</li>
				<li>3-1/2 cups all-purpose flour</li>
				<li>1/2 pound ground beef</li>
				<li>1 small onion, chopped</li>
				<li>1 can (15 ounces) tomato sauce</li>
				<li>3 teaspoons dried oregano</li>
				<li>1 teaspoon dried basil</li>
				<li>1 medium green pepper, diced</li>
				<li>2 cups (8 ounces) shredded part-skim mozzarella cheese</li>
			</ul>
			
			<h2>Directions</h2>
			<ol>
			 	<li>In large bowl, dissolve yeast and sugar in water; let stand for 5 minutes. Add oil and salt. Stir in flour, a cup at a time, until a soft dough forms.</li> <br />
 				<li>Turn onto floured surface; knead until smooth and elastic, about 2-3 minutes. Place in a greased bowl, turning once to grease the top. Cover and let rise in a warm place until doubled, about 45 minutes. Meanwhile, cook beef and onion over medium heat until no longer pink; drain.</li> <br />
				<li>Punch down dough; divide in half. Press each into a greased 12-in. pizza pan. Combine the tomato sauce, oregano and basil; spread over each crust. Top with beef mixture, green pepper and cheese.</li> <br />
 				<li>Bake at 400° for 25-30 minutes or until crust is lightly browned. Yield: 2 pizzas (3 servings each).</li> <br />
			</ol>
			<p>Tags: <a class="tags">Italian</a>
			<a class="tags">Lunch</a></p>

			<p class="center"><a href="raterecipe.php">Rate Recipe</a>&nbsp;&nbsp;|
				&nbsp;&nbsp;<a href="">Add to Cookbook</a>&nbsp;&nbsp;|
				&nbsp;&nbsp;<a href="">Flag Recipe</a></p>

		</div>
		
		<div class="footer"><p>&#169; Cookbook Network, 2015. All Rights Reserved.</p></div>
		
	</body>
</html>
