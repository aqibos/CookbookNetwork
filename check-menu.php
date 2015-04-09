<?php 
	//if a user has logged in
	if(isset($_SESSION['loggedin']))
	{
		//if admin, display admin menu
		if ($_SESSION['isAdmin']==1) 
		{
			print 
				'<table  class="navigation-bar-table">
					<tr>
						<td class="navigation-bar-table-left"><h1 class="navigation-bar-table-left-header">Cookbook Network</h1></td>
						<td class="navigation-bar-table-right">
							<ul class="upper-level-ul">
								<li>Search
									<ul>
										<li><a href="">Search Recipe</a></li>
										<li><a href="">Search Cookbook</a></li>
										<li><a href="">Search Accounts</a></li>
									</ul>
								</li>
								
								<li>Recipe
									<ul>
										<li><a href="">Create Recipe</a></li>
										<li><a href="">View myRecipes</a></li>
										<li><a href="">View Flags</a></li>
									</ul>
								</li>
								
								<li>Cookbook
									<ul>
										<li><a href="">Create Cookbook</a></li>
										<li><a href="">View myCookbooks</a></li>
									</ul>
								</li>
								
								<li>'. $_SESSION['username']. '
									<ul>
										<li><a href="">Account Info</a></li>
										<li><a href="">View All Accounts</a></li>
										<li><a href="">Delete User</a></li>
										<li><a href="">Log Out</a></li>
									</ul>
								</li>
							</ul>
						</td>
					</tr>
				</table>';
		}
		else if ($_SESSION['isAdmin']==0)	//not an admin, display registered menu
		{
			print 
				'<table  class="navigation-bar-table">
					<tr>
						<td class="navigation-bar-table-left"><h1 class="navigation-bar-table-left-header">Cookbook Network</h1></td>
						<td class="navigation-bar-table-right">
						<ul class="upper-level-ul">
	              			<li>Search
	                			<ul>
	                				<li><a href="">Search Recipe</a></li>
	                	  			<li><a href="">Search Cookbook</a></li>
	                			</ul>
	              			</li>
	              
	              			<li>Recipe
	                			<ul>
	                  				<li><a href="">Create Recipe</a></li>
	                  				<li><a href="">View myRecipes</a></li>
	                			</ul>
	              			</li>
	              
	              			<li>Cookbook
	                			<ul>
	                  				<li><a href="">Create Cookbook</a></li>
	                  				<li><a href="">View myCookbooks</a></li>
	                			</ul>
	              			</li>
	              
	              			<li>'. $_SESSION['username']. '
	                			<ul>
	                  				<li><a href="">Account Info</a></li>
	                  				<li><a href="">Log Out</a></li>
	                			</ul>
	              			</li>
	           			</ul>
	           		</td>
				</tr>
			</table>';
		}
	}
	else			//not logged in, display guest menu
	{	
		print '<table  class="navigation-bar-table">
				<tr>
					<td class="navigation-bar-table-left"><h1 class="navigation-bar-table-left-header">Cookbook Network</h1></td>
					<td class="navigation-bar-table-right">
						<ul class="upper-level-ul">		
							<li><a href="signup.php">Search Recipe</a></li>
							<li><a href="signup.php">Search Cookbook</a></li>
							<li><a href="signup.php">Log In</a></li>
							<li><a href="signup.php">Sign Up</a></li>
								
							
						</ul>
						
					</td>
				</tr>
			</table>';
	}
?>
