<?php

/**
=-----------------------------------------------------------------------

  PHP Mysql Query -> libphp.MysqlQuery.0-1.inc

   Version 0.1.001
    ->Revision 1(0.1.000->0.1.001) [ Add method ccount, no need for recompiling added functionality ]

   2009 ScriptDorks.com

Modified for use with United Jedi site April 28, 2008 [ ScriptDorks.com ]
Modified for use with the URL4Cash site Feb 13, 2009 [ScriptDorks.com ] (Removed all error reporting), (Removed this.user_id from constructor)
-----------------------------------------------------------------------=

!!!!!!!!!!<ATTENTION>!!!!!!!!!!!!!!!!!!

 - This Library has <NO> screening of queries before hand, so make sure ALL data is escaped before passing the query to this library. 

Information
------------------------------------------------------------------------
This class contains methods to perform:

Performing single queries
Performing multiple queries
------------------------------------------------------------------------

Requirements
------------------------------------------------------------------------
This class requires to perform:
A working mysql object
------------------------------------------------------------------------
  
License
--------------------------------------------------------------------------
Copyright (C) 2009 ScriptDorks.com

This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation; either version 3 of the License, or any later version.

This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.

A copy of the GPL is located at <http://www.gnu.org/licenses>.
--------------------------------------------------------------------------

*/
class MysqlQuery
{
// Start Class
 public function __construct($conn)
  {
    $this->conn = $conn;
    if($conn === null)
     {
       $obj = MysqlConnect::$conn;
       if(($obj === null) or (!is_object($obj)))
        {
          return -798;
        }
       else
        {
          $this->conn = $obj;
        }
     }
  }

  /** 
  =---------------------------------
   public method GetSingleQuery()
  ---------------------------------=
   - This method returns the result of the query as an array, string, XML, or other depending on format specified.
   
   Parameters -- prefix "in"
   ------------------------------------------
   string format
     -- --SINGLE [ Returns data in array arrayname[key_column] ]
     -- --MULTI [ Returns data in a multi-dimensional array, arrayname[index][key_column] ]
   string query
     -- [ Full query to execute, eg. "SELECT * FROM tablename WHERE value=value" ]
   array list
     -- [ List of all fields to return as keys ]
   string index DEFAULT NULL USE FOR --MULTI ONLY
     -- [ The index with which to search by and use as index in array key, for example news_id ]
   ------------------------------------------

   Structure
   ------------------------------------------
    This method prepares the query, and depending on the flag passed, groups the data according to format specifies, and returns it as an array.
   ------------------------------------------

   Requirements
   ------------------------------------------
    Connection to the database must be present
   ------------------------------------------

   Errors
   ------------------------------------------
    Returns array on true
   -1  Expected array for in_list, no array to be found / invalid array
   -2  in_format must be of type --SINGLE or --MULTI, got $in_format
   -3  Error submitting query
   -4  Expected index, got null
   -----------------------------------------
 */

  public function GetSingleQuery($in_format,$in_query,$in_list,$in_index=null)
   {
     // Validate to make sure in_list is an array of items
     if(!is_array($in_list))
      {
        return -1;
      }
     $conn = $this->conn;
     if($in_format === "--SINGLE")
      {
         $result = $conn->query($in_query);
         if($result === false)
           {
             // Report Error
	     return -3;
           }
         else
           {
             $array = array();
             while(($row = $result->fetch_assoc()) !== NULL)
              {
                foreach($in_list as $item)
                 {
                   $s = $row[$item];
                   $array[$item] = $s;
                 }
              }
             return $array;
           }
      }
     else if($in_format === "--MULTI")
      {
         if(($in_index === null) or $in_index == "")
          {
            return -4;
          }
         $result = $conn->query($in_query);
         if($result === false)
           {
              return -3;
           }
         else
           {
             $array = array();
             while(($row = $result->fetch_assoc()) !== NULL)
              { 
                $i = $row[$in_index];
                foreach($in_list as $item)
                 {
                   $s = $row[$item];
                   $array[$i][$item] = $s;
                 }
              }
             return $array;
           }
      }
     else
      {
        return -2;
      }
   }

  /** 
  =---------------------------------
   public method SendSingleQuery()
  ---------------------------------=
   - This method sends a query to the database for execution, an insert, update, or delete statement for example.
   
   Parameters -- prefix "in"
   ------------------------------------------
   string query
     -- [ Full query to execute, eg. "UPDATE tablename SET id = "id" WHERE value=value" ]
   ------------------------------------------

   Structure
   ------------------------------------------
    This method prepares the query, and executes it
   ------------------------------------------

   Requirements
   ------------------------------------------
    Connection to the database must be present
   ------------------------------------------

   Errors
   ------------------------------------------
    1  success
   -1  Error executing query, check logs
   -----------------------------------------
 */

 public function SendSingleQuery($in_query)
  {
    $conn = $this->conn;
    $result = $conn->query($in_query);
    if ($result === FALSE)
     {
        return -1;
     }
    else
     {
        return 1;
     }
  }


  /** 
  =---------------------------------
   public method ccount()
  ---------------------------------=
   - This method counts the number of records in database, and returns it as [INT]
   ------------------------------------------
   string TABLE
     -- [ Table where column exists ]
   string COLUMN
     -- [ Column to count ]
   optional boolean WHERE
     -- [ Add a WHERE clause - true if where clause, false if none, defaults false ], eg. "WHERE user_id = 'd'
    optional string WHEREVAL
    --	[ Where section to add to string
   ------------------------------------------

   Structure
   ------------------------------------------
    This method prepares the query, and executes it
   ------------------------------------------

   Requirements
   ------------------------------------------
    Connection to the database must be present
   ------------------------------------------

   Errors
   ------------------------------------------
    1  success
   -1  Error executing query, check logs
   -----------------------------------------
 */

 public function ccount($in_table,$in_column,$in_where=false,$in_whereval=null)
  {
    $conn = $this->conn;
    if($in_where === false)
      {
          $result = $conn->query("SELECT count({$in_column}) FROM {$in_table};");
      }
    else
      {
          $result = $conn->query("SELECT count({$in_column}) FROM {$in_table} {$in_whereval};");
      }
    if ($result === FALSE)
     {
         return -1;
     }
    else
     {
         $intCount = 0;
         while(($row = $result->fetch_assoc()) !== NULL)
             {
                 $intCount = $row["count({$in_column})"];
             }
         return $intCount;
     }
  }

// End Class
}

?>