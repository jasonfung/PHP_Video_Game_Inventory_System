<?php

// Filename: add.php
// Course: INT322
// Section: A
// Student Name: Ka Yee Jason Fung
// Instructor: Robert Boyczuk
// Date Submitted: Feb 20, 2014 
//
// This is a web-based inventory management system video game website that allows an user to store information into a MYSQL database.  
// It also allows an user to delete/restore information from the MYSQL database
//
// Student Declaration
//
// I/we declare that the attached assignment is my/our own work in accordance with Seneca Academic Policy. No part of this assignment has been copied manually or electronically from any other source (including web sites) or distributed to other students.
//
// Name: Ka Yee Jason Fung
//
// Student ID: 051640126

	session_start();

	require 'library.php';

	css();

	$valid = True;

	if ( $_POST ) 
	{
		if (!(preg_match("/^\s*[0-9A-Za-z,':;\-]([0-9A-Za-z,':;\-]|\s)*\s*$/", $_POST['itemName'])))   // validate the Item Name field
		{ 
			$valid = false;
		}
		if (!(preg_match("/^\s*[0-9A-Za-z,'\-\.]([0-9A-Za-z\-,'\-\.]|\s|\n)*\s*$/", $_POST['description'])))  // validate the Description field
		{
			$valid = false;
		}
		if (!(preg_match("/^\s*[0-9A-Za-z\-]([0-9A-Za-z\-]*|\s*)*\s*$/", $_POST['supplierCode'])))  // validate the Supplier Code field
		{	
			$valid = false;
		}
		if (!(preg_match("/^\s*[0-9]+.[0-9]{2}\s*$/", $_POST['cost'])))    // validate the Cost field
		{	
			$valid = false;
		}
		if (!(preg_match("/^\s*[0-9]+.[0-9]{2}\s*$/", $_POST['price'])))   // validate the Price field
		{	
			$valid = false;
		}
		if (!(preg_match("/^\s*[0-9]+\s*$/", $_POST['onHand'])))           // validate the Number On Hand field
		{	
			$valid = false;
		}
		if (!(preg_match("/^\s*[0-9]+\s*$/", $_POST['reorderPoint'])))     // validate the Reorder Point field
		{
			$valid = false;
		}

		if ( $valid ) 
		{ 
			$itemName =  trim($_POST['itemName']);
			$description = trim($_POST['description']);
			$supplierCode = trim($_POST['supplierCode']);
			$cost = trim($_POST['cost']);
			$price = trim($_POST['price']);
			$onHand = trim($_POST['onHand']);
			$reorderPoint = trim($_POST['reorderPoint']);
			$deleted = "n";

			if ((!isset($_POST['backOrder']))) 
			{
				$backOrder = "n";
			}		
			else 
			{
				$backOrder = $_POST['backOrder'];
			}

			$db = new DBLink('int322');

			if (isset($_POST['itemID'])) {
			$result = $db->query('UPDATE inventory set itemName="' . $itemName . '", description="' . $description . '", supplierCode="' . $supplierCode . '", cost="' . $cost . '", price="' . $price . '", onHand="' . $onHand . '", reorderPoint="' . $reorderPoint . '", backOrder="' . $backOrder . '", deleted="' . $deleted . '" WHERE id ="'.$_POST['itemID'].'"');
			}
			else {
			$result = $db->query('INSERT INTO inventory set itemName="' . $itemName . '", description="' . $description . '", supplierCode="' . $supplierCode . '", cost="' . $cost . '", price="' . $price . '", onHand="' . $onHand . '", reorderPoint="' . $reorderPoint . '", backOrder="' . $backOrder . '", deleted="' . $deleted . '"');
			}

			header("Location: view.php");
		}
	}

	if (!$valid ||  !$_POST)   // if not valid or not post then display web form again - otherwise, don't!
	{         
?>
<html>
	<head>
		<title>
			<?php showtitle(); ?> 
		</title>
	</head>
	<body>
		<h1> <?php showheader(); ?> </h1>
		<img src="vg.jpg" alt="Video Game" width="150" height="150">
		<br><br>
		<div class="one">
			<?php 
				showmenu(); 
				sessionstart();
			?>
		</div> 
		<div class="disclaimer">
			All fields mandatory except "On Back Order" 
		</div>

		<form method="POST" action="">
			<table>
				<?php if (isset($_GET['edit'])) {
				?>
				<tr>
					<td class ="field">Item ID</td>
					<td><input name="itemID" type="text" value="<?php if (isset($_GET['edit'])) echo $_GET['edit'];?>" readonly></td>
				</tr>
				<?php
				}
				?>
				<tr>
    				<td class="field">Item Name:</td>
					<td><input name="itemName" type="text" value="<?php if (isset($_POST['submit'])) echo htmlentities($_POST['itemName']); else if (isset($_GET['edit'])) echo edit('itemName', $_GET['edit']);?>"></td>
					<td class="error">   
						<?php if ($_POST) 
						{
							if (!(preg_match("/^\s*[0-9A-Za-z,':;\-]([0-9A-Za-z,':;\-]|\s)*\s*$/", $_POST['itemName']))) 
							{
								echo "Invalid Item Name, please enter letters, spaces, colon, semi-colon, dash, comma, apostrophe and numeric character (0-9) only - cannot be blank.";
							} 
						}
						?>   
					</td>
				</tr>
				<tr>
    				<td class="field">Description:</td>
					<td><textarea name='description' rows="6" cols="23"><?php if (isset($_POST['submit'])) echo htmlentities($_POST['description']); else if (isset($_GET['edit'])) echo edit('description', $_GET['edit']);?></textarea></td>
					<td class="error">  
						<?php if ($_POST) 
						{
							if (!(preg_match("/^\s*[0-9A-Za-z,'\-\.]([0-9A-Za-z\-,'\-\.]|\s|\n)*\s*$/", $_POST['description']))) 
							{
								echo "Invalid Description, please enter letters, digits, periods, commas, apostrophes, dashes and spaces only - cannot be blank.";
							} 
						}
						?>  
					</td>
				</tr>
				<tr>
    				<td class="field">Supplier Code:</td>
					<td><input name="supplierCode" type="text" value="<?php if (isset($_POST['submit'])) echo htmlentities($_POST['supplierCode']); else if (isset($_GET['edit'])) echo edit('supplierCode', $_GET['edit']); ?>"></td>
    				<td class="error">  
    					<?php if ($_POST) 
    					{
							if (!(preg_match("/^\s*[0-9A-Za-z\-]([0-9A-Za-z\-]*|\s*)*\s*$/", $_POST['supplierCode']))) 
							{
								echo "Invalid Supplier Code, please enter letters, spaces, numeric characters (0-9) and dashes only - cannot be blank.";
							} 
						}
						?>  
					</td>
				</tr>
				<tr>	
    				<td class="field">Cost:</td>
					<td><input name="cost" type="text" value="<?php if (isset($_POST['submit'])) echo htmlentities($_POST['cost']); else if (isset($_GET['edit'])) echo edit('cost', $_GET['edit']);?>"></td>
					<td class="error"> 
						 <?php if ($_POST) 
						 {
							if (!(preg_match("/^\s*[0-9]+.[0-9]{2}\s*$/", $_POST['cost']))) 
							{
								echo "Invalid Cost, please enter monetary amounts only i.e. one or more digits, then a period, then two digits - cannot be blank.";
							} 
						}
						?>  
					</td>
				</tr>
				<tr>
    				<td class="field">Selling Price:</td>
					<td><input name="price" type="text" value="<?php if (isset($_POST['submit'])) echo htmlentities($_POST['price']); else if (isset($_GET['edit'])) echo edit('price', $_GET['edit']);?>"></td>
					<td class="error">  
						<?php if ($_POST) 
						{
							if (!(preg_match("/^\s*[0-9]+.[0-9]{2}\s*$/", $_POST['price']))) 
							{
								echo "Invalid Price, please enter monetary amounts only i.e. one or more digits, then a period, then two digits - cannot be blank.";
							} 
						}
						?>   
					</td>
				</tr>
				<tr>
    				<td class="field">Number on hand:</td>
					<td><input name="onHand" type="text" value="<?php if (isset($_POST['submit'])) echo htmlentities($_POST['onHand']); else if (isset($_GET['edit'])) echo edit('onHand', $_GET['edit']);?>"></td>
					<td class="error">  
						<?php if ($_POST) 
						{
							if (!(preg_match("/^\s*[0-9]+\s*$/", $_POST['onHand']))) 
							{
								echo "Invalid Number on hand, please enter digits only - cannot be blank.";
							} 
						}
						?>   
					</td>
				</tr>
				<tr>
    				<td class="field">Reorder Point:</td>
					<td><input name="reorderPoint" type="text" value="<?php if (isset($_POST['submit'])) echo htmlentities($_POST['reorderPoint']); else if (isset($_GET['edit'])) echo edit('reorderPoint', $_GET['edit']);?>"></td>
					<td class="error">  
						<?php if ($_POST) 
						{
							if (!(preg_match("/^\s*[0-9]+\s*$/", $_POST['reorderPoint']))) 
							{
								echo "Invalid Reorder Point, please enter digits only - cannot be blank.";
							} 
						}
						?>   
					</td>
				</tr>
				<tr>
    				<td class="field">On Back Order:</td>
					<td><input name="backOrder" type="checkbox" value="y" <?php if (isset($_POST['backOrder']) && ($_POST['backOrder']) == 'y') echo 'checked'; else if (isset($_GET['edit'])) echo edit('backOrder', $_GET['edit']); ?>></td>
				</tr>
				<tr>
					<td class="field"><input name="submit" type="submit" value="Submit"></td>
					<td></td>
				</tr>
			</table>
			<div class="disclaimer"> <?php showfooter(); ?> </div>
		</form>
	<?php
	}
	?> 
	</body>
</html>