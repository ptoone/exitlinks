<?php
// If ADD_URL is in add mode...
session_start();
ob_start();
// Include libraries
require('../defines/constants.inc');
require('../includes/session.inc');
require('../includes/functions.inc');
require("../includes/DbConn/libphp.DbConnect.0-1.inc"); // Database Connection Class
require("../includes/query/libphp.MysqlQuery.0-1.inc"); // Query Class

if(Session::validate() !== 0)
{
    header("Location: ../login.php");
}



// If add flag is set
if( (isset($_POST['change_password'])) and ( ($_POST['edit_info'] == '83hffZ#97^@dIUD7s') ) )
{
    // Try / Catch
    try
    {
	// Load Variables
	// old_password, new_password, new_password2
	$user_id = Session::get("user_id");
	$old_password = md5($_POST['old_password']);
	$new_password = $_POST['new_password'];
	$new_password2 = $_POST['new_password2'];
	
	// Check to see if password2 and password match
	if($new_password !== $new_password2)
	{
	    header("Location: edit_information.php?e=0");
	    exit;
	}
	
	// If blank
	if( ($old_password == "") or ($new_password == "") or ($new_password2 == "") )
	{
	    header("Location: edit_information.php?e=1");
	    exit;
	}
	else if($new_password != $new_password2)
	{
	    // Passwords do not match
	    header("Location: edit_information.php?e=7");
	    exit;
	}
	// Too large or small
	else if( (strlen($new_password) < PASSWORD_MIN_CHAR) or (strlen($new_password) > PASSWORD_MAX_CHAR) )
	{
	    header("Location: edit_information.php?e=6");
	    exit;
	}

	$new_password = md5($new_password);
	$new_password2 = md5($new_password2);
	
	// Make connection to database
	$conn = MysqlConnect::connect();
	MysqlConnect::db_use($conn, "testing_url4cash");
	
	// Open new instance of the query class
	$query = new MysqlQuery($conn);
	
	$qresult = $query->GetSingleQuery('--SINGLE',"SELECT user_password FROM url_users WHERE id = '{$user_id}';",array("user_password"));
	
	if($qresult < 0)
	{
	    // Error
	    header("Location: edit_information.php?e=2");
	    exit;
	}
	
	// Check if old password matches old password
	if($qresult['user_password'] !== $old_password)
	{
	    // Error
	    header("Location: edit_information.php?e=3");
	    exit;
	}


	// Store information in database
	$qresult = $query->SendSingleQuery("UPDATE url_users SET user_password = '{$new_password}' WHERE id = '{$user_id}';");
	
	if($qresult == -1)
	{
	    // Error occurred
	    header("Location: edit_information.php?e=2");
	    exit;
	}
	else
	{
	    // Success, added   
	    header("Location: edit_information.php?e=P");
	    exit;
	}
	
	

    }
    catch(Exception $e)
    {
	// Error
	header("Location: edit_information.php?e=4");
    }
}
// If add flag is set
else if( (isset($_POST['change_user'])) and ( ($_POST['edit_info'] == '83hffZ#97^@dIUD7s') ) )
{
    // Try / Catch
    try
    {
	// Load Variables
	// UserName
	$user_id = Session::get("user_id");
	$user_name = escape($_POST['user_name']);
	$first_name = escape($_POST['first_name']);
	$last_name = escape($_POST['last_name']);

	// If blank
	if( ($user_name == "") or ($first_name == "") or ($last_name == "") )
	{
	   header("Location: edit_information.php?e=1");
	   exit;
	}
	
	// Username too short
	if( (strlen($user_name) < USERNAME_MIN_CHARACTERS) or (strlen($user_name > USERNAME_MAX_CHARACTERS) ) )
	{
	   header("Location: edit_information.php?e=8");
	   exit;	
	}

	// Make connection to database
	$conn = MysqlConnect::connect();
	MysqlConnect::db_use($conn, "testing_url4cash");
	
	// Open new instance of the query class
	$query = new MysqlQuery($conn);
		
	// Store information in database
	$qresult = $query->SendSingleQuery("UPDATE url_users SET user_name = '{$user_name}', first_name = '{$first_name}', last_name = '{$last_name}' WHERE id = '{$user_id}';");
	
	if($qresult == -1)
	{
	    // Error occurred
	    header("Location: edit_information.php?e=2");
	    exit;
	}
	else
	{
	    // Success, added   
	    header("Location: edit_information.php?e=U");
	    exit;
	}
	
	

    }
    catch(Exception $e)
    {
	// Error
	header("Location: edit_information.php?e=4");
	exit;
    }
}
// If add flag is set
else if( (isset($_POST['update_paypal'])) and ( ($_POST['edit_info'] == '83hffZ#97^@dIUD7s') ) )
{
    // Try / Catch
    try
    {
	// Load Variables
	// old_password, new_password, new_password2
	$user_id = Session::get("user_id");
	$paypal = escape($_POST['paypal_email']);
		
	// Check paypal email for validity
	if( (!(eregi('^[a-zA-Z0-9._-]+@[a-zA-Z0-9-]+\.[a-zA-Z.]{2,5}$', $paypal)) ) )
	{
	    // Invalid email address
	    header("Location: register.php?e=5");
	    exit;
	}
	// Make connection to database
	$conn = MysqlConnect::connect();
	MysqlConnect::db_use($conn, "testing_url4cash");
	
	// Open new instance of the query class
	$query = new MysqlQuery($conn);
		
	// Store information in database
	$qresult = $query->SendSingleQuery("UPDATE url_users SET user_paypal = '{$paypal}' WHERE id = '{$user_id}';");
	
	if($qresult == -1)
	{
	    // Error occurred
	    header("Location: edit_information.php?e=2");
	    exit;
	}
	else
	{
	    // Success, added   
	    header("Location: edit_information.php?e=Y");
	    exit;
	}
	

    }
    catch(Exception $e)
    {
	// Error
	header("Location: edit_information.php?e=4");
	exit;
    }
}
else if(isset($_GET['e']))
{
    $NEW_URL = "";
    // Switch through error to check for code and match up
    switch($_GET['e'])
    {
	case "0":
	  // Passwords do not match
	  $ERROR_REGISTER_MESSAGE = PASSWORD_NO_MATCH;
	break;
	case "1":
	  // Blank Entry
	  $ERROR_REGISTER_MESSAGE = BLANK_ENTRY;		
	break;
	case "2":
	  // Blank Entry
	  $ERROR_REGISTER_MESSAGE = DATABASE_ERROR;		
	break;
	case "3":
	  // Blank Entry
	  $ERROR_REGISTER_MESSAGE = INCORRECT_PASSWORD;		
	break;
	case "4":
	  // Blank Entry
	  $ERROR_REGISTER_MESSAGE = TRY_CATCH;		
	break;
	case "5":
	  // Blank Entry
	  $ERROR_REGISTER_MESSAGE = INVALID_PAYPALEMAIL;		
	break;
	case "6":
	  // Blank Entry
	  $ERROR_REGISTER_MESSAGE = INVALID_PASSWORD;		
	break;
	case "7":
	  // Blank Entry
	  $ERROR_REGISTER_MESSAGE = PASSWORD_NO_MATCH;		
	break;
	case "8":
	  // Blank Entry
	  $ERROR_REGISTER_MESSAGE = USERNAME_WRONGLENGTH;		
	break;
	case "P":
	  // Password Changed SUccess
	  $ERROR_REGISTER_MESSAGE = PASS_CHANGE_SUCCESS;
	  $SUCCESS = true;
	break;
	case "U":
	  // User Data Changed
	  $ERROR_REGISTER_MESSAGE = DATA_CHANGE_SUCCESS;
	  $SUCCESS = true;
	break;
	case "Y":
	  // Paypal Address Changed
	  $ERROR_REGISTER_MESSAGE = PAYPAL_CHANGE_SUCCESS;
	  $SUCCESS = true;
	break;
	default:
	  $ERROR_REGISTER_MESSAGE = "";
	break;
    
    
    }
    
 }
ob_end_flush();
	$USER_NAME = Session::get("user_name");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
		<title>Edit Your Information - ExitLinks - Converting Boring Links to Cash!</title>
		<meta name="description" content="content" />
		<meta name="keywords" content="content" />
		<link rel="stylesheet" href="css.css" type="text/css" media="screen" charset="utf-8" />

		<!--[if lte IE 6]>
			<link rel="stylesheet" href="css.css" type="text/css" media="screen" charset="utf-8" />
		<![endif]-->

	</head>	
	
	<body>
<form method="POST" action="edit_information.php" enctype="multipart/form-data" id="info_form1" name="info_form1"> 

			<p id="notes"><strong>ExitLinks is in Beta.</strong> Please send us <a href="contactus.php">feedback</a> to improve this site!</p>

			<div id="head">
				<div id="account">
					<h1><a href="/">ExitLinks</a></h1>
					
			        <dl>
						<dt>Hey! <strong><?php echo $USER_NAME; ?></strong></dt>
						<dd class="accountinfo"><a href="edit_information.php">Manage Account</a></dd>
						<dd class="logout"><a href="../logout.php">Logout</a></dd>
					</dl>
					
					
				</div>
				<hr />
				
				<hr />
				
			    <div id="nav">
					<ul>

						<li ><a href="index.php" id="navBlog">Blog</a></li>
						<li ><a href="manage_url.php" id="navManage">Manage Links</a></li>
			            <li ><a href="index.php" id="navCreate">Create Links</a></li>
						<li ><a href="manage_money.php" id="navEarnings">Earnings</a></li>
						<li ><a href="../help.php" id="navHelp">Help</a></li>

					</ul>
				</div>
			    
			</div>
			<hr />
			<div id="body">
	

	<div style='clear: both;'></div>

			<div id="content">
				<h2 class="first">Update your Account Information</h2>
				<div class="standardForm">				
					<fieldset>
						<legend>Personal Information</legend>
						<p class="info">Change your personal information below. Changes to your email must be confirmed via your original email address.</p>
						<p><label for="txtUsername">Username:</label><input type="text" name="user_name" id="user_name" value="" />&nbsp;</p>
						<p><label for="chkEmailPrivate">First Name:</label><input type="text" name="first_name" id="first_name" value="" /></p>

						<p class="last"><label for="txtHomepage">Last Name:</label><input type="text" name="last_name" id="last_name" value="" />
  <input type="hidden" name="edit_info" id="edit_info" value="83hffZ#97^@dIUD7s" />
  <br />
  <input type="submit" name="change_user" id="change_user" value="Change Personal Information" /></p>
					</fieldset>
					<fieldset>
						<legend>Change Password</legend>
						<p class="info"><b>We recommend that you <U>DO NOT</U> use the same password on Linkbucks.com as you do for your payment or email accounts.</b></p>
						<p><label for="txtPassword1">Old Password:</label><input type="password" name="old_password" id="old_password" value="" /></p>
						
						<p><label for="txtPassword1">New Password:</label><input type="password" name="new_password" id="new_password" value="" /></p>

						<p class="last"><label for="txtPassword2">Retype New Password:</label><input type="password" name="new_password2" id="new_password2" value="" />
  <input type="hidden" name="edit_info" id="edit_info" value="83hffZ#97^@dIUD7s" />
  <br />
  <input type="submit" name="change_password" id="change_password" value="Change Password" />&nbsp;</p>
					</fieldset>			
					<fieldset>
						<legend>PayPal Address</legend>
						<p class="info">If at the time of registering you entered an incorrect PayPal address or you simply want to change it for whatever reason you may do so below.</p>

						<p class="last"><label for="payID">PayPal E-Mail Address:</label><input type="text" name="paypal_email" id="paypal_email" value="" />
  <input type="hidden" name="edit_info" id="edit_info" value="83hffZ#97^@dIUD7s" />
  <br />
  <input type="submit" name="update_paypal" id="update_paypal" value="Change Paypal Address" />&nbsp;</p>

					</fieldset>
				</div>
			</div>


			</div>
			<hr />
			<div id="footer">

				<ul>
					<li><a href="../contactus.php">Contact Us</a></li>
					<li><a href="../info.php">More Info</a></li>
					<li><a href="../help.php">Get Help</a></li>
					<li><a href="../toc.php">Terms and Conditions</a></li>
					<li><a href="../advertise.php">Advertise</a></li>
					<li><a href="../dmca.php">DMCA</a></li>
				</ul>
				<p>Powered By <a href="http://www.scriptdorks.com">ExitLinks</a>. All Rights Reserved.</p>
			</div>
		</form>       
	</body>
</html>
