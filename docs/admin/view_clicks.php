<?php
// MANAGE_MONEY
session_start();
// Include libraries
require('../defines/constants.inc');
require('../includes/session_admin.inc');
require('../includes/functions.inc');
require("../includes/DbConn/libphp.DbConnect.0-1.inc"); // Database Connection Class
require("../includes/query/libphp.MysqlQuery.0-1.inc"); // Query Class

if(Session::validate() !== 0)
{
    header("Location: login.php");
}


if(isset($_GET['e']))
{
    $NEW_URL = "";
    // Switch through error to check for code and match up
    switch($_GET['e'])
    {
	case "0":
	  // Invalid Email Address
	  $ERROR_REGISTER_MESSAGE = DATABASE_ERROR;
	break;
	case "10":
	  // Invalid password
	  $ERROR_REGISTER_MESSAGE = INVALID_MONTH;		
	break;
	case "11":
	  // Database Error
	  $ERROR_REGISTER_MESSAGE = INVALID_DAY;
	break;
	case "12":
	  // Database Error
	  $ERROR_REGISTER_MESSAGE = INVALID_YEAR;
	break;
	case "13":
	  // Database Error
	  $ERROR_REGISTER_MESSAGE = INVALID_DATE;
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
// User ID

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
	header("Location: view_clicks.php?e=10");
	exit;
    }
    
    // Check day
    if( (($day < 1) or ($day > 31)) or (($day2 < 1) or ($day2 > 31)))
    {
	header("Location: view_clicks.php?e=11");
	exit;
    }
    
    // Check year for validity
    if( (($year < 2007) or ($year > 2032)) or (($year < 2007) or ($year > 2032)))
    {
	header("Location: view_clicks.php?e=12");
	exit;
    }

    // Try making time
    $new_time = strtotime($day."-".$month."-".$year);
    $new_time2 = strtotime($day2."-".$month2."-".$year2);
    
    if( ($new_time === false) or ($new_time2 === false))
    {
	// Error, return false time
	header("Location: view_clicks.php?e=13");
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

if(isset($_GET['u']))
{
    // We now have date ranges, continue
    $user_id = escape($_GET['u']);
    $new_time = (isset($_GET['t'])) ? $_GET['t'] : $new_time ;
    $new_time2 = (isset($_GET['t'])) ? $_GET['t2'] : $new_time2 ;
    
    $date1 = date('Y-m-d H:i:s',$new_time);
    $date2 = date('Y-m-d H:i:s',$new_time2);

    
    $qresult = $query->GetSingleQuery("--MULTI","SELECT dtime,ip_addr,url_id,ad_id,url_link,user_id FROM url_click WHERE user_id = '{$user_id}' AND dtime BETWEEN '{$date1}' AND '{$date2}';",array("dtime","ip_addr","url_id","ad_id","url_link","user_id"),"dtime");
     
    // Any Errors
    if($qresult < 0)
    {
	// Mysql Error
	echo "Server Error: Please reload page";
	exit;
    }
    
    $_RESULTS_SHOWING = "Showing Results for user ".$user_id;
}
else
{
    // We now have date ranges, continue
    $qresult = $query->GetSingleQuery("--MULTI","SELECT dtime,ip_addr,url_id,ad_id,url_link,user_id FROM url_click WHERE dtime BETWEEN '{$date1}' AND '{$date2}';",array("dtime","ip_addr","url_id","ad_id","url_link","user_id"),"dtime");
     
    // Any Errors
    if($qresult < 0)
    {
	// Mysql Error
	echo "Server Error: Please reload page";
	exit;
    }
    
    $_RESULTS_SHOWING = "Showing Results for All Users";
}
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Administrator - Powered By ExitLinks - Converting Boring Links to Cash!</title>
<link rel="stylesheet" href="css/style.css" type="text/css" media="screen" />

<script type="text/javascript" src="js/accordian.pack.js"></script>

</head>

<body>

<div id="header">
<h1><a href="index.php">Administrator</a></h1>
<h2>Powered by ExitLinks - Converting Boring Links to Cash!</h2>
</div>
<div id="accordian" ><!--Parent of the Accordion-->
<center><th><a href="index.php">Admin's Home</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="view_ads.php">Manage Advertisements</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="create_ads.php">Create Advertisements</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="view_clicks.php">Manage Clicks</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="view_users.php">User Management</a></th></center>
<br>


<!--Start of each accordion item-->
  <div id="test2-header" class="accordion_headings" >View and Manage Clicks</div><!--Heading of the accordion ( clicked to show n hide ) -->
  
  <!--Prefix of heading (the DIV above this) and content (the DIV below this) to be same... eg. foo-header & foo-content-->
  
  <div id="test2-content"><!--DIV which show/hide on click of header-->
  
  	<!--This DIV is for inline styling like padding...-->
    <div class="accordion_child">	
		<h2>User Revenue Management</h2>
		<table>
		<tbody><tr>
		<th>URL</th>
		<th>Time</th>
		<th>IP Address</th>
		<th>More..</th>
		</tr>
<?php
    foreach($qresult as $value)
    {
	$time = strtotime($value['dtime']);
	$date = date('r',$time);
	echo  "<tr><td>",$value['url_link'],"</td><td>",$date,"</td><td>",$value['ip_addr'],"</td><td>","  <a href='view_clicks.php?u=".$value['user_id']."</td><td>".$new_time."</td><td>".$new_time2."'>View All for This User (id=",$value['user_id'],")</a>","</td></tr>";
    }
?>
		</tbody></table>
    </div>
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
