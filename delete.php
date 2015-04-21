<?php
session_start() ;
include 'db-credentials.php' ;

if(isset($_GET["recipe_id"]))
	deleteRecipe() ;
else 
	deleteCookbook() ;

function deleteRecipe() 
{
	$recipe_id = $_GET["recipe_id"] ;
	
	$conn = new mysqli($servername, $username, $password, $dbname);
	
	$sql = " DELETE FROM recipe 
				WHERE recipe_id = '$recipe_id'" ;
	
	if ($conn->query($sql) !== TRUE) header('Location:fail.php') ;

	$sql = " DELETE FROM tag 
				WHERE type = 'RECIPE'
					AND type_id = '$recipe_id'" ;

	if ($conn->query($sql) !== TRUE) header('Location:fail.php') ;
	
	
	$sql = " DELETE FROM friends 
				WHERE type = 'RECIPE'
					AND type_id = '$recipe_id'" ;

	if ($conn->query($sql) !== TRUE) header('Location:fail.php') ;
	
	
	$conn->close();
	header('Location:my-recipes.php') ;
}	

function deleteCookbook() 
{
	$cookbook_id = $_GET["cookbook_id"] ;
	
	$conn = new mysqli($servername, $username, $password, $dbname);
	
	$sql = " DELETE FROM cookbook 
				WHERE cookbook_id = '$cookbook_id'" ;

	if ($conn->query($sql) !== TRUE) header('Location:fail.php') ;
	
	$sql = " DELETE FROM tag 
				WHERE type = 'COOKBOOK'
					AND type_id = '$cookbook_id'" ;

	if ($conn->query($sql) !== TRUE) header('Location:fail.php') ;
	
	$sql = " DELETE FROM friends 
				WHERE type = 'COOKBOOK'
					AND type_id = '$cookbook_id'" ;

	if ($conn->query($sql) !== TRUE)  header('Location:fail.php') ;
	
	$conn->close();
	
	header('Location:my-cookbooks.php') ;
}	
?>