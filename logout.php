<?php
session_start();

if(isset($_SESSION['username'])){
// unset($_SESSION['username']);
setcookie("sortPreference", "", time() - (3600*24*30));
// Finally, destroy the session.
session_destroy();
}
header('Location:login.php');
?>