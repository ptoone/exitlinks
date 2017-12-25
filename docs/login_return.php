<?php
// login.php on submit goes here

// Start session
session_start();

ob_start();
require("defines/constants.inc"); // Constants
require("includes/functions.inc"); // Functions
require("includes/DbConn/libphp.DbConnect.0-1.inc"); // Database Connection Class
require("includes/query/libphp.MysqlQuery.0-1.inc"); // Query Class
require("includes/session.inc"); // Session management class



// Check if submit is enabled, and $_POST[register_data] is true
if( (isset($_POST['submit'])) and (isset($_POST['login_data']) == "DC(*@^i7dxc9w26er0@"))
{
      /*
	  Html Field Value -> Required name for input tag
	  
	  eg. <input type="textbox" id="user_name" name="user_name" value ="" />
	  
	  Email Address = user_email
	  Password = user_password
	  Login Button = submit
	  
      */
      
      try
      {
      
      $user_email = escape($_POST['user_email']);
      $password = $_POST['user_password'];
      
      // Check email address for validity      
      if( (!(eregi('^[a-zA-Z0-9._-]+@[a-zA-Z0-9-]+\.[a-zA-Z.]{2,5}$', $user_email)) ) )
      {
	  // Invalid email address
	  header("Location: login.php?e=0");
      }
          
      // If password is invalid
      if((strlen($password) < PASSWORD_MIN_CHAR) or (strlen($password) > PASSWORD_MAX_CHAR))
      {
	  // Invalid password
	   header("Location: login.php?e=1");
      }
      
      $password = md5($password);
      
      // Connect to mysql database
       $conn = MysqlConnect::connect();
      MysqlConnect::db_use($conn, "testing_url4cash");
      
      // Open new instance of the query class
      $query = new MysqlQuery($conn);
      
      // Check for email already in DB
      $qmail = $query->GetSingleQuery('--SINGLE',"SELECT user_name,user_email,user_password,id FROM url_users WHERE user_email = '{$user_email}';",array("user_name","user_email","user_password","id"));
      
      // Check for errors
      if($qmail < 0)
      {
	  // Error, redirect
	  header("Location: login.php?e=2");
      }
      else if($qmail["user_email"] == "")
      {
	  // User does not exist
	  header("Location: login.php?e=3");
      }
      
      // Check for match
      if(strcmp($password,$qmail["user_password"]) == 0)
      {
	  // All good, start session, redirect
	  if( (Session::start($qmail["id"],$qmail["user_name"])) == 0)
	  {
	      // Session started, redirect to cpanel page
	      header("Location: cpanel/index.php");
	  }
	  else
	  {
	      // Error setting session
	      header("Location: login.php?e=5");
	  }
	  
      }
      else
      {
	  // Password error - incorrect password
	  header("Location: login.php?e=4");
	  
      }
     
      }
      catch(Exception $e)
      {
	  header("Location: login.php?e=6");
      }
      


}
else
{
     // Redirect to home page, as this page should not be accessed unless post session
     header("Location: login.php");
}
 
ob_end_flush();


?>
