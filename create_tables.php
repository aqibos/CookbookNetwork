<?php
include 'db-credentials.php';
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn -> connect_error)
	die("Connection failed: ".$conn -> connect_error);
//ACCOUNT
$sql = "CREATE TABLE Account (
		user_id INT(6) UNSIGNED AUTO_INCREMENT,
		email VARCHAR(50) NOT NULL UNIQUE,
		username VARCHAR(30) NOT NULL UNIQUE,
		password VARCHAR(30) NOT NULL,		
		isAdmin BOOL NOT NULL,
		PRIMARY KEY(user_id) 						
		)";
if($conn -> query($sql) === TRUE)
	echo "<br>Table ACCOUNT Created successfully" ;
else
	echo "<br>Error creating table: " . $conn->error ;
//COOKBOOK
$sql = "CREATE TABLE Cookbook (
		cookbook_id INT(7) UNSIGNED AUTO_INCREMENT,
		cb_title VARCHAR(40) NOT NULL,
		visibility ENUM('PUBLIC', 'REGISTERED', 'FRIENDLY', 'PRIVATE') NOT NULL,
		PRIMARY KEY(cookbook_id)	
		)" ;
if($conn -> query($sql) === TRUE)
	echo "<br>Table COOKBOOK Created successfully" ;
else
	echo "<br>Error creating table: " . $conn->error ;
//RECIPE
$sql = "CREATE TABLE Recipe (
		recipe_id INT(7) UNSIGNED AUTO_INCREMENT,
		recipe_title VARCHAR(40) NOT NULL,
		author INT(6) UNSIGNED,
		directions TEXT, 
		rating FLOAT ,
		times_rated INT,
		img_path VARCHAR(100),
		visibility ENUM('PUBLIC', 'REGISTERED', 'FRIENDLY', 'PRIVATE') NOT NULL,
		PRIMARY KEY(recipe_id),
		CONSTRAINT fk_AccReci FOREIGN KEY(author)
		REFERENCES Account(user_id)
        ON DELETE CASCADE
		)" ;
if($conn -> query($sql) === TRUE)
	echo "<br>Table RECIPE Created successfully" ;
else
	echo "<br>Error creating table: " . $conn->error ;
//FLAG
$sql = "CREATE TABLE Flag (
		flag_id INT(7) UNSIGNED AUTO_INCREMENT,
		recipe_id INT(7) UNSIGNED NOT NULL,
		reason varchar(50) NOT NULL,
		comment TEXT,
		user_id INT(6) UNSIGNED NOT NULL,
		PRIMARY KEY(flag_id),
		CONSTRAINT fk_ReciFlag FOREIGN KEY(recipe_id) 
		REFERENCES Recipe(recipe_id),
		CONSTRAINT fk_AccFlag FOREIGN KEY (user_id)
		REFERENCES Account(user_id)	
		)" ;
if($conn -> query($sql) === TRUE)
	echo "<br>Table FLAG Created successfully" ;
else
	echo "<br>Error creating table: " . $conn->error ;
//COOKBOOK_LIST
$sql = "CREATE TABLE Cookbook_list (
		user_id INT(6) UNSIGNED NOT NULL, 
		cookbook_id INT(7) UNSIGNED NOT NULL,
		CONSTRAINT fk_AccCbList FOREIGN KEY(user_id)
		REFERENCES Account(user_id),
		CONSTRAINT fk_CbCbList FOREIGN KEY(cookbook_id)
		REFERENCES Cookbook(cookbook_id)	
        ON DELETE CASCADE
		)" ;
if($conn -> query($sql) === TRUE)
	echo "<br>Table COOKBOOK_LIST Created successfully" ;
else
	echo "<br>Error creating table: " . $conn->error ;
//FRIENDS
$sql = "CREATE TABLE Friends(
		email VARCHAR(50) NOT NULL,
        type enum('RECIPE', 'COOKBOOK') NOT NULL,
		type_id INT(7) UNSIGNED NOT NULL,
        friend_id INT(7) UNSIGNED AUTO_INCREMENT,
        PRIMARY KEY(friend_id),
		CONSTRAINT fk_AccFriends FOREIGN KEY (email)
		REFERENCES Account(email)
        ON DELETE CASCADE
		)" ;
if($conn -> query($sql) === TRUE)
	echo "<br>Table COOKBOOK_LIST Created successfully" ;
else
	echo "<br>Error creating table: " . $conn->error ;
//RECIPE_LIST
$sql = "CREATE TABLE Recipe_list (
		cookbook_id INT(7) UNSIGNED NOT NULL,
		recipe_id INT(7) UNSIGNED NOT NULL,
		CONSTRAINT fk_CbReciList FOREIGN KEY (cookbook_id)
		REFERENCES Cookbook(cookbook_id),	
		CONSTRAINT fk_ReciReciList FOREIGN KEY (recipe_id)
		REFERENCES Recipe(recipe_id)
		)" ;
if($conn -> query($sql) === TRUE)
	echo "<br>Table RECIPE_LIST Created successfully" ;
else
	echo "<br>Error creating table: " . $conn->error ;
//INGREDIENTS
$sql = "CREATE TABLE Ingredient (
		ingredient_id INT(7) UNSIGNED NOT NULL AUTO_INCREMENT,
		name VARCHAR(50) NOT NULL,
		recipe_id INT(7) UNSIGNED NOT NULL,
		PRIMARY KEY(ingredient_id),
		CONSTRAINT fk_ReciIngr FOREIGN KEY (recipe_id)
		REFERENCES Recipe(recipe_id)
        ON DELETE CASCADE
		)" ;
if($conn -> query($sql) === TRUE)
	echo "<br>Table INGREDIENT Created successfully" ;
else
	echo "<br>Error creating table: " . $conn->error ;
//TAG
$sql = "CREATE TABLE Tag (
		tag_id INT(7) UNSIGNED AUTO_INCREMENT,
		name VARCHAR(20) NOT NULL,
		type enum('RECIPE', 'COOKBOOK') NOT NULL,
		type_id INT(7) UNSIGNED NOT NULL,
		PRIMARY KEY(tag_id)
		)" ;
if($conn -> query($sql) === TRUE)
	echo "<br>Table TAG Created successfully" ;
else
	echo "<br>Error creating table: " . $conn->error ;
$conn -> close() ;
?>