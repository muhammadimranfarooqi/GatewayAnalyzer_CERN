<?php
class connection
{
 
 public $mssqlHost;
    var $PassWord;
    var $DataBase;
	var $HostName;
	var $link;
	var $s;

 /*...........................................................  
     				Establishing connection with DB
    ...........................................................*/

    function connection($mysql_user,$mysql_pass,$mysql_host,$mysql_db)
    {
  
	mysql_connect($mysql_host,$mysql_user,$mysql_pass) or die (mysql_error());
	mysql_select_db($mysql_db) or die (mysql_error());
 
   }
    
  /*...........................................................  
     				Performing SQL query to get results
    ...........................................................*/
    
    
	function get_data($query)
	{
	   $result = mysql_query($query) or die("Query failed : " . mysql_error());
	   return $result;

   	}
   	
   	 /*...........................................................  
     				Performing SQL query to store data
    ...........................................................*/

	function store_data($query)
	{
	   $flag = mysql_query($query);
	   return $flag;
	}
	 /*...........................................................  
     				Performing SQL query to update data
    ...........................................................*/

	function update_data($query)
	{
	  $flag = mysql_query($query);
	  return $flag;
	}

	/*...........................................................  
		Performing SQL query to get total number of results
    ...........................................................*/

	function total_data($query)
	{
	  $result = mysql_query($query);
	  $line = mysql_fetch_array($result, MYSQL_ASSOC);
	  return $line['col_count'];
	}
	/*...........................................................  

		Performing SQL query to get total number of results
    ...........................................................*/

	function getTotalData($result)
	{
	
	  $line = mysql_fetch_array($result);
	  
	  return $line;
	}

		
	 /*...........................................................  
     				Closing Db connection 
    ...........................................................*/

	function Close_Db()
	{
	  
       mysql_close($this->link);
	
	}
	
}
/****************************************************************************************/
?>