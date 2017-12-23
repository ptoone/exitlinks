<?php
// MANAGE_MONEY
session_start();
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
		<title>Earnings - ExitLinks - Converting Boring Links to Cash!</title>
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

						<li ><a href="index.php" id="navBlog">Blog</a></li>
						<li ><a href="manage_url.php" id="navManage">Manage Links</a></li>
			            <li ><a href="index.php" id="navCreate">Create Links</a></li>
						<li  class="selected"><a href="manage_money.php" id="navEarnings">Earnings</a></li>
						<li ><a href="../help.php" id="navHelp">Help</a></li>

					</ul>
				</div>
			    
			</div>
			<hr />
			<div id="body">
				

	<div style='clear: both;'></div>

            <div id="content">
                <h2 class="first">Finances</h2>
                <p>View your earnings and or request a payment here</p>
                <dl id="balance">
	                <dt><strong>Total Earnings:</strong></dt>
	                <dd>$<?php echo $_CLICK_VALUE*COST_PER_CLICK; ?> USD</dd>
					<dt><strong>Total Clicks:</strong></dt>
	                <dd><?php echo $_CLICK_VALUE; ?></dd>
	                
                </dl>
                <dl id="payment">
                    <dd><a href="../request_payment.php"><img src="../img/button_payment.gif" border="0" id="imgBtn" alt="Request Payment" /></a></dd>

                    <dd id="payStat"></dd>
	                <dt>Minimum payment to request is $10.00</dt>

                </dl>
<br><br><br><br><br><br><br><br> <br><br>
<form id="" name="" method="POST" action="manage_money.php">
Please select the range between dates below so you can find out when your links were clicked! <br /><br /><strong>FROM:</strong> Month:
  <select name="date_month" id="date_month">
      <option value="01">Jan</option>
      <option value="02">Feb</option>
      <option value="03">Mar</option>
      <option value="04">Apr</option>
      <option value="05">May</option>
      <option value="06">Jun</option>
      <option value="07">Jul</option>
      <option value="08">Aug</option>
      <option value="09">Sep</option>
      <option value="10">Oct</option>
      <option value="11">Nov</option>
      <option value="12">Dec</option>

  </select>
    Day:
  <select name="date_day" id="date_day">
      <option value="01">01</option>
      <option value="02">02</option>
      <option value="03">03</option>
      <option value="04">04</option>
      <option value="05">05</option>
      <option value="06">06</option>
      <option value="07">07</option>
      <option value="08">08</option>
      <option value="09">09</option>
      <option value="10">10</option>
      <option value="11">11</option>
      <option value="12">12</option>
      <option value="13">13</option>
      <option value="14">14</option>
      <option value="15">15</option>
      <option value="16">16</option>
      <option value="17">17</option>
      <option value="18">18</option>
      <option value="19">19</option>
      <option value="20">20</option>
      <option value="21">21</option>
      <option value="22">22</option>
      <option value="23">23</option>
      <option value="24">24</option>
      <option value="25">25</option>
      <option value="26">26</option>
      <option value="27">27</option>
      <option value="28">28</option>
      <option value="29">29</option>
      <option value="30">30</option>
      <option value="31">31</option>
      </select>
	Year:
	<input type="text" name="date_year" id="date_year" value="2009" />
	<br />
<br /><strong>TO:</strong> Month:
  <select name="date_month2" id="date_month2">
      <option value="01">Jan</option>
      <option value="02">Feb</option>
      <option value="03">Mar</option>
      <option value="04">Apr</option>
      <option value="05">May</option>
      <option value="06">Jun</option>
      <option value="07">Jul</option>
      <option value="08">Aug</option>
      <option value="09">Sep</option>
      <option value="10">Oct</option>
      <option value="11">Nov</option>
      <option value="12">Dec</option>

  </select>
    Day:
  <select name="date_day2" id="date_day2">
      <option value="01">01</option>
      <option value="02">02</option>
      <option value="03">03</option>
      <option value="04">04</option>
      <option value="05">05</option>
      <option value="06">06</option>
      <option value="07">07</option>
      <option value="08">08</option>
      <option value="09">09</option>
      <option value="10">10</option>
      <option value="11">11</option>
      <option value="12">12</option>
      <option value="13">13</option>
      <option value="14">14</option>
      <option value="15">15</option>
      <option value="16">16</option>
      <option value="17">17</option>
      <option value="18">18</option>
      <option value="19">19</option>
      <option value="20">20</option>
      <option value="21">21</option>
      <option value="22">22</option>
      <option value="23">23</option>
      <option value="24">24</option>
      <option value="25">25</option>
      <option value="26">26</option>
      <option value="27">27</option>
      <option value="28">28</option>
      <option value="29">29</option>
      <option value="30">30</option>
      <option value="31">31</option>
      </select>
	Year:
	<input type="text" name="date_year2" id="date_year2" value="2009" />
	<input type="submit" name="get_date" id="get_date" value="Show Clicks!" />
</form>              
                <h3>Link Click Stats</h3>

                
                <table class="data" style="width: 100%;">
                <tr class="nolinks">        <th><center>Searching Clicks from: <strong><?php echo date('r',$new_time); ?> AND <?php echo date('r',$new_time2); ?></strong></center></th><br></tr>
                </table>
		<table class="data" >
		<tbody><tr>
		<th>Original Link</th>
		<th>Time</th>
		</tr>
<?php
    foreach($qresult as $value)
    {
	$time = strtotime($value['dtime']);
	$date = date('r',$time);
	echo  "<tr><td>",$value['url_link'],"</td><td>",$date,"</td></tr>";
    }
?>
		</tbody></table>

			    

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