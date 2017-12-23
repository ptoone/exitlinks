
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
		<title>Register with ExitLinks - Converting Boring Links to Cash!</title>
		<meta name="description" content="content" />
		<meta name="keywords" content="content" />
		<link rel="stylesheet" href="css.css" type="text/css" media="screen" charset="utf-8" />

		<!--[if lte IE 6]>
			<link rel="stylesheet" href="css.css" type="text/css" media="screen" charset="utf-8" />
		<![endif]-->

	</head>
	
<?php

// Do not MODIFY THIS PHP CODE (Code between <?php and ? > )
require('defines/constants.inc');

// If error
if(isset($_GET['e']))
{
    // Switch through error to check for code and match up
    switch($_GET['e'])
    {
	case "0":
	  // Invalid Username
	  $ERROR_REGISTER_MESSAGE = USERNAME_WRONGLENGTH;
	break;
	case "1":
	  // Invalid Email
	  $ERROR_REGISTER_MESSAGE = INVALID_EMAILADDR;		
	break;
	case "2":
	  // Invalid paypal email
	  $ERROR_REGISTER_MESSAGE = INVALID_PAYPALEMAIL;
	break;
	case "3":
	  // Invalid Password
	  $ERROR_REGISTER_MESSAGE = INVALID_PASSWORD;
	break;
	case "4":
	  // Email addresses do not match
	  $ERROR_REGISTER_MESSAGE = EMAIL_NO_MATCH;
	break;
	case "5":
	  // Passwords do not match
	  $ERROR_REGISTER_MESSAGE = PASSWORD_NO_MATCH;
	break;
	case "6":
	  // Mysql DB Error
	  $ERROR_REGISTER_MESSAGE = DATABASE_ERROR;
	break;
	case "7":
	  // Try/Catch block error, caught exception
	  $ERROR_REGISTER_MESSAGE = TRY_CATCH;
	break;
	case "8":
	  // Error getting existing email check
	  $ERROR_REGISTER_MESSAGE = DATABASE_ERROR;
	break;
	case "9":
	  // Email address already exists
	  $ERROR_REGISTER_MESSAGE = EMAIL_ALREADY_REGISTERED;
	break;
	default:
	  $ERROR_REGISTER_MESSAGE = "";
	break;
    
    
    }
}

?>
	
	<body>
<form method="POST" action="register_return.php" enctype="multipart/form-data" id="register_form" name="register_form">
<input type="hidden" name="register_data" id="register_data" value="DC(*@^i7dxc9w26er0@" />

			<p id="notes"><strong>ExitLinks is in Beta.</strong> Please send us <a href="/contact/">feedback</a> to improve this site!</p>

			<div id="head">
				<div id="account">
					<h1><a href="/">ExitLinks</a></h1>
					
					
				</div>
				<hr />
				
<div id="login"></div>

				<hr />
				
			</div>

			<hr />
			<div id="body">
				

			<div id="content">
				<p class="important"><img src="img/icon_clipboard.gif" alt="Clipboard Icon" style="float: left; margin: 5px 10px 0 0" />With our Fast and Free registration you will be <strong>converting those boring links to cash</strong> in no time! Take the next minute or so to complete the information needed below and you're all set!</p>
				<h2>"Converting Boring Links to Cash"</h2>
				<div class="standardForm">
					<fieldset>
						<legend>Account Information</legend>

						<p><label for="regUsername">* Username:</label><input name="user_name" type="text" size="40" id="user_name" class="text" />&nbsp;<!--<input type="text" name="regUsername" id="regUsername" class="text" />--></p>
						<P class="info"><b>We recommend that you <U>DO NOT</U> use the same password on ExitLinks.net as you do for your payment or email accounts.</b></P>
						<p><label for="regPassword">* Password:</label><input name="user_password" type="text" size="40" id="user_password" class="text" />&nbsp;<!--<input type="password" name="regPassword" id="regPassword" class="text" />--></p>
						<p><label for="regPasswordverify">* Retype Password:</label><input name="user_password2" type="text" size="40" id="user_password2" class="text" /><!--<input type="password" name="regPasswordverify" id="regPasswordverify" class="text" />--></p>
						<P class="info">You will use your E-Mail address to Login</P>

						<p><label for="regEmail">* Email Address</label><input name="user_email" type="text" size="40" id="user_email" class="text" value="info@exitlinks.net" />&nbsp;<!--<input type="text" name="regEmail" id="regEmail" class="text" />--></p>
						<p><label for="regEmail">* Retype Email Address</label><input name="user_email2" type="text" size="40" id="user_email2" class="text" value="info@exitlinks.net" />&nbsp;<!--<input type="text" name="regEmail" id="regEmail" class="text" />--></p>
						<p><label for="regEmail">First and Last Name</label><input name="first_name" type="text" size="18" id="first_name" class="text" value="John Smith" />&nbsp;<!--<input type="text" name="regEmail" id="regEmail" class="text" />--></p>
						<p><label for="regEmail">Current Country of Residence</label><input name="user_country" type="text" size="40" id="user_country" class="text" value="United States of America" />&nbsp;<!--<input type="text" name="regEmail" id="regEmail" class="text" />--></p>
					</fieldset>
					
					<fieldset>
						<legend>PayPal Information</legend>

						<p class="info">ExitLinks uses PayPal to transfer money to its' users.</p>
						<p class="last"><label for="payID">PayPal E-Mail Address</label><input name="user_paypal" type="text" size="40" id="user_paypal" class="text" />&nbsp;</p>
					</fieldset>
				
					<fieldset>
					<legend>Agreement</legend>
						<p class="info">Please read the following terms of use before proceeding.</p>

						<p><label>Terms</label><textarea readonly="readonly" class="text">By registering or submitting content on this site, you agree to be bound by these Terms of Use. If you do not agree to these terms, you may not proceed.

Copyright
All content included on this web site, including text, graphics, logos, buttons, icons, and images, is the property of ExitLinks.net, its licensors or its content suppliers, and is protected by U.S. and international copyright and trademark laws. The compilation of all content on this web site is the exclusive property of ExitLinks.net and is protected by U.S. and international copyright laws.

Trademarks
ExitLinks, the ExitLinks.net logo and all trademarks, servicemarks, and trade names appearing on the site are the property of ExitLinks.net or their respective owners that have granted ExitLinks.net the right to use such marks. 

Use of Information and Services
THE INFORMATION SERVICES CONTAINED IN THIS WEB SITE ARE PROVIDED ON AN "AS IS" BASIS WITH NO WARRANTY. TO THE MAXIMUM EXTENT PERMITTED BY APPLICABLE LAW, ExitLinks.net DISCLAIMS ALL REPRESENTATIONS AND WARRANTIES, EXPRESS OR IMPLIED, WITH RESPECT TO SUCH INFORMATION, SERVICES, PRODUCTS, AND MATERIALS, INCLUDING WITHOUT LIMITATION ANY IMPLIED WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN ADDITION, ExitLinks.net DOES NOT WARRANT THAT THE INFORMATION ACCESSIBLE VIA THIS WEB SITE IS CURRENT, COMPLETE, OR ERROR-FREE. SOME STATES DO NOT ALLOW THE EXCLUSION OR LIMITATION OF IMPLIED WARRANTIES SO THE ABOVE LIMITATION MAY NOT APPLY TO YOU.

IN NO EVENT WILL ExitLinks.net BE LIABLE FOR ANY CONSEQUENTIAL, INDIRECT, INCIDENTAL, SPECIAL, OR PUNITIVE DAMAGES, HOWEVER CAUSED AND UNDER ANY THEORY OF LIABILITY (INCLUDING NEGLIGENCE), ARISING FROM YOUR USE OF THIS SITE OR THE PROVISION OF THE INFORMATION, SERVICES, PRODUCTS, AND MATERIALS CONTAINED IN THIS SITE, EVEN IF ExitLinks.net HAS BEEN ADVISED OF THE POSSIBILITY OF SUCH DAMAGES. BECAUSE SOME STATES DO NOT ALLOW THE EXCLUSION OR LIMITATION OF LIABILITY FOR CONSEQUENTIAL DAMAGES, THE ABOVE LIMITATION MAY NOT APPLY TO YOU. 

Your Privacy
ExitLinks.net is committed to protecting your privacy. ExitLinks.net does not sell, trade or rent your personal information to other companies. ExitLinks.net will not collect any personal information about you except when you specifically and knowingly provide such information.

By using our Web site, you consent to the collection and use of this information by ExitLinks.net. If we decide to change our privacy policy, we will post the changes on this page so that you are always aware of what information we collect, how we use it, and under what circumstances we disclose it. Currently, ExitLinks.net may provide aggregate statistics about our traffic patterns, and related site information to reputable third-party vendors, but these statistics will include no personal identifying information.

User Submissions
By submitting content to ExitLinks.net, you grant ExitLinks.net permission to use the information for public viewing.

You are prohibited from submitting or transmitting to or from the Site any unlawful, threatening, libelous, defamatory, obscene, or pornographic materials that would violate any law or the rights of others, including without limitation, laws against copyright infringement. Violation of these restrictions may result in restricting or limiting your access or use of the Site.

ExitLinks.net, also reserves the right, in its sole discretion, to delete or remove your User Submissions from the Site and to restrict, suspend or terminate your access to all or part of the Site, at any time for any reason without prior notice or liability.

ExitLinks.net, may, but is not obligated to, monitor or review (a) any areas on the Site where users submit or transmit User Submissions, and (b) the substance of any User Submissions.

To the maximum extent permitted by law, ExitLinks.net will have no liability related to User Submissions arising under the laws of copyright, libel, privacy, obscenity, or otherwise. ExitLinks.net disclaims any and all liability with respect to the misuse, loss, modification, or unavailability of any User Submissions.

Termination of Usage
ExitLinks.net may terminate or suspend your access to all or part of the ExitLinks.net site, without notice, for any conduct that ExitLinks.net, in its sole discretion, believes is in violation of any applicable law or is harmful to the interests of another user, a sponsor, merchant or other third party, or ExitLinks.net. 

Modification of Terms of Use
ExitLinks.net reserves the right, at any time, to modify, alter or update these Terms of Use and you agree to be bound by such modifications, alterations or updates.
						</textarea></p>
						<p class="last"><label>* Do you accept the terms of use?</label> By Clicking the Submit Button You Agree to the Above Terms of ExitLinks</p>
					</fieldset>
					<p class="buttons"><input type="submit" name="submit" value="Submit Registration" id="submit" /></p>
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
