<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
		<title>Request a Payment! ExitLinks - Converting Boring Links to Cash!</title>
		<meta name="description" content="content" />
		<meta name="keywords" content="content" />
		<link rel="stylesheet" href="css.css" type="text/css" media="screen" charset="utf-8" />

		<!--[if lte IE 6]>
			<link rel="stylesheet" href="css.css" type="text/css" media="screen" charset="utf-8" />
		<![endif]-->

	</head>
	
<?php
	$comments_textarea_1 = "<text";
	$comments_textarea_2 = 'area name="comments" cols="60" rows="6">';
	$end_textarea_1 = "</text";
	$end_textarea_2 = "area>";
	if (!function_exists('str_split')) {
		function str_split($string, $split_length = 1) {
			return explode("\r\n", chunk_split($string, $split_length));
		}
	}
	
	function generateDropDown($values,$value_selected) {
		$value_array = explode(',',$values);
		$i = 0;
		while ($value_array[$i] != '') {
			if ($value_array[$i] == $value_selected) {
				$selected = ' selected ';
			} else {
				$selected = '';
			}
			$options .= '<option value="' . $value_array[$i] . '" ' . $selected . '>' . $value_array[$i] . '</option>';
			$i++;
		}
		return $options;
	}
	
	function checkValidChars($string,$valid_chars) {
		$string_array = str_split($string);
		$valid_chars_array = str_split($valid_chars);
		$i = 0;
		while ($string_array[$i] != '') {
			if (!in_array($string_array[$i],$valid_chars_array)) {
				return false;
			}
			$i++;
		}
		return true;
	}
	
	function getResultDiv($value,$type='error') {
		// Formats successful or error results whether they are in an array or a snippet.
		if ($type == 'success') {
			$class = 'success-div';
		} elseif ($type == 'test') {
			$class = 'test-div';
		} else {
			$class = 'error-div';
		}
		if (is_array($value)) {
			for ($i = 0; $value[$i] != ''; $i++) {
				$result_div .= '<li>' . $value[$i] . '</li>';
			}
			if ($result_div != '') {
				$result_div = '<div class="' . $class . '"><ul>' . $result_div . '</ul></div>';
			}
		} else {
			if ($value != '') {
				$result_div = '<div class="' . $class . '">' . $value . '</div>';
			}
		}
		return $result_div;
	}

	function getValidation($add_edit,$name,$msg,$type,$value='') {
		global $edit_action;
		global $add_action;
		global $error_div;
		global $_POST;
		global $_GET;
		if  ($_POST['action'] == "submit_form") {
			$do = 1;
		} 
		// No value
		if ($type == 'novalue') {
			if ($do == 1) {
				if (strlen($_POST[$name]) < '1') {
					$error_div .= getResultDiv($msg);
				}
			}
			$js_clause = 'form.' . $name . '.value == ""';
			return jsCheck($js_clause,$msg,$name);
		}
		
		// Number is less than
		if ($type == 'less_than') {
			if ($do == 1) {
				if ($_POST[$name] < $value) {
					$error_div .= getResultDiv($msg);
				}
			}
			$js_clause = 'form.' . $name . '.value < ' . $value;
			return jsCheck($js_clause,$msg,$name);
		}
		
		// Number is greater than
		if ($type == 'greater_than') {
			if ($do == 1) {
				if ($_POST[$name] > $value) {
					$error_div .= getResultDiv($msg);
				}
			}
			$js_clause = 'form.' . $name . '.value > ' . $value;
			return jsCheck($js_clause,$msg,$name);
		}
		
		// Value equals
		if ($type == 'equals') {
			if ($do == 1) {
				if ($_POST[$name] == $value) {
					$error_div .= getResultDiv($msg);
				}
			}
			$js_clause = 'form.' . $name . '.value == ' . $value;
			return jsCheck($js_clause,$msg,$name);
		}
		
		// Less Than String Length
		if ($type == 'strlen_less') {
			if ($do == 1) {
				if (strlen($_POST[$name]) < $value) {
					$error_div .= getResultDiv($msg);
				}
			}
			$js_clause = 'form.' . $name . '.value.length < ' . $value;
			return jsCheck($js_clause,$msg,$name);
		}
		
		// String Length
		if ($type == 'strlen') {
			if ($do == 1) {
				if (strlen($_POST[$name]) != $value) {
					$error_div .= getResultDiv($msg);
				}
			}
			$js_clause = 'form.' . $name . '.value.length != ' . $value;
			return jsCheck($js_clause,$msg,$name);
		}
		
		// Zip Code
		if ($type == 'zip') {
			$valid_chars = "0123456789";
			if ($do == 1) {
				if (strlen($_POST[$name]) != 5) {
					$error_div .= getResultDiv('Please enter 5 digits for the zip code');
				} elseif (!checkValidChars($_POST[$name],$valid_chars)) {
					$error_div .= getResultDiv('Please enter only digits for the zip code');
				}
			}
			$js_clause_1 = 'form.' . $name . '.value.length != 5';
			$js_clause_2 = '!ValidChars(form.' . $name . '.value,"' . $valid_chars . '")';
			return 
				jsCheck($js_clause_1,'Please enter 5 numbers for the zip code',$name) . 
				jsCheck($js_clause_2,'Please enter only numbers in the zip code',$name);
		}
		
		// Price
		if ($type == 'price') {
			$valid_chars = "0123456789.,";
			
			if ($do == 1) {
				$post_value = str_replace(',','',$_POST[$name]);
				if (!checkValidChars($post_value,$valid_chars)) {
					$error_div .= getResultDiv('Please enter only a number for ' . $msg);
				} elseif (strlen($post_value) > $value) {
					$error_div .= getResultDiv('Please enter a smaller value for ' . $msg);
				}
			}
			$js_clause_1 = 'form.' . $name . '.value.length > ' . $value;
			$js_clause_2 = '!ValidChars(form.' . $name . '.value,"' . $valid_chars . '")';

			return 
				jsCheck($js_clause_1,'Please enter no more than ' . $value . ' characters for ' . $msg,$name) . 
				jsCheck($js_clause_2,'Please enter only numbers for ' . $msg,$name);
		}
		
		// Number
		if ($type == 'number') {
			$valid_chars = "0123456789";
			if ($do == 1) {
				$post_value = str_replace(',','',$_POST[$name]);
				if (!checkValidChars($post_value,$valid_chars)) {
					$error_div .= getResultDiv('Please enter only a number for ' . $msg);
				} elseif (strlen($post_value) > $value) {
					$error_div .= getResultDiv('Please enter a smaller value for ' . $msg);
				}
			}
			$js_clause_1 = 'form.' . $name . '.value.length > ' . $value;
			$js_clause_2 = '!ValidChars(form.' . $name . '.value,"' . $valid_chars . '")';

			return 
				jsCheck($js_clause_1,'Please enter no more than ' . $value . ' numbers for ' . $msg,$name) . 
				jsCheck($js_clause_2,'Please enter only numbers for ' . $msg,$name);
		}
		
		// Phone Number
		if ($type == 'phone') {
			$valid_chars = "0123456789-() ";
			$value = 7;
			if ($do == 1) {
				if (!checkValidChars($_POST[$name],$valid_chars)) {
					$error_div .= getResultDiv('Please enter only a phone number for ' . $msg);
				} elseif (strlen($post_value) > $value) {
					$error_div .= getResultDiv('Please enter a smaller value for ' . $msg);
				}
			}
			$js_clause_1 = 'form.' . $name . '.value.length < ' . $value;
			$js_clause_2 = '!ValidChars(form.' . $name . '.value,"' . $valid_chars . '")';

			return 
				jsCheck($js_clause_1,'Please enter no more than ' . $value . ' numbers for the phone number',$name) . 
				jsCheck($js_clause_2,'Please enter a valid phone number',$name);
		}
		
		
		// Password
		if ($type == 'password') {
			$valid_chars = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
			if ($do == 1) {
				if (!checkValidChars($_POST[$name],$valid_chars)) {
					$error_div .= getResultDiv('Please enter only alpha-numeric values for ' . $msg);
				} elseif (strlen($_POST[$name]) < $value || $_POST[$name] == '') {
					$error_div .= getResultDiv($msg . ' must be at least 6 characters long');
				}
			}
			$js_clause_1 = 'form.' . $name . '.value.length < ' . $value . ' && ' . ' form.' . $name . '.value.length > 0';
			$js_clause_2 = '!ValidChars(form.' . $name . '.value,"' . $valid_chars . '")';

			return 
				jsCheck($js_clause_1,$msg . ' must be at least 6 characters long',$name) . 
				jsCheck($js_clause_2,'Please enter only alpha-numeric values for ' . $msg,$name);
		}
		
		// Duplicate
		if ($type == 'duplicate') {
			if ($do == 1) {
				$value_array = explode(':',$value);
				$table = $value_array[0];
				$column = $value_array[1];
				$content = $_POST[$name];
			}
		}
		
	}
	
	function jsCheck($clause,$msg,$name) {
		return '
			if (' . $clause . ') {
			 alert( "' . $msg . '" );
			 form.' . $name . '.focus();
				return false;
			}
		';
	}
	
	$subject_options = generateDropDown("",$_POST['subject']);
	
	$email['to'] = "YOURMEMAILADDRESSGOESHERE@gmail.com";
	$email['subject_prefix'] = "";
	
	
	if ($_POST['action'] == 'submit_form') {
		
					if (strlen($_POST['email']) < 1) {
						$error_div .= getResultDiv('Please enter a value for your email address');
					}
		$result_div .= $error_div;
		if ($error_div == '') {
			if (strlen($_POST["subject"] ) > 1) {
				$message .= "SUBJECT: " . $_POST["subject"] . "\n";
			}
			if (strlen($_POST["fullname"]) > 1) {
				$message .= "FROM: " . $_POST["fullname"] . "\n";
			}
			if (strlen($_POST["email"]) > 1) {
				$message .= "EMAIL: " . $_POST["email"] . "\n";
			}
			if (strlen($_POST["phone"] ) > 1) {
				$message .= "PHONE: " . $_POST["phone"] . "\n";
			}
			if (strlen($_POST["company"] ) > 1) {
				$message .= "COMPANY: " . $_POST["company"] . "\n";
			}
			if (strlen($_POST["address"] ) > 1) {
				$message .= "Address: " . $_POST["address"] . "  " .  $_POST["address_2"] . "  " . $_POST["city"] . ", " . $_POST["state"] . " " . $_POST["zip"] . "\n";
			}
			if (strlen($_POST["comments"] ) > 1) {
				$message .= "COMMENTS:\n" . $_POST["comments"] . "\n\n";
			}
			$message = "Below is the information submitted to your online Contact form on " . date('F j, Y') . " at " . date('j:i a') . ":\n\n" . $message;
			
			if (mail($email['to'],$email['subject_prefix'] . $_POST['subject'], $message, "From: " . $_POST['email'])) {
				header("Location: ../payment-results.php");
			}
		} else {
			$form = $_POST;
		}
	} 
	?>
	<html>
	<head>
		<style>
			.required {
				font-weight:bold;
				color:red;
			}
			
			.error-div {
				border:1px solid #FF0000;
				background-color:#FFDEDE;
				padding:10px;
				margin-bottom:5px;
				color:#CC0000;
			}
			
			.success-div {
				border:1px solid #09BD00;
				background-color:#EEFFED;
				padding:10px;
				margin-bottom:5px;
				color:#006600;
			}
		</style>
		<script language="JavaScript" type="text/javascript">
		
		
		var IE = (document.all) ? 1 : 0;
var DOM = 0; 
if (parseInt(navigator.appVersion) >=5) {DOM=1};

        function txtShow( cId, txt2show ) {
            // Detect Browser
            if (DOM) {
							var viewer = document.getElementById(cId);
              viewer.innerHTML=txt2show;
            } else if(IE) {
               document.all[cId].innerHTML=txt2show;
            }
        }//txtshow
        
        function getTxt( cId ) {
            var output = "";
            // Detect Browser
            if (DOM) {
		var viewer = document.getElementById(cId);
		output = viewer.value;
            }
            else if(IE) {
                output = document.all[cId].value;
            }
            return output;
        }//getTxt
		
		function countChars(cBoxName, cTxtName, maxKeys) {
			var str = new String(getTxt(cBoxName));
			var len = str.length;
			var showstr = '<span class="alert-pos">' + len + ' characters of ' + maxKeys + ' entered</span>';
			if (len > maxKeys) showstr = '<span class="alert">' + len + ' characters of ' + maxKeys + ' entered</span><br /><span class="alert">Too many characters, please edit content</span>';
			txtShow( cTxtName, showstr );
		}
		
		function ValidChars(sText,ValidChars) {
			var IsNumber=true;
			var Char;
			for (i = 0; i < sText.length && IsNumber == true; i++) { 
				Char = sText.charAt(i); 
				if (ValidChars.indexOf(Char) == -1)  {
					IsNumber = false;
				}
			}
			return IsNumber;
		}
		
		function checkform (form) {
			
			if (form.email.value.length < 5) {
			 alert( "Please enter your email" );
			 form.email.focus();
				return false;
			}
		
		}
		</script>	
			
	<body>
		<?php echo $result_div; ?>
		<form action="request_payment.php" onsubmit="return checkform(this);" method="post">
			<input type="hidden" name="action" value="submit_form" />
			<p id="notes"><strong>ExitLinks is in Beta.</strong> Please send us <a href="contactus.php">feedback</a> to improve this site!</p>

			<div id="head">
				<div id="account">
					<h1><a href="/">ExitLinks</a></h1>
					
					
				</div>
				<hr />
				
				<hr />
				
			    <div id="nav">
					<ul>

						<li ><a href="/cpanel/index.php" id="navBlog">Home</a></li>
						<li ><a href="/cpanel/manage_url.php" id="navManage">Manage Links</a></li>
			            <li ><a href="/cpanel/index.php" id="navCreate">Create Links</a></li>
						<li ><a href="/cpanel/manage_money.php" id="navEarnings">Earnings</a></li>
						<li ><a href="../help.php" id="navHelp">Help</a></li>

					</ul>
				</div>
			    
			</div>

			<hr />
			<div id="body">
				
	<div style='clear: both;'></div>
			<div id="content">
				<h2 class="first">Request a Payment</h2>

				If you have reach the minimum payout limit ($10) and it has been over 14 days then please fill out the request a payment form below<br />
				so our support team can send your payment right away.
				<br /><br />
				<div class="standardForm">
					<fieldset>
						<p class="info">Please fill out your e-mail address so we can forward your payment:</p>
						<p>
						    <label for="txtEmail" style="width:25%">Your Name: (optional) </label>
						    <input type="text" name="fullname" value="<?php echo $form['fullname']; ?>" size="40" />&nbsp; 
						</p>
						<p>
						    <label for="txtSubject" style="width:25%">* Your E-mail:</label>

						    <input type="text" name="email" size="40" value="<?php echo $form['email']; ?>" />&nbsp;
						</p>
						<br />
						
					</fieldset>
					<p class="buttons"><input type="submit" value="Submit Contact Form" /></p>
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