<?php
// If ADD_Ad is in add mode...
session_start();
ob_start();
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

// If add flag is set
if( (isset($_POST['ad_ad'])) and ( ($_POST['add_data'] == '83hffZ#97^@dIUD7s') ) )
{
    // Try / Catch
    try
    {
	// Load Variables
	// web_url = URL TO CONVERT
	$name = escape($_POST['ad_name']);
	$link = escape($_POST['ad_link']);
	$type = escape($_POST['ad_type']);
	$text = escape($_POST['ad_text']);
	$width = (int) $_POST['width'];
	$height = (int) $_POST['height'];
	$format = $_POST['ad_i'];
	
	switch($format)
	{
	  case "in":
	    $format = 1;
	  break;
	  default:
	    $format = 0;
	  break;
	}
	
	// Switch through ad types
	switch($type)
	{
	  case "html":
	  case "adsense":
	    // Do nothing
	  break;
	  case "img":
	    $text = '<a href="'.$link.'" target="_blank"><img src="'.$text.'" style="border:none;width:auto;margin:0 auto;height:auto;" /></a>';
	  break;
	  case "swf":
	    $text = '<object width="'.$width.'" height="'.$height.'"><param name="movie" value="'.$text.'"><embed src="'.$text.'" width="'.$width.'" height="'.$height.'"></embed></object>';
	  break;
	  default:
	    $text = $text;
	  break;
	}
	
	// Get next web_url ID
	// Make connection to database
	$conn = MysqlConnect::connect();
	MysqlConnect::db_use($conn, "testing_url4cash");
	
	// Open new instance of the query class
	$query = new MysqlQuery($conn);
	
	// Store information in database    
	$qresult = $query->SendSingleQuery("INSERT INTO ad_entry(ad_name,ad_link,ad_txt,ad_type) VALUES('{$name}','{$link}','{$text}','{$format}');");
	
	if($qresult == -1)
	{
	    // Error occurred
	    header("Location: create_ads.php?e=0");
	}
	else
	{
	    // Success, added
	    header("Location: create_ads.php?e=S");
	}	

    }
    catch(Exception $e)
    {
	// Error
	header("Location: create_ads.php?e=1");
    }
}
else if(isset($_GET['e']))
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
	  $ERROR_REGISTER_MESSAGE = SUCCESS_AD;
	break;
	default:
	  $ERROR_REGISTER_MESSAGE = "";
	break;
    
    
    }
    
}
ob_end_flush();
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
<h2>Powered by ExitLinks - Converting Boring Links to Cash!</h2>
</div>

<div id="accordian" ><!--Parent of the Accordion-->
<center><th><a href="index.php">Admin's Home</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="view_ads.php">Manage Advertisements</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="create_ads.php">Create Advertisements</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="view_clicks.php">Manage Clicks</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="view_users.php">User Management</a></th></center>
<br>



<!--Start of each accordion item-->

  <div id="test1-header" class="accordion_headings" >Create New Ads</div><!--Heading of the accordion ( clicked to show n hide ) -->
  
  <!--Prefix of heading (the DIV above this) and content (the DIV below this) to be same... eg. foo-header & foo-content-->
  
  <div id="test1-content"><!--DIV which show/hide on click of header-->
  
  	<!--This DIV is for inline styling like padding...-->
    <div class="accordion_child">

		<h2>Create a New Ad</h2>								
		
<form method="POST" action="create_ads.php" enctype="multipart/form-data" id="addurl_form" name="addurl_form"> 
Name of the Ad<br /><input type="text" name="ad_name" id="ad_name" value="" />
<br /><br />
Full URL of Link (leave blank for Google Adsense) e.g. http://www.scriptdorks.com<br /><input type="text" name="ad_link" id="ad_link" value="" />
<br /><br />Coding for Ad<br />
<select name="ad_type" id="ad_type">
      <option value="html">HTML</option>
      <option value="adsense">Adsense / Other JavaScript Code</option>
      <option value="img" default="default">Image</option>
      <option value="swf">Flash</option>
   </select>
  <br /><br />Style of Ad to be Shown<br /><select name="ad_i" id="ad_i">
      <option value="ba">Top-Frame Advertisement</option>
      <option value="in">Interstatial Advertisement</option>
   </select>
     <br /><br />Enter Advertisement Coding<br /><textarea name="ad_text" id="ad_text"></textarea>
     <br /><br />IF Flash is chosen, please input the height and width<br />
    <input type="text" name="width" id="width" value="Width" />&nbsp;    <input type="text" name="height" id="height" value="Height" />

  <input type="hidden" name="add_data" id="add_data" value="83hffZ#97^@dIUD7s" />
  <br />
  <input type="submit" name="ad_ad" id="ad_ad" value="Create" />
</form>
    </div>
    </div>
    
<!--End of each accordion item--> 


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
