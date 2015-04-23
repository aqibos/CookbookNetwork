<?php
function cbTitleSearch()
{
	$conn = getConn() ;
	
	$title = clean($_POST["title"]);
	$sql = "SELECT * FROM cookbook WHERE cb_title ='$title' ";
	
	printResult($conn -> query($sql)) ;
	
	$conn -> close() ;
}

function cbTagBrowse()
{
	$conn = getConn() ;
	
	$tags = $_POST["tags"] ;
	$len = count($tags) ;
	
	if($len <= 1)
	{
		$tag = $tags[0] ;
		$sql = " SELECT * FROM cookbook
					WHERE cookbook_id in (
						SELECT type_id FROM tag
						WHERE name = '$tag' AND type = 'COOKBOOK')";
						
	}
	else
	{
		$first = $tags[0] ; 
		$sql = " SELECT type_id FROM tag
					WHERE name = '$first' AND type = 'COOKBOOK' ";

		for($i = 1 ; $i < $len ; $i++)
		{
			$current = $tags[$i] ;
			$sql = " SELECT type_id FROM tag
						WHERE name = '$current' 
							AND type = 'COOKBOOK'
							AND type_id in (".$sql.")" ;
		}		
		
		$sql = " SELECT * FROM cookbook
					WHERE cookbook_id in (".$sql.")";
	}
	
	printResult($conn -> query($sql)) ;
	
	$conn -> close() ;
}

function getConn()
{	
	include 'db-credentials.php' ;
	
	return new mysqli($servername, $username, $password, $dbname);
}

function printResult($result)
{
	$rowNum = $result -> num_rows ;
	$visibleCookbooks = $rowNum ;
	$html = "" ;
	
	while($rowNum > 0)
	{
		$html .= '<div class="recipe-preview-row">';
		for($i = 0 ; $i < 3 ; $i++ )
		{
			if($row = $result -> fetch_assoc() )
			{
			    if(isVisible($row["cookbook_id"]))
				{
					$path = getImage($row["cookbook_id"]) ;
					$html .=  '<a href="view-cookbook.php?cookbook_id='.$row["cookbook_id"].'">
								<div class="recipe-preview-row-icon">
									<img class="thumbnail" src="'.$path.'">
									<p>'.$row["cb_title"].'</p>
								</div>
							</a>';
				}
				else
					$visibleCookbooks-- ;
			}	
			$rowNum = $rowNum - 1 ;	
		}
		$html .= '</div>';
	}
	echo '<h1>'.$visibleCookbooks.' cookbooks were found:</h1>' ;
	echo $html ;
}
function printResultWithX($result)
{
	$rowNum = $result -> num_rows ;
	
	echo '<h1>'.$rowNum.' cookbooks were found:</h1>' ;
	
	while($rowNum > 0)
	{
		echo'<div class="recipe-preview-row">';
		for($i = 0 ; $i < 3 ; $i++ )
		{
			if($row = $result -> fetch_assoc() )
			{
			    if(isVisible($row["cookbook_id"]))
				{
					$path = getImage($row["cookbook_id"]) ;
					echo '<a href="view-cookbook.php?cookbook_id='.$row["cookbook_id"].'">
								<div class="recipe-preview-row-icon">
									<img class="thumbnail" src="'.$path.'">
									<p>'.$row["cb_title"].'</p>
								</div>
							</a>
							<a href="delete.php?cookbook_id='.$row["cookbook_id"].'" onclick="return confirm(\'Are you sure you want to delete '.$row["cb_title"].'\');">
								<img class="x" src="images/x.png"></a>';
				}
			}	
			$rowNum = $rowNum - 1 ;	
		}
		echo'</div>';
	}
}


function getImage($cookbook_id)
{
	$conn = getConn() ;
	$sql = " SELECT img_path FROM recipe
				WHERE recipe_id = (
					SELECT recipe_id FROM recipe_list
					WHERE cookbook_id = '$cookbook_id'
					LIMIT 1)";
	$result = $conn -> query($sql) ;
	$row = $result -> fetch_assoc() ;
	
	return $row["img_path"];
}
function isVisible($cookbook_id)
{
	$visibility = getVisibility($cookbook_id) ;
	
	if($visibility == 'PRIVATE' ) 
		return isset($_SESSION["loggedin"]) and isOwner($cookbook_id) ;
	else if($visibility == 'PUBLIC')
		return true ;
	else if($visibility == 'REGISTERED')
		return isset($_SESSION["loggedin"]) and $_SESSION["loggedin"] ;
	else if($visibility == 'FRIENDLY')
		return isset($_SESSION["loggedin"]) and (isOwner($cookbook_id) or isFriend($cookbook_id)) ;
}

function getVisibility($cookbook_id)
{
	$conn = getConn() ;
	$sql = "SELECT visibility FROM cookbook WHERE cookbook_id = '$cookbook_id'" ;
	$result = $conn -> query($sql) ;
	$row = $result -> fetch_assoc();
	return $row["visibility"];
}

function isOwner($cookbook_id)
{	
	$conn = getConn() ;
	$sql = " SELECT user_id FROM cookbook_list
				WHERE cookbook_id = '$cookbook_id'" ;
	$result = $conn -> query($sql) ;
	$row = $result -> fetch_assoc() ;
	
	return $_SESSION["userid"] == $row["user_id"] ; 	
}

function isFriend($cookbook_id)
{
	$conn = getConn() ;
	$userid = $_SESSION["userid"] ;
	$sql = " SELECT * FROM account
				WHERE user_id = '$userid'
					AND email in (
						SELECT email FROM friends 
						WHERE type = 'COOKBOOK' 
							AND type_id = '$cookbook_id')" ;
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