<?php

/**
=-----------------------------------------------------------------------

  PHP Database Object Connecter -> libphp.DbConnect.0-1.inc

   Version 0.1

   2009 ScriptDorks.com
-----------------------------------------------------------------------=

Information
------------------------------------------------------------------------
This class contains an abstract class, with methods predifined for use with any database. This way, switching databases is very easy. 

To create a database class, it must extend that abstract class.
------------------------------------------------------------------------

Requirements
------------------------------------------------------------------------
This class requires to perform:

Error Reporting Library to be included in TOP LEVEL file
guildConfigValues file included in TOP LEVEL file
------------------------------------------------------------------------
  
License
--------------------------------------------------------------------------
Copyright (C) 2009 ScriptDorks.com

This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation; either version 3 of the License, or any later version.

This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.

A copy of the GPL is located at <http://www.gnu.org/licenses>.
--------------------------------------------------------------------------
*/

/**
     ------------------------------------------
      abstract class Database
     ------------------------------------------
  
      - This abstract class defines the way methods must access each other, as well as including some public / protected methods for use
      
      PARAMETERS
      ------------------------------
      
      ------------------------------
   
      DEFINED METHODS
      ------------------------------
       obj public method connect
       void public method close
      ------------------------------
*/

abstract class Database
 {
   public static $conn;
   abstract public static function connect($host=null,$uname=null,$password=null,$db=null,$port=null,$socket=null);
   abstract public static function destruct(&$conn);
   abstract public static function db_use($conn,$db);
  /** 
     ------------------------------------------
    public static method escape
     ------------------------------------------
  
      - This method cleans input for DB insertion
      
      PARAMETERS
      ------------------------------
      string in_string [ data to be escaped ]
      Optional String $method [ default USESLASH: Filters using slashes | USEBOTH: Slash, then entities ]
      obj connection [ Connection to database ] [ Depreciated, no function should call ]
      ------------------------------
  */
  static public function escape($in_string,$method="USESLASH",$conn=null)
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
 }


/**
     ------------------------------------------
      class MysqlConnect extends abstract class Database
     ------------------------------------------
  
      - This class connects to the Mysql Database, and has methods for connecting and killing connections.
      
      DEFINED METHODS
      ------------------------------
       obj public method connect
       void public method destruct
      ------------------------------
*/

class MysqlConnect extends Database
{
  public function __construct()
   {


   }


  /**
   ------------------------------------------
    public static string conn
   ------------------------------------------
    -- Stores a copy of the database connection object $obj
  */
  public static $conn = null;

  /**
     ------------------------------------------
     obj public static method connect
     ------------------------------------------
  
      - This method connects to the specified mysql user, and returns the connection, as well as setting $conn = $obj.
      
      PARAMETERS
      ------------------------------
      OPTIONAL string host [ Host name to connect to - localhost or IP address ]
      OPTIONAL string uname [ Username to connect to ]
      OPTIONAL string password [ Password for username ]
      OPTIONAL string db [ Database to use as default ]
      OPTIONAL string port [ Port to connect to ]
      OPTIONAL string socket [ socket to connect to ]
      ------------------------------
      RETURN VALUES
      ------------------------------
      $obj TRUE
      -1 Mysql Connection Error
      ------------------------------
  */
  public static function connect($host=null,$uname=null,$password=null,$db=null,$port=null,$socket=null)
   {
    if(self::$conn === null)
     {
      if($host === null)
       {
         $host = DB_SERVER;
       }
      if($uname === null)
       {
         $uname = DB_USERNAME;
       }
      if($password === null)
       {
         $password = DB_PW;
       }
/*      if($db === null)
       {
         $db = DB;
       }*/
      $obj = new mysqli($host,$uname,$password,$db,$port,$socket);
      if(mysqli_connect_errno() != 0)
       {
         // Define error
         return -1;
       }
      $obj->query('SET NAMES \'utf8\'');
      self::$conn = $obj;
      return $obj;
     }
    else
     {
       return self::$conn;
     }
   }

  /**
     ------------------------------------------
     void public method destruct
     ------------------------------------------
  
      - This method closes the $in conection, and sets $obj = null, as well as setting the outside $conn variable to null.
      
      PARAMETERS
      ------------------------------
      obj conn [ Connection to kill ]
      ------------------------------
      RETURN VALUES
      ------------------------------
      void
      ------------------------------
  */

 public static function destruct(&$conn)
  {
    $conn->close();
    $conn = null;
    self::$conn = null;
  }

   /**
     ------------------------------------------
     void public method db_use
     ------------------------------------------
  
      - This method sets the database to $db
      
      PARAMETERS
      ------------------------------
      obj conn [ Connection to change database for ]
      string db [ Database to use ]
      ------------------------------
      RETURN VALUES
      ------------------------------
      void
      ------------------------------
  */
 public static function db_use($conn,$db)
  {
    $conn->query("USE ".DB.";");
  }

}
