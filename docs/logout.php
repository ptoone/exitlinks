<?php
// Logout Script
session_start(); // Start session

// Check to see if the _GET parameter is for logout
if(isset($_GET['c']) and ($_GET['c'] == "true"))
{
    // Destroy Session, redirect to login page
    session_destroy();
    header("Location: index.php");
}

?>


<!--
    LOGOUT PAGE
     
    Button can go here that when clicked goes to the url 
    logout.php?c=true
    
    Or simply have any logout links link to 
    logout.php?c=true
    instead of
    logout.php
    
    
-->

Are you sure you want to logout?
<br />
<br />
<a href="logout.php?c=true">Logout Now</a>