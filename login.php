<?php
// Example of DB APPEND and SELECT
// You must create a table called registrant that has two columns of varchar(30) each.

// For debugging purposes
// print_r($_POST);

session_start();

if(!$_SERVER["HTTPS"]) {
   header("Location: https://". $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
}

require 'library.php';

$usernameErr = "";
$valid = True;
if ($_POST) {
// process form - add to DB and then print out all records
    // get database servername, username, password, and database name
            //  from local file not on web accessible path (remove newline/blanks)
    if ($valid) {

    $db = new DBLink('int322');

    $username = htmlentities($_POST['username']);
    $password = htmlentities($_POST['password']);
    $newpassword = encrypt($password);

    $result = $db->query('SELECT * FROM users WHERE username="' . $username . '" AND password="' . $newpassword . '"');

    $valid = false;
    $row = mysqli_fetch_assoc($result);
      if ($row) 
      {
        $valid = True;
        $_SESSION['username'] = $username;
        $_SESSION['role'] = $row['role'];
        header("Location: view.php");
      }
      else 
      {
        $usernameErr = 'You must enter a valid username and password';
      }
      
      // Free resultset (optional)
    mysqli_free_result($result);
  
  }
}
if (isset($_GET['forgotpassword'])) {
?>
<html>
<body>
<form method="POST" action="">
Enter your e-mail: <input type="text" name="email" value="<?php if (isset($_POST['email'])) print $_POST['email']; ?>">
<br>
<input type="submit" name="submit">
</form>
</body>
</html>
<?php
if ( $_POST ) {
// process form - add to DB and then print out all records
    // get database servername, username, password, and database name
            //  from local file not on web accessible path (remove newline/blanks

    $db = new DBLink('int322');
  
    $email = $_POST['email'];

    $result = $db->query('SELECT * FROM users WHERE username="' . $email . '"');

    $row = mysqli_fetch_assoc($result);
      if ($row) 
      {
        mail(
          "int322@localhost", 
          "Your Recovery Password", 
          "Your username is $row[username] , Your recovery hint is $row[passwordHint]",
          "From: Admin <admin@domain.tld>\r\nReply-to: Admin <admin@domain.tld>" 
        );
      }
    mysqli_free_result($result);
     
    header("Location: login.php");
      // Free resultset (optional)
    
  }
}

// if not valid or not post then display web form again - otherwise, don't!
else if (!$valid || !$_POST) {
?>
<html>
<body>
<form method="POST" action="">
Enter Username: <input type="text" name="username" value=""><strong><?php print $usernameErr; ?></strong>
<br>
Enter Password: <input type="password" name="password" value="">
<br>
<a href="login.php?forgotpassword">Forgot your password? </a> 
<?php
if (isset($_SESSION['username'])) {
 header("Location: view.php");
}
?>
<input type="submit" name="submit">
</form>
<?php
}
?>
</body>
</html>