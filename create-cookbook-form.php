<?php
	$error= "";
    if ($_SERVER["REQUEST_METHOD"] == "POST")
    { 
        include 'db-credentials.php';
        $tbl_name="Cookbook"; // Table name 

        // Connect to server and select databse.
        $link = new mysqli($servername, $username, $password, $dbname);
        if ($link -> connect_error)
			die("Connection failed: ".$link -> connect_error);
        
        // username and password and email sent from form
        $cookbookname = $_POST['cookbookname'];
        $privacy = $_POST['privacy']; 
        if($privacy == "friendly") {$email = $_POST['email'];}
        if(isset($_POST['tags']))
            $tags = $_POST['tags'];
        

        //ADD NEW COOKBOOK TO Cookbook Table
        $sql= "INSERT INTO $tbl_name (cb_title, visibility)
                VALUES ('$cookbookname', '$privacy')";

        if ($link->query($sql) != true)     //unsuccessful query
        {
            $error= "ERROR: Could not able to execute $sql. " . $link->connect_error;
        }
        //get new cookbook id
        $cb_id = mysqli_insert_id($link);

        //Add to Cookbook list of user
        $sql= "INSERT INTO Cookbook_list (user_id, cookbook_id)
            VALUES ('$user_id', '$cb_id')";
        if ($link->query($sql) != true)     //unsuccessful query
        {
            $error= "ERROR: Could not able to execute $sql. " . $link->connect_error;
        } 
            
            //store array of tags in database
        if(isset($tags)) {storeTags($tags, $cb_id, $link);}
            
        //If its friendly, add emails
        if($privacy=="friendly")
        {    
            $count = storeFriends($email, $cb_id, $link);
            $error = $email;
        }
       // redirect();

            
        mysqli_close($link);            //close connection
    }

    function storeTags($tag, $cookbook_id, $link)
    {
        $size = count($tag);
        for($i=0; $i < $size; $i++)
        {
            $current = $tag[$i];
            $sql= "INSERT INTO  Tag (name, type, type_id)
                VALUES ('$current', 'COOKBOOK', '$cookbook_id')";
            if ($link->query($sql) != true)     //unsuccessful query
            {
                $error= "ERROR: Could not execute $sql. " . $link->connect_error;
            } 
        }
    }
       
    function storeFriends($email, $cookbook_id, $link)
    {
        $size = count($email);
        for($i=0; $i < $size; $i++)
        {
            $current = $email[$i];
            $sql= "INSERT INTO  Friends (email, type, type_id)
                VALUES ('$current', 'COOKBOOK', '$cookbook_id')";
            if ($link->query($sql) != true)     //unsuccessful query
            {
                $error= "ERROR: Could not execute $sql. " . $link->connect_error;
            } 
        }
        return $i;
       // header('Location: index-1.html');
    }
        
    //Change location to home-page-registered.php
    function redirect()
    {
    	header('Location: view-cookbook.php');
    }

    ?>