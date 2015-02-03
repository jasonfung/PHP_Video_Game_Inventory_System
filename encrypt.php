<?php

function encrypt($a) {
	$b = crypt($a,'$1$1p0rHF1b$');  
	return $b;
}

  $lines = file('/home/int322/secret/topsecret');
    $dbserver = trim($lines[0]);
    $uid = trim($lines[1]);
    $pw = trim($lines[2]);
    $dbname = trim($lines[3]);

//   Connect to the mysql server and get back our link_identifier
    $link = mysqli_connect($dbserver, $uid, $pw, $dbname)
              or die('Could not connect: ' . mysqli_error($link));

    $newpassword = encrypt('P@ssw0rd');

    $sql_query = 'UPDATE users SET password = "'.$newpassword.'" WHERE username = "jonathan@gmail.com"';

    $result = mysqli_query($link, $sql_query) or die('query failed'. mysqli_error($link));

?>