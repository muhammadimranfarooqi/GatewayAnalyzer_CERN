<?php
if (!$_SESSION) {
session_start();
}
$_SESSION["gwLoad"] = "";
$_SESSION["service_load"] = "";
$_SESSION["top_ten_users"] ="";
$_SESSION["direction_load"] = "";
$_SESSION["destination_host_load"] = "";
$_SESSION["file_name"]="";


$_SESSION["gwLoadBar"] = "";
$_SESSION["service_load_bar"]="";
$_SESSION["top_ten_users_bar"]="";
$_SESSION["direction_load_bar"]="";
$_SESSION["destination_host_load_bar"]="";
$_SESSION["gwLoadDetail"] = "";
$_SESSION["svLoadDetail"]="";
$_SESSION["userLoadDetail"]="";
$_SESSION["dirLoadDetail"]="";
$_SESSION["destLoadDetail"] = "";

$_SESSION["fname"]="";

if ($_POST) {
$user_name =  $_POST['user_name']; 
$destination_user_name =  $_POST['destination_user_name']; 
$source_host = $_POST['source_host']; 
$destination_host =  $_POST['destination_host']; 
$service =  $_POST['service']; 
$service_text =  $_POST['service_text']; 
$direction = $_POST['direction']; 
$am_status_code= $_POST['am_status_code']; 
$am_status_code_text= $_POST['am_status_code_text']; 
$loginDate = $_POST['loginDate'];
if ($loginDate=="lastday" or $loginDate=="lastweek" or $loginDate=="lastmonth" or $loginDate=="lastyear") {
	$fromDate= $loginDate;
}
else {
	$fromDate= $_POST['fromDate'];
	$toDate= $_POST['toDate'];
}

$loginStatus = $_POST['loginStatus'];

if (loginStatus!="ON")  {
	$logoutDate = $_POST['logoutDate'];
	if ($logoutDate =="lastday" or $logoutDate =="lastweek" or $logoutDate =="lastmonth" or $logoutDate =="lastyear") {
		$logoutFromDate= $logoutDate ;
	}
	else {
		$logoutFromDate= $_POST['logoutFromDate'];
		$logoutToDate= $_POST['logoutToDate'];
	}
}

$_SESSION["user_name"] =  $user_name; 
$_SESSION["destination_user_name"] =  $destination_user_name; 
$_SESSION["source_host"] = $source_host; 
$_SESSION["destination_host"] =  $destination_host; 
$_SESSION["service"] =  $service; 
$_SESSION["service_text"] =  $service_text; 
$_SESSION["direction"] = $direction; 
$_SESSION["am_status_code"]= $am_status_code; 
$_SESSION["am_status_code_text"]= $am_status_code_text; 
$_SESSION["loginDate"] = $loginDate;
$_SESSION["fromDate"]= $fromDate;
$_SESSION["toDate"]= $toDate;
$_SESSION["loginStatus"] = $loginStatus;
$_SESSION["logoutDate"] = $logoutDate;
$_SESSION["logoutFromDate"]= $logoutFromDate;
$_SESSION["logoutToDate"]= $logoutToDate;
}
else {
$user_name =  $_SESSION["user_name"]; 
$destination_user_name = $_SESSION["destination_user_name"];
$source_host = $_SESSION["source_host"] ; 
$destination_host =  $_SESSION["destination_host"]; 
$service = $_SESSION["service"]; 
$service_text =  $_SESSION["service_text"]; 
$direction = $_SESSION["direction"]; 
$am_status_code= $_SESSION["am_status_code"]; 
$am_status_code_text= $_SESSION["am_status_code_text"]; 
$loginDate = $_SESSION["loginDate"];
$fromDate= $_SESSION["fromDate"];
$toDate= $_SESSION["toDate"];
$loginStatus = $_SESSION["loginStatus"];
$logoutDate = $_SESSION["logoutDate"];
$logoutFromDate= $_SESSION["logoutFromDate"];
$logoutToDate= $_SESSION["logoutToDate"];
$graph_file_name=$_SESSION["graph_file_name"];


}
$search_initial = "Searching total no.of logins of";
$search_text = "";
$search_gw = "";
$graph_file_name="";

if ($user_name!="") {
	$first_chr = substr($user_name,0,1);
	$ulen = strlen($user_name);
	$last_chr = substr($user_name,$ulen-1,1);
	
	if ($search_text=="") {
		$search_text = "user : <font color=limegreen> $user_name</font>";
		$link_text = "user_name:$user_name";

		}
	else {
		$search_text = $search_text ." and user : <font color=limegreen>$user_name</font>";
		$link_text = $link_text .",user_name:$user_name";
		}
	$g_user_name=$user_name;
	if ($first_chr=="*" and $last_chr=="*") 
		$g_user_name = substr($user_name,1,$ulen-2);
	else if ($first_chr=="*") 
		$g_user_name = substr($user_name,1,$ulen-1);
	else if ($last_chr=="*") 
		$g_user_name = substr($user_name,0,$ulen-1);
	if ($graph_file_name!="")
		$graph_file_name=$graph_file_name.",".$g_user_name;
	else 
		$graph_file_name=$g_user_name;

 }
 if ($destination_user_name!="") {
	$first_chr = substr($destination_user_name,0,1);
	$ulen = strlen($destination_user_name);
	$last_chr = substr($destination_user_name,$ulen-1,1);
	
	if ($search_text=="") {
		$search_text = "destination user : <font color=limegreen> $destination_user_name</font>";
		$link_text = "destination_user_name:$destination_user_name";

		}
	else {
		$search_text = $search_text ." and destination user : <font color=limegreen>$destination_user_name</font>";
		$link_text = $link_text .",destination_user_name:$destination_user_name";
		}
	$g_user_name=$destination_user_name;
	if ($first_chr=="*" and $last_chr=="*") 
		$g_user_name = substr($destination_user_name,1,$ulen-2);
	else if ($first_chr=="*") 
		$g_user_name = substr($destination_user_name,1,$ulen-1);
	else if ($last_chr=="*") 
		$g_user_name = substr($destination_user_name,0,$ulen-1);
	if ($graph_file_name!="")
		$graph_file_name=$graph_file_name.",".$g_user_name;
	else 
		$graph_file_name=$g_user_name;

 }
if ($source_host!="") {
	if ($search_text=="") {
		$search_text = "host name : <font color=limegreen>$source_host</font>";
		$link_text = "source_host:$source_host";
		}
	else {
		$search_text = $search_text ." and host name : <font color=limegreen>$source_host</font>";
		$link_text = $link_text .",source_host:$source_host";
		}
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
	if ($graph_file_name!="")
		$graph_file_name=$graph_file_name.",".$g_source_host;
	else 
		$graph_file_name=$g_source_host;	
	
 }

if ($destination_host!="") {
	if ($search_text=="") {
		$search_text = "destination : <font color=limegreen>$destination_host</font>";
		$link_text = "destination_host:$destination_host";

		}
	else {
		$search_text = $search_text ." and destination :<font color=limegreen>$destination_host</font>";
		$link_text = $link_text .",destination_host:$destination_host";

		}
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
	if ($graph_file_name!="")
		$graph_file_name=$graph_file_name.",".$g_destination_host;
	else 
		$graph_file_name=$g_destination_host;	
 }

if ($service !="Select") {
	if ($search_text=="") {
		$search_text = "service  :<font color=limegreen> $service_text</font>";
		$link_text = "service:$service_text";

		}
	else {
		$search_text = $search_text ." and service :<font color=limegreen> $service_text</font>";
		$link_text = $link_text .",service:$service_text";

		}
	if ($graph_file_name!="")
		$graph_file_name=$graph_file_name.",".$service_text;
	else 
		$graph_file_name=$service_text;
	
 }

if ($direction!="Select") {
	if ($search_text=="") {
		$search_text = "direction :<font color=limegreen> $direction</font>";
		$link_text = "direction:$direction";

		}
	else {
		$search_text = $search_text ." and direction : <font color=limegreen>$direction</font>";
		$link_text = $link_text .",direction:$direction";

		}
	if ($graph_file_name!="")
		$graph_file_name=$graph_file_name.",".$direction;
	else 
		$graph_file_name=$direction;

		
  }
if ($am_status_code!="Select") {
	if ($search_text=="") {
		$search_text = "AM Return Codes : <font color=limegreen>$am_status_code_text</font>";
		$link_text = "am_return_codes:$am_status_code_text";

		}
	else {
		$search_text = $search_text ." and AM Return Codes :<font color=limegreen> $am_status_code_text</font>";
		$link_text = $link_text .",am_return_codes:$am_status_code_text";

		}
	if ($graph_file_name!="")
		$graph_file_name=$graph_file_name.",".$am_status_code_text;
	else 
		$graph_file_name=$am_status_code_text;

  }
 // echo $fromDate;
if ($loginDate=="lastday" or $loginDate=="lastweek" or $loginDate=="lastmonth" or $loginDate=="lastyear") {
	$search_initial = "Searching total no.of logins";
	if ($search_text=="") {
		$search_text = " for login date <font color=limegreen>".$loginDate."</font>";
		$link_text = "from:$loginDate";
		}
	else {
		$search_text = $search_text ." and for login date <font color=limegreen>".$loginDate."</font>";
		$link_text = $link_text .",from:$loginDate";
		}
		if ($graph_file_name!="")
		$graph_file_name=$graph_file_name.",".$loginDate;
 	else 
		$graph_file_name=$loginDate;


}
else if ($fromDate!="" && $toDate!="") {
	 $fDate = date('Y-m-d ', strtotime($fromDate));
	 $tDate = date('Y-m-d', strtotime($toDate));
	 $date = strtotime(date("Y-m-d", strtotime($tDate)) . " +1 day");
	 $td = Date("Y-m-d", $date);
     $ffd = date('d-M-Y', strtotime($fromDate));
     $ttd = date('d-M-Y', strtotime($toDate));

	$search_initial = "Searching total no.of logins";
	if ($search_text=="") {
		$search_text = " login date from <font color=limegreen>$ffd</font> to <font color=limegreen>$ttd</font>";
		$link_text = "from:$fromDate,to:$toDate";
		}
	else {
		$search_text = $search_text ." and login date from <font color=limegreen>$ffd</font> to <font color=limegreen>$ttd</font>";
		$link_text = $link_text .",from:$fromDate".",to:$toDate";
		}
		if ($graph_file_name!="")
		$graph_file_name=$graph_file_name.",".$ffd."_to_".$ttd;
 	else 
		$graph_file_name=$ffd."_to_".$ttd;

  }
 if ($logoutDate=="lastday" or $logoutDate=="lastweek" or $logoutDate=="lastmonth" or $logoutDate=="lastyear") {
	$search_initial = "Searching total no.of logins";
	if ($search_text=="") {
		$search_text = " for logut date<font color=limegreen>".$logoutDate."</font>";
		$link_text = "logoutfrom:$logoutDate";
		}
	else {
		$search_text = $search_text ." and for logout date <font color=limegreen>".$logoutDate."</font>";
		$link_text = $link_text .",logoutfrom:$logoutDate";
		}
		if ($graph_file_name!="")
		$graph_file_name=$graph_file_name.",".$logoutDate;
 	else 
		$graph_file_name=$logoutDate;


}
else if ($logoutFromDate!="" && $logoutToDate!="") {
	 $lfDate = date('Y-m-d ', strtotime($logoutFromDate));
	 $ltDate = date('Y-m-d', strtotime($logoutToDate));
	 $ldate = strtotime(date("Y-m-d", strtotime($ltDate)) . " +1 day");
	 $ltd = Date("Y-m-d", $ldate);
     $lffd = date('d-M-Y', strtotime($logoutFromDate));
     $lttd = date('d-M-Y', strtotime($logoutToDate));

	$search_initial = "Searching total no.of logout";
	if ($search_text=="") {
		$search_text = " logout date from <font color=limegreen>$lffd</font> to <font color=limegreen>$lttd</font>";
		$link_text = "logoutfrom:$logoutFromDate,logoutto:$logoutToDate";
		}
	else {
		$search_text = $search_text ." and logout date from <font color=limegreen>$lffd</font> to <font color=limegreen>$lttd</font>";
		$link_text = $link_text .",logoutfrom:$logoutFromDate".",logoutto:$logoutToDate";
		}
		if ($graph_file_name!="")
		$graph_file_name=$graph_file_name.",".$lffd."_to_".$lttd;
 	else 
		$graph_file_name=$lffd."_to_".$lttd;

  }

$search_body = $search_initial . " " . $search_text . " " . $search_gw;
$_SESSION["link_text"] = $link_text;
$_SESSION["graph_file_name"]=$graph_file_name;
$_SESSION["user_url"]="user_load.php";

?>
<html>

<head>
<meta http-equiv="Content-Language" content="en-us">

<title>ATLAS TDAQ - Gateway Analyzer</title>
<script language="JavaScript" src="resources/selectItem.js"></script>
</head>

<body topmargin="0" leftmargin="0">

<table border="0" width="100%" id="table1" height="802" cellspacing="0">
	<tr>
		<td colspan="3" height="1%">
		<img border="0" src="images/gw-banner.jpg" width="100%" height="58"></td>
	</tr>
	<tr>
		<td width="15%" bgcolor="#E5E3F0" rowspan="15" valign="top">
		<table border="0" width="100%" id="table8">
			<tr>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
			</tr>
				<tr>
				<td>
				<div align="center">
					<?php include "main_menu.htm"; ?>

				</div>
				</td>
			</tr>
			</tr>
			<tr>
				<td height="24">
				<p align="center">&nbsp;</td>
			</tr>

			<tr>
				<td>
				<div align="center">
					<?php include "gw_login_menu.php"; ?>

				</div>
				</td>
			</tr>
			
			<tr>
				<td height="24">
				<p align="center">&nbsp;</td>
			</tr>
			<tr>
				<td>
				<div align="center">
						<?php include "gw_statistics_menu.htm"; ?>


				</div>
				</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
			</tr>
		</table>
		</td>
		<td width="85%" height="1" colspan="2"></td>
	</tr>
	<tr>
		<td width="1%" align=center height="1">
		
           
		</td>
		<td width="83%" align=center height="1">
		
            </td>
	</tr>
	<tr>
		<td width="1%" align=center height="1">
		
           
		</td>
		<td width="83%" align=center height="1">
		
            </td>
	</tr>
	<tr>
		<td width="1%" align=center height="1">
		
           
		</td>
		<td width="83%" align=center height="1">
		
            </td>
	</tr>
	<tr>
		<td width="1%" align=center height="1">
		
           
		</td>
		<td width="83%" align=center height="1">
		
            </td>
	</tr>
	<tr>
		<td width="1%" align=center height="1">
		
           
		</td>
		<td width="83%" align=center height="1">
		
            <p align="left"><font color="#800000"><b>TOP TEN USERS</b></font></td>
	</tr>
	<tr>
		<td width="1%" align=center height="1">
		
           
		&nbsp;</td>
		<td width="83%" align=center height="1">
		
            <hr>
		
            </td>
	</tr>
	<tr>
		<td width="1%" align=center height="151" rowspan="8">
		
           
		</td>
		<td width="83%" align=center height="1" valign="top">
		
          
				<p align=center><?php echo "<font face=verdana size=2 color=blue><b>$search_body</b></font>";?></p>


		<table border="1" width="100%" style="border-collapse: collapse" id="table2" bordercolor="#D7D1E4">
			<tr>
				<td>
		
          

		<table border="0" width="100%" id="table17">
			<tr>
				<td>
		
          
				

		<div align="left">
			<table border="0" width="100%" style="border-collapse: collapse" id="table18" cellspacing="2" cellpadding="3">
				<tr>
					<td background="images/15-green.jpg" height="28"><b>
					<font size="1" face="Verdana">Top Ten Users Statistics </font></b>
					<font color="#008000" size="1" face="Verdana">(View 
					As :- </font>
					<a href="javascript:getProperGraph('pie_chart','top_ten_users')">
					<img border="0" src="images/chart_pie.png" width="16" height="16"></a><font size="1" face="Verdana" color="#008000"> 
					or </font>
					<a href="javascript:getProperGraph('bar_chart','top_ten_users')">
					<img border="0" src="images/chart_bar.png" width="16" height="16"></a><font size="1" face="Verdana" color="#008000"> 
					)</font></td>
					<td background="images/15-green.jpg" height="28">&nbsp;</td>
				</tr>
				<tr>
					<td colspan="2">
		<div id="mainDiv">
          
				<?php include 'top_ten_users_graph.php';
				?>
				</div>
		</td>
				</tr>
				</table>
			
		</td>

				</tr>
				</table>
		</div></td>
				</tr>
				</table>
			</div>
		</td>
			</tr>
		</table>
		</td>
	</tr>
	<tr>
		<td width="83%" align=center height="1">
		
          
				

		</td>
	</tr>
	<tr>
		<td width="83%" align=center height="1">
		
          
				

		</td>
	</tr>
	<tr>
		<td width="83%" align=center height="1">
		
          
				

		</td>
	</tr>
	<tr>
		<td width="83%" align=center height="9">
		
          
				

		</td>
	</tr>
	<tr>
		<td width="83%" align=center height="9">
		
          
				

		</td>
	</tr>
	<tr>
		<td width="83%" align=center height="9">
		
          
				

		</td>
	</tr>
	<tr>
		<td width="83%" align=center height="9">
		
          
				

		</td>
	</tr>
	<tr>
		<td width="15%" bgcolor="#E5E3F0" valign="top">&nbsp;</td>
		<td width="85%" colspan="2">&nbsp;</td>
	</tr>
	<tr>
		<td width="100%" colspan="3" height="26"><hr></td>
	</tr>
</table>

</body>

</html>
