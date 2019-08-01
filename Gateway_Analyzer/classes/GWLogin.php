<?php

class GWLogin
{
    
/*****************************************************************************************************************************************************************************

//View Current Login

*****************************************************************************************************************************************************************************/	
function viewCurrentLogin($gateway,$user_name,$destination_user_name,$source_host,$destination_host,$service,$direction,$am_status_code,$fromDate,$toDate,$logoutFromDate,$logoutToDate,$loginStatus,$sort,$how,&$con)
	{
	$cn = (object)$con;
	  $criteria ="";
	
	 $gateway = mysql_real_escape_string($gateway);
	 $user_name = mysql_real_escape_string($user_name);
	 $destination_user_name = mysql_escape_string($destination_user_name);
	 $source_host = mysql_real_escape_string($source_host);
	 $destination_host = mysql_real_escape_string($destination_host);
	 $service = mysql_real_escape_string($service);
	 $direction = mysql_real_escape_string($direction);
	 $am_status_code = mysql_real_escape_string($am_status_code);
	 $fromDate = mysql_real_escape_string($fromDate);
	 $toDate = mysql_real_escape_string($toDate);
	 $logoutFromDate =  mysql_real_escape_string($logoutFromDate);
	 $logoutToDate =  mysql_real_escape_string($logoutToDate);

	

  /********** Setting tables for the query at the end *************/
$table = "SELECT SU.user_name AS source_user, RU.user_name AS remote_user, SH.host_name AS source_host, RH.host_name AS remote_host, gateways.name AS gw_name,login,logout,services.name AS name,direction, am_statuses.am_return_code,am_statuses.am_return_code_description as amd
			FROM gw_logins 
			LEFT JOIN users SU ON gw_logins.user_id=SU.user_id 
			LEFT JOIN users RU ON gw_logins.remote_user_id=RU.user_id 
			LEFT JOIN hosts SH ON gw_logins.source_id=SH.host_id 
			LEFT JOIN hosts RH ON gw_logins.destination_id=RH.host_id 
			LEFT JOIN gateways ON gw_logins.gw_id=gateways.id LEFT JOIN services ON gw_logins.service_id=services.id 
			LEFT JOIN am_statuses ON gw_logins.am_id=am_statuses.am_id ";
			
 /**** If everything is null in the form field then run this query otherwise the query at the end will be executed *******/
 
if ($gateway=="" and $user_name=="" and $destination_user_name=="" and $source_host=="" and $destination_host=="" and $service=="" and $direction=="" and $am_status_code=="" and $fromDate=="" and $toDate=="" and $logoutFromDate=="" and $logoutToDate=="") {
$query = " SELECT SU.user_name AS source_user, RU.user_name AS remote_user, SH.host_name AS source_host, RH.host_name AS remote_host, gateways.name AS gw_name,login,services.name AS name,direction, am_statuses.am_return_code,am_statuses.am_return_code_description as amd
	FROM gw_logins 
	LEFT JOIN users SU ON gw_logins.user_id=SU.user_id 
	LEFT JOIN users RU ON gw_logins.remote_user_id=RU.user_id 
	LEFT JOIN hosts SH ON gw_logins.source_id=SH.host_id 
	LEFT JOIN hosts RH ON gw_logins.destination_id=RH.host_id 
	LEFT JOIN gateways ON gw_logins.gw_id=gateways.id  LEFT JOIN services ON gw_logins.service_id=services.id 
	LEFT JOIN am_statuses ON gw_logins.am_id=am_statuses.am_id 
	WHERE logout IS Null ORDER BY $sort $how";
}
else {
 if ($gateway!="") {
 	if ($criteria == "" ) {
 		$criteria = "gateways.name='$gateway'";
 		}
 	else {
 		$criteria = $criteria ." and gateways.name='$gateway'";
 		 	}
 }
if ($user_name!="") {
	$first_chr = substr($user_name,0,1);
	$ulen = strlen($user_name);
	$last_chr = substr($user_name,$ulen-1,1);
	if ($first_chr=="*" and $last_chr=="*") {
		$user_name = substr($user_name,1,$ulen-2);
		if ($criteria == "") {
			$criteria = "SU.user_name Like '%$user_name%'";
		}
		else {
	 	$criteria = $criteria ." and SU.user_name Like '%$user_name%'";
	 	}
	}
	else if ($first_chr=="*") {
		$user_name = substr($user_name,1,$ulen-1);
		if ($criteria == "") {
			$criteria = "SU.user_name Like '%$user_name'";
		}
		else {
	 	$criteria = $criteria ." and SU.user_name Like '%$user_name'";
	 	}
	} 
	else if ($last_chr=="*") {
		$user_name = substr($user_name,0,$ulen-1);
		if ($criteria == "") {
			$criteria = "SU.user_name Like '$user_name%'";
		}
		else {
	 	$criteria = $criteria ." and SU.user_name Like '$user_name%'";
	 	}
	}
	else {
	if ($criteria == "") {
			$criteria = "SU.user_name='$user_name'";
		}
		else {
	 	$criteria = $criteria ." and SU.user_name='$user_name'";
	 	}
	} 
 }

if ($destination_user_name!="") {
	
	$first_chr = substr($destination_user_name,0,1);
	$ulen = strlen($destination_user_name);
	$last_chr = substr($destination_user_name,$ulen-1,1);
	if ($first_chr=="*" and $last_chr=="*") {
		$destination_user_name = substr($destination_user_name,1,$ulen-2);
		if ($criteria == "") {
			$criteria = "RU.user_name Like '%$destination_user_name%'";
		}
		else {
	 	$criteria = $criteria ." and RU.user_name Like '%$destination_user_name%'";
	 	}
	}
	else if ($first_chr=="*") {
		$destination_user_name = substr($destination_user_name,1,$ulen-1);
		if ($criteria == "") {
			$criteria = "RU.user_name Like '%$destination_user_name'";
		}
		else {
	 	$criteria = $criteria ." and RU.user_name Like '%$destination_user_name'";
	 	}
	} 
	else if ($last_chr=="*") {
		$destination_user_name = substr($destination_user_name,0,$ulen-1);
		if ($criteria == "") {
			$criteria = "RU.user_name Like '$destination_user_name%'";
		}
		else {
	 	$criteria = $criteria ." and RU.user_name Like '$destination_user_name%'";
	 	}
	}
	else {
		
	if ($criteria == "") {
			$criteria = "RU.user_name='$destination_user_name'";
		}
		else {
	 	$criteria = $criteria ." and RU.user_name='$destination_user_name'";
	 	}
	} 
 }
if ($source_host!="") {
	$first_chr = substr($source_host,0,1);
	$ulen = strlen($source_host);
	$last_chr = substr($source_host,$ulen-1,1);
	if ($first_chr=="*" and $last_chr=="*") {
		$source_host = substr($source_host,1,$ulen-2);
		if ($criteria == "") {
			$criteria = "SH.host_name like '%$source_host%'";
		}
		else {
	 	$criteria = $criteria ." and SH.host_name like '%$source_host%'";
	 	}
	}
	else if ($first_chr=="*") {
		$source_host = substr($source_host,1,$ulen-1);
		if ($criteria == "") {
			$criteria = "SH.host_name like '%$source_host'";
		}
		else {
	 	$criteria = $criteria ." and SH.host_name like '%$source_host'";
	 	}
	} 
	else if ($last_chr=="*") {
		$source_host = substr($source_host,0,$ulen-1);
		if ($criteria == "") {
			$criteria = "SH.host_name like '$source_host%'";
		}
		else {
	 	$criteria = $criteria ." and SH.host_name like '$source_host%'";
	 	}
	}
	else {
		$pos = strpos($source_host,".cern.ch");
     if($pos === false) {
     	$fqdn = $source_host . ".cern.ch";
         }
    if ($fqdn==""){
    	$sh = "SH.host_name='$source_host'";
    }
    else {
    	$sh = "(SH.host_name='$source_host' or SH.host_name='$fqdn')";
    }
    if ($criteria == "") {
			$criteria = $sh;
		}
		else {
	 	$criteria = $criteria ." and $sh";
	 	}
	} 
 }

if ($destination_host!="") {
	$first_chr = substr($destination_host,0,1);
	$ulen = strlen($destination_host);
	$last_chr = substr($destination_host,$ulen-1,1);
	if ($first_chr=="*" and $last_chr=="*") {
		$destination_host = substr($destination_host,1,$ulen-2);
		if ($criteria == "") {
			$criteria = "RH.host_name like '%$destination_host%'";
		}
		else {
	 	$criteria = $criteria ." and RH.host_name like '%$destination_host%'";
	 	}
	}
	else if ($first_chr=="*") {
		$destination_host = substr($destination_host,1,$ulen-1);
		if ($criteria == "") {
			$criteria = "RH.host_name like '%$destination_host'";
		}
		else {
	 	$criteria = $criteria ." and RH.host_name like '%$destination_host'";
	 	}
	} 
	else if ($last_chr=="*") {
		$destination_host = substr($destination_host,0,$ulen-1);
		if ($criteria == "") {
			$criteria = "RH.host_name like '$destination_host%'";
		}
		else {
	 	$criteria = $criteria ." and RH.host_name like '$destination_host%'";
	 	}
	}
	else {
	$pos = strpos($destination_host,".cern.ch");
    if($pos === false) {
     	$dfqdn = $destination_host . ".cern.ch";
       }
	 if ($dfqdn==""){
    	$sh = "RH.host_name='$destination_host'";
    }
    else {
    	$sh = "(RH.host_name='$destination_host' or RH.host_name='$dfqdn')";
    }  
	if ($criteria == "") {
			$criteria = $sh;
		}
		else {
	 	$criteria = $criteria ." and $sh";
	 	}
	} 
 }
if ($service !="Select" && $service !="") {
	if ($criteria == "") {
		$criteria = "services.name ='$service'";
	}
	else {
 	$criteria = $criteria ." and services.name ='$service'";
 	}
 }
if ($direction!="Select" && $direction!="") {
	if ($criteria == "") {
	$criteria = "gw_logins.direction ='$direction'";
	}
	else {
 	$criteria = $criteria ." and gw_logins.direction ='$direction'";
 	}
  }
if ($am_status_code!="Select" && $am_status_code!="") {
	if ($criteria == "") {
	$criteria = "am_statuses.am_return_code_description  ='$am_status_code'";
	}
	else {
 	$criteria = $criteria ." and am_statuses.am_return_code_description  ='$am_status_code'";
 	}
  }
if ($fromDate=="lastday") {
$yesterday  = date('Y-m-d H:i:s',time()-3600*24);
$todate = date('Y-m-d H:i:s');
	if ($criteria == "") {
	$criteria = "login between '$yesterday' and '$todate'";
	}
	else {
 	$criteria = $criteria ." and login between '$yesterday' and '$todate'";
	}
}
else if ($fromDate=="lastweek") {
$week  = date('Y-m-d H:i:s',time()-3600*24*6);

$todate = date('Y-m-d H:i:s');
	if ($criteria == "") {
	$criteria = "login between '$week' and '$todate'";
	}
	else {
 	$criteria = $criteria ." and login between '$week' and '$todate'";
 }
}
else if ($fromDate=="lastmonth") {
$month  = date('Y-m-d H:i:s',time()-3600*24*29);

$todate = date('Y-m-d H:i:s');
	if ($criteria == "") {
	$criteria = "login between '$month' and '$todate'";
	}
	else {
 	$criteria = $criteria ." and login between '$month' and '$todate'";
 	}
}
else if ($fromDate=="lastyear") {
$year  = date('Y-m-d H:i:s',time()-3600*24*365);
$todate = date('Y-m-d H:i:s');
	if ($criteria == "") {
	$criteria = "login between '$year' and '$todate'";
	}
	else {
 	$criteria = $criteria ." and login between '$year' and '$todate'";
  	}
}
else {

if ($fromDate!="" && $toDate!="") {
	 $fDate = date('Y-m-d H:i:s', strtotime($fromDate));
	 $tDate = date('Y-m-d H:i:s', strtotime($toDate));
	 //$date = strtotime(date("Y-m-d H:i:s", strtotime($tDate)));
	// $td = Date("Y-m-d H:i:s", $date);

	if ($criteria == "") {
	$criteria = "login between '$fromDate'and '$tDate'";
	}
	else {
 	$criteria = $criteria ." and login between '$fromDate'and '$tDate'";
 	}
  }
}
if ($logoutFromDate=="lastday") {
$yesterday  = date('Y-m-d H:i:s',time()-3600*24);
$todate = date('Y-m-d H:i:s');
	if ($criteria == "") {
	$criteria = "logout between '$yesterday' and '$todate'";
	}
	else {
 	$criteria = $criteria ." and logout between '$yesterday' and '$todate'";
	}
}
else if ($logoutFromDate=="lastweek") {
$week  = date('Y-m-d H:i:s',time()-3600*24*6);

$todate = date('Y-m-d H:i:s');
	if ($criteria == "") {
	$criteria = "logout between '$week' and '$todate'";
	}
	else {
 	$criteria = $criteria ." and logout between '$week' and '$todate'";
 }
}
else if ($logoutFromDate=="lastmonth") {
$month  = date('Y-m-d H:i:s',time()-3600*24*29);

$todate = date('Y-m-d H:i:s');
	if ($criteria == "") {
	$criteria = "logout between '$month' and '$todate'";
	}
	else {
 	$criteria = $criteria ." and logout between '$month' and '$todate'";
 	}
}
else if ($logoutFromDate=="lastyear") {
$year  = date('Y-m-d H:i:s',time()-3600*24*365);
$todate = date('Y-m-d H:i:s');
	if ($criteria == "") {
	$criteria = "logout between '$year' and '$todate'";
	}
	else {
 	$criteria = $criteria ." and logout between '$year' and '$todate'";
  	}
}
else {
if ($logoutFromDate!="" && $logoutToDate!="") {
	 $lfDate = date('Y-m-d H:i:s', strtotime($logoutFromDate));
	 $ltDate = date('Y-m-d H:i:s', strtotime($logoutToDate));
	// $date = strtotime(date("Y-m-d H:i:s", strtotime($ltDate)) . " +1 day");
	// $ltd = Date("Y-m-d H:i:s", $date);

	if ($criteria == "") {
	$criteria = "logout between '$logoutFromDate'and '$ltDate'";
	}
	else {
 	$criteria = $criteria ." and logout between '$logoutFromDate' and '$ltDate'";
 	}
  }
}
  if ($loginStatus=="ON") 
  	$logout = "logout is NULL";
  else
  	$logout = "logout is NOT NULL";
$query = $table . " WHERE ".$logout." and " . $criteria . " ORDER BY $sort $how";
}
$rs = $cn->get_data($query);
return $rs;
}
/*****************************************************************************************************************************************************************************

//View Current Login for Specific Page

*****************************************************************************************************************************************************************************/	
function viewCurrentLoginSpecificPage($gateway,$user_name,$destination_user_name,$source_host,$destination_host,$service,$direction,$am_status_code,$fromDate,$toDate,$logoutFromDate,$logoutToDate,$loginStatus,$sort,$how,$StartRow,$PageSize,&$con)
{
	$cn = (object)$con;
	$criteria ="";

	 $gateway = mysql_real_escape_string($gateway);
	 $user_name = mysql_real_escape_string($user_name);
	 $source_host = mysql_real_escape_string($source_host);
	 $destination_host = mysql_real_escape_string($destination_host);
	 $service = mysql_real_escape_string($service);
	 $direction = mysql_real_escape_string($direction);
	 $am_status_code = mysql_real_escape_string($am_status_code);
	 $fromDate = mysql_real_escape_string($fromDate);
	 $toDate = mysql_real_escape_string($toDate);
  //echo "Detail : ".$logoutFromDate."<BR>".$logoutToDate."<BR>";

$table = "SELECT SU.user_name AS source_user, RU.user_name AS remote_user, SH.host_name AS source_host, RH.host_name AS remote_host, gateways.name AS gw_name,login,services.name AS name,direction, am_statuses.am_return_code,am_statuses.am_return_code_description as amd,logout
			FROM gw_logins 
			LEFT JOIN users SU ON gw_logins.user_id=SU.user_id 
			LEFT JOIN users RU ON gw_logins.remote_user_id=RU.user_id 
			LEFT JOIN hosts SH ON gw_logins.source_id=SH.host_id 
			LEFT JOIN hosts RH ON gw_logins.destination_id=RH.host_id 
			LEFT JOIN gateways ON gw_logins.gw_id=gateways.id LEFT JOIN services ON gw_logins.service_id=services.id 
			LEFT JOIN am_statuses ON gw_logins.am_id=am_statuses.am_id ";
if ($gateway=="" and $user_name=="" and $destination_user_name=="" and $source_host=="" and $destination_host=="" and $service=="" and $direction=="" and $am_status_code=="" and $fromDate=="" and $toDate=="" and $logoutFromDate=="" and $logoutToDate=="") {
$query = " SELECT SU.user_name AS source_user, RU.user_name AS remote_user, SH.host_name AS source_host, RH.host_name AS remote_host, gateways.name AS gw_name,login,services.name AS name,direction, am_statuses.am_return_code ,am_statuses.am_return_code_description as amd,logout
	FROM gw_logins 
	LEFT JOIN users SU ON gw_logins.user_id=SU.user_id 
	LEFT JOIN users RU ON gw_logins.remote_user_id=RU.user_id 
	LEFT JOIN hosts SH ON gw_logins.source_id=SH.host_id 
	LEFT JOIN hosts RH ON gw_logins.destination_id=RH.host_id 
	LEFT JOIN gateways ON gw_logins.gw_id=gateways.id LEFT JOIN services ON gw_logins.service_id=services.id 
	LEFT JOIN am_statuses ON gw_logins.am_id=am_statuses.am_id 
	WHERE logout IS Null ORDER BY $sort $how LIMIT $StartRow,$PageSize";
}
else {
 if ($gateway!="") {
 	if ($criteria == "" ) {
 		$criteria = "gateways.name='$gateway'";
 		}
 	else {
 		$criteria = $criteria ." and gateways.name='$gateway'";
 		 	}
 }
if ($user_name!="") {
	$first_chr = substr($user_name,0,1);
	$ulen = strlen($user_name);
	$last_chr = substr($user_name,$ulen-1,1);
	if ($first_chr=="*" and $last_chr=="*") {
		$user_name = substr($user_name,1,$ulen-2);
		if ($criteria == "") {
			$criteria = "SU.user_name Like '%$user_name%'";
		}
		else {
	 	$criteria = $criteria ." and SU.user_name Like '%$user_name%'";
	 	}
	}
	else if ($first_chr=="*") {
		$user_name = substr($user_name,1,$ulen-1);
		if ($criteria == "") {
			$criteria = "SU.user_name Like '%$user_name'";
		}
		else {
	 	$criteria = $criteria ." and SU.user_name Like '%$user_name'";
	 	}
	} 
	else if ($last_chr=="*") {
		$user_name = substr($user_name,0,$ulen-1);
		if ($criteria == "") {
			$criteria = "SU.user_name Like '$user_name%'";
		}
		else {
	 	$criteria = $criteria ." and SU.user_name Like '$user_name%'";
	 	}
	}
	else {
	if ($criteria == "") {
			$criteria = "SU.user_name='$user_name'";
		}
		else {
	 	$criteria = $criteria ." and SU.user_name='$user_name'";
	 	}
	} 
 }
if ($destination_user_name!="") {
	$first_chr = substr($destination_user_name,0,1);
	$ulen = strlen($destination_user_name);
	$last_chr = substr($destination_user_name,$ulen-1,1);
	if ($first_chr=="*" and $last_chr=="*") {
		$destination_user_name = substr($destination_user_name,1,$ulen-2);
		if ($criteria == "") {
			$criteria = "RU.user_name Like '%$destination_user_name%'";
		}
		else {
	 	$criteria = $criteria ." and RU.user_name Like '%$destination_user_name%'";
	 	}
	}
	else if ($first_chr=="*") {
		$destination_user_name = substr($destination_user_name,1,$ulen-1);
		if ($criteria == "") {
			$criteria = "RU.user_name Like '%$destination_user_name'";
		}
		else {
	 	$criteria = $criteria ." and RU.user_name Like '%$destination_user_name'";
	 	}
	} 
	else if ($last_chr=="*") {
		$destination_user_name = substr($destination_user_name,0,$ulen-1);
		if ($criteria == "") {
			$criteria = "RU.user_name Like '$destination_user_name%'";
		}
		else {
	 	$criteria = $criteria ." and RU.user_name Like '$destination_user_name%'";
	 	}
	}
	else {
	if ($criteria == "") {
			$criteria = "RU.user_name='$destination_user_name'";
		}
		else {
	 	$criteria = $criteria ." and RU.user_name='$destination_user_name'";
	 	}
	} 
 }
 
if ($source_host!="") {
	$first_chr = substr($source_host,0,1);
	$ulen = strlen($source_host);
	$last_chr = substr($source_host,$ulen-1,1);
	if ($first_chr=="*" and $last_chr=="*") {
		$source_host = substr($source_host,1,$ulen-2);
		if ($criteria == "") {
			$criteria = "SH.host_name like '%$source_host%'";
		}
		else {
	 	$criteria = $criteria ." and SH.host_name like '%$source_host%'";
	 	}
	}
	else if ($first_chr=="*") {
		$source_host = substr($source_host,1,$ulen-1);
		if ($criteria == "") {
			$criteria = "SH.host_name like '%$source_host'";
		}
		else {
	 	$criteria = $criteria ." and SH.host_name like '%$source_host'";
	 	}
	} 
	else if ($last_chr=="*") {
		$source_host = substr($source_host,0,$ulen-1);
		if ($criteria == "") {
			$criteria = "SH.host_name like '$source_host%'";
		}
		else {
	 	$criteria = $criteria ." and SH.host_name like '$source_host%'";
	 	}
	}
	else {
	$pos = strpos($source_host,".cern.ch");

     if($pos === false) {
     	$fqdn = $source_host . ".cern.ch";
     	
     }
     
	   if ($fqdn==""){
    	$sh = "SH.host_name='$source_host'";
    }
    else {
    	$sh = "(SH.host_name='$source_host' or SH.host_name='$fqdn')";
    }
    if ($criteria == "") {
			$criteria = $sh;
		}
		else {
	 	$criteria = $criteria ." and $sh";
	 	}
	} 
 }
if ($destination_host!="") {
	$first_chr = substr($destination_host,0,1);
	$ulen = strlen($destination_host);
	$last_chr = substr($destination_host,$ulen-1,1);
	if ($first_chr=="*" and $last_chr=="*") {
		$destination_host = substr($destination_host,1,$ulen-2);
		if ($criteria == "") {
			$criteria = "RH.host_name like '%$destination_host%'";
		}
		else {
	 	$criteria = $criteria ." and RH.host_name like '%$destination_host%'";
	 	}
	}
	else if ($first_chr=="*") {
		$destination_host = substr($destination_host,1,$ulen-1);
		if ($criteria == "") {
			$criteria = "RH.host_name like '%$destination_host'";
		}
		else {
	 	$criteria = $criteria ." and RH.host_name like '%$destination_host'";
	 	}
	} 
	else if ($last_chr=="*") {
		$destination_host = substr($destination_host,0,$ulen-1);
		if ($criteria == "") {
			$criteria = "RH.host_name like '$destination_host%'";
		}
		else {
	 	$criteria = $criteria ." and RH.host_name like '$destination_host%'";
	 	}
	}
	else {
	$pos = strpos($destination_host,".cern.ch");

     if($pos === false) {
     	$dfqdn = $destination_host . ".cern.ch";
     	
     }
	 if ($dfqdn==""){
    	$sh = "RH.host_name='$destination_host'";
    }
    else {
    	$sh = "(RH.host_name='$destination_host' or RH.host_name='$dfqdn')";
    }  
	if ($criteria == "") {
			$criteria = $sh;
		}
		else {
	 	$criteria = $criteria ." and $sh";
	 	}
	} 
 }
if ($service !="Select" && $service !="") {
	if ($criteria == "") {
		$criteria = "services.name ='$service'";
	}
	else {
 	$criteria = $criteria ." and services.name ='$service'";
 	}
 }

if ($direction!="Select" && $direction!="") {
	if ($criteria == "") {
	$criteria = "gw_logins.direction ='$direction'";
	}
	else {
 	$criteria = $criteria ." and gw_logins.direction ='$direction'";
 	}
  }
if ($am_status_code!="Select" && $am_status_code!="") {
	if ($criteria == "") {
	$criteria = "am_statuses.am_return_code_description  ='$am_status_code'";
	}
	else {
 	$criteria = $criteria ." and am_statuses.am_return_code_description  ='$am_status_code'";
 	}
  }
if ($fromDate=="lastday") {
$yesterday  = date('Y-m-d H:i:s',time()-3600*24);
$todate = date('Y-m-d H:i:s');
	if ($criteria == "") {
	$criteria = "login between '$yesterday' and '$todate'";
	}
	else {
 	$criteria = $criteria ." and login between '$yesterday' and '$todate'";
 	}
}
else if ($fromDate=="lastweek") {
$week  = date('Y-m-d H:i:s',time()-3600*24*6);

$todate = date('Y-m-d H:i:s');
	if ($criteria == "") {
	$criteria = "login between '$week' and '$todate'";
	}
	else {
 	$criteria = $criteria ." and login between '$week' and '$todate'";
 	}
}
else if ($fromDate=="lastmonth") {
$month  = date('Y-m-d H:i:s',time()-3600*24*29);

$todate = date('Y-m-d H:i:s');
	if ($criteria == "") {
	$criteria = "login between '$month' and '$todate'";
	}
	else {
 	$criteria = $criteria ." and login between '$month' and '$todate'";
 	}
}
else if ($fromDate=="lastyear") {
$year  = date('Y-m-d H:i:s',time()-3600*24*365);
$todate = date('Y-m-d H:i:s');
	if ($criteria == "") {
	$criteria = "login between '$year' and '$todate'";
	}
	else {
 	$criteria = $criteria ." and login between '$year' and '$todate'";
 	}
}
else {

if ($fromDate!="" && $toDate!="") {
	 $fDate = date('Y-m-d H:i:s', strtotime($fromDate));
	 $tDate = date('Y-m-d H:i:s', strtotime($toDate));
	 //$date = strtotime(date("Y-m-d H:i:s", strtotime($tDate)));
	// $td = Date("Y-m-d H:i:s", $date);

	if ($criteria == "") {
	$criteria = "login between '$fromDate'and '$tDate'";
	}
	else {
 	$criteria = $criteria ." and login between '$fromDate'and '$tDate'";
 	}
  }
}
if ($logoutFromDate=="lastday") {
$yesterday  = date('Y-m-d H:i:s',time()-3600*24);
$todate = date('Y-m-d H:i:s');
	if ($criteria == "") {
	$criteria = "logout between '$yesterday' and '$todate'";
	}
	else {
 	$criteria = $criteria ." and logout between '$yesterday' and '$todate'";
	}
}
else if ($logoutFromDate=="lastweek") {
$week  = date('Y-m-d H:i:s',time()-3600*24*6);

$todate = date('Y-m-d H:i:s');
	if ($criteria == "") {
	$criteria = "logout between '$week' and '$todate'";
	}
	else {
 	$criteria = $criteria ." and logout between '$week' and '$todate'";
 }
}
else if ($logoutFromDate=="lastmonth") {
$month  = date('Y-m-d H:i:s',time()-3600*24*29);

$todate = date('Y-m-d H:i:s');
	if ($criteria == "") {
	$criteria = "logout between '$month' and '$todate'";
	}
	else {
 	$criteria = $criteria ." and logout between '$month' and '$todate'";
 	}
}
else if ($logoutFromDate=="lastyear") {
$year  = date('Y-m-d H:i:s',time()-3600*24*365);
$todate = date('Y-m-d H:i:s');
	if ($criteria == "") {
	$criteria = "logout between '$year' and '$todate'";
	}
	else {
 	$criteria = $criteria ." and logout between '$year' and '$todate'";
  	}
}
else {
if ($logoutFromDate!="" && $logoutToDate!="") {
	 $lfDate = date('Y-m-d H:i:s', strtotime($logoutFromDate));
	 $ltDate = date('Y-m-d H:i:s', strtotime($logoutToDate));
	// $date = strtotime(date("Y-m-d H:i:s", strtotime($ltDate)) . " +1 day");
	// $ltd = Date("Y-m-d H:i:s", $date);

	if ($criteria == "") {
	$criteria = "logout between '$logoutFromDate'and '$ltDate'";
	}
	else {
 	$criteria = $criteria ." and logout between '$logoutFromDate' and '$ltDate'";
 	}
  }
}
 if ($loginStatus=="ON") 
  	$logout = "logout is NULL";
  else
  	$logout = "logout is NOT NULL";
$query = $table . " WHERE ".$logout ." and " . $criteria . " ORDER BY $sort $how LIMIT $StartRow,$PageSize";
}
//echo $query;
$rs = $cn->get_data($query);
return $rs;
}
/*****************************************************************************************************************************************************************************

//View gateway load w.r.t no. of connection

*****************************************************************************************************************************************************************************/		
function viewGatewayLoad($gateway_name,$user_name,$destination_user_name,$source_host,$destination_host,$service,$direction,$am_status_code,$fromDate,$toDate,$logoutFromDate,$logoutToDate,$loginStatus,$groupby,&$con)
{
 $cn = (object)$con;
	
 $user_name = mysql_real_escape_string($user_name);
 $destination_user_name = mysql_real_escape_string($destination_user_name);
 $source_host = mysql_real_escape_string($source_host);
 $destination_host = mysql_real_escape_string($destination_host);
 $service = mysql_real_escape_string($service);
 $direction = mysql_real_escape_string($direction);
 $am_status_code = mysql_real_escape_string($am_status_code);
 $fromDate = mysql_real_escape_string($fromDate);
 $toDate = mysql_real_escape_string($toDate);
 $logoutFromDate= mysql_real_escape_string($logoutFromDate);
 $logoutToDate= mysql_real_escape_string($logoutToDate);

 $criteria ="";
$graph_criteria = "";
$order_by = "";
$table = "SELECT SU.user_name AS source_user, RU.user_name AS remote_user, SH.host_name AS source_host, RH.host_name AS remote_host, gateways.name AS gw_name,login,logout,services.name AS name,direction, am_statuses.am_return_code,am_statuses.am_return_code_description,count(gw_logins.login) as count
			FROM gw_logins 
			LEFT JOIN users SU ON gw_logins.user_id=SU.user_id 
			LEFT JOIN users RU ON gw_logins.remote_user_id=RU.user_id 
			LEFT JOIN hosts SH ON gw_logins.source_id=SH.host_id 
			LEFT JOIN hosts RH ON gw_logins.destination_id=RH.host_id 
			LEFT JOIN gateways ON gw_logins.gw_id=gateways.id LEFT JOIN services ON gw_logins.service_id=services.id 
			LEFT JOIN am_statuses ON gw_logins.am_id=am_statuses.am_id ";
if ($gateway_name!="" && $gateway_name!="Select") {
	if ($criteria == "") {
		$criteria = "gateways.name='$gateway_name'";
	}
	else {
 	$criteria = $criteria ." and gateways.name='$gateway_name'";
 	}
 }
 
if ($user_name!="") {
	$first_chr = substr($user_name,0,1);
	$ulen = strlen($user_name);
	$last_chr = substr($user_name,$ulen-1,1);
	if ($first_chr=="*" and $last_chr=="*") {
		$user_name = substr($user_name,1,$ulen-2);
		if ($criteria == "") {
			$criteria = "SU.user_name Like '%$user_name%'";
		}
		else {
	 	$criteria = $criteria ." and SU.user_name Like '%$user_name%'";
	 	}
	}
	else if ($first_chr=="*") {
		$user_name = substr($user_name,1,$ulen-1);
		if ($criteria == "") {
			$criteria = "SU.user_name Like '%$user_name'";
		}
		else {
	 	$criteria = $criteria ." and SU.user_name Like '%$user_name'";
	 	}
	} 
	else if ($last_chr=="*") {
		$user_name = substr($user_name,0,$ulen-1);
		if ($criteria == "") {
			$criteria = "SU.user_name Like '$user_name%'";
		}
		else {
	 	$criteria = $criteria ." and SU.user_name Like '$user_name%'";
	 	}
	}
	else {
	if ($criteria == "") {
			$criteria = "SU.user_name='$user_name'";
		}
		else {
	 	$criteria = $criteria ." and SU.user_name='$user_name'";
	 	}
	} 
 }
if ($destination_user_name!="") {
	
	$first_chr = substr($destination_user_name,0,1);
	$ulen = strlen($destination_user_name);
	$last_chr = substr($destination_user_name,$ulen-1,1);
	if ($first_chr=="*" and $last_chr=="*") {
		$destination_user_name = substr($destination_user_name,1,$ulen-2);
		if ($criteria == "") {
			$criteria = "RU.user_name Like '%$destination_user_name%'";
		}
		else {
	 	$criteria = $criteria ." and RU.user_name Like '%$destination_user_name%'";
	 	}
	}
	else if ($first_chr=="*") {
		$destination_user_name = substr($destination_user_name,1,$ulen-1);
		if ($criteria == "") {
			$criteria = "RU.user_name Like '%$destination_user_name'";
		}
		else {
	 	$criteria = $criteria ." and RU.user_name Like '%$destination_user_name'";
	 	}
	} 
	else if ($last_chr=="*") {
		$destination_user_name = substr($destination_user_name,0,$ulen-1);
		if ($criteria == "") {
			$criteria = "RU.user_name Like '$destination_user_name%'";
		}
		else {
	 	$criteria = $criteria ." and RU.user_name Like '$destination_user_name%'";
	 	}
	}
	else {
		
	if ($criteria == "") {
			$criteria = "RU.user_name='$destination_user_name'";
		}
		else {
	 	$criteria = $criteria ." and RU.user_name='$destination_user_name'";
	 	}
	} 
 }
if ($source_host!="") {
	$first_chr = substr($source_host,0,1);
	$ulen = strlen($source_host);
	$last_chr = substr($source_host,$ulen-1,1);
	if ($first_chr=="*" and $last_chr=="*") {
		$source_host = substr($source_host,1,$ulen-2);
		if ($criteria == "") {
			$criteria = "SH.host_name like '%$source_host%'";
		}
		else {
	 	$criteria = $criteria ." and SH.host_name like '%$source_host%'";
	 	}
	}
	else if ($first_chr=="*") {
		$source_host = substr($source_host,1,$ulen-1);
		if ($criteria == "") {
			$criteria = "SH.host_name like '%$source_host'";
		}
		else {
	 	$criteria = $criteria ." and SH.host_name like '%$source_host'";
	 	}
	} 
	else if ($last_chr=="*") {
		$source_host = substr($source_host,0,$ulen-1);
		if ($criteria == "") {
			$criteria = "SH.host_name like '$source_host%'";
		}
		else {
	 	$criteria = $criteria ." and SH.host_name like '$source_host%'";
	 	}
	}
	else {
		$pos = strpos($source_host,".cern.ch");
     if($pos === false) {
     	$fqdn = $source_host . ".cern.ch";
         }
	 if ($fqdn==""){
    	$sh = "SH.host_name='$source_host'";
    }
    else {
    	$sh = "(SH.host_name='$source_host' or SH.host_name='$fqdn')";
    }
    if ($criteria == "") {
			$criteria = $sh;
		}
		else {
	 	$criteria = $criteria ." and $sh";
	 	}
	} 
 }
if ($destination_host!="") {
	$first_chr = substr($destination_host,0,1);
	$ulen = strlen($destination_host);
	$last_chr = substr($destination_host,$ulen-1,1);
	if ($first_chr=="*" and $last_chr=="*") {
		$destination_host = substr($destination_host,1,$ulen-2);
		if ($criteria == "") {
			$criteria = "RH.host_name like '%$destination_host%'";
		}
		else {
	 	$criteria = $criteria ." and RH.host_name like '%$destination_host%'";
	 	}
	}
	else if ($first_chr=="*") {
		$destination_host = substr($destination_host,1,$ulen-1);
		if ($criteria == "") {
			$criteria = "RH.host_name like '%$destination_host'";
		}
		else {
	 	$criteria = $criteria ." and RH.host_name like '%$destination_host'";
	 	}
	} 
	else if ($last_chr=="*") {
		$destination_host = substr($destination_host,0,$ulen-1);
		if ($criteria == "") {
			$criteria = "RH.host_name like '$destination_host%'";
		}
		else {
	 	$criteria = $criteria ." and RH.host_name like '$destination_host%'";
	 	}
	}
	else {
	$pos = strpos($destination_host,".cern.ch");
	 if($pos === false) {
     	$dfqdn = $destination_host . ".cern.ch";
       }
	 if ($dfqdn==""){
    	$sh = "RH.host_name='$destination_host'";
    }
    else {
    	$sh = "(RH.host_name='$destination_host' or RH.host_name='$dfqdn')";
    }  
	if ($criteria == "") {
			$criteria = $sh;
		}
		else {
	 	$criteria = $criteria ." and $sh and RH.host_name is not null";
	 	}
	} 
	
 }
if ($service !="Select"  && $service!="") {
	
	if ($criteria == "") {
		$criteria = "gw_logins.service_id ='$service'";
	}
	else {
 	$criteria = $criteria ." and gw_logins.service_id ='$service'";
 	
	}
 }
if ($direction!="Select" && $direction!="") {
	if ($criteria == "") {
	$criteria = "gw_logins.direction ='$direction'";
	}
	else {
 	$criteria = $criteria ." and gw_logins.direction ='$direction'";
 	}
  }
if ($am_status_code!="Select" && $am_status_code!="") {
	if ($criteria == "") {
	$criteria = "gw_logins.am_id =$am_status_code";
	}
	else {
 	$criteria = $criteria ." and gw_logins.am_id =$am_status_code";
 	}
  }
if ($fromDate=="lastday") {
$yesterday  = date('Y-m-d H:i:s',time()-3600*24);
$todate = date('Y-m-d H:i:s');
	if ($criteria == "") {
	$criteria = "login between '$yesterday' and '$todate'";
	}
	else {
 	$criteria = $criteria ." and login between '$yesterday' and '$todate'";
 }
}
else if ($fromDate=="lastweek") {
$week  = date('Y-m-d H:i:s',time()-3600*24*6);

$todate = date('Y-m-d H:i:s');
	if ($criteria == "") {
	$criteria = "login between '$week' and '$todate'";
	}
	else {
 	$criteria = $criteria ." and login between '$week' and '$todate'";
 }
}
else if ($fromDate=="lastmonth") {
$month  = date('Y-m-d H:i:s',time()-3600*24*29);

$todate = date('Y-m-d H:i:s');
	if ($criteria == "") {
	$criteria = "login between '$month' and '$todate'";
	}
	else {
 	$criteria = $criteria ." and login between '$month' and '$todate'";
 }
}
else if ($fromDate=="lastyear") {
$year  = date('Y-m-d H:i:s',time()-3600*24*365);
$todate = date('Y-m-d H:i:s');
	if ($criteria == "") {
	$criteria = "login between '$year' and '$todate'";
	}
	else {
 	$criteria = $criteria ." and login between '$year' and '$todate'";
}
}
else {
if ($fromDate!="" && $toDate!="") {
	 $fDate = date('Y-m-d H:i:s', strtotime($fromDate));
	 $tDate = date('Y-m-d H:i:s', strtotime($toDate));
	 //$date = strtotime(date("Y-m-d H:i:s", strtotime($tDate)));
	// $td = Date("Y-m-d H:i:s", $date);

	if ($criteria == "") {
	$criteria = "login between '$fromDate'and '$tDate'";
	}
	else {
 	$criteria = $criteria ." and login between '$fromDate'and '$tDate'";
 	}
  }
}
if ($logoutFromDate=="lastday") {
$yesterday  = date('Y-m-d H:i:s',time()-3600*24);
$todate = date('Y-m-d H:i:s');
	if ($criteria == "") {
	$criteria = "logout between '$yesterday' and '$todate'";
	}
	else {
 	$criteria = $criteria ." and logout between '$yesterday' and '$todate'";
 }
}
else if ($logoutFromDate=="lastweek") {
$week  = date('Y-m-d H:i:s',time()-3600*24*6);

$todate = date('Y-m-d H:i:s');
	if ($criteria == "") {
	$criteria = "logout between '$week' and '$todate'";
	}
	else {
 	$criteria = $criteria ." and logout between '$week' and '$todate'";
 }
}
else if ($logoutFromDate=="lastmonth") {
$month  = date('Y-m-d H:i:s',time()-3600*24*29);

$todate = date('Y-m-d H:i:s');
	if ($criteria == "") {
	$criteria = "logout between '$month' and '$todate'";
	}
	else {
 	$criteria = $criteria ." and logout between '$month' and '$todate'";
 }
}
else if ($logoutFromDate=="lastyear") {
$year  = date('Y-m-d H:i:s',time()-3600*24*365);
$todate = date('Y-m-d H:i:s');
	if ($criteria == "") {
	$criteria = "logout between '$year' and '$todate'";
	}
	else {
 	$criteria = $criteria ." and logout between '$year' and '$todate'";
}
}
else {
 if ($logoutFromDate!="" && $logoutToDate!="") {
	 $lfDate = date('Y-m-d H:i:s', strtotime($logoutFromDate));
	 $ltDate = date('Y-m-d H:i:s', strtotime($logoutToDate));
	// $date = strtotime(date("Y-m-d H:i:s", strtotime($ltDate)) . " +1 day");
	// $ltd = Date("Y-m-d H:i:s", $date);

	if ($criteria == "") {
	$criteria = "logout between '$logoutFromDate'and '$logoutToDate'";
	}
	else {
 	$criteria = $criteria ." and logout between '$logoutFromDate' and '$logoutToDate'";
 	}
  }
 }
if ($loginStatus=="ON")
 	$logout = "logout is NULL";
else
	$logout = "logout is NOT NULL";
//	echo $logout;
if ($groupby=="gw_name")
	$query = $table . " WHERE ". $logout . " and " . $criteria . " group by ". $groupby ." order by count DESC";
elseif ($groupby=="SU.user_name" and $criteria=="")
	$query = $table . " WHERE ". $logout . " group by ". $groupby ." order by count DESC";

else
	$query = $table . " WHERE ". $logout . " and " . $criteria . " and " . $groupby ." is not null  group by ". $groupby ." order by count DESC";
$rs = $cn->get_data($query);

//echo $query;
return $rs;
}

/*****************************************************************************************************************************************************************************

//View gateway load per month

*****************************************************************************************************************************************************************************/		
    
	function viewGatewayLoadDetail($criteria,$loginStatus,&$con)
	{
		
	      
	   $cn = (object)$con;
	    
			    $gateway="";
				$user_name="";
				$gateway="";
				$source_host="";
				$destination_host="";
				$service="";
				$direction="";
				$am_status_code="";
				$fromDate="";
				$toDate="";
				$logoutfromDate="";
				$logouttoDate="";

				$table_criteria="";
				$total_criteria = split("\,",$criteria);
				$total_len = count($total_criteria);
				$G_file_name = "";
				for ($i=0;$i<$total_len;$i++) {
				  $each_item = split(":",$total_criteria[$i]);
				  $item_name = $each_item[0];
				  $item_value = $each_item[1];
				 // echo "<BR>$item_name : $item_value";
				 if ($each_item[0]=="gateway") {
					$gateway = $each_item[1];
					if ($G_file_name == "")
						$G_file_name = $each_item[1];
					else 
						$G_file_name = $G_file_name .",".$each_item[1];

				 }
				 if ($each_item[0]=="user_name") {
					$user_name= $each_item[1];
					if ($G_file_name == "")
						$G_file_name = $each_item[1];
					else 
						$G_file_name = $G_file_name .",".$each_item[1];

				 }
				 if ($each_item[0]=="destination_user_name") {
					$destination_user_name= $each_item[1];
					if ($G_file_name == "")
						$G_file_name = $each_item[1];
					else 
						$G_file_name = $G_file_name .",".$each_item[1];

				 }
				if ($each_item[0]=="source_host") {
					$source_host= $each_item[1];
					if ($G_file_name == "")
						$G_file_name = $each_item[1];
					else 
						$G_file_name = $G_file_name .",".$each_item[1];

				 }

				if ($each_item[0]=="destination_host") {
					$destination_host= $each_item[1];
					if ($G_file_name == "")
						$G_file_name = $each_item[1];
					else 
						$G_file_name = $G_file_name .",".$each_item[1];

				 }

				if ($each_item[0]=="service") {
					$service= $each_item[1];
					if ($G_file_name == "")
						$G_file_name = $each_item[1];
					else 
						$G_file_name = $G_file_name .",".$each_item[1];

				 }

				if ($each_item[0]=="direction") {
					$direction= $each_item[1];
					if ($G_file_name == "")
						$G_file_name = $each_item[1];
					else 
						$G_file_name = $G_file_name .",".$each_item[1];

				  }
				if ($each_item[0]=="am_return_codes") {
					$am_status_code= $each_item[1];
					if ($G_file_name == "")
						$G_file_name = $each_item[1];
					else 
						$G_file_name = $G_file_name .",".$each_item[1];

				  }
				if ($each_item[0]=="from") {
					if ($each_item[1]=="lastyear" or $each_item[1]=="lastmonth" or $each_item[1]=="lastweek" or $each_item[1]=="lastday")
						$fromDate=$each_item[1];
					else
					 	$fromDate= $each_item[1].":".$each_item[2].":".$each_item[3];
					 
					 if ($G_file_name == "")
						$G_file_name = $each_item[1];
					else 
						$G_file_name = $G_file_name .",".$each_item[1];

				  }
				if ($each_item[0]=="to") {
					 $toDate= $each_item[1].":".$each_item[2].":".$each_item[3];
					 if ($G_file_name == "")
						$G_file_name = $each_item[1];
					else 
						$G_file_name = $G_file_name .",".$each_item[1];
				  }
				
				if ($each_item[0]=="logoutfrom") {
					if ($each_item[1]=="lastyear" or $each_item[1]=="lastmonth" or $each_item[1]=="lastweek" or $each_item[1]=="lastday")
						$logoutfromDate=$each_item[1];
					else
 					  $logoutfromDate= $each_item[1].":".$each_item[2].":".$each_item[3];
					// echo $logoutfromDate;
					 if ($G_file_name == "")
						$G_file_name = $each_item[1];
					else 
						$G_file_name = $G_file_name .",".$each_item[1];

				  }
				if ($each_item[0]=="logoutto") {
					 $logouttoDate= $each_item[1].":".$each_item[2].":".$each_item[3];
					
					 if ($G_file_name == "")
						$G_file_name = $each_item[1];
					else 
						$G_file_name = $G_file_name .",".$each_item[1];
				  }

				}
	$criteria ="";
$graph_criteria = "";
$order_by = "";
$table = "SELECT SU.user_name AS source_user, RU.user_name AS remote_user, SH.host_name AS source_host, RH.host_name AS remote_host, gateways.name AS gw_name,login,logout,services.name AS name,direction, am_statuses.am_return_code,am_statuses.am_return_code_description,count(gw_logins.login) as count
			FROM gw_logins 
			LEFT JOIN users SU ON gw_logins.user_id=SU.user_id 
			LEFT JOIN users RU ON gw_logins.remote_user_id=RU.user_id 
			LEFT JOIN hosts SH ON gw_logins.source_id=SH.host_id 
			LEFT JOIN hosts RH ON gw_logins.destination_id=RH.host_id 
			LEFT JOIN gateways ON gw_logins.gw_id=gateways.id LEFT JOIN services ON gw_logins.service_id=services.id 
			LEFT JOIN am_statuses ON gw_logins.am_id=am_statuses.am_id ";

 if ($gateway!="") {
 	if ($criteria == "" ) {
 		$criteria = "gateways.name='$gateway'";
 		}
 	else {
 		$criteria = $criteria ." and gateways.name='$gateway'";
 		 	}
 		 	$group_by = "GROUP BY Month(gw_logins.login),Year(gw_logins.login) order by gw_logins.login ASC";
 		 	$_SESSION["gw_group"] = "ByMonth";
 }
else {
	$group_by = "GROUP BY gw_logins.gw_id";
	$_SESSION["gw_group"] = "ByGateway";

}
if ($user_name!="") {
if ($user_name=="Others") {
	 $count = $_SESSION["top_ten_users_loop"];
	 for ($i=0;$i<$count-1;$i++) {
				$labelName = $_SESSION["top_ten_users_load_labels".$i]; 	
				 if ($i==0)
					$user_id = "'".$labelName."'";
				else 
					$user_id = $user_id . "," . "'".$labelName."'";
			}
  
	if ($criteria == "") {
		$criteria = "SU.user_name NOT IN ($user_id)";
	}
	else {
 	$criteria = $criteria ." and SU.user_name NOT IN ($user_id)";
 	}
 }
 else {
	
	$first_chr = substr($user_name,0,1);
	$ulen = strlen($user_name);
	$last_chr = substr($user_name,$ulen-1,1);
	if ($first_chr=="*" and $last_chr=="*") {
		$user_name = substr($user_name,1,$ulen-2);
		if ($criteria == "") {
			$criteria = "SU.user_name Like '%$user_name%'";
		}
		else {
	 	$criteria = $criteria ." and SU.user_name Like '%$user_name%'";
	 	}
	}
	else if ($first_chr=="*") {
		$user_name = substr($user_name,1,$ulen-1);
		if ($criteria == "") {
			$criteria = "SU.user_name Like '%$user_name'";
		}
		else {
	 	$criteria = $criteria ." and SU.user_name Like '%$user_name'";
	 	}
	} 
	else if ($last_chr=="*") {
		$user_name = substr($user_name,0,$ulen-1);
		if ($criteria == "") {
			$criteria = "SU.user_name Like '$user_name%'";
		}
		else {
	 	$criteria = $criteria ." and SU.user_name Like '$user_name%'";
	 	}
	}
	else {
	if ($criteria == "") {
			$criteria = "SU.user_name='$user_name'";
		}
		else {
	 	$criteria = $criteria ." and SU.user_name='$user_name'";
	 	}
	} 
  }
 }
	if ($destination_user_name!="") {


	
	$first_chr = substr($destination_user_name,0,1);
	$ulen = strlen($destination_user_name);
	$last_chr = substr($destination_user_name,$ulen-1,1);
	if ($first_chr=="*" and $last_chr=="*") {
		$destination_user_name = substr($destination_user_name,1,$ulen-2);
		if ($criteria == "") {
			$criteria = "RU.user_name Like '%$destination_user_name%'";
		}
		else {
	 	$criteria = $criteria ." and RU.user_name Like '%$destination_user_name%'";
	 	}
	}
	else if ($first_chr=="*") {
		$destination_user_name = substr($destination_user_name,1,$ulen-1);
		if ($criteria == "") {
			$criteria = "RU.user_name Like '%$destination_user_name'";
		}
		else {
	 	$criteria = $criteria ." and RU.user_name Like '%$destination_user_name'";
	 	}
	} 
	else if ($last_chr=="*") {
		$destination_user_name = substr($destination_user_name,0,$ulen-1);
		if ($criteria == "") {
			$criteria = "RU.user_name Like '$destination_user_name%'";
		}
		else {
	 	$criteria = $criteria ." and RU.user_name Like '$destination_user_name%'";
	 	}
	}
	else {
	if ($criteria == "") {
			$criteria = "RU.user_name='$destination_user_name'";
		}
		else {
	 	$criteria = $criteria ." and RU.user_name='$destination_user_name'";
	 	}
	} 
 
 }
if ($source_host!="") {
	$first_chr = substr($source_host,0,1);
	$ulen = strlen($source_host);
	$last_chr = substr($source_host,$ulen-1,1);
	if ($first_chr=="*" and $last_chr=="*") {
		$source_host = substr($source_host,1,$ulen-2);
		if ($criteria == "") {
			$criteria = "SH.host_name like '%$source_host%'";
		}
		else {
	 	$criteria = $criteria ." and SH.host_name like '%$source_host%'";
	 	}
	}
	else if ($first_chr=="*") {
		$source_host = substr($source_host,1,$ulen-1);
		if ($criteria == "") {
			$criteria = "SH.host_name like '%$source_host'";
		}
		else {
	 	$criteria = $criteria ." and SH.host_name like '%$source_host'";
	 	}
	} 
	else if ($last_chr=="*") {
		$source_host = substr($source_host,0,$ulen-1);
		if ($criteria == "") {
			$criteria = "SH.host_name like '$source_host%'";
		}
		else {
	 	$criteria = $criteria ." and SH.host_name like '$source_host%'";
	 	}
	}
	else {
	$pos = strpos($source_host,".cern.ch");
     if($pos === false) {
     	$fqdn = $source_host . ".cern.ch";
         }
	 if ($fqdn==""){
    	$sh = "SH.host_name='$source_host'";
    }
    else {
    	$sh = "(SH.host_name='$source_host' or SH.host_name='$fqdn')";
    }
    if ($criteria == "") {
			$criteria = $sh;
		}
		else {
	 	$criteria = $criteria ." and $sh";
	 	}
	} 
 }

if ($destination_host!="") {
	if ($destination_host=="Others") {
	 $count = $_SESSION["destination_host_loop"];
	 for ($i=0;$i<$count-1;$i++) {
				$labelName = $_SESSION["destination_host_load_labels".$i]; 	
				 if ($i==0)
					$dest_id = "'".$labelName."'";
				else 
					$dest_id = $dest_id . "," . "'".$labelName."'";
			}
  
	if ($criteria == "") {
		$criteria = "RH.host_name NOT IN ($dest_id)";
	}
	else {
 	$criteria = $criteria ." and RH.host_name NOT IN ($dest_id)";
 	}
 }
 else {
	$first_chr = substr($destination_host,0,1);
	$ulen = strlen($destination_host);
	$last_chr = substr($destination_host,$ulen-1,1);
	if ($first_chr=="*" and $last_chr=="*") {
		$destination_host = substr($destination_host,1,$ulen-2);
		if ($criteria == "") {
			$criteria = "RH.host_name like '%$destination_host%'";
		}
		else {
	 	$criteria = $criteria ." and RH.host_name like '%$destination_host%'";
	 	}
	}
	else if ($first_chr=="*") {
		$destination_host = substr($destination_host,1,$ulen-1);
		if ($criteria == "") {
			$criteria = "RH.host_name like '%$destination_host'";
		}
		else {
	 	$criteria = $criteria ." and RH.host_name like '%$destination_host'";
	 	}
	} 
	else if ($last_chr=="*") {
		$destination_host = substr($destination_host,0,$ulen-1);
		if ($criteria == "") {
			$criteria = "RH.host_name like '$destination_host%'";
		}
		else {
	 	$criteria = $criteria ." and RH.host_name like '$destination_host%'";
	 	}
	}
	else {
	$pos = strpos($destination_host,".cern.ch");
	 if($pos === false) {
     	$dfqdn = $destination_host . ".cern.ch";
       }
	 if ($dfqdn==""){
    	$sh = "RH.host_name='$destination_host'";
    }
    else {
    	$sh = "(RH.host_name='$destination_host' or RH.host_name='$dfqdn')";
    }  
	if ($criteria == "") {
			$criteria = $sh;
		}
		else {
	 	$criteria = $criteria ." and $sh";
	 	}
	} 
 }
}
if ($service !="") {
  if ($service=="Others") {
		if ($criteria == "") {
			$criteria = "services.name  is null";
		}
		else {
	 	$criteria = $criteria ." and services.name  is null";
	 	}
	}
	else {
	if ($criteria == "") {
		$criteria = "services.name ='$service'";
	}
	else {
 	$criteria = $criteria ." and services.name ='$service'";
 	}
   }
 }

if ($direction!="") {
	if ($criteria == "") {
	$criteria = "gw_logins.direction ='$direction'";
	}
	else {
 	$criteria = $criteria ." and gw_logins.direction ='$direction'";
 	}
  }
if ($am_status_code!="") {
	if ($criteria == "") {
	$criteria = "am_statuses.am_return_code_description ='$am_status_code'";
	}
	else {
 	$criteria = $criteria ." and am_statuses.am_return_code_description='$am_status_code'";
 	}
  }
if ($fromDate=="lastday") {
$yesterday  = date('Y-m-d H:i:s',time()-3600*24);
$todate = date('Y-m-d H:i:s');
	if ($criteria == "") {
	$criteria = "login between '$yesterday' and '$todate'";
	}
	else {
 	$criteria = $criteria ." and login between '$yesterday' and '$todate'";
 	

 	}
}
else if ($fromDate=="lastweek") {
$week  = date('Y-m-d H:i:s',time()-3600*24*6);

$todate = date('Y-m-d H:i:s');
	if ($criteria == "") {
	$criteria = "login between '$week' and '$todate'";
	}
	else {
 	$criteria = $criteria ." and login between '$week' and '$todate'";
 	

 	}
}
else if ($fromDate=="lastmonth") {
$month  = date('Y-m-d H:i:s',time()-3600*24*29);

$todate = date('Y-m-d H:i:s');
	if ($criteria == "") {
	$criteria = "login between '$month' and '$todate'";
	}
	else {
 	$criteria = $criteria ." and login between '$month' and '$todate'";
 	

 	}
}
else if ($fromDate=="lastyear") {
$year  = date('Y-m-d H:i:s',time()-3600*24*365);
$todate = date('Y-m-d H:i:s');
	if ($criteria == "") {
	$criteria = "login between '$year' and '$todate'";
	}
	else {
 	$criteria = $criteria ." and login between '$year' and '$todate'";
 	

 	}
}

else {

if ($fromDate!="" && $toDate!="") {
	 $fDate = date('Y-m-d H:i:s', strtotime($fromDate));
	 $tDate = date('Y-m-d H:i:s', strtotime($toDate));
	 //$date = strtotime(date("Y-m-d H:i:s", strtotime($tDate)));
	// $td = Date("Y-m-d H:i:s", $date);

	if ($criteria == "") {
	$criteria = "login between '$fromDate'and '$tDate'";
	}
	else {
 	$criteria = $criteria ." and login between '$fromDate'and '$tDate'";
 	}
  }
}
if ($logoutfromDate=="lastday") {
$yesterday  = date('Y-m-d H:i:s',time()-3600*24);
$todate = date('Y-m-d H:i:s');
	if ($criteria == "") {
	$criteria = "logout between '$yesterday' and '$todate'";
	}
	else {
 	$criteria = $criteria ." and logout between '$yesterday' and '$todate'";
 	

 	}
}
else if ($logoutfromDate=="lastweek") {
$week  = date('Y-m-d H:i:s',time()-3600*24*6);

$todate = date('Y-m-d H:i:s');
	if ($criteria == "") {
	$criteria = "logout between '$week' and '$todate'";
	}
	else {
 	$criteria = $criteria ." and logout between '$week' and '$todate'";
 	

 	}
}
else if ($logoutfromDate=="lastmonth") {
$month  = date('Y-m-d H:i:s',time()-3600*24*29);

$todate = date('Y-m-d H:i:s');
	if ($criteria == "") {
	$criteria = "logout between '$month' and '$todate'";
	}
	else {
 	$criteria = $criteria ." and logout between '$month' and '$todate'";
 	

 	}
}
else if ($logoutfromDate=="lastyear") {
$year  = date('Y-m-d H:i:s',time()-3600*24*365);
$todate = date('Y-m-d H:i:s');
	if ($criteria == "") {
	$criteria = "logout between '$year' and '$todate'";
	}
	else {
 	$criteria = $criteria ." and logout between '$year' and '$todate'";
 	

 	}
}
else {
if ($logoutfromDate!="" && $logouttoDate!="") {
	 $lfDate = date('Y-m-d H:i:s', strtotime($logoutfromDate));
	 $ltDate = date('Y-m-d H:i:s', strtotime($logouttoDate));
	 $ldate = strtotime(date("Y-m-d H:i:s", strtotime($ltDate)) . " +1 day");
	 $ltd = Date("Y-m-d H:i:s", $ldate);

	if ($criteria == "") {
	$criteria = "logout between '$logoutfromDate'and '$logouttoDate'";
	}
	else {
 	$criteria = $criteria ." and logout between '$logoutfromDate'and '$logouttoDate'";
 	}
  }
 }
if ($loginStatus=="ON")
 	$logout = "logout is NULL";
else
	$logout = "logout is NOT NULL";

$query = $table . " WHERE ".$logout." and " . $criteria . " " . $group_by ;

$rs = $cn->get_data($query);
$num_rows = mysql_num_rows($rs);

//echo $query;
	  
	  return $rs;

	}	
/*****************************************************************************************************************************************************************************

//View gateway load Detailed Information

*****************************************************************************************************************************************************************************/		
    
	function viewGatewayLoadInformation($criteria,$id,$sort,$how,$loginStatus,&$con)
	{
	      
	   $cn = (object)$con;
	 
	 
	
	 $rs=null;
	  $fromDate="";
	  $toDate="";
	  $logoutfromDate="";
	  $logouttoDate="";

	  $table_criteria="";
	  $total_criteria = split("\,",$criteria);
	  $total_len = count($total_criteria);
	    //  echo $total_len;
	   for ($i=0;$i<$total_len;$i++) {
	   	
	   	$each_item = split(":",$total_criteria[$i]);
	   	$item_name = $each_item[0];
	   	$item_value = $each_item[1];
	   	 if ( $each_item[0]=="gateway") {
 			if ($table_criteria == "" ) {
 				$table_criteria= "gateways.name='$each_item[1]'";
 				}
 			else {
 				$table_criteria= $table_criteria." and gateways.name='$each_item[1]'";
 		 		}
 		 }
		if ( $each_item[0]=="user_name") {
			$user_name=$each_item[1];
			if ($user_name=="Others") {
	     	    $count = $_SESSION["top_ten_users_loop"];
				for ($j=0;$j<$count;$j++) {
					$labelName = $_SESSION["top_ten_users_load_labels".$j]; 	
				 if ($j==0)
					$user_id = "'".$labelName."'";
				else 
					$user_id = $user_id . "," . "'".$labelName."'";
				}
 			if ($table_criteria == "" ) {
 				$table_criteria= "SU.user_name NOT IN ($user_id)";
 				}
 			else {
 				$table_criteria= $table_criteria." and SU.user_name NOT IN ($user_id)";
 		 		}
 		 	}
 		 else {
			$first_chr = substr($user_name,0,1);
			$ulen = strlen($user_name);
			$last_chr = substr($user_name,$ulen-1,1);
			if ($first_chr=="*" and $last_chr=="*") {
				$user_name = substr($user_name,1,$ulen-2);
			if ($table_criteria == "" ) {
 				$table_criteria= "SU.user_name like '%$user_name%'";
 				}
 			else {
 				$table_criteria= $table_criteria." and SU.user_name like '%$user_name%'";
 		 		}
			}
			else if ($first_chr=="*") {
				$user_name = substr($user_name,1,$ulen-1);
			if ($table_criteria == "" ) {
 				$table_criteria= "SU.user_name like '%$user_name'";
 				}
 			else {
 				$table_criteria= $table_criteria." and SU.user_name like '%$user_name'";
 		 		}
			} 
			else if ($last_chr=="*") {
				$user_name = substr($user_name,0,$ulen-1);
			if ($table_criteria == "" ) {
 				$table_criteria= "SU.user_name like '$user_name%'";
 				}
 			else {
 				$table_criteria= $table_criteria." and SU.user_name like '$user_name%'";
 		 		}
			}
			else {
			if ($table_criteria == "" ) {
 				$table_criteria= "SU.user_name='$user_name'";
 				}
 			else {
 				$table_criteria= $table_criteria." and SU.user_name='$user_name'";
 		 		}
			} 
 		 }
 		 }
	   if ( $each_item[0]=="destination_user_name") {
			$destination_user_name=$each_item[1];
			
			$first_chr = substr($destination_user_name,0,1);
			$ulen = strlen($destination_user_name);
			$last_chr = substr($destination_user_name,$ulen-1,1);
			if ($first_chr=="*" and $last_chr=="*") {
				$destination_user_name = substr($destination_user_name,1,$ulen-2);
			if ($table_criteria == "" ) {
 				$table_criteria= "RU.user_name like '%$destination_user_name%'";
 				}
 			else {
 				$table_criteria= $table_criteria." and RU.user_name like '%$destination_user_name%'";
 		 		}
			}
			else if ($first_chr=="*") {
				$destination_user_name = substr($destination_user_name,1,$ulen-1);
			if ($table_criteria == "" ) {
 				$table_criteria= "RU.user_name like '%$destination_user_name'";
 				}
 			else {
 				$table_criteria= $table_criteria." and RU.user_name like '%$destination_user_name'";
 		 		}
			} 
			else if ($last_chr=="*") {
				$destination_user_name = substr($destination_user_name,0,$ulen-1);
			if ($table_criteria == "" ) {
 				$table_criteria= "RU.user_name like '$destination_user_name%'";
 				}
 			else {
 				$table_criteria= $table_criteria." and RU.user_name like '$destination_user_name%'";
 		 		}
			}
			else {
			if ($table_criteria == "" ) {
 				$table_criteria= "RU.user_name='$destination_user_name'";
 				}
 			else {
 				$table_criteria= $table_criteria." and RU.user_name='$destination_user_name'";
 		 		}
			} 
 		 
 		 }
		if ( $each_item[0]=="source_host") {
 			$source_host=$each_item[1];
			$first_chr = substr($source_host,0,1);
			$ulen = strlen($source_host);
			$last_chr = substr($source_host,$ulen-1,1);
			if ($first_chr=="*" and $last_chr=="*") {
				$source_host = substr($source_host,1,$ulen-2);
			if ($table_criteria == "" ) {
 				$table_criteria= "SH.host_name  like '%$source_host%'";
 				}
 			else {
 				$table_criteria= $table_criteria." and SH.host_name  like '%$source_host%'";
 		 		}
			}
			else if ($first_chr=="*") {
				$source_host = substr($source_host,1,$ulen-1);
			if ($table_criteria == "" ) {
 				$table_criteria= "SH.host_name  like '%$source_host'";
 				}
 			else {
 				$table_criteria= $table_criteria." and SH.host_name  like '%$source_host'";
 		 		}
			} 
			else if ($last_chr=="*") {
				$source_host = substr($source_host,0,$ulen-1);
			if ($table_criteria == "" ) {
 				$table_criteria= "SH.host_name  like '$source_host%'";
 				}
 			else {
 				$table_criteria= $table_criteria." and SH.host_name  like '$source_host%'";
 		 		}
			}
			else {
				
			$pos = strpos($source_host,".cern.ch");
   			 if($pos === false) {
     			$fqdn = $source_host . ".cern.ch";
      			 }
			 if ($fqdn==""){
    			$sh = "SH.host_name='$source_host'";
			    }
			    else {
			    	$sh = "(SH.host_name='$source_host' or SH.host_name='$fqdn')";
			    }
			if ($table_criteria == "" ) {
	 				$table_criteria= $sh;
	 				}
	 			else {
	 				$table_criteria= $table_criteria." and $sh";
	 		 		}
			} 
 			
 		 }
		if ( $each_item[0]=="destination_host") {
 			$destination_host=$each_item[1];
 			if ($destination_host=="Others") {
	     	    $count = $_SESSION["destination_host_loop"];
				for ($j=0;$j<$count;$j++) {
					$labelName = $_SESSION["destination_host_load_labels".$j]; 	
				 if ($j==0)
					$destination_host_id = "'".$labelName."'";
				else 
					$destination_host_id = $destination_host_id . "," . "'".$labelName."'";
				}
 			if ($table_criteria == "" ) {
 				$table_criteria= "RH.host_name NOT IN ($destination_host_id)";
 				}
 			else {
 				$table_criteria= $table_criteria." and RH.host_name NOT IN ($destination_host_id)";
 		 		}
 		 	}
 		 else {
			$first_chr = substr($destination_host,0,1);
			$ulen = strlen($destination_host);
			$last_chr = substr($destination_host,$ulen-1,1);
			if ($first_chr=="*" and $last_chr=="*") {
				$destination_host = substr($destination_host,1,$ulen-2);
			if ($table_criteria == "" ) {
 				$table_criteria= "RH.host_name  like '%$destination_host%'";
 				}
 			else {
 				$table_criteria= $table_criteria." and RH.host_name  like '%$destination_host%'";
 		 		}
			}
			else if ($first_chr=="*") {
				$destination_host = substr($destination_host,1,$ulen-1);
			if ($table_criteria == "" ) {
 				$table_criteria= "RH.host_name  like '%$destination_host'";
 				}
 			else {
 				$table_criteria= $table_criteria." and RH.host_name  like '%$destination_host'";
 		 		}
			} 
			else if ($last_chr=="*") {
				$destination_host = substr($destination_host,0,$ulen-1);
			if ($table_criteria == "" ) {
 				$table_criteria= "RH.host_name  like '$destination_host%'";
 				}
 			else {
 				$table_criteria= $table_criteria." and RH.host_name  like '$destination_host%'";
 		 		}
			}
			else {
			$pos = strpos($destination_host,".cern.ch");
			 if($pos === false) {
     			$dfqdn = $destination_host . ".cern.ch";
      			 }
			
			 if ($dfqdn==""){
    			$sh = "RH.host_name='$destination_host'";
			    }
			    else {
			    	$sh = "(RH.host_name='$destination_host' or RH.host_name='$dfqdn')";
			    }	 	
			if ($table_criteria == "" ) {
 				$table_criteria= $sh;
 				}
 			else {
 				$table_criteria= $table_criteria." and $sh";
 		 		}
			} 
 		   }
 		 }
		if ( $each_item[0]=="service") {
			if ( $each_item[1]=="Others") {
				if ($table_criteria == "" ) {
	 				$table_criteria= "services.name is null'";
	 				}
	 			else {
	 				$table_criteria= $table_criteria." and services.name is null";
	 		 		}
			}
			else {
	 			if ($table_criteria == "" ) {
	 				$table_criteria= "services.name='$each_item[1]'";
	 				}
	 			else {
	 				$table_criteria= $table_criteria." and services.name='$each_item[1]'";
	 		 		}
			}
 		 }
		if ( $each_item[0]=="direction") {
 			if ($table_criteria == "" ) {
 				$table_criteria= "direction='$each_item[1]'";
 				}
 			else {
 				$table_criteria= $table_criteria." and direction='$each_item[1]'";
 		 		}
 		 }
		if ( $each_item[0]=="am_return_codes") {
 			if ($table_criteria == "" ) {
 				$table_criteria= "am_statuses.am_return_code_description='$each_item[1]'";
 				}
 			else {
 				$table_criteria= $table_criteria." and am_statuses.am_return_code_description='$each_item[1]'";
 		 		}
 		 }
 		 	if ($each_item[0]=="from") {
 		 			if ($each_item[1]=="lastyear" or $each_item[1]=="lastmonth" or $each_item[1]=="lastweek" or $each_item[1]=="lastday")
						$fromDate=$each_item[1];
					else
					 	$fromDate= $each_item[1].":".$each_item[2].":".$each_item[3];
					
				  }
				if ($each_item[0]=="to") {
				
					 $toDate= $each_item[1].":".$each_item[2].":".$each_item[3];
					
				  }

if ($fromDate=="lastday") {
$yesterday  = date('Y-m-d H:i:s',time()-3600*24);
$todate = date('Y-m-d H:i:s');
	if ($table_criteria == "") {
	$table_criteria = "login between '$yesterday' and '$todate'";
	}
	else {
 	$table_criteria = $table_criteria ." and login between '$yesterday' and '$todate'";
 	

 	}
}
else if ($fromDate=="lastweek") {
$week  = date('Y-m-d H:i:s',time()-3600*24*6);

$todate = date('Y-m-d H:i:s');
	if ($table_criteria == "") {
	$table_criteria = "login between '$week' and '$todate'";
	}
	else {
 	$table_criteria = $table_criteria ." and login between '$week' and '$todate'";
 	

 	}
}
else if ($fromDate=="lastmonth") {
$month  = date('Y-m-d H:i:s',time()-3600*24*29);

$todate = date('Y-m-d H:i:s');
	if ($table_criteria == "") {
	$table_criteria = "login between '$month' and '$todate'";
	}
	else {
 	$table_criteria = $table_criteria ." and login between '$month' and '$todate'";
 	

 	}
}
else if ($fromDate=="lastyear") {
$year  = date('Y-m-d H:i:s',time()-3600*24*365);
$todate = date('Y-m-d H:i:s');
	if ($table_criteria == "") {
	$table_criteria= "login between '$year' and '$todate'";
	}
	else {
 	$table_criteria = $table_criteria ." and login between '$year' and '$todate'";
 	

 	}
}

else {

if ($fromDate!="" && $toDate!="") {
	 $fDate = date('Y-m-d H:i:s', strtotime($fromDate));
	 $tDate = date('Y-m-d H:i:s', strtotime($toDate));
	 //$date = strtotime(date("Y-m-d H:i:s", strtotime($tDate)));
	// $td = Date("Y-m-d H:i:s", $date);

	if ($table_criteria == "") {
	$table_criteria = "login between '$fromDate'and '$tDate'";
	}
	else {
 	$table_criteria = $table_criteria ." and login between '$fromDate'and '$tDate'";
 	}
  }
}

		
if ($each_item[0]=="logoutfrom") {
				if ($each_item[1]=="lastyear" or $each_item[1]=="lastmonth" or $each_item[1]=="lastweek" or $each_item[1]=="lastday")
						$logoutfromDate=$each_item[1];
					else
					 	$logoutfromDate= $each_item[1].":".$each_item[2].":".$each_item[3];
					
				  }
				if ($each_item[0]=="logoutto") {
					 $logouttoDate= $each_item[1].":".$each_item[2].":".$each_item[3];
					
				  }
		if ($logoutfromDate=="lastday") {
			$yesterday  = date('Y-m-d H:i:s',time()-3600*24);
			$todate = date('Y-m-d H:i:s');
				if ($table_criteria == "") {
				$table_criteria = "logout between '$yesterday' and '$todate'";
				}
				else {
			 	$table_criteria = $table_criteria ." and logout between '$yesterday' and '$todate'";
			 	
			
			 	}
			}
		else if ($logoutfromDate=="lastweek") {
			$week  = date('Y-m-d H:i:s',time()-3600*24*6);
			$todate = date('Y-m-d H:i:s');
				if ($table_criteria == "") {
				$table_criteria = "logout between '$week' and '$todate'";
				}
				else {
			 	$table_criteria = $table_criteria ." and logout between '$week' and '$todate'";
			 	
			
			 	}
			}
		else if ($logoutfromDate=="lastmonth") {
			$month  = date('Y-m-d H:i:s',time()-3600*24*29);
			
			$todate = date('Y-m-d H:i:s');
				if ($table_criteria == "") {
				$table_criteria = "logout between '$month' and '$todate'";
				}
				else {
			 	$table_criteria = $table_criteria ." and logout between '$month' and '$todate'";
			 	
			
			 	}
			}
		else if ($logoutfromDate=="lastyear") {
			$year  = date('Y-m-d H:i:s',time()-3600*24*365);
			$todate = date('Y-m-d H:i:s');
				if ($table_criteria == "") {
				$table_criteria= "logout between '$year' and '$todate'";
				}
				else {
			 	$table_criteria = $table_criteria ." and logout between '$year' and '$todate'";
			 	}
			}
	else {
		   if ( $logoutfromDate!="" && $logouttoDate!="") {
	 			if ($table_criteria == "" ) {
 					$table_criteria= "logout between '$logoutfromDate' and '$logouttoDate'";
 					}
 				else {
 					$table_criteria= $table_criteria." and logout between '$logoutfromDate' and '$logouttoDate'";
 		 		}
 			 }
	   }
}   
if ($loginStatus=="ON")
 	$logout = "logout is NULL";
else
	$logout = "logout is NOT NULL";
 
       $cn = (object)$con;	
 if ($id!="") {
    list ($mn,$yr) = split("-",$id);
    	
    if ($mn=="Jan")
    		$mon =  "01";
	if ($mn=="Feb")
    		$mon =  "02"; 
	if ($mn=="Mar")
    		$mon =  "03"; 
	if ($mn=="Apr")
    		$mon =  "04"; 
	if ($mn=="May")
    		$mon =  "05"; 
	if ($mn=="Jun")
    		$mon =  "06"; 
	if ($mn=="Jul")
    		$mon =  "07"; 
	if ($mn=="Aug")
    		$mon =  "08"; 
	if ($mn=="Sep")
    		$mon =  "09";
	if ($mn=="Oct")
    		$mon =  "10";  
	if ($mn=="Nov")
    		$mon =  "11";
	if ($mn=="Dec")
    		$mon =  "12"; 

    $query = " SELECT SU.user_name AS source_user, RU.user_name AS remote_user, SH.host_name AS source_host, RH.host_name AS remote_host, gateways.name as gw_name,login,logout,services.name AS name,direction, am_statuses.am_return_code,am_statuses.am_return_code_description as amd
			FROM gw_logins 
			LEFT JOIN users SU ON gw_logins.user_id=SU.user_id 
			LEFT JOIN users RU ON gw_logins.remote_user_id=RU.user_id 
			LEFT JOIN hosts SH ON gw_logins.source_id=SH.host_id 
			LEFT JOIN hosts RH ON gw_logins.destination_id=RH.host_id 
			LEFT JOIN gateways ON gw_logins.gw_id=gateways.id
			LEFT JOIN services ON gw_logins.service_id=services.id 
			LEFT JOIN am_statuses ON gw_logins.am_id=am_statuses.am_id 
			WHERE ".$logout." and ".$table_criteria." and login like '$yr-$mon%' 
			ORDER BY $sort $how ";
 }
 else {
 	$query = " SELECT SU.user_name AS source_user, RU.user_name AS remote_user, SH.host_name AS source_host, RH.host_name AS remote_host, gateways.name as gw_name,login,logout,services.name AS name,direction, am_statuses.am_return_code,am_statuses.am_return_code_description as amd
			FROM gw_logins 
			LEFT JOIN users SU ON gw_logins.user_id=SU.user_id 
			LEFT JOIN users RU ON gw_logins.remote_user_id=RU.user_id 
			LEFT JOIN hosts SH ON gw_logins.source_id=SH.host_id 
			LEFT JOIN hosts RH ON gw_logins.destination_id=RH.host_id 
			LEFT JOIN gateways ON gw_logins.gw_id=gateways.id LEFT JOIN services ON gw_logins.service_id=services.id 
			LEFT JOIN am_statuses ON gw_logins.am_id=am_statuses.am_id 
			WHERE ".$logout." and ".$table_criteria." 
			ORDER BY $sort $how ";
 }
//echo $query;
	  	$rs = $cn->get_data($query);

	  return $rs;

	}
/*****************************************************************************************************************************************************************************

//View gateway load information by page

*****************************************************************************************************************************************************************************/		
    
	function viewGatewayLoadInformationByPage($criteria,$id,$sort,$how,$StartRow,$PageSize,$loginStatus,&$con)
	{
	     // echo $criteria;
	    $rs=null;
	  $fromDate="";
	  $toDate="";
	  $logoutfromDate="";
	  $logouttoDate="";

	  $table_criteria="";
	  $total_criteria = split("\,",$criteria);
	  $total_len = count($total_criteria);
	    
	   for ($i=0;$i<$total_len;$i++) {
	   	$each_item = split(":",$total_criteria[$i]);
	   	$item_name = $each_item[0];
	   	$item_value = $each_item[1];
	   
	   	 if ( $each_item[0]=="gateway") {
 			if ($table_criteria == "" ) {
 				$table_criteria= "gateways.name='$each_item[1]'";
 				}
 			else {
 				$table_criteria= $table_criteria." and gateways.name='$each_item[1]'";
 		 		}
 		 }
	if ( $each_item[0]=="user_name") {
			$user_name=$each_item[1];
			if ($user_name=="Others") {
	     	    $count = $_SESSION["top_ten_users_loop"];
				for ($j=0;$j<$count;$j++) {
					$labelName = $_SESSION["top_ten_users_load_labels".$j]; 	
				 if ($j==0)
					$user_id = "'".$labelName."'";
				else 
					$user_id = $user_id . "," . "'".$labelName."'";
				}
 			if ($table_criteria == "" ) {
 				$table_criteria= "SU.user_name NOT IN ($user_id)";
 				}
 			else {
 				$table_criteria= $table_criteria." and SU.user_name NOT IN ($user_id)";
 		 		}
 		 	}
 		 else {
			$first_chr = substr($user_name,0,1);
			$ulen = strlen($user_name);
			$last_chr = substr($user_name,$ulen-1,1);
			if ($first_chr=="*" and $last_chr=="*") {
				$user_name = substr($user_name,1,$ulen-2);
			if ($table_criteria == "" ) {
 				$table_criteria= "SU.user_name like '%$user_name%'";
 				}
 			else {
 				$table_criteria= $table_criteria." and SU.user_name like '%$user_name%'";
 		 		}
			}
			else if ($first_chr=="*") {
				$user_name = substr($user_name,1,$ulen-1);
			if ($table_criteria == "" ) {
 				$table_criteria= "SU.user_name like '%$user_name'";
 				}
 			else {
 				$table_criteria= $table_criteria." and SU.user_name like '%$user_name'";
 		 		}
			} 
			else if ($last_chr=="*") {
				$user_name = substr($user_name,0,$ulen-1);
			if ($table_criteria == "" ) {
 				$table_criteria= "SU.user_name like '$user_name%'";
 				}
 			else {
 				$table_criteria= $table_criteria." and SU.user_name like '$user_name%'";
 		 		}
			}
			else {
			if ($table_criteria == "" ) {
 				$table_criteria= "SU.user_name='$user_name'";
 				}
 			else {
 				$table_criteria= $table_criteria." and SU.user_name='$user_name'";
 		 		}
			} 
 		 }
 		 }
	   if ( $each_item[0]=="destination_user_name") {
			$destination_user_name=$each_item[1];
			
 			
			$first_chr = substr($destination_user_name,0,1);
			$ulen = strlen($destination_user_name);
			$last_chr = substr($destination_user_name,$ulen-1,1);
			if ($first_chr=="*" and $last_chr=="*") {
				$destination_user_name = substr($destination_user_name,1,$ulen-2);
			if ($table_criteria == "" ) {
 				$table_criteria= "RU.user_name like '%$destination_user_name%'";
 				}
 			else {
 				$table_criteria= $table_criteria." and RU.user_name like '%$destination_user_name%'";
 		 		}
			}
			else if ($first_chr=="*") {
				$destination_user_name = substr($destination_user_name,1,$ulen-1);
			if ($table_criteria == "" ) {
 				$table_criteria= "RU.user_name like '%$destination_user_name'";
 				}
 			else {
 				$table_criteria= $table_criteria." and RU.user_name like '%$destination_user_name'";
 		 		}
			} 
			else if ($last_chr=="*") {
				$destination_user_name = substr($destination_user_name,0,$ulen-1);
			if ($table_criteria == "" ) {
 				$table_criteria= "RU.user_name like '$destination_user_name%'";
 				}
 			else {
 				$table_criteria= $table_criteria." and RU.user_name like '$destination_user_name%'";
 		 		}
			}
			else {
			if ($table_criteria == "" ) {
 				$table_criteria= "RU.user_name ='$destination_user_name'";
 				}
 			else {
 				$table_criteria= $table_criteria." and RU.user_name='$destination_user_name'";
 		 		}
			} 
 		 
 		 }
		if ( $each_item[0]=="source_host") {
 			$source_host=$each_item[1];
			$first_chr = substr($source_host,0,1);
			$ulen = strlen($source_host);
			$last_chr = substr($source_host,$ulen-1,1);
			if ($first_chr=="*" and $last_chr=="*") {
				$source_host = substr($source_host,1,$ulen-2);
			if ($table_criteria == "" ) {
 				$table_criteria= "SH.host_name  like '%$source_host%'";
 				}
 			else {
 				$table_criteria= $table_criteria." and SH.host_name  like '%$source_host%'";
 		 		}
			}
			else if ($first_chr=="*") {
				$source_host = substr($source_host,1,$ulen-1);
			if ($table_criteria == "" ) {
 				$table_criteria= "SH.host_name  like '%$source_host'";
 				}
 			else {
 				$table_criteria= $table_criteria." and SH.host_name  like '%$source_host'";
 		 		}
			} 
			else if ($last_chr=="*") {
				$source_host = substr($source_host,0,$ulen-1);
			if ($table_criteria == "" ) {
 				$table_criteria= "SH.host_name  like '$source_host%'";
 				}
 			else {
 				$table_criteria= $table_criteria." and SH.host_name  like '$source_host%'";
 		 		}
			}
			else {
			$pos = strpos($source_host,".cern.ch");
   			 if($pos === false) {
     			$fqdn = $source_host . ".cern.ch";
      			 }
			 if ($fqdn==""){
    			$sh = "SH.host_name='$source_host'";
			    }
			    else {
			    	$sh = "(SH.host_name='$source_host' or SH.host_name='$fqdn')";
			    }
			if ($table_criteria == "" ) {
	 				$table_criteria= $sh;
	 				}
	 			else {
	 				$table_criteria= $table_criteria." and $sh";
	 		 		}
			} 
 		 }
		if ( $each_item[0]=="destination_host") {
 			$destination_host=$each_item[1];
 			if ($destination_host=="Others") {
	     	    $count = $_SESSION["destination_host_loop"];
				for ($j=0;$j<$count;$j++) {
					$labelName = $_SESSION["destination_host_load_labels".$j]; 	
				 if ($j==0)
					$destination_host_id = "'".$labelName."'";
				else 
					$destination_host_id = $destination_host_id . "," . "'".$labelName."'";
				}
 			if ($table_criteria == "" ) {
 				$table_criteria= "RH.host_name NOT IN ($destination_host_id)";
 				}
 			else {
 				$table_criteria= $table_criteria." and RH.host_name NOT IN ($destination_host_id)";
 		 		}
 		 	}
 		 else {
			$first_chr = substr($destination_host,0,1);
			$ulen = strlen($destination_host);
			$last_chr = substr($destination_host,$ulen-1,1);
			if ($first_chr=="*" and $last_chr=="*") {
				$destination_host = substr($destination_host,1,$ulen-2);
			if ($table_criteria == "" ) {
 				$table_criteria= "RH.host_name  like '%$destination_host%'";
 				}
 			else {
 				$table_criteria= $table_criteria." and RH.host_name  like '%$destination_host%'";
 		 		}
			}
			else if ($first_chr=="*") {
				$destination_host = substr($destination_host,1,$ulen-1);
			if ($table_criteria == "" ) {
 				$table_criteria= "RH.host_name  like '%$destination_host'";
 				}
 			else {
 				$table_criteria= $table_criteria." and RH.host_name  like '%$destination_host'";
 		 		}
			} 
			else if ($last_chr=="*") {
				$destination_host = substr($destination_host,0,$ulen-1);
			if ($table_criteria == "" ) {
 				$table_criteria= "RH.host_name  like '$destination_host%'";
 				}
 			else {
 				$table_criteria= $table_criteria." and RH.host_name  like '$destination_host%'";
 		 		}
			}
			else {
			$pos = strpos($destination_host,".cern.ch");
			 if($pos === false) {
     			$dfqdn = $destination_host . ".cern.ch";
      			 }
			
			 if ($dfqdn==""){
    			$sh = "RH.host_name='$destination_host'";
			    }
			    else {
			    	$sh = "(RH.host_name='$destination_host' or RH.host_name='$dfqdn')";
			    }	 	
			if ($table_criteria == "" ) {
 				$table_criteria= $sh;
 				}
 			else {
 				$table_criteria= $table_criteria." and $sh";
 		 		}
			} 
 		   }
 		 }
		if ( $each_item[0]=="service") {
			if ( $each_item[1]=="Others") {
				if ($table_criteria == "" ) {
	 				$table_criteria= "services.name is null'";
	 				}
	 			else {
	 				$table_criteria= $table_criteria." and services.name is null";
	 		 		}
			}
			else {
 			if ($table_criteria == "" ) {
 				$table_criteria= "services.name='$each_item[1]'";
 				}
 			else {
 				$table_criteria= $table_criteria." and services.name='$each_item[1]'";
 		 		}
			}
 		 }
		if ( $each_item[0]=="direction") {
 			if ($table_criteria == "" ) {
 				$table_criteria= "direction='$each_item[1]'";
 				}
 			else {
 				$table_criteria= $table_criteria." and direction='$each_item[1]'";
 		 		}
 		 }
		if ( $each_item[0]=="am_return_codes") {
 			if ($table_criteria == "" ) {
 				$table_criteria= "am_statuses.am_return_code_description='$each_item[1]'";
 				}
 			else {
 				$table_criteria= $table_criteria." and am_statuses.am_return_code_description='$each_item[1]'";
 		 		}
 		 }
 		 	if ($each_item[0]=="from") {
					if ($each_item[1]=="lastyear" or $each_item[1]=="lastmonth" or $each_item[1]=="lastweek" or $each_item[1]=="lastday")
						$fromDate=$each_item[1];
					else
					 	$fromDate= $each_item[1].":".$each_item[2].":".$each_item[3];
					
				  }
				if ($each_item[0]=="to") {
					 $toDate= $each_item[1].":".$each_item[2].":".$each_item[3];
					
				  }


if ($fromDate=="lastday") {
$yesterday  = date('Y-m-d H:i:s',time()-3600*24);
$todate = date('Y-m-d H:i:s');
	if ($table_criteria == "") {
	$table_criteria = "login between '$yesterday' and '$todate'";
	}
	else {
 	$table_criteria = $table_criteria ." and login between '$yesterday' and '$todate'";
 	

 	}
}
else if ($fromDate=="lastweek") {
$week  = date('Y-m-d H:i:s',time()-3600*24*6);

$todate = date('Y-m-d H:i:s');
	if ($table_criteria == "") {
	$table_criteria = "login between '$week' and '$todate'";
	}
	else {
 	$table_criteria = $table_criteria ." and login between '$week' and '$todate'";
 	

 	}
}
else if ($fromDate=="lastmonth") {
$month  = date('Y-m-d H:i:s',time()-3600*24*29);

$todate = date('Y-m-d H:i:s');
	if ($table_criteria == "") {
	$table_criteria = "login between '$month' and '$todate'";
	}
	else {
 	$table_criteria = $table_criteria ." and login between '$month' and '$todate'";
 	

 	}
}
else if ($fromDate=="lastyear") {
$year  = date('Y-m-d H:i:s',time()-3600*24*365);
$todate = date('Y-m-d H:i:s');
	if ($table_criteria == "") {
	$table_criteria= "login between '$year' and '$todate'";
	}
	else {
 	$table_criteria = $table_criteria ." and login between '$year' and '$todate'";
 	

 	}
}

else {

if ($fromDate!="" && $toDate!="") {
	 $fDate = date('Y-m-d H:i:s', strtotime($fromDate));
	 $tDate = date('Y-m-d H:i:s', strtotime($toDate));
	 //$date = strtotime(date("Y-m-d H:i:s", strtotime($tDate)));
	// $td = Date("Y-m-d H:i:s", $date);

	if ($table_criteria == "") {
	$table_criteria = "login between '$fromDate'and '$tDate'";
	}
	else {
 	$table_criteria = $table_criteria ." and login between '$fromDate'and '$tDate'";
 	}
  }
}
		
if ($each_item[0]=="logoutfrom") {
					if ($each_item[1]=="lastyear" or $each_item[1]=="lastmonth" or $each_item[1]=="lastweek" or $each_item[1]=="lastday")
						$logoutfromDate=$each_item[1];
					else
  					    $logoutfromDate= $each_item[1].":".$each_item[2].":".$each_item[3];
					
				  }
				if ($each_item[0]=="logoutto") {
					 $logouttoDate= $each_item[1].":".$each_item[2].":".$each_item[3];
					
				  }

	if ($logoutfromDate=="lastday") {
			$yesterday  = date('Y-m-d H:i:s',time()-3600*24);
			$todate = date('Y-m-d H:i:s');
				if ($table_criteria == "") {
				$table_criteria = "logout between '$yesterday' and '$todate'";
				}
				else {
			 	$table_criteria = $table_criteria ." and logout between '$yesterday' and '$todate'";
			 	
			
			 	}
			}
		else if ($logoutfromDate=="lastweek") {
			$week  = date('Y-m-d H:i:s',time()-3600*24*6);
			$todate = date('Y-m-d H:i:s');
				if ($table_criteria == "") {
				$table_criteria = "logout between '$week' and '$todate'";
				}
				else {
			 	$table_criteria = $table_criteria ." and logout between '$week' and '$todate'";
			 	
			
			 	}
			}
		else if ($logoutfromDate=="lastmonth") {
			$month  = date('Y-m-d H:i:s',time()-3600*24*29);
			
			$todate = date('Y-m-d H:i:s');
				if ($table_criteria == "") {
				$table_criteria = "logout between '$month' and '$todate'";
				}
				else {
			 	$table_criteria = $table_criteria ." and logout between '$month' and '$todate'";
			 	
			
			 	}
			}
		else if ($logoutfromDate=="lastyear") {
			$year  = date('Y-m-d H:i:s',time()-3600*24*365);
			$todate = date('Y-m-d H:i:s');
				if ($table_criteria == "") {
				$table_criteria= "logout between '$year' and '$todate'";
				}
				else {
			 	$table_criteria = $table_criteria ." and logout between '$year' and '$todate'";
			 	}
			}
	else {
	   if ( $logoutfromDate!="" && $logouttoDate!="") {
	   		
 			if ($table_criteria == "" ) {
 				$table_criteria= "logout between '$logoutfromDate' and '$logouttoDate'";
 				}
 			else {
 				$table_criteria= $table_criteria." and logout between '$logoutfromDate' and '$logouttoDate'";
 		 		}
 		 }
		}

	   	
	   }   
if ($loginStatus=="ON")
 	$logout = "logout is NULL";
else
	$logout = "logout is NOT NULL";
 
       $cn = (object)$con;	
 if ($id!="") {
	   
    list ($mn,$yr) = split("-",$id);
    if ($mn=="Jan")
    		$mon =  "01";
	if ($mn=="Feb")
    		$mon =  "02"; 
	if ($mn=="Mar")
    		$mon =  "03"; 
	if ($mn=="Apr")
    		$mon =  "04"; 
	if ($mn=="May")
    		$mon =  "05"; 
	if ($mn=="Jun")
    		$mon =  "06"; 
	if ($mn=="Jul")
    		$mon =  "07"; 
	if ($mn=="Aug")
    		$mon =  "08"; 
	if ($mn=="Sep")
    		$mon =  "09";
	if ($mn=="Oct")
    		$mon =  "10";  
	if ($mn=="Nov")
    		$mon =  "11";
	if ($mn=="Dec")
    		$mon =  "12";  

    $query = " SELECT SU.user_name AS source_user, RU.user_name AS remote_user, SH.host_name AS source_host, RH.host_name AS remote_host, gateways.name as gw_name,login,logout,services.name AS name,direction, am_statuses.am_return_code,am_statuses.am_return_code_description as amd
			FROM gw_logins 
			LEFT JOIN users SU ON gw_logins.user_id=SU.user_id 
			LEFT JOIN users RU ON gw_logins.remote_user_id=RU.user_id 
			LEFT JOIN hosts SH ON gw_logins.source_id=SH.host_id 
			LEFT JOIN hosts RH ON gw_logins.destination_id=RH.host_id 
			LEFT JOIN gateways ON gw_logins.gw_id=gateways.id
			LEFT JOIN services ON gw_logins.service_id=services.id 
			LEFT JOIN am_statuses ON gw_logins.am_id=am_statuses.am_id 
			WHERE ".$logout." and ".$table_criteria." and login like '$yr-$mon%' 
			ORDER BY $sort $how LIMIT $StartRow,$PageSize";
 }
 else {
 	$query = " SELECT SU.user_name AS source_user, RU.user_name AS remote_user, SH.host_name AS source_host, RH.host_name AS remote_host, gateways.name as gw_name,login,logout,services.name AS name,direction, am_statuses.am_return_code,am_statuses.am_return_code_description as amd
			FROM gw_logins 
			LEFT JOIN users SU ON gw_logins.user_id=SU.user_id 
			LEFT JOIN users RU ON gw_logins.remote_user_id=RU.user_id 
			LEFT JOIN hosts SH ON gw_logins.source_id=SH.host_id 
			LEFT JOIN hosts RH ON gw_logins.destination_id=RH.host_id 
			LEFT JOIN gateways ON gw_logins.gw_id=gateways.id LEFT JOIN services ON gw_logins.service_id=services.id 
			LEFT JOIN am_statuses ON gw_logins.am_id=am_statuses.am_id 
			WHERE ".$logout." and ".$table_criteria." 
			ORDER BY $sort $how LIMIT $StartRow,$PageSize";
 }
//echo $query;
	  	$rs = $cn->get_data($query);


	  return $rs;	}
	
/*****************************************************************************************************************************************************************************

//View Current Login

*****************************************************************************************************************************************************************************/	
 

    function viewStatisticsHistoryLoad($gateway,$user_name,$destination_user_name,$source_host,$destination_host,$service,$direction,$am_status_code,$fromDate,$toDate,$logoutFromDate,$logoutToDate,&$con)
	{
	$cn = (object)$con;
	
 $gateway = mysql_real_escape_string($gateway);
 $user_name = mysql_real_escape_string($user_name);
 $destination_user_name = mysql_real_escape_string($destination_user_name);
 $source_host = mysql_real_escape_string($source_host);
 $destination_host = mysql_real_escape_string($destination_host);
 $service = mysql_real_escape_string($service);
 $direction = mysql_real_escape_string($direction);
 $am_status_code = mysql_real_escape_string($am_status_code);
 $fromDate = mysql_real_escape_string($fromDate);
 $toDate = mysql_real_escape_string($toDate);
 $logoutFromDate= mysql_real_escape_string($logoutFromDate);
 $logoutToDate= mysql_real_escape_string($logoutToDate);

 
	$criteria ="";
$graph_criteria = "";
$order_by = "";
$table = "SELECT SU.user_name AS source_user, RU.user_name AS remote_user, SH.host_name AS source_host, RH.host_name AS remote_host, gateways.name AS gw_name,login,logout,services.name AS name,direction, am_statuses.am_return_code,am_statuses.am_return_code_description,count(gw_logins.login) as total_login
			FROM gw_logins 
			LEFT JOIN users SU ON gw_logins.user_id=SU.user_id 
			LEFT JOIN users RU ON gw_logins.remote_user_id=RU.user_id 
			LEFT JOIN hosts SH ON gw_logins.source_id=SH.host_id 
			LEFT JOIN hosts RH ON gw_logins.destination_id=RH.host_id 
			LEFT JOIN gateways ON gw_logins.gw_id=gateways.id LEFT JOIN services ON gw_logins.service_id=services.id 
			LEFT JOIN am_statuses ON gw_logins.am_id=am_statuses.am_id ";

 if ($gateway!="") {
 	if ($criteria == "" ) {
 		$criteria = "gateways.name='$gateway'";
 		}
 	else {
 		$criteria = $criteria ." and gateways.name='$gateway'";
 		 	}
 		 	$group_by = "GROUP BY Month(gw_logins.login),Year(gw_logins.login) order by gw_logins.login ASC";
 }
else {
	$group_by = "GROUP BY gw_logins.gw_id";

}
	if ($user_name!="") {
	$first_chr = substr($user_name,0,1);
	$ulen = strlen($user_name);
	$last_chr = substr($user_name,$ulen-1,1);
	if ($first_chr=="*" and $last_chr=="*") {
		$user_name = substr($user_name,1,$ulen-2);
		if ($criteria == "") {
			$criteria = "SU.user_name Like '%$user_name%'";
		}
		else {
	 	$criteria = $criteria ." and SU.user_name Like '%$user_name%'";
	 	}
	}
	else if ($first_chr=="*") {
		$user_name = substr($user_name,1,$ulen-1);
		if ($criteria == "") {
			$criteria = "SU.user_name Like '%$user_name'";
		}
		else {
	 	$criteria = $criteria ." and SU.user_name Like '%$user_name'";
	 	}
	} 
	else if ($last_chr=="*") {
		$user_name = substr($user_name,0,$ulen-1);
		if ($criteria == "") {
			$criteria = "SU.user_name Like '$user_name%'";
		}
		else {
	 	$criteria = $criteria ." and SU.user_name Like '$user_name%'";
	 	}
	}
	else {
	if ($criteria == "") {
			$criteria = "SU.user_name='$user_name'";
		}
		else {
	 	$criteria = $criteria ." and SU.user_name='$user_name'";
	 	}
	} 
 }
	if ($destination_user_name!="") {
	
	$first_chr = substr($destination_user_name,0,1);
	$ulen = strlen($destination_user_name);
	$last_chr = substr($destination_user_name,$ulen-1,1);
	if ($first_chr=="*" and $last_chr=="*") {
		$destination_user_name = substr($destination_user_name,1,$ulen-2);
		if ($criteria == "") {
			$criteria = "RU.user_name Like '%$destination_user_name%'";
		}
		else {
	 	$criteria = $criteria ." and RU.user_name Like '%$destination_user_name%'";
	 	}
	}
	else if ($first_chr=="*") {
		$destination_user_name = substr($destination_user_name,1,$ulen-1);
		if ($criteria == "") {
			$criteria = "RU.user_name Like '%$destination_user_name'";
		}
		else {
	 	$criteria = $criteria ." and RU.user_name Like '%$destination_user_name'";
	 	}
	} 
	else if ($last_chr=="*") {
		$destination_user_name = substr($destination_user_name,0,$ulen-1);
		if ($criteria == "") {
			$criteria = "RU.user_name Like '$destination_user_name%'";
		}
		else {
	 	$criteria = $criteria ." and RU.user_name Like '$destination_user_name%'";
	 	}
	}
	else {
		
	if ($criteria == "") {
			$criteria = "RU.user_name='$destination_user_name'";
		}
		else {
	 	$criteria = $criteria ." and RU.user_name='$destination_user_name'";
	 	}
	} 
 }
if ($source_host!="") {
	$first_chr = substr($source_host,0,1);
	$ulen = strlen($source_host);
	$last_chr = substr($source_host,$ulen-1,1);
	if ($first_chr=="*" and $last_chr=="*") {
		$source_host = substr($source_host,1,$ulen-2);
		if ($criteria == "") {
			$criteria = "SH.host_name like '%$source_host%'";
		}
		else {
	 	$criteria = $criteria ." and SH.host_name like '%$source_host%'";
	 	}
	}
	else if ($first_chr=="*") {
		$source_host = substr($source_host,1,$ulen-1);
		if ($criteria == "") {
			$criteria = "SH.host_name like '%$source_host'";
		}
		else {
	 	$criteria = $criteria ." and SH.host_name like '%$source_host'";
	 	}
	} 
	else if ($last_chr=="*") {
		$source_host = substr($source_host,0,$ulen-1);
		if ($criteria == "") {
			$criteria = "SH.host_name like '$source_host%'";
		}
		else {
	 	$criteria = $criteria ." and SH.host_name like '$source_host%'";
	 	}
	}
	else {
	$pos = strpos($source_host,".cern.ch");
     if($pos === false) {
     	$fqdn = $source_host . ".cern.ch";
         }
	 if ($fqdn==""){
    	$sh = "SH.host_name='$source_host'";
    }
    else {
    	$sh = "(SH.host_name='$source_host' or SH.host_name='$fqdn')";
    }
    if ($criteria == "") {
			$criteria = $sh;
		}
		else {
	 	$criteria = $criteria ." and $sh";
	 	}
	} 
 }
if ($destination_host!="") {
	$first_chr = substr($destination_host,0,1);
	$ulen = strlen($destination_host);
	$last_chr = substr($destination_host,$ulen-1,1);
	if ($first_chr=="*" and $last_chr=="*") {
		$destination_host = substr($destination_host,1,$ulen-2);
		if ($criteria == "") {
			$criteria = "RH.host_name like '%$destination_host%'";
		}
		else {
	 	$criteria = $criteria ." and RH.host_name like '%$destination_host%'";
	 	}
	}
	else if ($first_chr=="*") {
		$destination_host = substr($destination_host,1,$ulen-1);
		if ($criteria == "") {
			$criteria = "RH.host_name like '%$destination_host'";
		}
		else {
	 	$criteria = $criteria ." and RH.host_name like '%$destination_host'";
	 	}
	} 
	else if ($last_chr=="*") {
		$destination_host = substr($destination_host,0,$ulen-1);
		if ($criteria == "") {
			$criteria = "RH.host_name like '$destination_host%'";
		}
		else {
	 	$criteria = $criteria ." and RH.host_name like '$destination_host%'";
	 	}
	}
	else {
	$pos = strpos($destination_host,".cern.ch");
	 if($pos === false) {
     	$dfqdn = $destination_host . ".cern.ch";
       }
	 if ($dfqdn==""){
    	$sh = "RH.host_name='$destination_host'";
    }
    else {
    	$sh = "(RH.host_name='$destination_host' or RH.host_name='$dfqdn')";
    }  
	if ($criteria == "") {
			$criteria = $sh;
		}
		else {
	 	$criteria = $criteria ." and $sh";
	 	}
	} 
	
 }

if ($service !="Select") {
	if ($criteria == "") {
		$criteria = "gw_logins.service_id ='$service'";
	}
	else {
 	$criteria = $criteria ." and gw_logins.service_id =$service";
 	}
 }

if ($direction!="Select") {
	if ($criteria == "") {
	$criteria = "gw_logins.direction ='$direction'";
	}
	else {
 	$criteria = $criteria ." and gw_logins.direction ='$direction'";
 	}
  }
if ($am_status_code!="Select") {
	if ($criteria == "") {
	$criteria = "gw_logins.am_id =$am_status_code";
	}
	else {
 	$criteria = $criteria ." and gw_logins.am_id =$am_status_code";
 	}
  }
if ($fromDate=="lastday") {
$yesterday  = date('Y-m-d H:i:s',time()-3600*24);
$todate = date('Y-m-d H:i:s');
	if ($criteria == "") {
	$criteria = "login between '$yesterday' and '$todate'";
	}
	else {
 	$criteria = $criteria ." and login between '$yesterday' and '$todate'";
 	

 	}
}
else if ($fromDate=="lastweek") {
$week  = date('Y-m-d H:i:s',time()-3600*24*6);

$todate = date('Y-m-d H:i:s');
	if ($criteria == "") {
	$criteria = "login between '$week' and '$todate'";
	}
	else {
 	$criteria = $criteria ." and login between '$week' and '$todate'";
 	

 	}
}
else if ($fromDate=="lastmonth") {
$month  = date('Y-m-d H:i:s',time()-3600*24*29);

$todate = date('Y-m-d H:i:s');
	if ($criteria == "") {
	$criteria = "login between '$month' and '$todate'";
	}
	else {
 	$criteria = $criteria ." and login between '$month' and '$todate'";
 	

 	}
}
else if ($fromDate=="lastyear") {
$year  = date('Y-m-d H:i:s',time()-3600*24*365);
$todate = date('Y-m-d H:i:s');
	if ($criteria == "") {
	$criteria = "login between '$year' and '$todate'";
	}
	else {
 	$criteria = $criteria ." and login between '$year' and '$todate'";
 	

 	}
}

else {

if ($fromDate!="" && $toDate!="") {
	 $fDate = date('Y-m-d H:i:s', strtotime($fromDate));
	 $tDate = date('Y-m-d H:i:s', strtotime($toDate));
	 //$date = strtotime(date("Y-m-d H:i:s", strtotime($tDate)));
	// $td = Date("Y-m-d H:i:s", $date);

	if ($criteria == "") {
	$criteria = "login between '$fromDate'and '$tDate'";
	}
	else {
 	$criteria = $criteria ." and login between '$fromDate'and '$tDate'";
 	}
  }
}
if ($logoutFromDate=="lastday") {
$yesterday  = date('Y-m-d H:i:s',time()-3600*24);
$todate = date('Y-m-d H:i:s');
	if ($criteria == "") {
	$criteria = "logout between '$yesterday' and '$todate'";
	}
	else {
 	$criteria = $criteria ." and logout between '$yesterday' and '$todate'";
 	

 	}
}
else if ($logoutFromDate=="lastweek") {
$week  = date('Y-m-d H:i:s',time()-3600*24*6);

$todate = date('Y-m-d H:i:s');
	if ($criteria == "") {
	$criteria = "logout between '$week' and '$todate'";
	}
	else {
 	$criteria = $criteria ." and logout between '$week' and '$todate'";
 	

 	}
}
else if ($logoutFromDate=="lastmonth") {
$month  = date('Y-m-d H:i:s',time()-3600*24*29);

$todate = date('Y-m-d H:i:s');
	if ($criteria == "") {
	$criteria = "logout between '$month' and '$todate'";
	}
	else {
 	$criteria = $criteria ." and logout between '$month' and '$todate'";
 	

 	}
}
else if ($logoutFromDate=="lastyear") {
$year  = date('Y-m-d H:i:s',time()-3600*24*365);
$todate = date('Y-m-d H:i:s');
	if ($criteria == "") {
	$criteria = "logout between '$year' and '$todate'";
	}
	else {
 	$criteria = $criteria ." and logout between '$year' and '$todate'";
 	

 	}
}

else {

if ($logoutFromDate!="" && $logoutToDate!="") {
	 $lfDate = date('Y-m-d H:i:s', strtotime($logoutFromDate));
	 $ltDate = date('Y-m-d H:i:s', strtotime($logoutToDate));
	 $date = strtotime(date("Y-m-d H:i:s", strtotime($ltDate)) . " +1 day");
	 $ltd = Date("Y-m-d H:i:s", $date);

	if ($criteria == "") {
	$criteria = "logout between '$logoutFromDate'and '$logoutToDate'";
	}
	else {
 	$criteria = $criteria ." and logout between '$logoutFromDate' and '$logoutToDate'";
 	}
  }
}
  

$query = $table . " WHERE logout is NOT NULL and " . $criteria . " " . $group_by;
//echo $query;
$rs = $cn->get_data($query);
	  
	  return $rs;
	}


/*****************************************************************************************************************************************************************************

//View Statistics History Load Per Month

*****************************************************************************************************************************************************************************/	
 

    function viewStatisticsHistoryLoadPerMonth($criteria,&$con)
	{
	$cn = (object)$con;
	  			$gateway="";
				$user_name="";
				$gateway="";
				$source_host="";
				$destination_host="";
				$service="";
				$direction="";
				$am_status_code="";
				$fromDate="";
				$toDate="";
				$logoutfromDate="";
				$logouttoDate="";

				$table_criteria="";
				$total_criteria = split("\,",$criteria);
				$total_len = count($total_criteria);
				$G_file_name = "";
				for ($i=0;$i<$total_len;$i++) {
				  $each_item = split(":",$total_criteria[$i]);
				  $item_name = $each_item[0];
				  $item_value = $each_item[1];
				 if ($each_item[0]=="gateway") {
					$gateway = $each_item[1];
					if ($G_file_name == "")
						$G_file_name = $each_item[1];
					else 
						$G_file_name = $G_file_name .",".$each_item[1];

				 }
				 if ($each_item[0]=="user_name") {
					$user_name= $each_item[1];
					if ($G_file_name == "")
						$G_file_name = $each_item[1];
					else 
						$G_file_name = $G_file_name .",".$each_item[1];

				 }
				 if ($each_item[0]=="destination_user_name") {
					$destination_user_name= $each_item[1];
					if ($G_file_name == "")
						$G_file_name = $each_item[1];
					else 
						$G_file_name = $G_file_name .",".$each_item[1];

				 }
				if ($each_item[0]=="source_host") {
					$source_host= $each_item[1];
					if ($G_file_name == "")
						$G_file_name = $each_item[1];
					else 
						$G_file_name = $G_file_name .",".$each_item[1];

				 }

				if ($each_item[0]=="destination_host") {
					$destination_host= $each_item[1];
					if ($G_file_name == "")
						$G_file_name = $each_item[1];
					else 
						$G_file_name = $G_file_name .",".$each_item[1];

				 }

				if ($each_item[0]=="service") {
					$service= $each_item[1];
					if ($G_file_name == "")
						$G_file_name = $each_item[1];
					else 
						$G_file_name = $G_file_name .",".$each_item[1];

				 }

				if ($each_item[0]=="direction") {
					$direction= $each_item[1];
					if ($G_file_name == "")
						$G_file_name = $each_item[1];
					else 
						$G_file_name = $G_file_name .",".$each_item[1];

				  }
				if ($each_item[0]=="am_return_codes") {
					$am_status_code= $each_item[1];
					if ($G_file_name == "")
						$G_file_name = $each_item[1];
					else 
						$G_file_name = $G_file_name .",".$each_item[1];

				  }
				if ($each_item[0]=="from") {
					if ($each_item[1]=="lastyear" or $each_item[1]=="lastmonth" or $each_item[1]=="lastweek" or $each_item[1]=="lastday")
						$fromDate=$each_item[1];
					else 
						$fromDate= $each_item[1].":".$each_item[2].":".$each_item[3];
					 
					 if ($G_file_name == "")
						$G_file_name = $each_item[1];
					else 
						$G_file_name = $G_file_name .",".$each_item[1];

				  }
				if ($each_item[0]=="to") {
					 $toDate= $each_item[1].":".$each_item[2].":".$each_item[3];
					 if ($G_file_name == "")
						$G_file_name = $each_item[1];
					else 
						$G_file_name = $G_file_name .",".$each_item[1];
				  }
				
				if ($each_item[0]=="logoutfrom") {
					 $logoutfromDate= $each_item[1].":".$each_item[2].":".$each_item[3];
					// echo $logoutfromDate;
					 if ($G_file_name == "")
						$G_file_name = $each_item[1];
					else 
						$G_file_name = $G_file_name .",".$each_item[1];

				  }
				if ($each_item[0]=="logoutto") {
					 $logouttoDate= $each_item[1].":".$each_item[2].":".$each_item[3];
					
					 if ($G_file_name == "")
						$G_file_name = $each_item[1];
					else 
						$G_file_name = $G_file_name .",".$each_item[1];
				  }

				}
	$criteria ="";
$graph_criteria = "";
$order_by = "";
$table = "SELECT SU.user_name AS source_user, RU.user_name AS remote_user, SH.host_name AS source_host, RH.host_name AS remote_host, gateways.name AS gw_name,login,logout,services.name AS name,direction, am_statuses.am_return_code,am_statuses.am_return_code_description,count(gw_logins.login) as total_login
			FROM gw_logins 
			LEFT JOIN users SU ON gw_logins.user_id=SU.user_id 
			LEFT JOIN users RU ON gw_logins.remote_user_id=RU.user_id 
			LEFT JOIN hosts SH ON gw_logins.source_id=SH.host_id 
			LEFT JOIN hosts RH ON gw_logins.destination_id=RH.host_id 
			LEFT JOIN gateways ON gw_logins.gw_id=gateways.id LEFT JOIN services ON gw_logins.service_id=services.id 
			LEFT JOIN am_statuses ON gw_logins.am_id=am_statuses.am_id ";

 if ($gateway!="") {
 	if ($criteria == "" ) {
 		$criteria = "gateways.name='$gateway'";
 		}
 	else {
 		$criteria = $criteria ." and gateways.name='$gateway'";
 		 	}
 		 	$group_by = "GROUP BY Month(gw_logins.login),Year(gw_logins.login) order by gw_logins.login ASC";
 }
else {
	$group_by = "GROUP BY gw_logins.gw_id";

}
	if ($user_name!="") {
	$first_chr = substr($user_name,0,1);
	$ulen = strlen($user_name);
	$last_chr = substr($user_name,$ulen-1,1);
	if ($first_chr=="*" and $last_chr=="*") {
		$user_name = substr($user_name,1,$ulen-2);
		if ($criteria == "") {
			$criteria = "SU.user_name Like '%$user_name%'";
		}
		else {
	 	$criteria = $criteria ." and SU.user_name Like '%$user_name%'";
	 	}
	}
	else if ($first_chr=="*") {
		$user_name = substr($user_name,1,$ulen-1);
		if ($criteria == "") {
			$criteria = "SU.user_name Like '%$user_name'";
		}
		else {
	 	$criteria = $criteria ." and SU.user_name Like '%$user_name'";
	 	}
	} 
	else if ($last_chr=="*") {
		$user_name = substr($user_name,0,$ulen-1);
		if ($criteria == "") {
			$criteria = "SU.user_name Like '$user_name%'";
		}
		else {
	 	$criteria = $criteria ." and SU.user_name Like '$user_name%'";
	 	}
	}
	else {
	if ($criteria == "") {
			$criteria = "SU.user_name='$user_name'";
		}
		else {
	 	$criteria = $criteria ." and SU.user_name='$user_name'";
	 	}
	} 
 }
 
if ($destination_user_name!="") {
	$first_chr = substr($destination_user_name,0,1);
	$ulen = strlen($destination_user_name);
	$last_chr = substr($destination_user_name,$ulen-1,1);
	if ($first_chr=="*" and $last_chr=="*") {
		$destination_user_name = substr($destination_user_name,1,$ulen-2);
		if ($criteria == "") {
			$criteria = "RU.user_name Like '%$destination_user_name%'";
		}
		else {
	 	$criteria = $criteria ." and RU.user_name Like '%$destination_user_name%'";
	 	}
	}
	else if ($first_chr=="*") {
		$destination_user_name = substr($destination_user_name,1,$ulen-1);
		if ($criteria == "") {
			$criteria = "RU.user_name Like '%$destination_user_name'";
		}
		else {
	 	$criteria = $criteria ." and RU.user_name Like '%$destination_user_name'";
	 	}
	} 
	else if ($last_chr=="*") {
		$destination_user_name = substr($destination_user_name,0,$ulen-1);
		if ($criteria == "") {
			$criteria = "RU.user_name Like '$destination_user_name%'";
		}
		else {
	 	$criteria = $criteria ." and RU.user_name Like '$destination_user_name%'";
	 	}
	}
	else {
	if ($criteria == "") {
			$criteria = "RU.user_name='$destination_user_name'";
		}
		else {
	 	$criteria = $criteria ." and RU.user_name='$destination_user_name'";
	 	}
	} 
 }
 
if ($source_host!="") {
	$first_chr = substr($source_host,0,1);
	$ulen = strlen($source_host);
	$last_chr = substr($source_host,$ulen-1,1);
	if ($first_chr=="*" and $last_chr=="*") {
		$source_host = substr($source_host,1,$ulen-2);
		if ($criteria == "") {
			$criteria = "SH.host_name like '%$source_host%'";
		}
		else {
	 	$criteria = $criteria ." and SH.host_name like '%$source_host%'";
	 	}
	}
	else if ($first_chr=="*") {
		$source_host = substr($source_host,1,$ulen-1);
		if ($criteria == "") {
			$criteria = "SH.host_name like '%$source_host'";
		}
		else {
	 	$criteria = $criteria ." and SH.host_name like '%$source_host'";
	 	}
	} 
	else if ($last_chr=="*") {
		$source_host = substr($source_host,0,$ulen-1);
		if ($criteria == "") {
			$criteria = "SH.host_name like '$source_host%'";
		}
		else {
	 	$criteria = $criteria ." and SH.host_name like '$source_host%'";
	 	}
	}
	else {
	$pos = strpos($source_host,".cern.ch");
     if($pos === false) {
     	$fqdn = $source_host . ".cern.ch";
         }
	 if ($fqdn==""){
    	$sh = "SH.host_name='$source_host'";
    }
    else {
    	$sh = "(SH.host_name='$source_host' or SH.host_name='$fqdn')";
    }
    if ($criteria == "") {
			$criteria = $sh;
		}
		else {
	 	$criteria = $criteria ." and $sh";
	 	}
	} 
 }
if ($destination_host!="") {
	$first_chr = substr($destination_host,0,1);
	$ulen = strlen($destination_host);
	$last_chr = substr($destination_host,$ulen-1,1);
	if ($first_chr=="*" and $last_chr=="*") {
		$destination_host = substr($destination_host,1,$ulen-2);
		if ($criteria == "") {
			$criteria = "RH.host_name like '%$destination_host%'";
		}
		else {
	 	$criteria = $criteria ." and RH.host_name like '%$destination_host%'";
	 	}
	}
	else if ($first_chr=="*") {
		$destination_host = substr($destination_host,1,$ulen-1);
		if ($criteria == "") {
			$criteria = "RH.host_name like '%$destination_host'";
		}
		else {
	 	$criteria = $criteria ." and RH.host_name like '%$destination_host'";
	 	}
	} 
	else if ($last_chr=="*") {
		$destination_host = substr($destination_host,0,$ulen-1);
		if ($criteria == "") {
			$criteria = "RH.host_name like '$destination_host%'";
		}
		else {
	 	$criteria = $criteria ." and RH.host_name like '$destination_host%'";
	 	}
	}
	else {
	$pos = strpos($destination_host,".cern.ch");
	 if($pos === false) {
     	$dfqdn = $destination_host . ".cern.ch";
       }
	 if ($dfqdn==""){
    	$sh = "RH.host_name='$destination_host'";
    }
    else {
    	$sh = "(RH.host_name='$destination_host' or RH.host_name='$dfqdn')";
    }  
	if ($criteria == "") {
			$criteria = $sh;
		}
		else {
	 	$criteria = $criteria ." and $sh";
	 	}
	} 
	
 }

if ($service !="") {
	if ($criteria == "") {
		$criteria = "services.name ='$service'";
	}
	else {
 	$criteria = $criteria ." and services.name ='$service'";
 	}
 }

if ($direction!="") {
	if ($criteria == "") {
	$criteria = "gw_logins.direction ='$direction'";
	}
	else {
 	$criteria = $criteria ." and gw_logins.direction ='$direction'";
 	}
  }
if ($am_status_code!="") {
	if ($criteria == "") {
	$criteria = "am_statuses.am_return_code_description ='$am_status_code'";
	}
	else {
 	$criteria = $criteria ." and am_statuses.am_return_code_description='$am_status_code'";
 	}
  }
if ($fromDate=="lastday") {
$yesterday  = date('Y-m-d H:i:s',time()-3600*24);
$todate = date('Y-m-d H:i:s');
	if ($criteria == "") {
	$criteria = "login between '$yesterday' and '$todate'";
	}
	else {
 	$criteria = $criteria ." and login between '$yesterday' and '$todate'";
 	

 	}
}
else if ($fromDate=="lastweek") {
$week  = date('Y-m-d H:i:s',time()-3600*24*6);

$todate = date('Y-m-d H:i:s');
	if ($criteria == "") {
	$criteria = "login between '$week' and '$todate'";
	}
	else {
 	$criteria = $criteria ." and login between '$week' and '$todate'";
 	

 	}
}
else if ($fromDate=="lastmonth") {
$month  = date('Y-m-d H:i:s',time()-3600*24*29);

$todate = date('Y-m-d H:i:s');
	if ($criteria == "") {
	$criteria = "login between '$month' and '$todate'";
	}
	else {
 	$criteria = $criteria ." and login between '$month' and '$todate'";
 	

 	}
}
else if ($fromDate=="lastyear") {
$year  = date('Y-m-d H:i:s',time()-3600*24*365);
$todate = date('Y-m-d H:i:s');
	if ($criteria == "") {
	$criteria = "login between '$year' and '$todate'";
	}
	else {
 	$criteria = $criteria ." and login between '$year' and '$todate'";
 	

 	}
}

else {

if ($fromDate!="" && $toDate!="") {
	 $fDate = date('Y-m-d H:i:s', strtotime($fromDate));
	 $tDate = date('Y-m-d H:i:s', strtotime($toDate));
	 //$date = strtotime(date("Y-m-d H:i:s", strtotime($tDate)));
	// $td = Date("Y-m-d H:i:s", $date);

	if ($criteria == "") {
	$criteria = "login between '$fromDate'and '$tDate'";
	}
	else {
 	$criteria = $criteria ." and login between '$fromDate'and '$tDate'";
 	}
  }
}
if ($logoutfromDate=="lastday") {
$yesterday  = date('Y-m-d H:i:s',time()-3600*24);
$todate = date('Y-m-d H:i:s');
	if ($criteria == "") {
	$criteria = "logout between '$yesterday' and '$todate'";
	}
	else {
 	$criteria = $criteria ." and logout between '$yesterday' and '$todate'";
 	

 	}
}
else if ($logoutfromDate=="lastweek") {
$week  = date('Y-m-d H:i:s',time()-3600*24*6);

$todate = date('Y-m-d H:i:s');
	if ($criteria == "") {
	$criteria = "logout between '$week' and '$todate'";
	}
	else {
 	$criteria = $criteria ." and logout between '$week' and '$todate'";
 	

 	}
}
else if ($logoutfromDate=="lastmonth") {
$month  = date('Y-m-d H:i:s',time()-3600*24*29);

$todate = date('Y-m-d H:i:s');
	if ($criteria == "") {
	$criteria = "logout between '$month' and '$todate'";
	}
	else {
 	$criteria = $criteria ." and logout between '$month' and '$todate'";
 	

 	}
}
else if ($logoutfromDate=="lastyear") {
$year  = date('Y-m-d H:i:s',time()-3600*24*365);
$todate = date('Y-m-d H:i:s');
	if ($criteria == "") {
	$criteria = "logout between '$year' and '$todate'";
	}
	else {
 	$criteria = $criteria ." and logout between '$year' and '$todate'";
 	

 	}
}

else {

if ($logoutfromDate!="" && $logouttoDate!="") {
	 $lfDate = date('Y-m-d H:i:s', strtotime($logoutFromDate));
	 $ltDate = date('Y-m-d H:i:s', strtotime($logoutToDate));
	// $date = strtotime(date("Y-m-d H:i:s", strtotime($ltDate)) . " +1 day");
	// $ltd = Date("Y-m-d H:i:s", $date);

	if ($criteria == "") {
	$criteria = "logout between '$logoutfromDate'and '$logouttoDate'";
	}
	else {
 	$criteria = $criteria ." and logout between '$logoutfromDate' and '$logouttoDate'";
 	}
  }
}
  
$query = $table . " WHERE logout is NOT NULL and " . $criteria . " " . $group_by ;
//echo $query;

$rs = $cn->get_data($query);
$num_rows = mysql_num_rows($rs);
//echo "Num : ".$num_rows;
	  
	  return $rs;
	}

/*****************************************************************************************************************************************************************************

//View gateway history load by month

*****************************************************************************************************************************************************************************/		
    
	function viewGatewayHistoryLoadByMonth($criteria,$id,$sort,$how,&$con)
	{
	  $rs=null;
	  $fromDate="";
	  $toDate="";
	  $logoutfromDate="";
	  $logouttoDate="";

	  $table_criteria="";
	  $total_criteria = split("\,",$criteria);
	  $total_len = count($total_criteria);
	    //  echo $total_len;
	   for ($i=0;$i<$total_len;$i++) {
	   	$each_item = split(":",$total_criteria[$i]);
	   	$item_name = $each_item[0];
	   	$item_value = $each_item[1];
	   	 if ( $each_item[0]=="gateway") {
 			if ($table_criteria == "" ) {
 				$table_criteria= "gateways.name='$each_item[1]'";
 				}
 			else {
 				$table_criteria= $table_criteria." and gateways.name='$each_item[1]'";
 		 		}
 		 }
	   if ( $each_item[0]=="user_name") {
			$user_name=$each_item[1];
			$first_chr = substr($user_name,0,1);
			$ulen = strlen($user_name);
			$last_chr = substr($user_name,$ulen-1,1);
			if ($first_chr=="*" and $last_chr=="*") {
				$user_name = substr($user_name,1,$ulen-2);
			if ($table_criteria == "" ) {
 				$table_criteria= "SU.user_name like '%$user_name%'";
 				}
 			else {
 				$table_criteria= $table_criteria." and SU.user_name like '%$user_name%'";
 		 		}
			}
			else if ($first_chr=="*") {
				$user_name = substr($user_name,1,$ulen-1);
			if ($table_criteria == "" ) {
 				$table_criteria= "SU.user_name like '%$user_name'";
 				}
 			else {
 				$table_criteria= $table_criteria." and SU.user_name like '%$user_name'";
 		 		}
			} 
			else if ($last_chr=="*") {
				$user_name = substr($user_name,0,$ulen-1);
			if ($table_criteria == "" ) {
 				$table_criteria= "SU.user_name like '$user_name%'";
 				}
 			else {
 				$table_criteria= $table_criteria." and SU.user_name like '$user_name%'";
 		 		}
			}
			else {
			if ($table_criteria == "" ) {
 				$table_criteria= "SU.user_name='$user_name'";
 				}
 			else {
 				$table_criteria= $table_criteria." and SU.user_name='$user_name'";
 		 		}
			} 
 		  }
 		  
	    if ( $each_item[0]=="destination_user_name") {
			$destination_user_name=$each_item[1];
			$first_chr = substr($destination_user_name,0,1);
			$ulen = strlen($destination_user_name);
			$last_chr = substr($destination_user_name,$ulen-1,1);
			if ($first_chr=="*" and $last_chr=="*") {
				$destination_user_name = substr($destination_user_name,1,$ulen-2);
			if ($table_criteria == "" ) {
 				$table_criteria= "RU.user_name like '%$destination_user_name%'";
 				}
 			else {
 				$table_criteria= $table_criteria." and RU.user_name like '%$destination_user_name%'";
 		 		}
			}
			else if ($first_chr=="*") {
				$destination_user_name = substr($destination_user_name,1,$ulen-1);
			if ($table_criteria == "" ) {
 				$table_criteria= "RU.user_name like '%$destination_user_name'";
 				}
 			else {
 				$table_criteria= $table_criteria." and RU.user_name like '%$destination_user_name'";
 		 		}
			} 
			else if ($last_chr=="*") {
				$destination_user_name = substr($destination_user_name,0,$ulen-1);
			if ($table_criteria == "" ) {
 				$table_criteria= "RU.user_name like '$destination_user_name%'";
 				}
 			else {
 				$table_criteria= $table_criteria." and RU.user_name like '$destination_user_name%'";
 		 		}
			}
			else {
			if ($table_criteria == "" ) {
 				$table_criteria= "RU.user_name='$destination_user_name'";
 				}
 			else {
 				$table_criteria= $table_criteria." and RU.user_name='$destination_user_name'";
 		 		}
			} 
 		  }
		if ( $each_item[0]=="source_host") {
 			$source_host=$each_item[1];
			$first_chr = substr($source_host,0,1);
			$ulen = strlen($source_host);
			$last_chr = substr($source_host,$ulen-1,1);
			if ($first_chr=="*" and $last_chr=="*") {
				$source_host = substr($source_host,1,$ulen-2);
			if ($table_criteria == "" ) {
 				$table_criteria= "SH.host_name  like '%$source_host%'";
 				}
 			else {
 				$table_criteria= $table_criteria." and SH.host_name  like '%$source_host%'";
 		 		}
			}
			else if ($first_chr=="*") {
				$source_host = substr($source_host,1,$ulen-1);
			if ($table_criteria == "" ) {
 				$table_criteria= "SH.host_name  like '%$source_host'";
 				}
 			else {
 				$table_criteria= $table_criteria." and SH.host_name  like '%$source_host'";
 		 		}
			} 
			else if ($last_chr=="*") {
				$source_host = substr($source_host,0,$ulen-1);
			if ($table_criteria == "" ) {
 				$table_criteria= "SH.host_name  like '$source_host%'";
 				}
 			else {
 				$table_criteria= $table_criteria." and SH.host_name  like '$source_host%'";
 		 		}
			}
			else {
			$pos = strpos($source_host,".cern.ch");
   			 if($pos === false) {
     			$fqdn = $source_host . ".cern.ch";
      			 }
			 if ($fqdn==""){
    			$sh = "SH.host_name='$source_host'";
			    }
			    else {
			    	$sh = "(SH.host_name='$source_host' or SH.host_name='$fqdn')";
			    }
			if ($table_criteria == "" ) {
	 				$table_criteria= $sh;
	 				}
	 			else {
	 				$table_criteria= $table_criteria." and $sh";
	 		 		}
			} 
 			
 		 }
		if ( $each_item[0]=="destination_host") {
 			$destination_host=$each_item[1];
 			$first_chr = substr($destination_host,0,1);
			$ulen = strlen($destination_host);
			$last_chr = substr($destination_host,$ulen-1,1);
			if ($first_chr=="*" and $last_chr=="*") {
				$destination_host = substr($destination_host,1,$ulen-2);
			if ($table_criteria == "" ) {
 				$table_criteria= "RH.host_name  like '%$destination_host%'";
 				}
 			else {
 				$table_criteria= $table_criteria." and RH.host_name  like '%$destination_host%'";
 		 		}
			}
			else if ($first_chr=="*") {
				$destination_host = substr($destination_host,1,$ulen-1);
			if ($table_criteria == "" ) {
 				$table_criteria= "RH.host_name  like '%$destination_host'";
 				}
 			else {
 				$table_criteria= $table_criteria." and RH.host_name  like '%$destination_host'";
 		 		}
			} 
			else if ($last_chr=="*") {
				$destination_host = substr($destination_host,0,$ulen-1);
			if ($table_criteria == "" ) {
 				$table_criteria= "RH.host_name  like '$destination_host%'";
 				}
 			else {
 				$table_criteria= $table_criteria." and RH.host_name  like '$destination_host%'";
 		 		}
			}
			else {
			$pos = strpos($destination_host,".cern.ch");
   			 if($pos === false) {
     			$dfqdn = $destination_host . ".cern.ch";
      			 }
			
			 if ($dfqdn==""){
    			$sh = "RH.host_name='$destination_host'";
			    }
			    else {
			    	$sh = "(RH.host_name='$destination_host' or RH.host_name='$dfqdn')";
			    }	 	
			if ($table_criteria == "" ) {
 				$table_criteria= $sh;
 				}
 			else {
 				$table_criteria= $table_criteria." and $sh";
 		 		}
			} 
 		   
 		 }
		if ( $each_item[0]=="service") {
 			if ($table_criteria == "" ) {
 				$table_criteria= "services.name='$each_item[1]'";
 				}
 			else {
 				$table_criteria= $table_criteria." and services.name='$each_item[1]'";
 		 		}
 		 }
		if ( $each_item[0]=="direction") {
 			if ($table_criteria == "" ) {
 				$table_criteria= "direction='$each_item[1]'";
 				}
 			else {
 				$table_criteria= $table_criteria." and direction='$each_item[1]'";
 		 		}
 		 }
		if ( $each_item[0]=="am_return_codes") {
 			if ($table_criteria == "" ) {
 				$table_criteria= "am_statuses.am_return_code_description='$each_item[1]'";
 				}
 			else {
 				$table_criteria= $table_criteria." and am_statuses.am_return_code_description='$each_item[1]'";
 		 		}
 		 }
 		 	if ($each_item[0]=="from") {
 		 		if ($each_item[1]=="lastyear" or $each_item[1]=="lastmonth" or $each_item[1]=="lastweek" or $each_item[1]=="lastday")
						$fromDate=$each_item[1];
				else
					 $fromDate= $each_item[1].":".$each_item[2].":".$each_item[3];
					
				  }
				if ($each_item[0]=="to") {
					 $toDate= $each_item[1].":".$each_item[2].":".$each_item[3];
					
				  }

if ($fromDate=="lastday") {
$yesterday  = date('Y-m-d H:i:s',time()-3600*24);
$todate = date('Y-m-d H:i:s');
	if ($table_criteria == "") {
	$table_criteria = "login between '$yesterday' and '$todate'";
	}
	else {
 	$table_criteria = $table_criteria ." and login between '$yesterday' and '$todate'";
 	

 	}
}
else if ($fromDate=="lastweek") {
$week  = date('Y-m-d H:i:s',time()-3600*24*6);

$todate = date('Y-m-d H:i:s');
	if ($table_criteria == "") {
	$table_criteria = "login between '$week' and '$todate'";
	}
	else {
 	$table_criteria = $table_criteria ." and login between '$week' and '$todate'";
 	

 	}
}
else if ($fromDate=="lastmonth") {
$month  = date('Y-m-d H:i:s',time()-3600*24*29);

$todate = date('Y-m-d H:i:s');
	if ($table_criteria == "") {
	$table_criteria = "login between '$month' and '$todate'";
	}
	else {
 	$table_criteria = $table_criteria ." and login between '$month' and '$todate'";
 	

 	}
}
else if ($fromDate=="lastyear") {
$year  = date('Y-m-d H:i:s',time()-3600*24*365);
$todate = date('Y-m-d H:i:s');
	if ($table_criteria == "") {
	$table_criteria= "login between '$year' and '$todate'";
	}
	else {
 	$table_criteria = $table_criteria ." and login between '$year' and '$todate'";
 	

 	}
}

else {

if ($fromDate!="" && $toDate!="") {
	 $fDate = date('Y-m-d H:i:s', strtotime($fromDate));
	 $tDate = date('Y-m-d H:i:s', strtotime($toDate));
	 //$date = strtotime(date("Y-m-d H:i:s", strtotime($tDate)));
	// $td = Date("Y-m-d H:i:s", $date);

	if ($table_criteria == "") {
	$table_criteria = "login between '$fromDate'and '$tDate'";
	}
	else {
 	$table_criteria = $table_criteria ." and login between '$fromDate'and '$tDate'";
 	}
  }
}

		
if ($each_item[0]=="logoutfrom") {
					 $logoutfromDate= $each_item[1].":".$each_item[2].":".$each_item[3];
					
				  }
				if ($each_item[0]=="logoutto") {
					 $logouttoDate= $each_item[1].":".$each_item[2].":".$each_item[3];
					
				  }

		if ($logoutfromDate=="lastday") {
				$yesterday  = date('Y-m-d H:i:s',time()-3600*24);
				$todate = date('Y-m-d H:i:s');
					if ($table_criteria == "") {
					$table_criteria = "logout between '$yesterday' and '$todate'";
					}
					else {
				 	$table_criteria = $table_criteria ." and logout between '$yesterday' and '$todate'";
				 	
				
				 	}
				}
				else if ($logoutfromDate=="lastweek") {
				$week  = date('Y-m-d H:i:s',time()-3600*24*6);
				
				$todate = date('Y-m-d H:i:s');
					if ($table_criteria == "") {
					$table_criteria = "logout between '$week' and '$todate'";
					}
					else {
				 	$table_criteria = $table_criteria ." and logout between '$week' and '$todate'";
				 	
				
				 	}
				}
				else if ($logoutfromDate=="lastmonth") {
				$month  = date('Y-m-d H:i:s',time()-3600*24*29);
				
				$todate = date('Y-m-d H:i:s');
					if ($table_criteria == "") {
					$table_criteria = "logout between '$month' and '$todate'";
					}
					else {
				 	$table_criteria = $table_criteria ." and logout between '$month' and '$todate'";
				 	
				
				 	}
				}
				else if ($logoutfromDate=="lastyear") {
				$year  = date('Y-m-d H:i:s',time()-3600*24*365);
				$todate = date('Y-m-d H:i:s');
					if ($table_criteria == "") {
					$table_criteria= "logout between '$year' and '$todate'";
					}
					else {
				 	$table_criteria = $table_criteria ." and logout between '$year' and '$todate'";
				 	
				
				 	}
				}
				
				else {

	   if ( $logoutfromDate!="" && $logouttoDate!="") {
	   		
 			if ($table_criteria == "" ) {
 				$table_criteria= "logout between '$logoutfromDate' and '$logouttoDate'";
 				}
 			else {
 				$table_criteria= $table_criteria." and logout between '$logoutfromDate' and '$logouttoDate'";
 		 		}
 		 }

	}
	   	
	   }   
	
	   
    	list ($mn,$yr) = split("-",$id);
    	
    	if ($mn=="Jan")
    		$mon =  "01";
	if ($mn=="Feb")
    		$mon =  "02"; 
	if ($mn=="Mar")
    		$mon =  "03"; 
	if ($mn=="Apr")
    		$mon =  "04"; 
	if ($mn=="May")
    		$mon =  "05"; 
	if ($mn=="Jun")
    		$mon =  "06"; 
	if ($mn=="Jul")
    		$mon =  "07"; 
	if ($mn=="Aug")
    		$mon =  "08"; 
	if ($mn=="Sep")
    		$mon =  "09";
	if ($mn=="Oct")
    		$mon =  "10";  
	if ($mn=="Nov")
    		$mon =  "11";
	if ($mn=="Dec")
    		$mon =  "12";  
       $cn = (object)$con;
    $query = " SELECT SU.user_name AS source_user, RU.user_name AS remote_user, SH.host_name AS source_host, RH.host_name AS remote_host, gateways.name as gw_name,login,logout,services.name AS name,direction, am_statuses.am_return_code,am_statuses.am_return_code_description as amd
			FROM gw_logins 
			LEFT JOIN users SU ON gw_logins.user_id=SU.user_id 
			LEFT JOIN users RU ON gw_logins.remote_user_id=RU.user_id 
			LEFT JOIN hosts SH ON gw_logins.source_id=SH.host_id 
			LEFT JOIN hosts RH ON gw_logins.destination_id=RH.host_id 
			LEFT JOIN gateways ON gw_logins.gw_id=gateways.id LEFT JOIN services ON gw_logins.service_id=services.id 
			LEFT JOIN am_statuses ON gw_logins.am_id=am_statuses.am_id 
			WHERE logout is NOT NULL and ".$table_criteria." and login like '$yr-$mon%' 
			ORDER BY $sort $how ";

//echo $query;
	  	$rs = $cn->get_data($query);

	  return $rs;
	}

/*****************************************************************************************************************************************************************************

//View gateway history load by month fro specific page

*****************************************************************************************************************************************************************************/		
    
	function viewGatewayHistoryLoadByMonthSpecificPage($criteria,$id,$sort,$how,$StartRow,$PageSize,&$con)
	{
	  $rs=null;
	  $fromDate="";
	  $toDate="";
	  $logoutfromDate="";
	  $logouttoDate="";

	  $table_criteria="";
	  $total_criteria = split("\,",$criteria);
	  $total_len = count($total_criteria);
	    //  echo $total_len;
	   for ($i=0;$i<$total_len;$i++) {
	   	$each_item = split(":",$total_criteria[$i]);
	   	$item_name = $each_item[0];
	   	$item_value = $each_item[1];
	   	 if ( $each_item[0]=="gateway") {
 			if ($table_criteria == "" ) {
 				$table_criteria= "gateways.name='$each_item[1]'";
 				}
 			else {
 				$table_criteria= $table_criteria." and gateways.name='$each_item[1]'";
 		 		}
 		 }
	      if ( $each_item[0]=="user_name") {
			$user_name=$each_item[1];
			$first_chr = substr($user_name,0,1);
			$ulen = strlen($user_name);
			$last_chr = substr($user_name,$ulen-1,1);
			if ($first_chr=="*" and $last_chr=="*") {
				$user_name = substr($user_name,1,$ulen-2);
			if ($table_criteria == "" ) {
 				$table_criteria= "SU.user_name like '%$user_name%'";
 				}
 			else {
 				$table_criteria= $table_criteria." and SU.user_name like '%$user_name%'";
 		 		}
			}
			else if ($first_chr=="*") {
				$user_name = substr($user_name,1,$ulen-1);
			if ($table_criteria == "" ) {
 				$table_criteria= "SU.user_name like '%$user_name'";
 				}
 			else {
 				$table_criteria= $table_criteria." and SU.user_name like '%$user_name'";
 		 		}
			} 
			else if ($last_chr=="*") {
				$user_name = substr($user_name,0,$ulen-1);
			if ($table_criteria == "" ) {
 				$table_criteria= "SU.user_name like '$user_name%'";
 				}
 			else {
 				$table_criteria= $table_criteria." and SU.user_name like '$user_name%'";
 		 		}
			}
			else {
			if ($table_criteria == "" ) {
 				$table_criteria= "SU.user_name='$user_name'";
 				}
 			else {
 				$table_criteria= $table_criteria." and SU.user_name='$user_name'";
 		 		}
			} 
 		  }
 		  
	   	    if ( $each_item[0]=="destination_user_name") {
			$destination_user_name=$each_item[1];
			$first_chr = substr($destination_user_name,0,1);
			$ulen = strlen($destination_user_name);
			$last_chr = substr($destination_user_name,$ulen-1,1);
			if ($first_chr=="*" and $last_chr=="*") {
				$destination_user_name = substr($destination_user_name,1,$ulen-2);
			if ($table_criteria == "" ) {
 				$table_criteria= "RU.user_name like '%$destination_user_name%'";
 				}
 			else {
 				$table_criteria= $table_criteria." and RU.user_name like '%$destination_user_name%'";
 		 		}
			}
			else if ($first_chr=="*") {
				$destination_user_name = substr($destination_user_name,1,$ulen-1);
			if ($table_criteria == "" ) {
 				$table_criteria= "RU.user_name like '%$destination_user_name'";
 				}
 			else {
 				$table_criteria= $table_criteria." and RU.user_name like '%$destination_user_name'";
 		 		}
			} 
			else if ($last_chr=="*") {
				$destination_user_name = substr($destination_user_name,0,$ulen-1);
			if ($table_criteria == "" ) {
 				$table_criteria= "RU.user_name like '$destination_user_name%'";
 				}
 			else {
 				$table_criteria= $table_criteria." and RU.user_name like '$destination_user_name%'";
 		 		}
			}
			else {
			if ($table_criteria == "" ) {
 				$table_criteria= "RU.user_name='$destination_user_name'";
 				}
 			else {
 				$table_criteria= $table_criteria." and RU.user_name='$destination_user_name'";
 		 		}
			} 
 		  }  
		if ( $each_item[0]=="source_host") {
 			$source_host=$each_item[1];
			$first_chr = substr($source_host,0,1);
			$ulen = strlen($source_host);
			$last_chr = substr($source_host,$ulen-1,1);
			if ($first_chr=="*" and $last_chr=="*") {
				$source_host = substr($source_host,1,$ulen-2);
			if ($table_criteria == "" ) {
 				$table_criteria= "SH.host_name  like '%$source_host%'";
 				}
 			else {
 				$table_criteria= $table_criteria." and SH.host_name  like '%$source_host%'";
 		 		}
			}
			else if ($first_chr=="*") {
				$source_host = substr($source_host,1,$ulen-1);
			if ($table_criteria == "" ) {
 				$table_criteria= "SH.host_name  like '%$source_host'";
 				}
 			else {
 				$table_criteria= $table_criteria." and SH.host_name  like '%$source_host'";
 		 		}
			} 
			else if ($last_chr=="*") {
				$source_host = substr($source_host,0,$ulen-1);
			if ($table_criteria == "" ) {
 				$table_criteria= "SH.host_name  like '$source_host%'";
 				}
 			else {
 				$table_criteria= $table_criteria." and SH.host_name  like '$source_host%'";
 		 		}
			}
			else {
			$pos = strpos($source_host,".cern.ch");
   			 if($pos === false) {
     			$fqdn = $source_host . ".cern.ch";
      			 }
      			 
			 if ($fqdn==""){
    			$sh = "SH.host_name='$source_host'";
			    }
			    else {
			    	$sh = "(SH.host_name='$source_host' or SH.host_name='$fqdn')";
			    }
			if ($table_criteria == "" ) {
	 				$table_criteria= $sh;
	 				}
	 			else {
	 				$table_criteria= $table_criteria." and $sh";
	 		 		}
			} 
 			
 		 }
		if ( $each_item[0]=="destination_host") {
 			$destination_host=$each_item[1];
 			$first_chr = substr($destination_host,0,1);
			$ulen = strlen($destination_host);
			$last_chr = substr($destination_host,$ulen-1,1);
			if ($first_chr=="*" and $last_chr=="*") {
				$destination_host = substr($destination_host,1,$ulen-2);
			if ($table_criteria == "" ) {
 				$table_criteria= "RH.host_name  like '%$destination_host%'";
 				}
 			else {
 				$table_criteria= $table_criteria." and RH.host_name  like '%$destination_host%'";
 		 		}
			}
			else if ($first_chr=="*") {
				$destination_host = substr($destination_host,1,$ulen-1);
			if ($table_criteria == "" ) {
 				$table_criteria= "RH.host_name  like '%$destination_host'";
 				}
 			else {
 				$table_criteria= $table_criteria." and RH.host_name  like '%$destination_host'";
 		 		}
			} 
			else if ($last_chr=="*") {
				$destination_host = substr($destination_host,0,$ulen-1);
			if ($table_criteria == "" ) {
 				$table_criteria= "RH.host_name  like '$destination_host%'";
 				}
 			else {
 				$table_criteria= $table_criteria." and RH.host_name  like '$destination_host%'";
 		 		}
			}
			else {
			$pos = strpos($destination_host,".cern.ch");
			 if($pos === false) {
     			$dfqdn = $destination_host . ".cern.ch";
      			 }
			
			 if ($dfqdn==""){
    			$sh = "RH.host_name='$destination_host'";
			    }
			    else {
			    	$sh = "(RH.host_name='$destination_host' or RH.host_name='$dfqdn')";
			    }	 	
			if ($table_criteria == "" ) {
 				$table_criteria= $sh;
 				}
 			else {
 				$table_criteria= $table_criteria." and $sh";
 		 		}
			} 
 		   
 		 }
		if ( $each_item[0]=="service") {
 			if ($table_criteria == "" ) {
 				$table_criteria= "services.name='$each_item[1]'";
 				}
 			else {
 				$table_criteria= $table_criteria." and services.name='$each_item[1]'";
 		 		}
 		 }
		if ( $each_item[0]=="direction") {
 			if ($table_criteria == "" ) {
 				$table_criteria= "direction='$each_item[1]'";
 				}
 			else {
 				$table_criteria= $table_criteria." and direction='$each_item[1]'";
 		 		}
 		 }
		if ( $each_item[0]=="am_return_codes") {
 			if ($table_criteria == "" ) {
 				$table_criteria= "am_statuses.am_return_code_description='$each_item[1]'";
 				}
 			else {
 				$table_criteria= $table_criteria." and am_statuses.am_return_code_description='$each_item[1]'";
 		 		}
 		 }
 		 	if ($each_item[0]=="from") {
 		 		if ($each_item[1]=="lastyear" or $each_item[1]=="lastmonth" or $each_item[1]=="lastweek" or $each_item[1]=="lastday")
						$fromDate=$each_item[1];
				else
					 $fromDate= $each_item[1].":".$each_item[2].":".$each_item[3];
					
				  }
				if ($each_item[0]=="to") {
					 $toDate= $each_item[1].":".$each_item[2].":".$each_item[3];
					
				  }


	   if ($fromDate=="lastday") {
$yesterday  = date('Y-m-d H:i:s',time()-3600*24);
$todate = date('Y-m-d H:i:s');
	if ($table_criteria == "") {
	$table_criteria = "login between '$yesterday' and '$todate'";
	}
	else {
 	$table_criteria = $table_criteria ." and login between '$yesterday' and '$todate'";
 	

 	}
}
else if ($fromDate=="lastweek") {
$week  = date('Y-m-d H:i:s',time()-3600*24*6);

$todate = date('Y-m-d H:i:s');
	if ($table_criteria == "") {
	$table_criteria = "login between '$week' and '$todate'";
	}
	else {
 	$table_criteria = $table_criteria ." and login between '$week' and '$todate'";
 	

 	}
}
else if ($fromDate=="lastmonth") {
$month  = date('Y-m-d H:i:s',time()-3600*24*29);

$todate = date('Y-m-d H:i:s');
	if ($table_criteria == "") {
	$table_criteria = "login between '$month' and '$todate'";
	}
	else {
 	$table_criteria = $table_criteria ." and login between '$month' and '$todate'";
 	

 	}
}
else if ($fromDate=="lastyear") {
$year  = date('Y-m-d H:i:s',time()-3600*24*365);
$todate = date('Y-m-d H:i:s');
	if ($table_criteria == "") {
	$table_criteria= "login between '$year' and '$todate'";
	}
	else {
 	$table_criteria = $table_criteria ." and login between '$year' and '$todate'";
 	

 	}
}

else {

if ($fromDate!="" && $toDate!="") {
	 $fDate = date('Y-m-d H:i:s', strtotime($fromDate));
	 $tDate = date('Y-m-d H:i:s', strtotime($toDate));
	 //$date = strtotime(date("Y-m-d H:i:s", strtotime($tDate)));
	// $td = Date("Y-m-d H:i:s", $date);

	if ($table_criteria == "") {
	$table_criteria = "login between '$fromDate'and '$tDate'";
	}
	else {
 	$table_criteria = $table_criteria ." and login between '$fromDate'and '$tDate'";
 	}
  }
}
		
if ($each_item[0]=="logoutfrom") {
					 $logoutfromDate= $each_item[1].":".$each_item[2].":".$each_item[3];
					
				  }
				if ($each_item[0]=="logoutto") {
					 $logouttoDate= $each_item[1].":".$each_item[2].":".$each_item[3];
					
				  }


	   		if ($logoutfromDate=="lastday") {
				$yesterday  = date('Y-m-d H:i:s',time()-3600*24);
				$todate = date('Y-m-d H:i:s');
					if ($table_criteria == "") {
					$table_criteria = "logout between '$yesterday' and '$todate'";
					}
					else {
				 	$table_criteria = $table_criteria ." and logout between '$yesterday' and '$todate'";
				 	
				
				 	}
				}
				else if ($logoutfromDate=="lastweek") {
				$week  = date('Y-m-d H:i:s',time()-3600*24*6);
				
				$todate = date('Y-m-d H:i:s');
					if ($table_criteria == "") {
					$table_criteria = "logout between '$week' and '$todate'";
					}
					else {
				 	$table_criteria = $table_criteria ." and logout between '$week' and '$todate'";
				 	
				
				 	}
				}
				else if ($logoutfromDate=="lastmonth") {
				$month  = date('Y-m-d H:i:s',time()-3600*24*29);
				
				$todate = date('Y-m-d H:i:s');
					if ($table_criteria == "") {
					$table_criteria = "logout between '$month' and '$todate'";
					}
					else {
				 	$table_criteria = $table_criteria ." and logout between '$month' and '$todate'";
				 	
				
				 	}
				}
				else if ($logoutfromDate=="lastyear") {
				$year  = date('Y-m-d H:i:s',time()-3600*24*365);
				$todate = date('Y-m-d H:i:s');
					if ($table_criteria == "") {
					$table_criteria= "logout between '$year' and '$todate'";
					}
					else {
				 	$table_criteria = $table_criteria ." and logout between '$year' and '$todate'";
				 	
				
				 	}
				}
				
				else {

	   if ( $logoutfromDate!="" && $logouttoDate!="") {
	   		
 			if ($table_criteria == "" ) {
 				$table_criteria= "logout between '$logoutfromDate' and '$logouttoDate'";
 				}
 			else {
 				$table_criteria= $table_criteria." and logout between '$logoutfromDate' and '$logouttoDate'";
 		 		}
 		 }

	}


	   	
	   }   
	   $cn = (object)$con;
	   
    	list ($mn,$yr) = split("-",$id);
    	if ($mn=="Jan")
    		$mon =  "01";
	if ($mn=="Feb")
    		$mon =  "02"; 
	if ($mn=="Mar")
    		$mon =  "03"; 
	if ($mn=="Apr")
    		$mon =  "04"; 
	if ($mn=="May")
    		$mon =  "05"; 
	if ($mn=="Jun")
    		$mon =  "06"; 
	if ($mn=="Jul")
    		$mon =  "07"; 
	if ($mn=="Aug")
    		$mon =  "08"; 
	if ($mn=="Sep")
    		$mon =  "09";
	if ($mn=="Oct")
    		$mon =  "10";  
	if ($mn=="Nov")
    		$mon =  "11";
	if ($mn=="Dec")
    		$mon =  "12";  
    $query = " SELECT SU.user_name AS source_user, RU.user_name AS remote_user, SH.host_name AS source_host, RH.host_name AS remote_host, gateways.name as gw_name,login,logout,services.name AS name,direction, am_statuses.am_return_code,am_statuses.am_return_code_description as amd
			FROM gw_logins 
			LEFT JOIN users SU ON gw_logins.user_id=SU.user_id 
			LEFT JOIN users RU ON gw_logins.remote_user_id=RU.user_id 
			LEFT JOIN hosts SH ON gw_logins.source_id=SH.host_id 
			LEFT JOIN hosts RH ON gw_logins.destination_id=RH.host_id 
			LEFT JOIN gateways ON gw_logins.gw_id=gateways.id LEFT JOIN services ON gw_logins.service_id=services.id 
			LEFT JOIN am_statuses ON gw_logins.am_id=am_statuses.am_id 
			WHERE logout is NOT NULL and ".$table_criteria." and login like '$yr-$mon%' 
			ORDER BY $sort $how LIMIT $StartRow,$PageSize";
//echo $query;
	  	$rs = $cn->get_data($query);


	  return $rs;
	}

}//end class
?>
