<?php
	$emailerror = $nameerror = "" ;

    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
    	$host="localhost";              // Host name 
        $username="root";               // Mysql username 
        $password="";                   // Mysql password 
        $db_name="cookbooknetwork";     // Database name 
        $tbl_name="Account"; // Table name 

        // Connect to server and select databse.
        $link = new mysqli($host, $username, $password, $db_name);
        if ($link -> connect_error)
			die("Connection failed: ".$link -> connect_error);
        
        // username and password and email sent from form
        $username = $_POST['username'];
        $password=$_POST['password']; 
        $email=$_POST['email']; 
        
        //check if a row is returned, meaning account username / email is taken
        $usernametaken = check_account_exists("username", $username, $link); 
        $emailtaken = check_account_exists("email", $email, $link); 

        // if a row was returned for same email, display error message
        if($emailtaken == 1)
        {
            $emailerror = "* An account exists with this email."; 
        }
        else if($usernametaken == 1)    //if a row was returned for same username, display error
        {
            $nameerror = "* Username is taken. Please choose another one.";
        }
        else          //username, email not taken -  make new account
        {
            //ADD NEW ACCOUNT TO DATABASE
            $sql= "INSERT INTO $tbl_name (email, username, password, isAdmin)
                    VALUES ('$email', '$username', '$password', '0')";

            if ($link->query($sql) != true)     //unsuccessful query
            {
                $emailerror= "ERROR: Could not able to execute $sql. " . $link->connect_error;
            } 
            
            //start session, initialize session variables
            session_start();
            $_SESSION['loggedin'] = true ;
            $_SESSION['username'] = $username;
            $_SESSION['isAdmin'] = '0';
            redirect();     //done checking form, go to next page
        }
        mysqli_close($link);            //close connection
    }

    //Execute select query in Account table if specified attribute contains specified name and return count of rows
    function check_account_exists($attribute, $name, $link) 
    {
        $sql="SELECT * FROM Account WHERE $attribute='$name'";
        $result = $link -> query($sql);
        $count = $result->num_rows;
        return $count;
    }

    //Change location to home-page-registered.php
    function redirect()
    {
    	header('Location: home-page-registered.php');
    }

        
    ?>