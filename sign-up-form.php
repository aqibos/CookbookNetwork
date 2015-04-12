<?php
	$emailerror = $nameerror = "" ;
	function check_account_exists($column, $name, $link) 
    {
        $sql="SELECT * FROM Account WHERE $column='$name'";
        $result = $link -> query($sql);
        $count = $result->num_rows;
        return $count;
    }
    function redirect()
    {
    	header('Location: home-page-registered.php');
    }

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
        // username and password sent from form
        $username = $_POST['username'];
        $password=$_POST['password']; 
        $email=$_POST['email']; 

        $usernametaken = check_account_exists("username", $username, $link); 
        $emailtaken = check_account_exists("email", $email, $link); 

                // result must be of one row
                if($emailtaken ==1)
                {
                    $emailerror = "* An account exists with this email."; 
                }
                else if($usernametaken == 1)
                {
                	$nameerror = "* Username is taken. Choose another one.";
                }
                else
                {
       				//ADD ACCOUNT TO DATABASE
                	$sql= "INSERT INTO $tbl_name (email, username, password, isAdmin)
							VALUES ('$email', '$username', '$password', '0')";

					if ($link->query($sql) !=true)
					{
    					$emailerror= "ERROR: Could not able to execute $sql. " . $link->connect_error;
					} 
                    session_start();
                    $_SESSION['loggedin'] = true ;
                    $_SESSION['username'] = $username;
                    $_SESSION['isAdmin'] = '0';
                    redirect();
                }
                mysqli_close($link);
            } 
    ?>