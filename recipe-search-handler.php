<?php
function titleSearch()
{
	$conn = getConn() ;
	
	$title = clean($_POST["title"]);
	$title = $conn -> real_escape_string($title) ;
	$sql = "SELECT * FROM recipe WHERE recipe_title ='$title'";
	
	printResult($conn -> query($sql)) ;
	
	$conn -> close() ;
}
function ingredientSearch()
{
	$conn = getConn() ;
	$ingredients = array_filter($_POST["ingredient"]);
	$len = count($ingredients);
	
	if($len <= 1)
	{
		$ing = clean($ingredients[0]);
		$ing = $conn -> real_escape_string($ing) ;
		$sql = " SELECT * FROM recipe 
					WHERE recipe_id in (
						SELECT recipe_id FROM ingredient 
						WHERE name='$ing' )";		
	}
	else
	{
		$first = clean($ingredients[0]) ; 
		$first= $conn -> real_escape_string($first) ;
		$sql = " SELECT recipe_id FROM ingredient
					WHERE name='$first'";
		
		for($i = 1 ; $i < $len ; $i++ )
		{
			$current = clean($ingredients[$i]) ;
			$current = $conn -> real_escape_string($current) ;
			$sql = " SELECT recipe_id FROM ingredient
						WHERE name = '$current' 
							AND recipe_id in (".$sql.")";
		}
		
		$sql = " SELECT * FROM recipe 
					WHERE recipe_id in (".$sql.")";
	}
	
	printResult( $conn -> query($sql) ) ;
	
	$conn -> close() ;
}

function tagBrowse()
{
	$conn = getConn() ;
	
	$tags = $_POST["tags"] ;
	$len = count($tags) ;
	
	if($len <= 1)
	{
		$tag = $tags[0] ;
		$sql = " SELECT * FROM recipe
					WHERE recipe_id in (
						SELECT type_id FROM tag
						WHERE name = '$tag' AND type = 'RECIPE')";
						
	}
	else
	{
		$first = $tags[0] ; 
		$sql = " SELECT type_id FROM tag
					WHERE name = '$first AND type = 'RECIPE'";

		for($i = 1 ; $i < $len ; $i++)
		{
			$current = $tags[$i] ;
			$sql = " SELECT type_id FROM tag
						WHERE name = '$current' 
							AND type = 'RECIPE'
							AND type_id in (".$sql.")" ;
		}		
		
		$sql = " SELECT * FROM recipe
					WHERE recipe_id in (".$sql.")";
	}
	
	printResult($conn -> query($sql)) ;
	
	$conn -> close() ;
}
function getConn()
{	
	include 'db-credentials.php'; 
	return new mysqli($servername, $username, $password, $dbname);
}

function printResult($result)
{
	$visibleRecipes = $rowNum = $result -> num_rows ;
	$html = "" ;
	
	while($rowNum > 0)
	{
		$html .= "<div class=\"recipe-preview-row\">";
		for($i = 0 ; $i < 3 ; $i++ )
		{
			if($row = $result -> fetch_assoc() )
			{
			    if(isVisible($row["recipe_id"]))
					$html .= "<a href=\"view-recipe.php?recipe_id=".$row["recipe_id"]."\">
								<div class=\"recipe-preview-row-icon\">
									<img class=\"thumbnail\" src=\"".$row["img_path"]."\">
									<p>".$row["recipe_title"]."</p>
								</div>
							</a>";
				
				else
					$visibleRecipes-- ;
			}
			$rowNum = $rowNum - 1 ;	
		}
		$html .= "</div>";
	}
	
	echo '<h1>'.$visibleRecipes.' recipes were found:</h1>' ;
	echo $html ;
}

function printResultWithX($result)
{
	$rowNum = $result -> num_rows ;
	
	echo '<h1>'.$rowNum.' recipes were found:</h1>' ;
	
	while($rowNum > 0)
	{
		echo'<div class="recipe-preview-row">';
		for($i = 0 ; $i < 3 ; $i++ )
		{
			if($row = $result -> fetch_assoc() )
			{
			    if(isVisible($row["recipe_id"]))
				{
					echo '<a href="view-recipe.php?recipe_id='.$row["recipe_id"].'">
								<div class="recipe-preview-row-icon">
									<img class="thumbnail" src="'.$row["img_path"].'">
									<p>'.$row["recipe_title"].'</p>
								</div>
							</a>
							<a href="delete.php?recipe_id='.$row["recipe_id"].'" onclick="return confirm(\'Are you sure youu want to delete '.$row["recipe_title"].'\')">
								<img class="x" src="images/x.png"></a>';
				}
			}
			$rowNum = $rowNum - 1 ;	
		}
		echo'</div>';
	}
}

function isVisible($recipe_id)
{
	$visibility = getVisibility($recipe_id) ;
	
	if($visibility == 'PRIVATE' ) 
		return isset($_SESSION["loggedin"]) and isAuthor($recipe_id) ;
	else if($visibility == 'PUBLIC')
		return true ;
	else if($visibility == 'REGISTERED')
		return isset($_SESSION["loggedin"]) and $_SESSION["loggedin"] ;
	else if($visibility == 'FRIENDLY')
		return isset($_SESSION["loggedin"]) and isAuthor($recipe_id) or isFriend($recipe_id) ;
}

function getVisibility($recipe_id)
{
	$conn = getConn() ;
	$sql = "SELECT visibility FROM recipe WHERE recipe_id = '$recipe_id'" ;
	$result = $conn -> query($sql) ;
	$row = $result -> fetch_assoc();
	return $row["visibility"];
}
function isAuthor($recipe_id)
{	
	$conn = getConn() ;
	$sql = " SELECT author FROM recipe
				WHERE recipe_id = '$recipe_id'" ;
	$result = $conn -> query($sql) ;
	$row = $result -> fetch_assoc() ;
	
	return $_SESSION["userid"] == $row["author"] ; 	
}
function isFriend($recipe_id)
{
	$conn = getConn() ;
	$userid = $_SESSION["userid"] ;
	$sql = " SELECT * FROM account
				WHERE user_id = '$userid'
					AND email in (
						SELECT email FROM friends 
						WHERE type = 'RECIPE' 
							AND type_id = '$recipe_id')" ;
	$result = $conn -> query($sql) ;
	return $result -> num_rows > 0 ;
}

function clean($data)
{
	$data = trim($data) ;
	$data = stripslashes($data) ;
	$data = htmlspecialchars($data) ;
	
	return $data ;
}
?>