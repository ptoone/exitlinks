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
      if( (isset($_GET['u'])))
      {
          // Try / Catch
          try
          {
          // Load Variables
          $clicks = escape($_GET['u']);
          // Get next web_url ID
          // Make connection to database
          $conn = MysqlConnect::connect();
          MysqlConnect::db_use($conn, "testing_url4cash");
          // Open new instance of the query class
          $query = new MysqlQuery($conn);
          $qresult = $query->SendSingleQuery("DELETE FROM url_users WHERE clicks = '{$clicks}';");
          if($qresult === -1)
          {
              // Error
              header("Location: view_users.php?e=0");
              exit;
          }
          else
          {
              // Success, added
              header("Location: view_users.php?e=S");
              exit;
          }  
          }
          catch(Exception $e)
          {
          // Error
          header("Location: view_users.php?e=1");
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
      //Reseting User Value
      if (isset($_GET['reset'])) {
          // Make connection to the database
          $conn = MysqlConnect::connect();
          MysqlConnect::db_use($conn, "testing_url4cash");
          $query = new MysqlQuery($conn);
          $user_id = $_GET['reset'];
          //Resetting
          $qresult = $query->SendSingleQuery("UPDATE url_users SET clicks='0' WHERE id='$user_id'");
          if($qresult === -1) echo '';
          else echo '';
      }
      // Make connection to the database
      $conn = MysqlConnect::connect();
      MysqlConnect::db_use($conn, "testing_url4cash");
      $query = new MysqlQuery($conn);
      $qresult = $query->GetSingleQuery("--MULTI","SELECT id,user_name,first_name,last_name,user_email,user_paypal,country,clicks FROM url_users ORDER BY id ASC;",array("id","user_name","first_name","last_name","user_email","user_paypal","country","clicks"),"id");
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
      <h2>Powered by ExitLinks - Converting Boring Links to Cash!</h2>
      </div>
      <div id="accordian" ><!--Parent of the Accordion-->
      <center><th><a href="index.php">Admin's Home</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="view_ads.php">Manage Advertisements</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="create_ads.php">Create Advertisements</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="view_clicks.php">Manage Clicks</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="view_users.php">User Management</a></th></center>
      <br>
      <!--Start of each accordion item-->
        <div id="test3-header" class="accordion_headings" >User Management</div><!--Heading of the accordion ( clicked to show n hide ) -->
        <!--Prefix of heading (the DIV above this) and content (the DIV below this) to be same... eg. foo-header & foo-content-->
        <div id="test3-content"><!--DIV which show/hide on click of header-->
          <!--This DIV is for inline styling like padding...-->
          <div class="accordion_child">
              <h2>View Registered Users</h2>
              <table>
              <tbody><tr>
              <th>Username</th>
              <th>Name</th>
              <th>E-Mail Address</th>
              <th>PayPal Address</th>
              <th>Country</th>
              <th># of Clicks</th>
              <th>View Clicks</th>
              <th>Reset User</th>
              <th>Delete User</th>
              </tr>
      <?php
          foreach($qresult as $value)
          {
           echo  "<tr><td>",$value['user_name'],"</td><td>",$value['first_name'],"</td><td>",$value['user_email'],"</td><td>",$value['user_paypal'],"</td><td>",$value['country'],"</td><td>",$value['clicks'],"</td><td>","<a href='view_clicks.php?u=".$value['id']."'>View</a>","</td><td>","<a href='view_users.php?reset=".$value['id']."'>Reset","</a></td><td>","<a href='view_users.php?u=".$value['clicks']."'>Delete User","</a></td></tr>";
         }
      ?>
              </tbody></table>
          </div>
        </div>
      <!--End of each accordion item-->
      <blockquote><em>Success is how high you bounce when you hit bottom - George S. Patton</em></blockquote>
      </div><!--End of accordion parent-->
      <div id="footer">      
      <!-- Please leave this line intact -->
      <p>Powered By <a href="http://www.exitlinks.net">ExitLinks</a>. <br />
      Official ExitLinks Store: <a href="http://www.scriptdorks.com">ScriptDorks</a> <br />
      <!-- you can delete below here -->
      &copy; ExitLinks. All Rights Reserved.</p>
      </div>
      </body>
      </html>