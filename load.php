<?php

/// DO NOT CHANGE PHP CODE AT ALL!!!! 

// Output Buffering
ob_start();
session_start();
// Include Libraries
require("defines/constants.inc"); 
require("includes/DbConn/libphp.DbConnect.0-1.inc"); // Database Connection Class
require("includes/query/libphp.MysqlQuery.0-1.inc"); // Query Class

// Make sure _GET['i'] Exists
if(!(isset($_GET['i'])))
{
    die("Incorrect URL");
}


// Database Connection
$conn = MysqlConnect::connect();
MysqlConnect::db_use($conn, "testing_url4cash");

// Get count of ads in the database
$query = new MysqlQuery($conn);


// Get URL to load in page, 
$url_hash = $_GET['i'];

// Look in query database
$qresult = $query->GetSingleQuery("--SINGLE","SELECT user_id,url_id,web_url,web_type FROM url_urls WHERE web_nurl = '{$url_hash}';",array("user_id","url_id","web_url","web_type"));

if($qresult < 0)
{
    // Mysql Error occurred
    echo "Server Error #2A45: Please reload page";
    exit;
}

// Does anything by that ID exist
if($qresult["web_url"] == "")
{	
    echo "Malformed URL, please check link and try again!";
    exit;
}

// Declare Variables
$_URL_ID = $qresult["url_id"];
$_USER_ID = $qresult["user_id"];
$_WEB_URL = $qresult["web_url"];

switch($qresult["web_type"])
{
    case "interstitial":
      $_WEB_TYPE = 1;
    break;
    default:
      $_WEB_TYPE = 0;
    break;
}

$qresult = $query->ccount('ad_entry','ad_id',true," WHERE ad_type = $_WEB_TYPE");

// Check for error
if($qresult === -1)
{
    // MYSQL ERROR Occurred
    echo "Server Error #2A4F: Please reload page";
    exit;
}

// We have count, make random number between 0 and _COUNT_
$rand = rand(0,$qresult-1);

if($rand == 0)
{
    $max = 1;
    $min = $rand;
}
else if($rand == $qresult-1)
{
    $min = $rand-1;
    $max = $rand;
}
else
{
    $max = $rand;
    $min = $rand;
}

$mysql_query = "SELECT ad_id,ad_txt,ad_link FROM ad_entry WHERE ad_type = $_WEB_TYPE LIMIT {$min},{$max};";

$qresult = $query->GetSingleQuery("--SINGLE",$mysql_query,array("ad_id","ad_txt","ad_link"));

// If errors
if($qresult < 0)
{
    // MYSQL ERROR Occurred
    echo "Server Error #2A9: Please reload page";
    exit;
}

// Ads
$_SESSION['exitlinks.net_scriptdorks.com_672_txtad'] = $qresult["ad_txt"];
$_AD_ID = $qresult["ad_id"];
$_AD_LINK = $qresult["ad_link"];

// Check if user has already clicked
// Send cookie if cookie does not exist
if((isset($_COOKIE['_URLCASH_COOKIE_TP9235'])) and (isset($_SESSION['_URL$CASH_8398fh48qo8732^%RTD**(#Y*#YT*&FH#YR)_TPCATRICK&%(*#RFB101038'])) and (($_SESSION['_URL$CASH_8398fh48qo8732^%RTD**(#Y*#YT*&FH#YR)_TPCATRICK&%(*#RFB101038']) == true) and (isset($_SESSION['_URL$CASH_8398fh48qo8732^%RTD**(#Y*#YT*&FH#YR)_TPCATRICK&%_USERID'])) and (($_SESSION['_URL$CASH_8398fh48qo8732^%RTD**(#Y*#YT*&FH#YR)_TPCATRICK&%_USERID']) == $_URL_ID) )
{
    // Click already recorded, do nothing
}
else
{
    // Set cookie 
    setcookie('_URLCASH_COOKIE_TP9235',true,time()+86400);
    $_SESSION['_URL$CASH_8398fh48qo8732^%RTD**(#Y*#YT*&FH#YR)_TPCATRICK&%(*#RFB101038'] = true;
    $_SESSION['_URL$CASH_8398fh48qo8732^%RTD**(#Y*#YT*&FH#YR)_TPCATRICK&%_USERID'] = $_URL_ID;
    
    // Update click by one
    $qresult = $query->SendSingleQuery("INSERT INTO url_click(dtime,ip_addr,user_id,url_id,ad_id,url_link) VALUES(NOW(),'{$_SERVER['REMOTE_ADDR']}','{$_USER_ID}','{$_URL_ID}','{$_AD_ID}','{$_WEB_URL}');");
    
    $qresult = $query->SendSingleQuery("UPDATE url_users SET clicks = clicks+1 WHERE id = '{$_USER_ID}';");
    
}

$_AD_TXT = $_SESSION['exitlinks.net_scriptdorks.com_672_txtad'];

ob_end_flush();
?>

<!-- Modify this HTML code
    To output the LINK of the randomly chosen ad, place this code minus the slash \ in the src field of the frame for the ad
    {$_AD_LINK}

    To output the URL of the page to be loaded, place this code minus the slash \ in the src field of the frame for the page 
    {$_WEB_URL}
    
    For the interstitial ad, to output the ad contents
    {$_AD_TXT}
    
    Html code between BANNER is the code for a banner above page. Code between INTERSTITIAL is code for interstitial page
-->
<?php
if($_WEB_TYPE == 0)
{
// Edit HTML code between BANNER and BANNER and INTERSTITIAL and INTERSTITIAL
echo <<<BANNER
<frameset rows="20%,80%">
<frame style="borders:none;" scrolling="no" noresize="noresize" src="ads.php?l={$_AD_LINK}"> 
</frame>
<frame noresize="noresize" src="{$_WEB_URL}"> </frame>
</framset>
BANNER;

}
else
{

echo <<<INTERSTITIAL
<!-- THIS SCRIPT MUST BE KEPT HERE TO HAVE AUTOMATIC REDIRECTION -->
<script type="text/javascript">
function redir()
{
  window.location = "{$_WEB_URL}";
};

setTimeout("redir()",8000);
</script>
<!-- -->
<div id="intermission">

		<div id="lb_header">
		    <div id="lb_wrap">
		        <a href="http://demo.scriptdorks.com/" target="_blank" class="lb_link left"><img src="img/el.png" border="0"></a>
		        Site Will Load in 8 Seconds &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="{$_WEB_URL}">Skip This >></a>
		    </div>

		</div>
<br /><br /><center>
  {$_AD_TXT}
</center></div>
INTERSTITIAL;


}

?>
<!DOCTYPE html PUBLIC " -//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
<title>ExitLinks - Converting Those Boring Links to Cash!</title>
<link rel="stylesheet" href="ads.css" type="text/css" media="screen" charset="utf-8" />
<link rel="stylesheet" href="ads-inter.css" type="text/css" media="screen" charset="utf-8" />

</head>
</html>