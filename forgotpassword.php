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
require 'library.php';

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
?>


