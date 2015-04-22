<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST")
    { 
        include 'db-credentials.php';
        $tbl_name="Cookbook"; // Table name 

        // Connect to server and select databse.
        $link = new mysqli($servername, $username, $password, $dbname);
        if ($link -> connect_error)
			die("Connection failed: ".$link -> connect_error);
        
        // cookbook name, privacy, tags, friends from form
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
        
        
        //If its friendly, add emails
        if($privacy=="friendly")
        {    
            storeFriends($email, $cb_id, $link);
            //$error = $count;
        }
        

        //Add to Cookbook list of user
        $sql= "INSERT INTO Cookbook_list (user_id, cookbook_id)
            VALUES ('$user_id', '$cb_id')";
        if ($link->query($sql) != true)     //unsuccessful query
        {
            $error= "ERROR: Could not able to execute $sql. " . $link->connect_error;
        } 
        
            //store array of tags in database
        if(isset($tags)) {storeTags($tags, $cb_id, $link);}
        
        

            
        mysqli_close($link);            //close connection
    }

    //Store tags in database
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
       
    //Store friends in databases
    function storeFriends($email, $cookbook_id, $link)
    {
        $size = count($email);
        for($i=0; $i < $size; $i++)
        {
            $current = $email[$i];
            if(checkValidFriend($current, $link))
            {
                $sql= "INSERT INTO  Friends (email, type, type_id)
                    VALUES ('$current', 'COOKBOOK', '$cookbook_id')";
                if ($link->query($sql) != true)     //unsuccessful query
                    header('Location: fail.php');
            }
            else
            {
                //invalid friend, delete cookbook
                $sql = "DELETE FROM Cookbook WHERE cookbook_id = '$cookbook_id'";
                if ($link->query($sql) != true)     //unsuccessful query
                    header('Location: fail.php');
                //delete any previously added friends from cookbook
                $sql2 = "DELETE FROM Friends WHERE type = 'COOKBOOK' AND type_id = '$cookbook_id'";
                if ($link->query($sql2) != true)     //unsuccessful query
                    header('Location: fail.php');
                 exit('Sorry, you have inserted invalid friend(s).');
            }
        }
    }

    //Check friend is a valid account
    function checkValidFriend($email, $link)
    {
        $sql= "SELECT email from Account WHERE email = '$email'";
        if ($link->query($sql) != true)     //unsuccessful query
            header('Location: fail.php');
        $result = $link -> query($sql);
        $row = $result->fetch_assoc();
        if(count($row) == 1) return true;       //found friends account in database
        else return false;
        
    }
        
    //Change location to home-page-registered.php
    function redirect()
    {
    	header('Location: view-cookbook.php');
    }

    ?>