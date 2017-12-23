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
	$USER_NAME = Session::get("user_name");
	$SUCCESS = false;

// If add flag is set
if( (isset($_POST['add_url'])) and ( ($_POST['add_data'] == '83hffZ#97^@dIUD7s') ) )
{
    // Try / Catch
    try
    {
	// Load Variables
	// web_url = URL TO CONVERT
	$url = escape($_POST['web_url']);
	$type = escape($_POST['web_type']);
	
	// Check to see if $url has http in front of it
	if(!(ereg("^(http://).*",$url)))
	{
	    $my = "http://";
	    $url = $my.$url;
	}
	
	$user_id = Session::get("user_id");
	
	switch($type)
	{
	  case "interstitial":
	    $type = 'interstitial';
	  break;
	  case "banner":
	    $type = 'banner';
	  break;
	  default:
	    $type = 'banner';
	  break;
	}
	
	// Get next web_url ID
	// Make connection to database
	$conn = MysqlConnect::connect();
	MysqlConnect::db_use($conn, "testing_url4cash");
	
	// Open new instance of the query class
	$query = new MysqlQuery($conn);
	
	$qresult = $query->GetSingleQuery('--SINGLE',"SELECT web_nurl FROM url_urls ORDER BY url_id DESC LIMIT 1;",array("web_nurl"));
	
	if($qresult < 0)
	{
	    // Error
	    header("Location: index.php?e=0");
	}
	
	$url_count = getNewCount($qresult['web_nurl']);
// Get money so far
$qresult2 = $query->GetSingleQuery("--SINGLE","SELECT clicks FROM url_users WHERE id = '{$user_id}';",array("clicks"));
if($qresult < 0)
{
    // Mysql Error
    echo "Server Error: Please reload page";
    exit;
}
	// Store information in database
	$qresult = $query->SendSingleQuery("INSERT INTO url_urls(user_id,web_url,web_nurl,web_type) VALUES('{$user_id}','{$url}','{$url_count}','{$type}');");
	
	if($qresult == -1)
	{
	    // Error occurred
	    header("Location: index.php?e=0");
	}
	else
	{
	    // Success, added
	    header("Location: index.php?e=S&n={$url_count}");
	}	

    }
    catch(Exception $e)
    {
	// Error
	header("Location: index.php?e=1");
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
	  $ERROR_REGISTER_MESSAGE = ADD_URL_SUCCESS;
	  $NEW_URL = SITE_PATH."load.php?i=".$_GET['n'];
	  $SUCCESS = true;
	break;
	default:
	  $ERROR_REGISTER_MESSAGE = "";
	break;
    
    
    }
    
    /// SUCCESS CHANGE THIS MESSAGE TO WHATEVER YOU WANT! KEEP THE {$NEW_URL} WHEREVER YOU WANT THE NEW URL TO BE SHOWN 
    $SUCCESS_MESSAGE = "Your Converted URL is, {$NEW_URL}";
}

ob_end_flush();

// Make connection to the database
$conn = MysqlConnect::connect();
MysqlConnect::db_use($conn, "testing_url4cash");
$query = new MysqlQuery($conn);
// User ID
$user_id = Session::get("user_id");

// Try to format DATE
if(isset($_POST['get_date']))
{
    // Get form values
    $month = intval($_POST['date_month']);
    $day = intval($_POST['date_day']);
    $year = intval($_POST['date_year']);
    
    $month2 = intval($_POST['date_month2']);
    $day2 = intval($_POST['date_day2']);
    $year2 = intval($_POST['date_year2']);
    
    // Check month for validity
    if( (($month < 1) or ($month > 12)) or (($month2 < 1) or ($month2 > 12)) )
    {
	header("Location: manage_money.php?e=10");
	exit;
    }
    
    // Check day
    if( (($day < 1) or ($day > 31)) or (($day2 < 1) or ($day2 > 31)))
    {
	header("Location: manage_money.php?e=11");
	exit;
    }
    
    // Check year for validity
    if( (($year < 2007) or ($year > 2032)) or (($year < 2007) or ($year > 2032)))
    {
	header("Location: manage_money.php?e=12");
	exit;
    }

    // Try making time
    $new_time = strtotime($day."-".$month."-".$year);
    $new_time2 = strtotime($day2."-".$month2."-".$year2);
    
    if( ($new_time === false) or ($new_time2 === false))
    {
	// Error, return false time
	header("Location: manage_money.php?e=13");
	exit;
    }
    
    // Date ranges
    $date1 = date('Y-m-d H:i:s',$new_time);
    $date2 = date('Y-m-d H:i:s',$new_time2);

}
else
{
    // Get Day Today
    $curr_time = time();
    $month = date('m',$curr_time);
    $year = date('Y',$curr_time);
    $day = date('d',$curr_time);
    
    $new_time = strtotime($day."-".$month."-".$year);
    $new_time2 = time();
    
    $date1 = date('Y-m-d H:i:s',$new_time);
    $date2 = date('Y-m-d H:i:s',$new_time2);
}

// We now have date ranges, continue
$qresult = $query->GetSingleQuery("--MULTI","SELECT dtime,ip_addr,url_id,ad_id,url_link FROM url_click WHERE user_id = '{$user_id}' AND dtime BETWEEN '{$date1}' AND '{$date2}';",array("dtime","ip_addr","url_id","ad_id","url_link"),"dtime");
     
// Any Errors
if($qresult < 0)
{
    // Mysql Error
    echo "Server Error: Please reload page";
    exit;
}

// Get money so far
$qresult2 = $query->GetSingleQuery("--SINGLE","SELECT clicks FROM url_users WHERE id = '{$user_id}';",array("clicks"));
if($qresult < 0)
{
    // Mysql Error
    echo "Server Error: Please reload page";
    exit;
}

$_CLICK_VALUE = $qresult2['clicks'];
$USER_NAME = Session::get("user_name");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
		<title>User cPanel - ExitLinks - Converting Boring Links to Cash!</title>
		<meta name="description" content="content" />
		<meta name="keywords" content="content" />
		<link rel="stylesheet" href="css.css" type="text/css" media="screen" charset="utf-8" />
		<link rel="stylesheet" href="style.css" type="text/css" media="screen" charset="utf-8" />
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

						<li class="selected"><a href="index.php" id="navBlog">Blog</a></li>
						<li ><a href="manage_url.php" id="navManage">Manage Links</a></li>
			            <li ><a href="index.php" id="navCreate">Create Links</a></li>
						<li ><a href="manage_money.php" id="navEarnings">Earnings</a></li>
						<li ><a href="../help.php" id="navHelp">Help</a></li>

					</ul>
				</div>
			    
			</div>
			<hr />
			<div id="body">
				

	<div id="quickstats">
		<h2>ExitLinks Console</h2>
		<dl>

			<dt>Total Earnings:</dt>
			<dd>$<?php echo $_CLICK_VALUE*COST_PER_CLICK; ?></dd>
		</dl>
		<dl>
			<dt>Total Clicks:</dt>
			<dd><?php echo $_CLICK_VALUE; ?></dd>
		</dl>

		<dl>
			<a href="../request_payment.php"><img src="../img/button_payment.gif" border="0" id="imgBtn" alt="Request Payment" /></a>
		</dl>
	</div>
	<div style='clear: both;'></div>
<div id="content">
<br>
<h2>Convert Your Links!</h2>
<br>Copy and paste your boring links below and click 'Convert!' to have our system generate a link will <strong>make you money everytime it is clicked!</strong><br><br>
You can then post your links on Forums, Blogs, Youtube, Flickr, Facebook, Myspace or ANYWHERE! The possibilities are endless.<br><br>
<form method="POST" action="index.php" enctype="multipart/form-data" id="addurl_form" name="addurl_form"> 
  Enter the URL to Convert: <input type="text" name="web_url" id="web_url" value="" />
<br />Style of Advertisement:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<select name="web_type" id="web_type">
    <option value="banner">Top-Frame Advertisement</option>
    <option value="interstitial">Interstitial Advertisements</option>
  </select><br><img src='../img/legend.jpg' border="0"><br>
  <input type="hidden" name="add_data" id="add_data" value="83hffZ#97^@dIUD7s" />
  <br />
<input type="submit" name="add_url" id="add_url" value="Convert My Boring Link!" />
</form><br><br><strong>
<?php if($SUCCESS === true) { echo $SUCCESS_MESSAGE; } ?></strong>
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