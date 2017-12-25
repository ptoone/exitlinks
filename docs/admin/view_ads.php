<?php
// Manage Ads
session_start();
// Include libraries
ob_start();
require('../defines/constants.inc');
require('../includes/session_admin.inc');
require('../includes/functions.inc');
require("../includes/DbConn/libphp.DbConnect.0-1.inc"); // Database Connection Class
require("../includes/query/libphp.MysqlQuery.0-1.inc"); // Query Class

if(Session::validate() !== 0)
{
    header("Location: index.php");
}

if( (isset($_GET['u'])))
{
    // Try / Catch
    try
    {
	// Load Variables
	$ad_id = escape($_GET['u']);
	
	// Get next web_url ID
	// Make connection to database
	$conn = MysqlConnect::connect();
	MysqlConnect::db_use($conn, "testing_url4cash");
	
	// Open new instance of the query class
	$query = new MysqlQuery($conn);
	
	$qresult = $query->SendSingleQuery("DELETE FROM ad_entry WHERE ad_id = '{$ad_id}';");
	
	if($qresult === -1)
	{
	    // Error
	    header("Location: view_ads.php?e=0");
	    exit;
	}
	else
	{
	    // Success, added
	    header("Location: view_ads.php?e=S");
	    exit;
	}	

    }
    catch(Exception $e)
    {
	// Error
	header("Location: view_ads.php?e=1");
	exit;
    }
}
ob_end_flush();
if(isset($_GET['e']))
{
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
 
// Make connection to the database
$conn = MysqlConnect::connect();
MysqlConnect::db_use($conn, "testing_url4cash");
$query = new MysqlQuery($conn);

$qresult = $query->GetSingleQuery("--MULTI","SELECT ad_id,ad_name,ad_link FROM ad_entry ORDER BY ad_id ASC;",array("ad_id","ad_name","ad_link"),"ad_link");   
// Any Errors
if($qresult < 0)
{
    // Mysql Error
    echo "Server Error: Please reload page";
    exit;
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Administrator - Powered By ExitLinks - Converting Boring Links to Cash!</title>
<link rel="stylesheet" href="css/style.css" type="text/css" media="screen" />

<script type="text/javascript" src="js/accordian.pack.js"></script>

</head>

<body>

<div id="header">
<h1><a href="index.php">Administrator</a></h1>
<h2>Powered by LinkShave - Converting Boring Links to Cash!</h2>
</div>

<div id="accordian" ><!--Parent of the Accordion-->
<center><th><a href="index.php">Admin's Home</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="view_ads.php">Manage Advertisements</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="create_ads.php">Create Advertisements</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="view_clicks.php">Manage Clicks</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="view_users.php">User Management</a></th></center>
<br>


<!--Start of each accordion item-->
  <div id="test-header" class="accordion_headings header_highlight" >Manage Existing Ads</div><!--Heading of the accordion ( clicked to show n hide ) -->
  
  <!--Prefix of heading (the DIV above this) and content (the DIV below this) to be same... eg. foo-header & foo-content-->
  
  <div id="test-content"><!--DIV which show/hide on click of header-->
  
  	<!--This DIV is for inline styling like padding...-->
    <div class="accordion_child">
		<h2>View and Manage Existing Ads</h2>
		<table>
		<tbody><tr>
		<th>ID</th>
		<th>Name</th>
		<th>URL</th>
		<th>Delete</th>
		</tr>
<?php
    foreach($qresult as $value)
    {
	echo  "<tr><td>",$value['ad_id'],"</td><td>",$value['ad_name'],"</td><td>",$value['ad_link'],"</td><td>","<a href='view_ads.php?u=".$value['ad_id']."'>Delete","</a></td></tr>";
   }
?>
		</tbody></table>
	</div>
    
  </div>
<!--End of each accordion item--> 

    <blockquote><em>Success is how high you bounce when you hit bottom - George S. Patton</em></blockquote>
  </div>
<!--End of each accordion item--> 


<div id="footer">		
<!-- Please leave this line intact -->
<p>Powered By <a href="http://www.ExitLinks.net">ExitLinks</a>. <br />
Official ExitLinks Store: <a href="http://www.scriptdorks.com">ScriptDorks</a> <br />
<!-- you can delete below here -->
&copy; ExitLinks. All Rights Reserved.</p>
</div>

</body>
</html>
