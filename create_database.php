<?php
$servername="localhost" ;
$username = "root" ;
$password = "" ;	
$dbname = "cookbooknetwork" ;

$conn = new mysqli($servername, $username, $password);

if ($conn -> connect_error)
	die("Connection failed: ".$conn -> connect_error);

$sql = "DROP DATABASE IF EXISTS $dbname";

if($conn -> query($sql) === TRUE)
	echo "Database dropped...<br>" ;
else
	echo "Database not deleted...<br>" ;


$sql = "CREATE DATABASE IF NOT EXISTS $dbname"  ;

if($conn -> query($sql) === TRUE)
{
	echo "Database created...<br>" ;
	$conn -> close() ;
	
	include 'create_tables.php.' ;
}
else
{
	echo "Error creating databse...<br>" ;
	$conn -> close() ;
}
?>
