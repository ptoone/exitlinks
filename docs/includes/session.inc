<?php

class Session
{
    // Returns -1 if no session started, -2 if exception, 0 on success
    static public function start($id,$name)
    {
	// Check for session enabled
	if(!isset($_SESSION))
	{
	    return -1;
	}
	
	// Try / catch block
	try
	{
	    // Define Salts
	    $SALT1 = "C)(&U#HF#T^VHSCVH@@$2548205(#";
	    $SALT2 = "6324r^^&%28-10CJnvsgf cm isdfIs ify^@~`8";
	    $SALT3 = "S0x83tf9scvjw272*@*@9Q()#%(*#Dhf34t7468&#";
	    $IPSALT = ";::fL;SF9034TLaDP129371`9w92r98ikvcdsfr0w30r";
	  
	    // Create hashes
	    // Hashes have the salt, value, and are md5 hashed
	    $hsh = md5($_SERVER['HTTP_USER_AGENT'].$SALT1);
	    $hsh2 = md5($SALT2.$_SERVER['REMOTE_ADDR'].$SALT3);
	    $hsh3 = md5($_SERVER['REMOTE_ADDR'].$IPSALT);
    
	    // Declare Session Variables
	    $_SESSION['_URL$CLICK_D(*@#!_D@R*&$%(){*@)_D_TPATRICK_FEB10&296'] = array();
	
	    // Store hashes and security measures
	    $_SESSION['_URL$CLICK_D(*@#!_D@R*&$%(){*@)_D_TPATRICK_FEB10&296']['user_id'] = $id;	    
	    $_SESSION['_URL$CLICK_D(*@#!_D@R*&$%(){*@)_D_TPATRICK_FEB10&296']['user_name'] = $name;	  
	    $_SESSION['_URL$CLICK_D(*@#!_D@R*&$%(){*@)_D_TPATRICK_FEB10&296']['user_agent'] = $hsh;
	    $_SESSION['_URL$CLICK_D(*@#!_D@R*&$%(){*@)_D_TPATRICK_FEB10&296']['ip_address'] = $hsh3;
	    $_SESSION['_URL$CLICK_D(*@#!_D@R*&$%(){*@)_D_TPATRICK_FEB10&296']['security'] = $hsh2;
	    $_SESSION['_URL$CLICK_D(*@#!_D@R*&$%(){*@)_D_TPATRICK_FEB10&296']['created'] = true;
	
	    // Store any other session data in session
	
	}
	catch(Exception $e)
	{
	    return -2; // Exception thrown
	}
	
	// Else
	return 0;
	
    }
   
    // Returns -1 on failure to set session, 0 success
    static public function end_session()
    {
	// Check for session enabled
	if(!isset($_SESSION))
	{
	    return -1;
	}
	
	// Destroy session
	session_destroy();
	
	return 0;
    }
    
    // Returns -1 on no session, -2 try catch error, -500 possible violation, 0 all good
    static public function validate()
    {
	// Check for session enabled
	if(!isset($_SESSION))
	{
	    return -1;
	}
	
	// Try / catch block
	try
	{
	    // Define Salts
	    $SALT1 = "C)(&U#HF#T^VHSCVH@@$2548205(#";
	    $SALT2 = "6324r^^&%28-10CJnvsgf cm isdfIs ify^@~`8";
	    $SALT3 = "S0x83tf9scvjw272*@*@9Q()#%(*#Dhf34t7468&#";
	    $IPSALT = ";::fL;SF9034TLaDP129371`9w92r98ikvcdsfr0w30r";
	  
	    // Create hashes
	    // Hashes have the salt, value, and are md5 hashed
	    $hsh = md5($_SERVER['HTTP_USER_AGENT'].$SALT1);
	    $hsh2 = md5($SALT2.$_SERVER['REMOTE_ADDR'].$SALT3);
	    $hsh3 = md5($_SERVER['REMOTE_ADDR'].$IPSALT);
	    // Is variable even initialized?
	    if(!(isset($_SESSION['_URL$CLICK_D(*@#!_D@R*&$%(){*@)_D_TPATRICK_FEB10&296'])))
	    {
		return -500;
	    }
	    
	    // Make sure session has not been tampered with
	    if( ( ($_SESSION['_URL$CLICK_D(*@#!_D@R*&$%(){*@)_D_TPATRICK_FEB10&296']['user_agent']) !== $hsh) or ( ($_SESSION['_URL$CLICK_D(*@#!_D@R*&$%(){*@)_D_TPATRICK_FEB10&296']['ip_address']) !== $hsh3) or ( ($_SESSION['_URL$CLICK_D(*@#!_D@R*&$%(){*@)_D_TPATRICK_FEB10&296']['security']) !== $hsh2) )
	    {
		// Possible session violation, destroy session
		session_destroy();
		
		return -500;
		
	    }
	    else if(!($_SESSION['_URL$CLICK_D(*@#!_D@R*&$%(){*@)_D_TPATRICK_FEB10&296']['created']))
	    {
		// Regenerate ID
		session_regenerate_id();
		$_SESSION['_URL$CLICK_D(*@#!_D@R*&$%(){*@)_D_TPATRICK_FEB10&296']['created'] = true;
		return 0;
	    }
	    else
	    {
		// All good, return 0
		return 0;
	    }
	    
	    
	
	}
	catch(Exception $e)
	{
	    return -2; // Exception thrown
	}

    }
    
    static public function get($key)
    {
	try
	{
	    if(!isset($_SESSION))
	    {
		return -1;
	    }
	    else
	    {
		return $_SESSION['_URL$CLICK_D(*@#!_D@R*&$%(){*@)_D_TPATRICK_FEB10&296'][$key];
	    }
	}
	catch(Exception $e)
	{
	    return -1;
	}
    }
    
    




}








?>
