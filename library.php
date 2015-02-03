<?php

// Filename: library.php
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

function showtitle() {
	echo "Jason Fung's Video Games Store";
}

function showheader() {
	echo "Jason Fung's Video Games Store";
}

function showmenu() {
?>
<a href="add.php" class="left-align"> Add </a>&nbsp;&nbsp;   
<a href="view.php" class="left-align"> View All</a>   
<?php
}

function showfooter() {
	echo "Copyright @ 2014 Jason Fung Inc.";
}

class DBLink {
    private $link;
    private $result;
    
    public 
    function __construct($database_name) {
        $lines = file('/home/int322/secret/topsecret');
        $dbserver = trim($lines[0]);
        $uid = trim($lines[1]);
        $pw = trim($lines[2]);
        $dbname = trim($database_name);
       

        $link = mysqli_connect ($dbserver, $uid, $pw, $dbname) or die('Could not connect: ' . mysqli_error($link));
        $this->link = $link;
    }

    public
    function query($sql_query) {
    
        $result = mysqli_query ($this->link, $sql_query) or die('Query Failed' . mysqli_error($this->link));
    
        $this->result = $result;
        return $result;
    }

    public
	function emptyResult() {
        if(!(mysqli_num_rows($this->result))) {
            return true;
        }
        else{
            return false;
        }
    }
	
//	public
//	function linkname() {
//	return $this->link;
//	}

	public
	function __destruct() {
        mysqli_close ($this -> link);
    }
}


 

function encrypt($a) {
  $b = crypt($a,'$1$1p0rHF1b$');  
  return $b;
}

function sessionstart() {
	if(isset($_SESSION['username']))
	{
	?>
	<a href="logout.php" class="right-align">Click here to logout</a> 
	<span class="right-align"> 
		<?php
		echo "User: "; 
		echo $_SESSION['username'];
		?>
	</span>
	<span class="right-align"> 
		<?php
		echo "Role: "; 
		echo $_SESSION['role'];
		?>
	</span>
	<span class ="left-align">
	<form method="POST" action ="view.php">
		Search in description:
		<input type ="text" name='desc' value="<?php if (isset($_POST['desc'])) echo htmlentities($_POST['desc']); ?>"></input>
		<input type="submit" value='submit'>
	</form>
	</span>
<?php
	}
	else {
		header('Location:login.php');
	}
}

function edit($fieldname, $id) {
	$db = new DBLink('int322');
	$result = $db->query("SELECT $fieldname from inventory WHERE id = $id");
	while($row = mysqli_fetch_assoc($result)) {
		$output = htmlentities($row[$fieldname]);
	}
	if ($output == 'y') {
		$output = 'checked';
	}
	return $output;
}


function css() {
?>
<style>
div.one
{
	border: 2px solid orange;              /* Make the div one border in orange colour and border 2 px */
	padding: 15px;
}

div.disclaimer
{
	padding-top: 20px;                     /* Make the div disclaimer to have a padding of 20 px around it except the left. Set font size to 12 px */
	padding-bottom: 20px;
	padding-right: 20x;
	font-size: 12px;
}

td.field
{
	text-align: right;                     /* Align text to the right in the first column of the form */
}

tr.firstrow
{
	background-color: orange;              /* Set background color of table header to orange */
}

td.restofrow
{
	text-align: center;                    /* Align text to center for each row */
}
.left-align {
	float : left;
	margin : 0px 24px;

}

.right-align {
	float : right;
	margin : 0px 24px;

}
td.error
{
	color: red;                            /* Make the error texts in red colour */
}
</style>
<?php 
}
?>
