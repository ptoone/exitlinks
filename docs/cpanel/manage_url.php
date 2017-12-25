<?php
// View URLS
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

// User ID
$user_id = Session::get("user_id");

// If delete flag is set
if( (isset($_GET['du'])) and ( ($_GET['del_data'] == 'DEL_CONTROL_127') ) )
{
    // Try / Catch
    try
    {
	// Load Variables
	$url_id = escape($_GET['du']);
	
	// Get next web_url ID
	// Make connection to database
	$conn = MysqlConnect::connect();
	MysqlConnect::db_use($conn, "testing_url4cash");
	
	// Open new instance of the query class
	$query = new MysqlQuery($conn);
	
	$qresult = $query->SendSingleQuery("DELETE FROM url_urls WHERE url_id = '{$url_id}';");
	
	if($qresult === -1)
	{
	    // Error
	    header("Location: manage_url.php?e=0");
	    exit;
	}
	else
	{
	    // Success, added
	    header("Location: manage_url.php?e=S");
	    exit;
	}	

    }
    catch(Exception $e)
    {
	// Error
	header("Location: manage_url.php?e=1");
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
	  // Invalid Email Address
	  $ERROR_REGISTER_MESSAGE = DATABASE_ERROR;
	break;
	case "1":
	  // Invalid password
	  $ERROR_REGISTER_MESSAGE = TRY_CATCH;		
	break;
	case "S":
	  // Database Error
	  $ERROR_REGISTER_MESSAGE = DEL_SUCCESS;
	break;
	default:
	  $ERROR_REGISTER_MESSAGE = "";
	break;
    
    
    }
    
}
ob_end_flush();

// Make connection to the database
$conn = MysqlConnect::connect();
MysqlConnect::db_use($conn, "testing_url4cash");
	
// Open new instance of the query class
$query = new MysqlQuery($conn);
$qresult = $query->GetSingleQuery("--MULTI","SELECT url_id,web_url,web_nurl FROM url_urls WHERE user_id = '{$user_id}'",array("url_id","web_url","web_nurl"),"url_id");

// Success?
if($qresult < 0)
{
    echo "Severe Server Error : Please refresh page, sorry for the inconvenience!";
    exit;
}

// Loop through array
// ARRAY [0][val] = value
//	  key value0   

$USER_NAME = Session::get("user_name");

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
		<title>Manage Links - ExitLinks - Converting Boring Links to Cash!</title>
		<meta name="description" content="content" />
		<meta name="keywords" content="content" />
		<link rel="stylesheet" href="css.css" type="text/css" media="screen" charset="utf-8" />

		<!--[if lte IE 6]>
			<link rel="stylesheet" href="css.css" type="text/css" media="screen" charset="utf-8" />
		<![endif]-->

	</head>
	
	<body>

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
						<li ><a href="index.php" id="navBlog">Home</a></li>

						<li  class="selected"><a href="manage_url.php" id="navManage">Manage Links</a></li>
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
	<h2 class="first">Manage Links</h2>

	<p>Listed below are the links that you had converted</p>
		
    <div>
	<table class="data" cellspacing="0" border="0" id="ctl00_MainBody_ctl01_GridView1">
		<tr style="background-color:#444444;font-weight:bold;">
			<th scope="col">Your Converted Links</th>
		</tr>
			<td> 
                <div>
	<table class="data" >
		<tbody><tr>
		<th>Original Link</th>
		<th>Converted Link</th>
		<th scope="col">Delete</th>
		</tr>
<?php
    foreach($qresult as $value)
    {
	echo  "<tr><td>",$value["web_url"],"</td><td>",SITE_PATH."load.php?i=".$value["web_nurl"],"</td><td><a href='manage_url.php?du={$value['url_id']}&del_data=DEL_CONTROL_127'>Delete</a>","</td></tr>";
    }
?>
		</tbody></table></div>
        </td>

	</table>
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
