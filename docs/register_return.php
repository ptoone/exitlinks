<?php
// Start session
session_start();

ob_start();
require("defines/constants.inc"); // Constants
require("includes/functions.inc"); // Functions
require("includes/DbConn/libphp.DbConnect.0-1.inc"); // Database Connection Class
require("includes/query/libphp.MysqlQuery.0-1.inc"); // Query Class



// Check if submit is enabled, and $_POST[register_data] is true
 if( (isset($_POST['submit'])) and (isset($_POST['register_data']) == "DC(*@^i7dxc9w26er0@"))
 {
      // Store values, do checks
      /*
	  Html Field Value -> Required name for input tag
	  
	  eg. <input type="textbox" id="user_name" name="user_name" value ="" />
	  
	  User Name = user_name Must be between 
	  First Name = first_name
	  Last Name = last_name
	  Country = user_country
	  Email = user_email,user_email2     
	  password = user_password
	  paypal_email = user_paypal
      
	  
      */
      
      try
      {
       // START TRY
       
      $user_name = escape($_POST['user_name']);
      $first_name = escape($_POST['first_name']);
      $last_name = escape($_POST['last_name']);
      $country = escape($_POST['user_country']);
      $user_email = escape($_POST['user_email']);
      $user_email2 = escape($_POST['user_email2']);
      $password = $_POST['user_password'];
      $password2 = $_POST['user_password2'];
      $user_paypal = escape($_POST['user_paypal']);

      // Check for val and value
      if( (isset($_POST['__val_$option_242'])) and ($_POST['__val_$option_242'] == "983c(DAJD(@X)@@E287462") )
      {
	  $user_email2 = $user_email;
      }

      // Password check
      if( (isset($_POST['__val_$option_243'])) and ($_POST['__val_$option_243'] == "983c(DAJD(@X)@@E287462") )
      {
	  $password2 = $password;
      }

      // Check username for length and that it exists
      if( (strlen($user_name) < USERNAME_MIN_CHARACTERS) or (strlen($user_name) > USERNAME_MAX_CHARACTERS) )
      {
	  // Invalid user name, too long or short
	  header("Location: register.php?e=0");
      }
      
      // Check email for validity
      if( (!(eregi('^[a-zA-Z0-9._-]+@[a-zA-Z0-9-]+\.[a-zA-Z.]{2,5}$', $user_email)) ) )
      {
	  // Invalid email address
	  header("Location: register.php?e=1");
      }
 
      // Check paypal email for validity
      if( (!(eregi('^[a-zA-Z0-9._-]+@[a-zA-Z0-9-]+\.[a-zA-Z.]{2,5}$', $user_paypal)) ) )
      {
	  // Invalid email address
	  header("Location: register.php?e=2");
      }
      
      // Check Password
      if( (strlen($password) < PASSWORD_MIN_CHAR) or (strlen($password) > PASSWORD_MAX_CHAR) )
      {
	  // Invalid Password
	  header("Location: register.php?e=3");  
      }
      
      // Make sure email1 and email2 match
      if($user_email != $user_email2)
      {
	  // Email addresses do not match
	  header("Location: register.php?e=4");
      }
      
      // If passwords match
      if($password != $password2)
      {
	  // Passwords do not match
	  header("Location: register.php?e=5");
      }
      
      // hash password
      $password = md5($password);

      // Open connection to the database
      $conn = MysqlConnect::connect();
      MysqlConnect::db_use($conn, "testing_url4cash");
      
      // Open new instance of the query class
      $query = new MysqlQuery($conn);
      
      // Check for email already in DB
      $qmail = $query->ccount('url_users','user_email',true,"WHERE user_email = '{$user_email}'");

      // Check for errors
      if($qmail === -1)
      {
	  // Error, redirect
	  header("Location: register.php?e=8");
      }
      else if($qmail > 0)
      {
	  // User already exists
	  header("Location: register.php?e=9");
      }

      $qstr = "INSERT INTO url_users(user_name,first_name,last_name,user_email,user_paypal,user_password,country) VALUES('$user_name','$first_name','$last_name','$user_email','$user_paypal','$password','$country');";
      
      // Send query, check return value
      if( ($query->SendSingleQuery($qstr)) == -1)
      {
	  // Error happened 
	  header("Location: register.php?e=6");
      }
      else
      {
	  // All good
	  header("Location: register_message.html");
      }
      
      // END TRY
      }
      catch(Exception $e)
      {
	  header("Location: register.php?e=7");
      }
      
 }
 else
 {
      // Redirect to home page, as this page should not be accessed unless post session
      header("Location: index.php");
 }
 
 ob_end_flush();

 ?>