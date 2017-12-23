<?php


// Constant Defines, change these values
/*
	THIS FILE CONTAINS CONSTANT VALUES
	THESE CAN BE CHANGED BY YOU
	SIMPLY CHANGE THE RIGHT HAND VALUE TO WHATEVER YOU WANT
	(eg:)
	change 4 to 3 in define("USERNAME_MIN_CHARACTERS",4)

	For error messages, write custom ones...


*/



/// MYSQL PASSWORD
define('DB_SERVER', 'localhost'); // MYSQL HOST
define('DB_USERNAME', 'DATABASE USERNAME'); // MYSQL USER NAME
define('DB_PW', 'PASSWORD'); // MYSQL PASSWORD
define('DB', 'DATABASE NAME'); // DATABASE NAME

// USERNAME_MIN & MAX_CHARACTERS -- Maximum Characters and Minimum Characters for a username
define("USERNAME_MIN_CHARACTERS", 4); // Change integer value (4) to another minimum value. MIN must be less than MAX below
define("USERNAME_MAX_CHARACTERS", 20); // Change integer value (4) to another maximum value, MAX must be greater than MIN above

// Site Variables
define("SITE_PATH","http://www.YOUR WEBSITE URL GOES HERE.com/"); // Path (URL) to your site, MUST INCLUDE TRAILING SLASH
define("COST_PER_CLICK",0.0005); // HOW MUCH PER CLICK TO BE PAID TO USER


// MAX and MIN PASSWORD LENGTH
define("PASSWORD_MIN_CHAR", 5);
define("PASSWORD_MAX_CHAR", 15);

// ERROR MESSAGES
define("USERNAME_WRONGLENGTH", "Error: Username invalid"); // username is the wrong lenght, too short or too long
define("INVALID_EMAILADDR", "Error: Email address is not valid"); // Email address is not valid
define("INVALID_PAYPALEMAIL", "Error: Paypal Email Address is not valid"); // Paypal Email address is not valid
define("INVALID_PASSWORD", "Error: Password is not valid"); // Password is not valid
define("EMAIL_NO_MATCH", "Error: Email addresses do not match"); // Email addresses do not match
define("PASSWORD_NO_MATCH", "Error: Passwords do not match"); // Passwords do not match
define("DATABASE_ERROR", "A server error occurred - Try again"); // Server Error
define("EMAIL_ALREADY_REGISTERED", "Error: This email address has already been registered"); // Email address already registered
define("TRY_CATCH", "A server error occurred - Try again"); // Server Error
define("EMAIL_DOESNT_EXIST", "Error: The email address you entered does not exist"); // User does not exist for login
define("INCORRECT_PASSWORD", "Error: The Password you entered is invalid"); // Incorrect Password
define("SESSION_SET_ERROR", "Error: Server Session set failed, please try again"); // Server Error in setting session
define("BLANK_ENTRY", "Error: No fields can be left blank!"); // If a input field is blank
define("INVALID_DATE", "Error: Date is not valid"); // If the date put to the user is not valid
define("INVALID_MONTH","Error: Month is not valid"); // If the month is not valid
define("INVALID_YEAR", "Error: Year is not valid"); // if the year is not valid
define("INVALID_DAY", "Error: Day is not valid");
define("ADMIN_INVALID_PASSWORD", "Error: Password or Username is not correct"); // Invalid Password for admin panel
define("ADMIN_INVALID_USER", "Error: Password or Username is not correct"); // Invalid UIs


// Success Messages
define("ADD_URL_SUCCESS", "Success: Url added successfully!"); // URL ADD success
define("PASS_CHANGE_SUCCESS", "Success: Password successfully changed"); // Password Change
define("DATA_CHANGE_SUCCESS", "Success: User Info changed"); // User InFO change
define("PAYPAL_CHANGE_SUCCESS", "Success: Paypal Email Updated"); // Update paypal email
define("DEL_SUCCESS", "Success Deleting!"); // Delete success
define("SUCCESS_AD", "Success Adding Ad"); // Add an Ad success



?>
