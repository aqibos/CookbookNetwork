    <?php
        $pwerror = "" ;

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

            // current and new password sent from form
            $currentpw = $_POST['currentpw'];
            $newpw =$_POST['newpw'];
            
            $sql="SELECT * FROM Account WHERE username= '$user' and password='$currentpw'";
            $result = $link -> query($sql);
            $count = $result->num_rows;
            
            if($count == 0)     //input of current password is incorrect
            {
                $pwerror= "* Invalid Password.";
            }
            else
            {
                //change password in database
                $sql = "UPDATE Account SET password ='$newpw' WHERE `username`='$user'";
                if ($link->query($sql) != true)     //unsuccessful query
                {
                    $pwerror= "ERROR: Could not able to execute $sql. " . $link->connect_error;
                } 
                redirect();
            }
        }

        function redirect()
        {
            header('Location: account-info.php');
        }
    ?>