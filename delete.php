<?php
	session_start() ;
	include 'db-credentials.php' ;
	include 'create-recipe-form.php' ;

	$conn = new mysqli($servername, $username, $password, $dbname);
		
	if ($conn->connect_error) 
	{
		die("Connection failed: " . $conn->connect_error);
	}
		
	if(isset($_GET["recipe_id"]))
	{
		$recipe_id = $_GET["recipe_id"] ;
		removeRecipe($conn, $recipe_id);
		header('Location: my-recipes.php');
	}
	else 
	{
		$id = $_GET["cookbook_id"] ;
		removeFromDbType("Friends", "type_id", $id, $conn);
		removeFromDbType("Tag", "type_id", $id, $conn);
		removeFromDb("Recipe_list", "cookbook_id", $id, $conn);
		removeFromDb("cookbook_list", "cookbook_id", $id, $conn);
		removeFromDb("cookbook", "cookbook_id", $id, $conn);
		header('Location: my-cookbooks.php');
	}
?>