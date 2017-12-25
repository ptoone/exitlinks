<?php 
 
 /** 
     ------------------------------------------
    function escape
     ------------------------------------------
  
      - This method cleans input for DB insertion
      
      PARAMETERS
      ------------------------------
      string in_string [ data to be escaped ]
      Optional String $method [ default USESLASH: Filters using slashes | USEBOTH: Slash, then entities ]
      ------------------------------
  */
  function escape($in_string,$method="USESLASH")
   {
     if($in_string === NULL)
      {
        return '';
      }
     $str0 = ereg_replace('([%;])', '\\\1', $in_string);
     $str =$str0;#= mysql_real_escape_string($str0);
     if($method == "USESLASH")
      {
         return $str;
      }
      else if($method == "USEBOTH")
      {
        return htmlspecialchars($str,ENT_NOQUOTES,"UTF-8");
      }
   }
  
  
  /**
  *	string function getNewCount($in_string)
  *	
  *	- This function returns the next incrementation of url count $in_string. Since the count is not numerical (0-9 and then A-Z) it has to be managed by a function.
  *
  *	$in_string STRING -- The url count
  */
  function getNewCount($in_count)
  {
      // Get string length
      $length = strlen($in_count); // Length of string, how many characters
      $i = 0; // Counter
      $j = 0; // Counter
      $new_count = $in_count; // New string
      $rollover = false; // Next digit rollover
      $array_of_letters = array('0','1','2','3','4','5','6','7','8','9','A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y'); // Array of all increments
      $array_of_values = array('1','2','3','4','5','6','7','8','9','A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z'); // Array of new increments
      
      $letter_array_count = count($array_of_letters);

      // Check if it is a full string
      if($in_count[0] == 'Z')
      {
	  // Add 1, loop through each length of strlen and put as 0s
	  $pholder = "1";
	  
	  for($i = 0; $i < $length; $i++)
	  {
	      $pholder .= "0";
	  }
	  
	  return $pholder;
      }

      for($i = $length-1; $i > -1; $i--)
      {           
	  // If rollover
	  if($rollover == true)
	  {
	      // If == Z
	      if($in_count[$i] == 'Z')
	      {
		  $new_count[$i] = '0';
		  continue;
	      }
	      else
	      {
		  for($j = 0; $j < $letter_array_count; $j++)
		  {
		      // Do they match
		      if($array_of_letters[$j] == $in_count[$i])
		      {
			  // Set new count
			  $new_count[$i] = $array_of_values[$j];
			  break;
		      }
		  }
	      
		  $rollover == false;
		  
		  break;
	      }
	  }
	  // Check last digit
	  else if($in_count[$i] == 'Z')
	  {
	      // Rollover
	      $new_count[$i] = '0';
	      $rollover = true;
	      continue;
	  }
	  else
	  {	
	      for($j = 0; $j < $letter_array_count; $j++)
	      {
		  // Do they match
		  if($array_of_letters[$j] == $in_count[$i])
		  {
		      // Set new count
		      $new_count[$i] = $array_of_values[$j];
		      break;
		  }
	      }
	      
	      break;
	  }
      
       }
      
      // Return new count
      return $new_count;
  
  }
   
 ?>