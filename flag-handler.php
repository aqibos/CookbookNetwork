<?php
	function getReasons($conn , $recipe_id, $dm)
	{
		$reasons = "" ;
		
		$sql = "SELECT reason FROM flag 
					WHERE recipe_id = '$recipe_id'";
		$result = $conn -> query($sql) ;
		
		while( $row = $result -> fetch_assoc() )
		{
			$reasons .= $row["reason"] . $dm ;
		}
		
		return $reasons ;
	}
	
	function getComments($conn, $recipe_id, $dm)
	{
		$comments = "" ;
		
		$sql = "SELECT comment FROM flag 
					WHERE recipe_id='$recipe_id'";			
		$result = $conn -> query($sql) ;

		while( $row = $result -> fetch_assoc() )
		{
			$comments .= $row["comment"] . $dm ;
		}	
		
		return $comments ;
	}
	
	function getAuthorsID($conn, $recipe_id, $dm)
	{
		$ids = "" ;
		
		$sql = "SELECT user_id FROM flag 
					WHERE recipe_id='$recipe_id'";			
		$result = $conn -> query($sql) ;

		while( $row = $result -> fetch_assoc() )
		{
			$ids .= $row["user_id"] . $dm ;
		}	
		
		return $ids ;
	}
	
	function getEmail($conn, $user_id) 
	{
		
		$sql = "SELECT email FROM account 
					WHERE user_id='$user_id'";			
		$result = $conn -> query($sql) ;

		$row = $result -> fetch_assoc() ;
	
		return $row["email"] ;
	}
?>
