<?php

// Do not MODIFY THIS PHP CODE (Code between <?php and ? > )
session_start();
require('../defines/constants.inc');
require('../includes/session_admin.inc');

if(Session::validate() === 0)
{
    header("Location: index.php");
}

ob_start();

// If POST login attempt
if((isset($_POST['submit'])) and ($_POST['login_data'] === "DC(*@^i7dxc9w26er0@"))
{
    // Check to see if user name and password match
    if($_POST['user_name'] === "admin")
    {
	if($_POST['user_password'] === "password")
	{
	    // Set Session
	    if( (Session::start($qmail["id"])) == 0)
	    {
		// Session started, redirect to cpanel page
		header("Location: index.php");
	    }
	    else
	    {
		// error
		header("Location: login.php?e=2");
	    }
	    
	}
	else
	{
	    header("Location: login.php?e=1");
	    exit;
	}
    }
    else
    {
	header("Location: login.php?e=0");
	exit;
    }
}
// If error
else if(isset($_GET['e']))
{
    // Switch through error to check for code and match up
    switch($_GET['e'])
    {
	case "0":
	  // Invalid Email Address
	  $ERROR_REGISTER_MESSAGE = ADMIN_INVALID_USER;
	break;
	case "1":
	  // Invalid password
	  $ERROR_REGISTER_MESSAGE = ADMIN_INVALID_PASSWORD;		
	break;
	case "2":
	  // Database Error
	  $ERROR_REGISTER_MESSAGE = SESSION_SET_ERROR;
	break;
	default:
	  $ERROR_REGISTER_MESSAGE = "";
	break;
    
    
    }
}
ob_end_flush();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Administrator - Powered By ExitLinks - Converting Boring Links to Cash!</title>
<link rel="stylesheet" href="css/style.css" type="text/css" media="screen" />

</head>
<body>

<div id="header">
<h1><a href="index.php">Administrator</a></h1>
<h2>Powered by ExitLinks - Converting Boring Links to Cash!</h2>
</div>

<div id="accordian" ><!--Parent of the Accordion-->


<!--Start of each accordion item-->
  <div id="test-header" class="accordion_headings header_highlight" >Administrator Eyes Only</div><!--Heading of the accordion ( clicked to show n hide ) -->
  
  <!--Prefix of heading (the DIV above this) and content (the DIV below this) to be same... eg. foo-header & foo-content-->
  
  <div id="test-content"><!--DIV which show/hide on click of header-->
  
  	<!--This DIV is for inline styling like padding...-->
    <div class="accordion_child">
		<h2>ExitLinks Administrator Login Below:</h2>
<?php if(isset($ERROR_REGISTER_MESSAGE)) { echo $ERROR_REGISTER_MESSAGE; } ?>
<br />The login information has been provided as this is a <strong>DEMO</strong>. So enjoy!<br />
<form method="POST" action="login.php" enctype="multipart/form-data" id="login_form" name="login_form">
<input type="hidden" name="login_data" id="login_data" value="DC(*@^i7dxc9w26er0@" />
Username
<br /><input type="text" id="user_name" name="user_name" value="" />
<br /><br />
Password 
<br /><input type="password" id="user_password" name="user_password" value="" />
<br /><br />
<input type="submit" name="submit" id="submit" value="Login" />
</form>
	</div>
<blockquote><em>Success is how high you bounce when you hit bottom - George S. Patton</em></blockquote>
  </div>
<!--End of each accordion item--> 

<div id="footer">		
<!-- Please leave this line intact -->
<p>Powered By <a href="http://www.exitlinks.net">ExitLinks</a>. <br />
Official ExitLinks Store: <a href="http://www.scriptdorks.com">ScriptDorks</a> <br />
<!-- you can delete below here -->
&copy; ExitLinks. All Rights Reserved.</p>
</div>

</body>
</html>