<?php
include 'connection.php';
include 'GWLogin.php';
include 'Charts.php';
include 'Gateway.php';
include 'Service.php';
include 'AMStatusCode.php';

class Controller
{
/*****************************************************************************************************************************************************************************

//View Current Login

*****************************************************************************************************************************************************************************/	
    function viewCurrentLogin($gateway,$user_name,$destination_user_name,$source_host,$destination_host,$service,$direction,$am_status_code,$fromDate,$toDate,$logoutFromDate,$logoutToDate,$loginStatus,$sort,$how,&$conn)
	{
	 $cn = (object)$conn;
	  $gw = new GWLogin();
	  $rs=null;

	  $rs= $gw->viewCurrentLogin($gateway,$user_name,$destination_user_name,$source_host,$destination_host,$service,$direction,$am_status_code,$fromDate,$toDate,$logoutFromDate,$logoutToDate,$loginStatus,$sort,$how,$cn);
	  return $rs;
	}
	
	
	function viewCurrentLoginSpecificPage($gateway,$user_name,$destination_user_name,$source_host,$destination_host,$service,$direction,$am_status_code,$fromDate,$toDate,$logoutFromDate,$logoutToDate,$loginStatus,$sort,$how,$StartRow,$PageSize,&$conn)
	{
	 $cn = (object)$conn;
	  $gw = new GWLogin();
	  $rs=null;
	$rs = $gw->viewCurrentLoginSpecificPage($gateway,$user_name,$destination_user_name,$source_host,$destination_host,$service,$direction,$am_status_code,$fromDate,$toDate,$logoutFromDate,$logoutToDate,$loginStatus,$sort,$how,$StartRow,$PageSize,$cn);
	return $rs;

	}


/*****************************************************************************************************************************************************************************

//View gateway load w.r.t no. of connection

*****************************************************************************************************************************************************************************/			
	function viewGatewayLoad($gateway_name,$user_name,$destination_user_name,$source_host,$destination_host,$service,$direction,$am_status_code,$fromDate,$toDate,$logoutFromDate,$logoutToDate,$loginStatus,$groupby,&$conn)
	{
	  $cn = (object)$conn;
	  $gw = new GWLogin();
	  $rs=null;
	  $rs= $gw->viewGatewayLoad($gateway_name,$user_name,$destination_user_name,$source_host,$destination_host,$service,$direction,$am_status_code,$fromDate,$toDate,$logoutFromDate,$logoutToDate,$loginStatus,$groupby,$cn);
	  return $rs;
	}
/*****************************************************************************************************************************************************************************

//View gateway load detail

*****************************************************************************************************************************************************************************/			
	function viewGatewayLoadDetail($criteria,$loginStatus,&$conn)
	{
	  $cn = (object)$conn;
	  $gw = new GWLogin();
	  $rs=null;
	  $rs= $gw->viewGatewayLoadDetail($criteria,$loginStatus,$cn);
	  return $rs;
	}
/*****************************************************************************************************************************************************************************

//View gateway load information

*****************************************************************************************************************************************************************************/			
	function viewGatewayLoadInformation($criteria,$id,$sort,$how,$loginStatus,&$conn)
	{
	  $cn = (object)$conn;
	  $gw = new GWLogin();
	  $rs=null;
	  $rs= $gw->viewGatewayLoadInformation($criteria,$id,$sort,$how,$loginStatus,$cn);
	  return $rs;
	}
/*****************************************************************************************************************************************************************************

//View gateway load by month Specific Page

*****************************************************************************************************************************************************************************/			
	function viewGatewayLoadInformationByPage($criteria,$id,$sort,$how,$StartRow,$PageSize,$loginStatus,&$conn)
	{
	  $cn = (object)$conn;
	  $gw = new GWLogin();
	  $rs=null;
	  $rs= $gw->viewGatewayLoadInformationByPage($criteria,$id,$sort,$how,$StartRow,$PageSize,$loginStatus,$cn);
	  return $rs;
	}


/*****************************************************************************************************************************************************************************

//Generate Charts

*****************************************************************************************************************************************************************************/			
	
	function generateChart($chartType,$graph_type,$chart_path,$rs,$graph_file_name,&$conn)
	{
	$con = new Controller();
	$cn = (object)$conn;
	$ch = new Charts();
	$ch->generateChart($chartType,$rs,$graph_type,$chart_path,$graph_file_name);
	}
	
	
/*****************************************************************************************************************************************************************************

//Generate Detail Charts

*****************************************************************************************************************************************************************************/			
	function generateDetailChart($chartType,$criteria,$chart_path,$rs,&$conn)
	{
	$con = new Controller();
	$cn = (object)$conn;
	$ch = new Charts();
		if ($chartType=="gw_history_load") {
				$gateway="";
				$user_name="";
				$source_host="";
				$destination_host="";
				$service="";
				$direction="";
				$am_status_code="";
				$fromDate="";
				$toDate="";
				$table_criteria="";
				$total_criteria = split("\,",$criteria);
				$total_len = count($total_criteria);
				$G_file_name = "";
				for ($i=0;$i<$total_len;$i++) {
				  $each_item = split(":",$total_criteria[$i]);
				  $item_name = $each_item[0];
				  $item_value = $each_item[1];
				 if ( $each_item[0]=="gateway") {
					$gateway = $each_item[1];
					if ($G_file_name == "")
						$G_file_name = $each_item[1];
					else 
						$G_file_name = $G_file_name .",".$each_item[1];

				 }
				 if ($each_item[0]=="user_name") {
					$user_name= $each_item[1];
					$first_chr = substr($user_name,0,1);
					$ulen = strlen($user_name);
					$last_chr = substr($user_name,$ulen-1,1);	
						
					$g_user_name=$user_name;
					if ($first_chr=="*" and $last_chr=="*") 
						$g_user_name = substr($user_name,1,$ulen-2);
					else if ($first_chr=="*") 
						$g_user_name = substr($user_name,1,$ulen-1);
					else if ($last_chr=="*") 
						$g_user_name = substr($user_name,0,$ulen-1);
					
					if ($G_file_name == "")
						$G_file_name = $g_user_name;
					else 
						$G_file_name = $G_file_name .",".$g_user_name;

				 }
				 if ($each_item[0]=="destination_user_name") {
					$user_name= $each_item[1];
					$first_chr = substr($user_name,0,1);
					$ulen = strlen($user_name);
					$last_chr = substr($user_name,$ulen-1,1);	
						
					$g_user_name=$user_name;
					if ($first_chr=="*" and $last_chr=="*") 
						$g_user_name = substr($user_name,1,$ulen-2);
					else if ($first_chr=="*") 
						$g_user_name = substr($user_name,1,$ulen-1);
					else if ($last_chr=="*") 
						$g_user_name = substr($user_name,0,$ulen-1);
					
					if ($G_file_name == "")
						$G_file_name = $g_user_name;
					else 
						$G_file_name = $G_file_name .",".$g_user_name;

				 }
				if ($each_item[0]=="source_host") {
					$source_host= $each_item[1];
					
					$first_chr = substr($source_host,0,1);
					$ulen = strlen($source_host);
					$last_chr = substr($source_host,$ulen-1,1);	
					
					$g_source_host=$source_host;
					if ($first_chr=="*" and $last_chr=="*") 
						$g_source_host = substr($source_host,1,$ulen-2);
					else if ($first_chr=="*") 
						$g_source_host = substr($source_host,1,$ulen-1);
					else if ($last_chr=="*") 
						$g_source_host = substr($source_host,0,$ulen-1);
										
					if ($G_file_name == "")
						$G_file_name = $g_source_host;
					else 
						$G_file_name = $G_file_name .",".$g_source_host;

				 }

				if ($each_item[0]=="destination_host") {
					$destination_host= $each_item[1];
					
					$first_chr = substr($destination_host,0,1);
					$ulen = strlen($destination_host);
					$last_chr = substr($destination_host,$ulen-1,1);	
					$g_destination_host=$destination_host;
					if ($first_chr=="*" and $last_chr=="*") 
						$g_destination_host = substr($destination_host,1,$ulen-2);
					else if ($first_chr=="*") 
						$g_destination_host = substr($destination_host,1,$ulen-1);
					else if ($last_chr=="*") 
						$g_destination_host = substr($destination_host,0,$ulen-1);
										
					if ($G_file_name == "")
						$G_file_name = $g_destination_host;
					else 
						$G_file_name = $G_file_name .",".$g_destination_host;

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
				if ($each_item[0]=="am_status_code") {
					$am_status_code= $each_item[1];
					if ($G_file_name == "")
						$G_file_name = $each_item[1];
					else 
						$G_file_name = $G_file_name .",".$each_item[1];

				  }
				if ($each_item[0]=="fromDate") {
					 $fromDate= $each_item[1];
					 if ($G_file_name == "")
						$G_file_name = $each_item[1];
					else 
						$G_file_name = $G_file_name .",".$each_item[1];

				  }
				if ($each_item[0]=="toDate") {
					 $toDate= $each_item[1];
					 if ($G_file_name == "")
						$G_file_name = $each_item[1];
					else 
						$G_file_name = $G_file_name .",".$each_item[1];
				  }

				}
	 		
	 		 
	 		 $ch->generateHistoryChart($rs,"bar_chart",$G_file_name,$gateway,$chart_path);
	 		
	  }
else {
   $ch->generateDetailChart($chartType,$rs,$criteria,$chart_path);
   }
	
	}
/*****************************************************************************************************************************************************************************

//Get AM Status Codes

*****************************************************************************************************************************************************************************/		
  function viewGateways(&$conn) {
   $cn = (object)$conn;
   $gw = new Gateway();
   $rs = $gw->viewGateways($cn);
   return $rs;
   }


/*****************************************************************************************************************************************************************************

//Get Services

*****************************************************************************************************************************************************************************/		
  function viewServices(&$conn) {
   $cn = (object)$conn;
   $sv = new Service();
   $rs = $sv->viewServices($cn);
   return $rs;
   }
/*****************************************************************************************************************************************************************************

//Get AM Status Codes

*****************************************************************************************************************************************************************************/		
  function viewAMStatusCode(&$conn) {
  $cn = (object)$conn;
   $am = new AMStatusCode();
   $rs = $am->viewAMStatusCode($cn);
   return $rs;
   }

/*****************************************************************************************************************************************************************************

//Get ResultSet as an array (row by row data)

*****************************************************************************************************************************************************************************/		
   function getTotalData($result,&$conn) {
   $cn = (object)$conn;
   $line = $cn->getTotalData($result);
   return $line;
   }

/*****************************************************************************************************************************************************************************

//View Statistics History

*****************************************************************************************************************************************************************************/		
	 function viewStatisticsHistoryLoad($gateway,$user_name,$destination_user_name,$source_host,$destination_host,$service,$direction,$am_status_code,$fromDate,$toDate,$logoutFromDate,$logoutToDate,&$conn)
	{
		
	  $cn = (object)$conn;
	  $gw = new GWLogin();
	  $rs=null;
	  $rs= $gw->viewStatisticsHistoryLoad($gateway,$user_name,$destination_user_name,$source_host,$destination_host,$service,$direction,$am_status_code,$fromDate,$toDate,$logoutFromDate,$logoutToDate,$cn);
	  return $rs;
	}
/*****************************************************************************************************************************************************************************

//View Statistics History Per Month

*****************************************************************************************************************************************************************************/		
	 function viewStatisticsHistoryLoadPerMonth($criteria,&$conn)
	{
	  $cn = (object) $conn;
	  $gw = new GWLogin();
	  $rs=null;
	  $rs= $gw->viewStatisticsHistoryLoadPerMonth($criteria,$cn);
	  return $rs;
	}

/*****************************************************************************************************************************************************************************

//View gateway history load by month

*****************************************************************************************************************************************************************************/			
	function viewGatewayHistoryLoadByMonth($criteria,$id,$sort,$how,&$conn)
	{
	 $cn = (object) $conn;
	  $gw = new GWLogin();
	  $rs=null;
	  $rs= $gw->viewGatewayHistoryLoadByMonth($criteria,$id,$sort,$how,$cn);
	  return $rs;
	}
/*****************************************************************************************************************************************************************************

//View gateway history load by month

*****************************************************************************************************************************************************************************/			
	function viewGatewayHistoryLoadByMonthSpecificPage($criteria,$id,$sort,$how,$StartRow,$PageSize,&$conn)
	{
	 $cn = (object) $conn;
	  $gw = new GWLogin();
	  $rs=null;
	  $rs= $gw->viewGatewayHistoryLoadByMonthSpecificPage($criteria,$id,$sort,$how,$StartRow,$PageSize,$cn);
	  return $rs;
	}

/*****************************************************************************************************************************************************************************

//Generate History Charts

*****************************************************************************************************************************************************************************/			
	function generateHistoryChart($graph_type,$gateway,$user_name,$destination_user_name,$source_host,$destination_host,$service,$direction,$am_status_code,$fromDate,$toDate,$logoutFromDate,$logoutToDate,$graph_file_name,$gateway,$chart_path,&$conn)
	{
	
	$cn = (object) $conn;
	$con = new Controller();
	$ch = new Charts();
	  $rs=null;
	

	
	 		 $rs= $con->viewStatisticsHistoryLoad($gateway,$user_name,$destination_user_name,$source_host,$destination_host,$service,$direction,$am_status_code,$fromDate,$toDate,$logoutFromDate,$logoutToDate,$cn);
			$num_rows = $con->getHistoryCount($rs);
			if ($num_rows!=0)  		 
	 		 $ch->generateHistoryChart($rs,$graph_type,$graph_file_name,$gateway,$chart_path);
	 		 
	 		
	  }
	 

	function getHistoryCount($result) {
		$num_rows = mysql_num_rows($result);
		return $num_rows;
	
	}
	
/*****************************************************************************************************************************************************************************

//Generate DB Connection

*****************************************************************************************************************************************************************************/			

	
function getDBConnection($mysql_user,$mysql_pass,$mysql_host,$mysql_db)
	{
	  $cn = new connection($mysql_user,$mysql_pass,$mysql_host,$mysql_db);
	  return $cn;
	}

 
   
}//end class
?>
