
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
		<title>ExitLinks - Converting Boring Links to Cash!</title>
		<meta name="description" content="content" />
		<meta name="keywords" content="content" />
		<link rel="stylesheet" href="css.css" type="text/css" media="screen" charset="utf-8" />

		<!--[if lte IE 6]>
			<link rel="stylesheet" href="css.css" type="text/css" media="screen" charset="utf-8" />
		<![endif]-->

	</head>
	
<?php
require('defines/constants.inc');
require('includes/session.inc');

// If error
if(isset($_GET['e']))
{
    // Switch through error to check for code and match up
    switch($_GET['e'])
    {
	case "0":
	  // Invalid Email Address
	  $ERROR_REGISTER_MESSAGE = INVALID_EMAILADDR;
	break;
	case "1":
	  // Invalid password
	  $ERROR_REGISTER_MESSAGE = INVALID_PASSWORD;		
	break;
	case "2":
	  // Database Error
	  $ERROR_REGISTER_MESSAGE = DATABASE_ERROR;
	break;
	case "3":
	  // No user with that email
	  $ERROR_REGISTER_MESSAGE = EMAIL_DOESNT_EXIST;
	break;
	case "4":
	  // Wrong password
	  $ERROR_REGISTER_MESSAGE = INCORRECT_PASSWORD;
	break;
	case "5":
	  // Session Setting Error
	  $ERROR_REGISTER_MESSAGE = SESSION_SET_ERROR;
	break;
	case "6":
	  // Try / Catch error
	  $ERROR_REGISTER_MESSAGE = TRY_CATCH;
	break;
	default:
	  $ERROR_REGISTER_MESSAGE = "";
	break;
    
    
    }
}

?>
	
	<body>
<form method="POST" action="login_return.php" enctype="multipart/form-data" id="login_form" name="login_form">
<input type="hidden" name="login_data" id="login_data" value="DC(*@^i7dxc9w26er0@" />

			<p id="notes"><strong>INVALID LOGIN INFORMATION!</strong> Please try again and ensure that you are using your e-mail address and correct password.</p>

			<div id="head">
				<div id="account">
					<h1><a href="/">ExitLinks</a></h1>
					
					
				</div>
				<hr />
				


                <div id="login">
					<fieldset>
						<h2>Login</h2>

						<p><label for="username">E-Mail Address:</label><input type="text" id="user_email" name="user_email" value="test@test.com" /></p>
						<p><label for="password">Password:</label><input type="password" id="user_password" name="user_password" value="password" /></p>
						<p class="button"><input type="submit" name="submit" id="submit" value="Sign In" /></p>
						<p id="help"><a href="forgot.php">Forgot your Password?</a></p>
						<div style="clear:both;"></div>
						<p style="margin: 2px 10px 0px 0px;"><span></span></p>
					</fieldset>

				</div>

				<hr />
				
			</div>
			<hr />
			<div id="body">
				

<div>
	<div id="main" align="right" style="padding-right:50px">
<br><br><br><br><br>

            <a href="signup.php" id="signUp"><img src="img/signUp.gif" width="149" height="49" alt="Sign Up!" /></a>
<br><br><br><br><br>
    </div>
    <div id="mainbottom"><p><center><font color="#f4ae35">ExitLinks allows you to make money from the links that your visitors click on! Now you can convert those boring links to high-paying links Today!</font></center></p></div>
    <div id="bottomNav">

<table width="850" border="0" cellspacing="5" cellpadding="5" style="margin-left:auto; margin-right:auto;">
  <tr>

    <td align="center" width="230" valign="top">
    <a href="info.php"><img src="img/moreInfo.gif" alt="More Info" width="228" height="51" border="0" /></a><br />
    <a href="advertise.php"><img src="img/advertise.gif" alt="Advertisers" width="229" height="51" border="0" /></a><br />
    <a href="help.php"><img src="img/getHelp3.jpg" alt="Get Help" width="229" height="51" border="0" /></a>
        </td>
    <td valign="top"><table width="777" border="0" cellpadding="0" cellspacing="0"><div id="content">
<p class="important">
To purchase the script running ExitLinks and <strong>start your own social advertising network</strong> have a look at our parent site here! <a href="http://www.exitlinks.net">ExitLinks.net</a><br><br>
Updates will be released when new additions are made and will automatically be sent to those who purchase! We will be selling the script on a per-domain basis and if you wish to have ExitLinks on more than one domain then you would have to purchase multiple license (discounts available!).<br><br>
The <strong>Price is $225</strong> and you can find more information here <a href="http://www.exitlinks.net">ExitLinks.net</a><br><br>
Enjoy the freedom <strong>converting those boring links to cash</strong> with our software.</div></p>
    </table></td>
  </tr>
</table>
    </div>
</div>



			</div>
			<hr />

			<div id="footer">

				<ul>
					<li><a href="contactus.php">Contact Us</a></li>
					<li><a href="info.php">More Info</a></li>
					<li><a href="help.php">Get Help</a></li>
					<li><a href="toc.php">Terms and Conditions</a></li>
					<li><a href="advertise.php">Advertise</a></li>
					<li><a href="dmca.php">DMCA</a></li>
				</ul>
				<p>Powered By <a href="http://www.scriptdorks.com">ExitLinks</a>. All Rights Reserved.</p>
			</div>
		</form>       
	</body>
</html>
