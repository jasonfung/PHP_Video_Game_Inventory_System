<?php

// Filename: view.php
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
		
	$db = new DBLink('int322');

	$sort = "id";
	$desc = "";

	if (isset($_COOKIE['sortPreference'])) {
		$sort = $_COOKIE['sortPreference'];
	}

	if (isset($_GET['sort'])) {  
	$sort = $_GET['sort'];
	}

	setcookie("sortPreference", $sort, time()+(3600*24*30));
	// echo $_COOKIE["sortPreference"];

	if (isset($_POST['desc'])) {
		$_SESSION['desc'] = $_POST['desc'];
		$desc = strtoupper($_POST['desc']);
		$result = $db->query("SELECT * from inventory WHERE upper(description) LIKE '%$desc%' ORDER BY $sort");			
	}	
	
	else if (isset($_SESSION['desc']) && isset($_GET['sort'])) {    
		$desc = $_SESSION['desc'];
		$result = $db->query("SELECT * from inventory WHERE upper(description) LIKE '%$desc%' ORDER BY $sort");
	}

	else {
		$result = $db->query("SELECT * from inventory ORDER BY $sort");
		unset($_SESSION['desc']);
	}
?>

<html>
	<head>
	 	<title>Jason Fung's Video Games Store View Page</title>
	</head>
	<body>
		<h1>Jason Fung's Video Games Store</h1>
		<img src="vg.jpg" alt="Video Game" width="150" height="150">
		<br><br>
		<div class="one">
			<?php 
				showmenu(); 
				sessionstart();
			?>
		</div> 
		<br><br>
		<table class="one" border="1">
			<tr class="firstrow">
				<th><a href=view.php?sort=id>ID</a></th>
				<th><a href=view.php?sort=itemName>Item Name</a></th>
				<th><a href=view.php?sort=description>Description</a></th>
				<th><a href=view.php?sort=supplierCode>Supplier</a></th>
				<th><a href=view.php?sort=cost>Cost</a></th>
				<th><a href=view.php?sort=price>Price</a></th>
				<th><a href=view.php?sort=onHand>Number On Hand</a></th>
				<th><a href=view.php?sort=reorderPoint>Reorder Level</a></th>
				<th><a href=view.php?sort=backOrder>On Back Order?</a></th><th><a href=view.php?sort=deleted>Delete/Restore</a></th>
			</tr>
			<?php	
 				while($row = mysqli_fetch_assoc($result))                                // Fetch associative array of $result
 				{
			?>
			<tr>                                                                   
				<td class="restofrow"><a href=add.php?edit=<?php echo $row['id'];?>><?php print $row['id']; ?></a></td>                    <?php // Print Id stored in the inventory table ?>
				<td class="restofrow"><?php print $row['itemName']; ?></td>              <?php // Print Item Name stored in the inventory table ?>
				<td class="restofrow"><?php print $row['description']; ?></td>           <?php // Print Description stored in the inventory table ?>
				<td class="restofrow"><?php print $row['supplierCode']; ?></td>          <?php // Print Supplier Code stored in the inventory table ?>
				<td class="restofrow"><?php print $row['cost']; ?></td>                  <?php // Print Cost stored in the inventory table ?>
				<td class="restofrow"><?php print $row['price']; ?></td>                 <?php // Print Price stored in the inventory table ?>
				<td class="restofrow"><?php print $row['onHand']; ?></td>                <?php // Print Number On Hand stored in the inventory table ?>
				<td class="restofrow"><?php print $row['reorderPoint']; ?></td>          <?php // Print Reorder Level stored in the inventory table ?>
				<td class="restofrow"><?php print $row['backOrder']; ?></td>             <?php // Print Back Order stored in the inventory table ?>
				<td class="restofrow">                                                          
					<a href="delete.php?id=<?php echo $row['id']; ?>&amp;deleted=<?php echo $row['deleted']; ?>"><?php if ($row['deleted'] == "n") print "Delete"; ?></a>   <?php // Print Delete/Restore Button ?> 
					<a href="delete.php?id=<?php echo $row['id']; ?>&amp;deleted=<?php echo $row['deleted']; ?>"><?php if ($row['deleted'] == "y") print "Restore"; ?></a>  
				</td>
			</tr>
			<?php
 			}
			?>
		</table>
		<p> <?php if ($db->emptyResult()) echo "No record is found."; ?> </p>
		<br>
	</body>
</html>

<?php
		mysqli_free_result($result);             // Free resultset (optional)
?>