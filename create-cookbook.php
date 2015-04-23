<?php 
    session_start(); 
    $user_id = $_SESSION['userid'];
    include 'create-cookbook-form.php';
?>
<!DOCTYPE html>
<html>
	
	<head>
		<title>Create Cookbook</title>
		 <meta charset="UTF-8">
		<meta name="description" content="A virtual cookbook that allows user's to view, create and share recipes.">
		<meta name="keywords" content="recipe, cookbook, food, ingredients">
		<meta name="author" content="Cookbook Network Inc.">
		<link rel="stylesheet" type="text/css" href="page_style.css">
		<link href='http://fonts.googleapis.com/css?family=Tangerine:700' rel='stylesheet' type='text/css'>
		<link href='http://fonts.googleapis.com/css?family=IM+Fell+Double+Pica' rel='stylesheet' type='text/css'>
	</head>
	
	<body>
		
		<img class="background-image" src="images/loaf-delicious-cake-with-strawberries-wallpapers-1440x900.jpg" height="700"/>
		
		<div class="navigation-bar">
			<?php include 'check-menu.php' ;?>
		</div>
		
		<div class="content">
			<h1 class="center">Create Cookbook</h1>
			 <form name="createcbk" method="post" onsubmit="return validate();">
            <table class="tableform">
				<tr>
  					<td colspan="2" width="60%"> <h3>Name of Cookbook: </h3><br/></td>
  					<td colspan="2" width="30%"><input size="35" type="text" name="cookbookname"><br/><br/></td>
  				</tr>
  				<tr>
  					<td colspan="2" width="20%"> <h3>Privacy: </h3><br/></td>
  					<td width="15%"><input type="radio" name="privacy" value="private" id="priv" onclick="javascript:isChecked();"/>Private<br/><br/></td>
  					<td width="15%"><input type="radio" name="privacy" value="registered" id="reg" onclick="javascript:isChecked();"/>Registered<br/><br/></td>
  					<td width="15%"><input type="radio" name="privacy" value="friendly" id="friendlycheck" onclick="javascript:isChecked();"/>Friendly<br/><br/></td>
  					<td width="15%"><input type="radio" name="privacy" value="public" id="pub" onclick="javascript:isChecked();"/>Public<br/><br/></td>
  				</tr>
                
  				<tr>
                    <td colspan="2" width="60%"><div class="hidden" id="ifFriendly"><h3>Enter email of users to share: </h3></div></td>
                    <td colspan="2" width="30%">
                        <div class="hidden" id="ifFriendly2">
                            <div id="emailfield">
                                <input type="text" size="35" name="email[]">
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
  					<td><input type="checkbox" name="tags[]" value="appetizer">Appetizer<br/></td>
  					<td><input type="checkbox" name="tags[]" value="paleo">Paleo<br/></td>
  					<td><input type="checkbox" name="tags[]" value="american">American<br/></td>
  				</tr>
  				<tr>
  					<td><br/></td>
  					<td><br/></td>
  					<td><input type="checkbox" name="tags[]" value="beef">Beef<br/></td>
  					<td><input type="checkbox" name="tags[]" value="pork">Pork<br/></td>
  					<td><input type="checkbox" name="tags[]" value="aasian">Asian<br/></td>
  				</tr>
  				<tr>
  					<td><br/></td>
  					<td><br/></td>
  					<td><input type="checkbox" name="tags[]" value="beverages">Beverages<br/></td>
  					<td><input type="checkbox" name="tags[]" value="poultry">Poultry<br/></td>
  					<td><input type="checkbox" name="tags[]" value="desi">Desi<br/></td>
  				</tr>
  				<tr>
  					<td><br/></td>
  					<td><br/></td>
  					<td><input type="checkbox" name="tags[]" value="breakfast">Breakfast<br/></td>
  					<td><input type="checkbox" name="tags[]" value="salad">Salad<br/></td>
  					<td><input type="checkbox" name="tags[]" value="greek">Greek<br/></td>
  				</tr>
  				<tr>
  					<td><br/></td>
  					<td><br/></td>
  					<td><input type="checkbox" name="tags[]" value="chicken">Chicken<br/></td>
  					<td><input type="checkbox" name="tags[]" value="seafood">Seafood<br/></td>
  					<td><input type="checkbox" name="tags[]" value="italian">Italian<br/></td>
  				</tr>
  				<tr>
  					<td><br/></td>
  					<td><br/></td>
  					<td><input type="checkbox" name="tags[]" value="desserts">Desserts<br/></td>
  					<td><input type="checkbox" name="tags[]" value="soup">Soup<br/></td>
  					<td><input type="checkbox" name="tags[]" value="jamaican">Jamaican<br/></td>
  				</tr>
  				<tr>
  					<td><br/></td>
  					<td><br/></td>
  					<td><input type="checkbox" name="tags[]" value="gluten-free">Gluten-free<br/></td>
  					<td><input type="checkbox" name="tags[]" value="vegan">Vegan<br/></td>
  					<td><input type="checkbox" name="tags[]" value="latin">Latin<br/></td>

  				</tr>
  				<tr>
  					<td><br/></td>
  					<td><br/></td>
  					<td><input type="checkbox" name="tags[]" value="lunch">Lunch<br/></td>
  					<td><input type="checkbox" name="tags[]" value="vegetarian">Vegetarian<br/></td>

  				</tr>
  				<br/>
  				<tr>
  					<td><br/><br/></td>
  					<td><br/><br/></td>
  					<td colspan="2"><br/><br/><br/><div class="submitbutton"><input type="submit" value="Create"/></div></td>
            <td colspan="2"><br/><br/><br/><div class="submitbutton"><input type="submit" value="Cancel" onclick="window.history.back(); return false;"></div></td>

  				</tr>
			</table>
            </form>
		</div>
        

        <script type="text/javascript">
            
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
                    var emails = document.forms["createcbk"]["email"];
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
            
            function isBlank(field)
            {
                return (field == null || field == '');

            }
        </script>
            
		
		<div class="footer"><p>&#169; Cookbook Network, 2015. All Rights Reserved.</p></div>
		
	</body>
</html>