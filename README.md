# exitlinks
Formally sold through ScriptDorks, this URL Shortener is now free and open source.

Steps to Install:

1. Unzip all contents from ZIP file

2. Upload all files to your website host provider

3. Change the CHMOD of the following files to 755;
a) "includes/DbConn/libphp.DbConnect.0-1.inc"
b) "includes/query/libphp.MysqlQuery.0-1.inc"

4. Open "defines/constants.inc" and Edit the following;
a) Database Username
b) Database Password
c) Database Name
d) Website URL
e) Cost Per Click of Ad (optional)

5. Open "includes/DbConn/DbConfig.inc"
a) Change 'DB NAME' to your MySQL Database Name
b) Change 'DB Username' to your MySQL Database Username
c) Change 'PASSWORD' to your MySQL Database Password

6. Upload "defines/constants.inc" to your website host provider for your new configuration to be adapted
- That's It!
-------------------------------------------------------------------------
-------------------------------------------------------------------------
Admin Details:
username: admin
password: password
-------------------------------------------------------------------------
-------------------------------------------------------------------------
How to Change Admin Details?
a) open file, "admin/login.php"
b) change the following;
    // Check to see if user name and password match
    if($_POST['user_name'] === "admin")
    {
	if($_POST['user_password'] === "password")
-------------------------------------------------------------------------
-------------------------------------------------------------------------
How to Change the Email Address on the Contact Forms?
a) in both "contactus.php" and "request_payment.php" find, "EMAIL ADDRESS" and simply enter in your e-mail address
-------------------------------------------------------------------------
-------------------------------------------------------------------------

If you require any specific coding help please submit a GIT.

Thank You for choosing ExitLinks!

