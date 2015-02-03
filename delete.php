<?php

// Filename: delete.php
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

    require 'library.php';

	$db = new DBLink('int322'); // Connect to MySQL server with local host, mysql_user, mysql_password and database name
    
    $deleted = $_GET['deleted'];        // Receive the value of deleted through GET method from view.php and store it in $deleted
    
    if ($deleted == "n")                // Update the "deleted" column on the MYSQL inventory table 
    {
    	$sql_query = "UPDATE inventory set deleted = 'y' WHERE id = '".$_GET['id']."'";  
    }
    else 
    {
    	$sql_query = "UPDATE inventory set deleted = 'n' WHERE id = '".$_GET['id']."'";
    }

    $result = $db->query($sql_query);

  	header("Location: view.php");    // Pass the SQL statement stored in $sql_query to view.php
?>