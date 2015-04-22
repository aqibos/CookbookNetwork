<?php 
    session_start();

    if(isset($_SESSION['userid']))          //get user id
        $user_id = $_SESSION['userid'];

    //get cookbook id that is being edited
    $cookbook_id = $_GET["cookbook_id"] ;

    include 'db-credentials.php';

    $link = new mysqli($servername, $username, $password, $dbname);
    if ($link -> connect_error)
        die("Connection failed: ".$link -> connect_error);

    $sql = "SELECT * FROM Cookbook WHERE cookbook_id = '$cookbook_id'";
    $result = $link -> query($sql);
    $row = $result->fetch_assoc();
    
    $title = $row['cb_title'];     //get title of cookbook
    $privacy = $row['visibility'];      //get privacy of cookbook
    

    if($privacy == "FRIENDLY")
    {
        $sql = "SELECT email FROM Friends WHERE type='COOKBOOK' AND type_id = '$cookbook_id'";
        $result = $link -> query($sql);

        $i=0;
        while($row = $result->fetch_assoc())        //get tags and store in array
        {
            $allemails[$i] = $row['email']; 
            $i++;
        }
    }


    $sql = "SELECT name FROM Tag WHERE type='COOKBOOK' AND type_id = '$cookbook_id'";
    $result = $link -> query($sql);

    $i=0;
    while($row = $result->fetch_assoc())        //get tags and store in array
    {
        $tagsfromdb[$i] = $row['name']; 
        $i++;
    }

    //all possible tags
    $alltags_array = array('1' => 'appetizer',
                            '2' => 'paleo',
                            '3' => 'american',
                            '4' => 'beef',
                            '5' => 'pork',
                            '6' => 'asian',
                            '7' => 'beverages',
                            '8' => 'poultry',
                            '9' => 'desi',
                            '10' => 'breakfast/brunch',
                            '11' => 'salad',
                            '12' => 'greek',
                            '13' => 'chicken',
                            '14' => 'seafood',
                            '15' => 'italian',
                            '16' => 'desserts',
                            '17' => 'soup',
                            '18' => 'jamaican',
                            '19' => 'gluten-free',
                            '20' => 'vegan',
                            '21' => 'latin',
                            '22' => 'lunch',
                            '23' => 'vegetarian');

    if($i > 0)
    {
        $c = getTags($tagsfromdb, $alltags_array);
    }
    else
    {
        foreach ( $alltags_array as $k => $v ) 
        {
            $c[$k] = "";
        }
    }



    //SUBMITTED FORM
    if ($_SERVER["REQUEST_METHOD"] == "POST")
    { 
        
        $tbl_name="Cookbook"; // Table name 

        // Connect to server and select databse.
        $link = new mysqli($servername, $username, $password, $dbname);
        if ($link -> connect_error)
			die("Connection failed: ".$link -> connect_error);
        
        // get cbkn name, privacy, tags, friends from form
        $cookbookname = $_POST['cookbookname'];
        $privacy = $_POST['privacy']; 
        
        if(isset($_POST['email'])) 
            $email = $_POST['email'];
        
        if(isset($_POST['tags']))
            $tags = $_POST['tags'];
        

        //DELETE TAGS from Cookbook
        $sql ="DELETE FROM Tag WHERE type='COOKBOOK' AND type_id ='$cookbook_id'";
        if ($link->query($sql) != true)     //unsuccessful query
        {
            header('Location: fail.php');
        }
        
        //DELETE friends of cookbook
        $sql ="DELETE FROM Friends WHERE type='COOKBOOK' AND type_id ='$cookbook_id'";
        if ($link->query($sql) != true)     //unsuccessful query
        {
            header('Location: fail.php');
        }
        

        //If its friendly, add emails
        if(isset($_POST['email']))
        {    
            storeFriends($email, $cookbook_id, $link);
        }
        
        //Update cookbook name and privacy
        $sql= "UPDATE Cookbook SET cb_title = '$cookbookname', visibility = '$privacy' WHERE cookbook_id = '$cookbook_id'";

        if ($link->query($sql) != true)     //unsuccessful query
        {
            $error= "ERROR: Could not able to execute $sql. " . $link->connect_error;
        }
            
        //store array of tags in database
        if(isset($tags)) {storeTags($tags, $cookbook_id, $link);}
            
        redirect($cookbook_id);

            
        mysqli_close($link);            //close connection
    }


    function getTags($tagsfromdb, $alltags_array)
    {
        foreach ( $alltags_array as $k => $v ) 
        {
            if (in_array($v, $tagsfromdb)) 
                $c[$k] = "checked='checked'";
            else 
                $c[$k] = "";
        }
        return $c;
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
            if(($current == null || $current == '') && $i <= $size-2)   //if empty field and there is more, skip
            {
                $i++;
                $current = $email[$i];
            }
            if(checkValidFriend($current, $link))       //if account exists, add as friend
            {
                $sql= "INSERT INTO  Friends (email, type, type_id)
                    VALUES ('$current', 'COOKBOOK', '$cookbook_id')";
                if ($link->query($sql) != true)     //unsuccessful query
                    header('Location: fail.php');
            }
            else
            {
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
    function redirect($cookbook_id)
    {
    	header('Location: view-cookbook.php?cookbook_id='. $cookbook_id );
    }
    
?>
<!DOCTYPE html>
<html>
	
	<head>
		<title>Edit Cookbook</title>
		 <meta charset="UTF-8">
		<meta name="description" content="A virtual cookbook that allows user's to view, create and share recipes.">
		<meta name="keywords" content="recipe, cookbook, food, ingredients">
		<meta name="author" content="Cookbook Network Inc.">
		<link rel="stylesheet" type="text/css" href="page_style.css">
		<link href='http://fonts.googleapis.com/css?family=Tangerine:700' rel='stylesheet' type='text/css'>
		<link href='http://fonts.googleapis.com/css?family=IM+Fell+Double+Pica' rel='stylesheet' type='text/css'>
	</head>
	
	<body>
		
		<div class="background-image"></div>
		
		<div class="navigation-bar">
			<?php include 'check-menu.php'; ?>
		</div>
		
		<div class="content">
			<h1 class="center">Edit Cookbook</h1>
            <!--<p><?php print_r($error); echo $privacy; echo $count; ?></p>-->
			<table class="tableform">
            <form name="createcbk" method="post" onsubmit="return validate()">
				<tr>
  					<td colspan="2" width="60%"> <h3>Name of Cookbook: </h3><br/></td>
  					<td colspan="2" width="30%"><input size="35" type="text" name="cookbookname" value="<?php echo $title ?>"><br/><br/></td>
  				</tr>
  				<tr>
  					<td colspan="2" width="20%"> <h3>Privacy: </h3><br/></td>
  					<td width="15%"><input type="radio" name="privacy" value="private" <?php if ($privacy === 'PRIVATE') echo 'checked="checked"'; ?> id="priv" onclick="javascript:isChecked();"/>Private<br/><br/></td>
  					<td width="15%"><input type="radio" name="privacy" value="registered" <?php if ($privacy === 'REGISTERED') echo 'checked="checked"'; ?> id="reg" onclick="javascript:isChecked();"/>Registered<br/><br/></td>
  					<td width="15%"><input type="radio" name="privacy" value="friendly" <?php if ($privacy === 'FRIENDLY') echo 'checked="checked"'; ?> id="friendlycheck" onclick="javascript:isChecked();"/>Friendly<br/><br/></td>
  					<td width="15%"><input type="radio" name="privacy" value="public" <?php if ($privacy === 'PUBLIC') echo 'checked="checked"'; ?> id="pub" onclick="javascript:isChecked();"/>Public<br/><br/></td>
  				</tr>
                
  				<tr>
                    <td colspan="2" width="60%"><div class="hidden" id="ifFriendly"><h3>Enter email of users to share: </h3></div></td>
                    <td colspan="2" width="30%">
                        <div class="hidden" id="ifFriendly2">
                            <div id="emailfield">
                                <!--TEXT BOX GOES HERE FOR FRIEND EMAILS -->
                            </div>
                        </div>
                    </td>
                    <td colspan="2"><a id="ifFriendly3" href="javascript:void(0);" class="addLink hidden" onclick="addEmailField();"><div class="button">+ Add More</div></a></td>
  				</tr>
  				<tr>
  					<td width="45%"> <h3>Tags for Cookbook:</h3></td>
  				</tr>
  				<tr>
  					<td><br/></td>
  					<td><br/></td>
  					<td><input type="checkbox" name="tags[]" value="appetizer" <?php echo $c[1]; ?>>Appetizer<br/></td>
  					<td><input type="checkbox" name="tags[]" value="paleo" <?php echo $c[2]; ?>>Paleo<br/></td>
  					<td><input type="checkbox" name="tags[]" value="american" <?php echo $c[3]; ?>>American<br/></td>
  				</tr>
  				<tr>
  					<td><br/></td>
  					<td><br/></td>
  					<td><input type="checkbox" name="tags[]" value="beef" <?php echo $c[4]; ?>>Beef<br/></td>
  					<td><input type="checkbox" name="tags[]" value="pork" <?php echo $c[5]; ?>>Pork<br/></td>
  					<td><input type="checkbox" name="tags[]" value="aasian" <?php echo $c[6]; ?>>Asian<br/></td>
  				</tr>
  				<tr>
  					<td><br/></td>
  					<td><br/></td>
  					<td><input type="checkbox" name="tags[]" value="beverages" <?php echo $c[7]; ?>>Beverages<br/></td>
  					<td><input type="checkbox" name="tags[]" value="poultry" <?php echo $c[8]; ?>>Poultry<br/></td>
  					<td><input type="checkbox" name="tags[]" value="desi" <?php echo $c[9]; ?>>Desi<br/></td>
  				</tr>
  				<tr>
  					<td><br/></td>
  					<td><br/></td>
  					<td><input type="checkbox" name="tags[]" value="breakfast/brunch" <?php echo $c[10]; ?>>Breakfast<br/></td>
  					<td><input type="checkbox" name="tags[]" value="salad" <?php echo $c[11]; ?>>Salad<br/></td>
  					<td><input type="checkbox" name="tags[]" value="greek" <?php echo $c[12]; ?>>Greek<br/></td>
  				</tr>
  				<tr>
  					<td><br/></td>
  					<td><br/></td>
  					<td><input type="checkbox" name="tags[]" value="chicken" <?php echo $c[13]; ?>>Chicken<br/></td>
  					<td><input type="checkbox" name="tags[]" value="seafood" <?php echo $c[14]; ?>>Seafood<br/></td>
  					<td><input type="checkbox" name="tags[]" value="italian" <?php echo $c[15]; ?>>Italian<br/></td>
  				</tr>
  				<tr>
  					<td><br/></td>
  					<td><br/></td>
  					<td><input type="checkbox" name="tags[]" value="desserts" <?php echo $c[16]; ?>>Desserts<br/></td>
  					<td><input type="checkbox" name="tags[]" value="soup" <?php echo $c[17]; ?>>Soup<br/></td>
  					<td><input type="checkbox" name="tags[]" value="jamaican" <?php echo $c[18]; ?>>Jamaican<br/></td>
  				</tr>
  				<tr>
  					<td><br/></td>
  					<td><br/></td>
  					<td><input type="checkbox" name="tags[]" value="gluten-free" <?php echo $c[19]; ?>>Gluten-free<br/></td>
  					<td><input type="checkbox" name="tags[]" value="vegan" <?php echo $c[20]; ?>>Vegan<br/></td>
  					<td><input type="checkbox" name="tags[]" value="latin" <?php echo $c[21]; ?>>Latin<br/></td>

  				</tr>
  				<tr>
  					<td><br/></td>
  					<td><br/></td>
  					<td><input type="checkbox" name="tags[]" value="lunch" <?php echo $c[22]; ?>>Lunch<br/></td>
  					<td><input type="checkbox" name="tags[]" value="vegetarian" <?php echo $c[23]; ?>>Vegetarian<br/></td>

  				</tr>
  				<br/>
  				<tr>
  					<td><br/><br/></td>
  					<td><br/><br/></td>
  					<td colspan="2"><br/><br/><br/><div class="submitbutton"><input type="submit" value="Save"/></div></td>
            <td colspan="2"><br/><br/><br/><div class="submitbutton"><input type="submit" value="Cancel" onclick="window.history.back(); return false;"></div></td>

  				</tr>
                </form>
			</table>

		</div>
        

        <script type="text/javascript">
            
            var privacy = "<?php echo $privacy; ?>";
            
            if  (privacy == "FRIENDLY")
            {
                var friends = <?php echo '["' . implode('", "', $allemails) . '"]' ?>;
                document.getElementById('ifFriendly').style.display = 'block';
                document.getElementById('ifFriendly2').style.display = 'block';
                document.getElementById('ifFriendly3').style.display = 'block';
                
                for (i = 0; i < friends.length; i++)
                {
                    displayFriendEmail(friends[i]);
                }
            }
            
            function validate() 
            {
                var cookbookname = document.forms["createcbk"]["cookbookname"].value;
                var checkboxes = document.getElementsByName('privacy');
                
                //Check for blank cookbook name
                if(isBlank(cookbookname))
                { 
                    alert("Fill in cookbook name.");
                    return false;
                }
                
                //check for at least one email is friendly checked
                if(document.getElementById('friendlycheck').checked)
                {
                    var emails = document.forms["createcbk"]["email[]"];
                    if(emails[0] == null || emails[0] == '')
                    {   
                        alert("Fill in at least one email.");
                        return false;
                    }
                }
                
                //check privacy is chosen
                var i = checkboxes.length - 1;

                for ( ; i >= 0 ; i-- ) 
                {
                    if ( checkboxes[i].checked )   
                        return true;
                }

                alert("Must choose a privacy.");
                return false;
                
            }
            
            function isChecked()
            {
                if(document.getElementById('friendlycheck').checked)
                {
                    document.getElementById('ifFriendly').style.display = 'block';
                    document.getElementById('ifFriendly2').style.display = 'block';
                    document.getElementById('ifFriendly3').style.display = 'block';
                }
                else
                {
                    document.getElementById('ifFriendly').style.display = 'none';
                    document.getElementById('ifFriendly2').style.display = 'none';
                    document.getElementById('ifFriendly3').style.display = 'none';
                }
            }
            
            function addEmailField()
            {
                var input = document.createElement('input'); 
                input.type = "text";
                input.name = "email[]";
                input.size = "35";
                
                var container = document.getElementById("emailfield");
                container.appendChild(input);
            }
            
            function displayFriendEmail(friendEmail)
            {
                var input = document.createElement('input'); 
                input.type = "text";
                input.name = "email[]";
                input.size = "35";
                input.value = friendEmail;
                
                var container = document.getElementById("emailfield");
                container.appendChild(input);
            }
            
            /*function addEmailField() 
            {
                var allEmails = document.getElementsByClassName("email");
                var lastEmail = allEmails[allEmails.length - 1];
                var clone = lastEmail.cloneNode(true);
                clone.class = "email";
                lastEmail.parentNode.appendChild(clone);
                fixEmailInputName();
            }
            
            //fixes the last added step's name
            function fixEmailInputName()
            {
                var allInputs = document.getElementsByClassName("email");
                var lastStepInput = allStepInputs[allStepInputs.length - 1];
                lastStepInput.name = "email[]";
            }*/
        </script>
            
		
		<div class="footer"><p>&#169; Cookbook Network, 2015. All Rights Reserved.</p></div>
		
	</body>
</html>