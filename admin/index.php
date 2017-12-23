<?php
// Admin Management Panel
// Make sure user can validly go here
session_start();

require('../includes/session_admin.inc');

if(Session::validate() !== 0)
{
    header("Location: login.php");
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
<h2>Powered by ExitLinks - Converting Boring Links to Cash!</h2>
</div>

<div id="accordian" ><!--Parent of the Accordion-->
<center><th><a href="index.php">Admin's Home</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="view_ads.php">Manage Advertisements</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="create_ads.php">Create Advertisements</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="view_clicks.php">Manage Clicks</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="view_users.php">User Management</a></th></center>
<br>

<!--Start of each accordion item-->
  <div id="test-header" class="accordion_headings header_highlight" >Welcome, Admin!</div><!--Heading of the accordion ( clicked to show n hide ) -->
  
  <!--Prefix of heading (the DIV above this) and content (the DIV below this) to be same... eg. foo-header & foo-content-->
  
  <div id="test-content"><!--DIV which show/hide on click of header-->
  
  	<!--This DIV is for inline styling like padding...-->
    <div class="accordion_child">
<a href='view_ads.php'><h2>Manage Existing Advertisements</h2></a>
<a href='create_ads.php'><h2>Create Advertisements</h2></a>
<a href='view_clicks.php'><h2>Manage and View Clicks</h2></a>
<a href='view_users.php'><h2>User Management</h2></a>
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
