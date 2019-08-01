<html>

<head>
<meta http-equiv="Content-Language" content="en-us">
<title>ATLAS TDAQ - Gateway Analyzer</title>


<script type="text/javascript" src="Calendar/datetimepicker_css.js"></script>
<script type="text/javascript" src="resources/selectItem.js"></script>


<script language="javascript">
function getLoginDate(str) {
if (str=="Custom") {
	document.getElementById("loginDateRow").style.display = '';
	document.historyForm.fromDate.value='<?php print $_SESSION[customFromDate];?>';
	document.historyForm.toDate.value='<?php print $_SESSION["customToDate"];?>';

	}
else {
	document.getElementById("loginDateRow").style.display = 'none';
	document.historyForm.fromDate.value="";
	document.historyForm.toDate.value="";
	}
}

function Validate() {

var gateway = document.historyForm.gateway.value;
var user_name = document.historyForm.user_name.value;
var destination_user_name = document.historyForm.destination_user_name.value;
var source_host = document.historyForm.source_host.value;
var destination_host = document.historyForm.destination_host.value;
var service = document.historyForm.service.value;
var direction = document.historyForm.direction.value;
var am_status_code = document.historyForm.am_status_code.value;
var loginDate = document.historyForm.loginDate.value;
var fromDate = document.historyForm.fromDate.value;
var toDate = document.historyForm.toDate.value;
if (loginDate=="Custom") {
if (document.historyForm.fromDate.value!="") {
	if (document.historyForm.toDate.value=="") {
	    alert("Please eneter end date");
    	document.historyForm.toDate.focus();
		return false;
	}
}
}
if (document.historyForm.fromDate.value!="" && document.historyForm.toDate.value!="") {
	
  var yr1  = parseInt(fromDate.substring(0,4),10);
  var mon1  = parseInt(fromDate.substring(5,7),10);
  var dt1 = parseInt(fromDate.substring(8,10),10);

  var yr2  = parseInt(toDate.substring(0,4),10);
  var mon2  = parseInt(toDate.substring(5,7),10);
  var dt2 = parseInt(toDate.substring(8,10),10);
  
  var date1 = new Date(yr1, mon1, dt1);
  var date2 = new Date(yr2, mon2, dt2);
  if(date2 < date1)
    {
    alert("From date cannot be greater than End date");
    document.historyForm.toDate.focus();
	return false;
    } 
}	

	

}
</script>
<script language=javascript>
function getURL(str) {
	var url = window.location.href;
	var query_string = url.split("?");
	var qlen = query_string.length;
	
	
 if (qlen==1) 
 	 query_string[1] = "PageNo=1&sort=source_user&how=DESC&totalpages=200";
  

	var pageIndex = query_string[1].indexOf("PageNo=");

	if (pageIndex>=0) {
		
		var sortIndex = query_string[1].indexOf("&sort=");
		var diff = sortIndex - pageIndex;
		
		var firstStr = query_string[1].substring(0,pageIndex);

		var preStr = query_string[1].substring(pageIndex,diff);
		var newStr =preStr.replace(preStr, "PageNo=1");

		var nextStr = query_string[1].substring(sortIndex);
		var strIndex = nextStr.indexOf("&totalpages");
		
		if (strIndex>0) {
			var start = strIndex+11;
			
			var str1 = nextStr.substring(0,strIndex);
			var pg = nextStr.substring(start,start+5);
			
			var lastchr = pg.substring(start+5,4);
			if (lastchr==0) {
			var str2 = nextStr.substring(strIndex,strIndex+16);
			var str3 = nextStr.substring(strIndex+16);

			}
			else {
			var str2 = nextStr.substring(strIndex,strIndex+15);
			var str3 = nextStr.substring(strIndex+15);
			}
			if (firstStr=="") {
				var str4 = newStr + str1 + str3;
			}
			else {
				var str4 = firstStr + newStr + str1 + str3;
			}
			var newurl = query_string[0] + "?"+str4;
			window.location.href = newurl+"&totalpages="+str;
		}
	}
	else {
		var strIndex = query_string[1].indexOf("&totalpages");

		if (strIndex>0) {
		
			var str1 = query_string[1].substring(0,strIndex);
			var pg = query_string[1].substring(start,start+5);
			
			var lastchr = pg.substring(start+5,4);
			if (lastchr==0) {
			var str2 = query_string[1].substring(strIndex,strIndex+16);
			var str3 = query_string[1].substring(strIndex+16);

			}
			else {

			var str2 = query_string[1].substring(strIndex,strIndex+15);
			var str3 = query_string[1].substring(strIndex+15);
			}
			var str4 = str1 + str3;

			var newurl = query_string[0] + "?"+str4;
			window.location.href = newurl+"&totalpages="+str;

		}
		else
		{
			window.location.href = window.location.href+"&totalpages="+str;
		}
	}
}//end function
</script>


<link href="resources/style.css" rel="stylesheet" type="text/css">

</head>
<?php
include "classes/Controller.php";
include("Config/config.inc.php");

if(!isset($_SESSION))  {
session_start();
}
if ($_SESSION['totalpages']=="")
	 $_SESSION['totalpages'] = 200;

$con = new Controller();
$cn = $con->getDBConnection($mysql_user,$mysql_pass,$mysql_host,$mysql_db);

$result = $con->viewServices($cn);
$result1 = $con->viewAMStatusCode($cn);
$result3 = $con->viewGateways($cn);

$num_rows = 0;

$nimg = "images/bg.gif";
$aimg = "images/asc.gif";
$dimg = "images/desc.gif";

if (!isset($_GET['how'])) {
    $_GET['how'] = "DESC";
    $query ="";
     $PageSize = 200;
	 $_SESSION['totalpages'] = $PageSize;

}

if ($_GET['how'] == "ASC") {
	$np=$_GET['how'];
    $how="DESC";
    if (!isset($_GET['sort']))
    	$sort = "source_user";
    else
        $sort = $_GET["sort"];
if (!$_SESSION['totalpages']) {
 	 if (!isset($_GET['totalpages'])) {
	 	$PageSize = 200;
	 	$_SESSION['totalpages'] = $PageSize;
	 	}
	else {
	     $PageSize = $_GET['totalpages'];
	     $_SESSION['totalpages'] = $PageSize;

	    }
	}
	else {
		     if (!isset($_GET['totalpages'])) {
	 		$PageSize = $_SESSION['totalpages'];
			$_SESSION['totalpages'] = $PageSize;	 	
			}
		else {
	    	 $PageSize = $_GET['totalpages'];
	    	 $_SESSION['totalpages'] = $PageSize;
	    }
	}


    $query="";
} elseif ($_GET['how'] == "DESC") {
	$np=$_GET['how'];
    $how="ASC";
    if (!isset($_GET['sort']))
    	$sort = "source_user";
    else
        $sort = $_GET["sort"];
  if (!$_SESSION['totalpages']) {
 	 if (!isset($_GET['totalpages'])) {
	 	$PageSize = 200;
	 	$_SESSION['totalpages'] = $PageSize;
	 	}
	else {
	     $PageSize = $_GET['totalpages'];
	     $_SESSION['totalpages'] = $PageSize;

	    }
	}
	else {
		     if (!isset($_GET['totalpages'])) {
	 		$PageSize = $_SESSION['totalpages'];
			$_SESSION['totalpages'] = $PageSize;	 	
			}
		else {
	    	 $PageSize = $_GET['totalpages'];
	    	 $_SESSION['totalpages'] = $PageSize;
	    }
	}

}


//Set the page size
$StartRow = 0;

//Set the page no
if(empty($_GET['PageNo'])){
    if($StartRow == 0){
        $PageNo = $StartRow + 1;
    }
}else{
    $PageNo = $_GET['PageNo'];
    $StartRow = ($PageNo - 1) * $PageSize;
}

//Set the counter start
if($PageNo % $PageSize == 0){
    $CounterStart = $PageNo - ($PageSize - 1);
}else{
    $CounterStart = $PageNo - ($PageNo % $PageSize) + 1;
}

//Counter End
$CounterEnd = $CounterStart + ($PageSize - 1);

$gateway_list = "";
$gateway = ""; 
$user_name =  ""; 
$destination_user_name="";
$source_host = ""; 
$destination_host =  ""; 
$service = ""; 
$service_text =  ""; 
$direction = ""; 
$am_status_code= ""; 
$am_status_code_text= ""; 
$fromDate= "";
$toDate= "";


if ($_POST) {
$gateway_list = $_POST['gateway_list'];
$gateway = $_POST['gateway']; 
$user_name =  $_POST['user_name']; 
$destination_user_name = $_POST['destination_user_name']; 
//echo "destination_user_name: ".$destination_user_name;
$source_host = $_POST['source_host']; 
$destination_host =  $_POST['destination_host']; 
$service =  $_POST['service']; 
$service_text =  $_POST['service_text']; 
$direction = $_POST['direction']; 
$am_status_code= $_POST['am_status_code']; 
$am_status_code_text= $_POST['am_status_code_text']; 
$loginDate = $_POST['loginDate'];

$toDate= $_POST['toDate'];
if (($loginDate=="lastday") or ($loginDate=="lastweek") or ($loginDate=="lastmonth") or ($loginDate=="lastyear")) {
	$fromDate = $loginDate;
	

}
else {
	$fromDate= $_POST['fromDate'];
	}


$_SESSION["gateway_list"] = $gateway_list;
$_SESSION["gateway"] = $gateway; 
$_SESSION["user_name"] =  $user_name; 
$_SESSION["destination_user_name"] =  $destination_user_name; 
$_SESSION["source_host"] = $source_host; 
$_SESSION["destination_host"] =  $destination_host; 
$_SESSION["service"] = $service; 
$_SESSION["service_text"] =  $service_text; 
$_SESSION["direction"] = $direction; 
$_SESSION["am_status_code"]= $am_status_code; 
$_SESSION["am_status_code_text"]= $am_status_code_text; 
$_SESSION["fromDate"]= $fromDate;
$_SESSION["toDate"]= $toDate;
$_SESSION['lloginDate'] = $loginDate;

/*if ($_SESSION['lloginDate']=="lastday" or $_SESSION['lloginDate']=="lastweek" or $_SESSION['lloginDate']=="lastmonth" or $_SESSION['lloginDate']=="lastyear") {
	$fromDate= $_SESSION['lloginDate'];
}else  {
	$fromDate= $_SESSION['fromDate'];
	}*/


if ($gateway_list=="Select" or $gateway=="Select") {
$gateway_list = "";
$_SESSION["$gateway_list"] = "";
$gateway = "";
$_SESSION["gateway"] = $gateway; 
}
if ($service=="Select" or $service_text=="Select") {
$service= "";
$_SESSION["service"] = ""; 
$service_text= "";
$_SESSION["service_text"] = ""; 
}
if ($direction=="Select") {
$direction= "";
$_SESSION["direction"] = ""; 
}
if ($am_status_code=="Select" or $am_status_code_text=="Select") {
$am_status_code= "";
$_SESSION["am_status_code"] = ""; 
$am_status_code_text= "";
$_SESSION["am_status_code_text"] = ""; 
}

//echo "gateway : ".$gateway ."<BR>service : ".$service."<BR>direction : ".$direction."<BR>am code : ".am_status_code;


	if (($gateway_list=="Select" or $gateway_list=="") and $user_name=="" and $destination_user_name=="" and $source_host=="" and $destination_host=="" and ($service=="Select" or $service=="") and ($direction=="Select" or $direction=="") and ($am_status_code=="Select" or $am_status_code=="") and ($loginDate=="Custom") and ($fromDate=="" or $toDate=="")) {
		$gateway = ""; 
		$user_name =  ""; 
		$destination_user_name =  ""; 
		$source_host = ""; 
		$destination_host =  ""; 
		$service = ""; 
		$service_text =  ""; 
		$direction = ""; 
		$am_status_code= ""; 
		$am_status_code_text= ""; 
		$fromDate= "";
		$toDate= "";
		
	}
	
}
else if($_GET) {
#echo "gateway :".$_SESSION['gateway'];
$gateway_list = $_SESSION["gateway_list"];
$gateway = $_SESSION['gateway']; 
$user_name =  $_SESSION['user_name']; 
$destination_user_name =  $_SESSION['destination_user_name'];
$source_host = $_SESSION['source_host']; 
$destination_host =  $_SESSION['destination_host']; 
$service =  $_SESSION['service']; 
$service_text =  $_SESSION['service_text']; 
$direction = $_SESSION['direction']; 
$am_status_code= $_SESSION['am_status_code']; 
$am_status_code_text= $_SESSION['am_status_code_text']; 
if ($_SESSION['fromDate']=="lastday")
	$_SESSION['fromDate'] = "";
$fromDate= $_SESSION['fromDate'];
$toDate= $_SESSION['toDate'];


$breakLoop=0;

if ($gateway_list=="Select" or $gateway=="Select") {
$gateway_list = "";
$_SESSION["$gateway_list"] = "";
$gateway = "";
$_SESSION["gateway"] = $gateway; 
}
if ($service=="Select" or $service_text=="Select") {
$service= "";
$_SESSION["service"] = ""; 
$service_text= "";
$_SESSION["service_text"] = ""; 
}
if ($direction=="Select") {
$direction= "";
$_SESSION["direction"] = ""; 
$service_text= "";
$_SESSION["service_text"] = ""; 
}
if ($am_status_code=="Select" or $am_status_code_text=="Select") {
$am_status_code= "";
$_SESSION["am_status_code"] = ""; 
$am_status_code_text= "";
$_SESSION["am_status_code_text"] = ""; 
}
//echo $gateway_list;

	if (($gateway_list=="Select" or $gateway_list=="") and $user_name=="" and $destination_user_name=="" and $source_host=="" and $destination_host=="" and ($service=="Select" or $service=="") and ($direction=="Select" or $direction=="") and ($am_status_code=="Select" or $am_status_code=="") and ($fromDate=="" or $toDate=="")) {
		$gateway_list = "";
		$gateway = ""; 
		$user_name =  ""; 
		$destination_user_name =  ""; 
		$source_host = ""; 
		$destination_host =  ""; 
		$service = ""; 
		$service_text =  ""; 
		$direction = ""; 
		$am_status_code= ""; 
		$am_status_code_text= ""; 
		$fromDate= "";
		$toDate= "";
		

	}
	//echo "Get";
}

else {
$_SESSION["gateway_list"] = "";
$_SESSION["gateway"] = ""; 
$_SESSION["user_name"] =  ""; 
$_SESSION["destination_user_name"] =  ""; 
$_SESSION["source_host"] = ""; 
$_SESSION["destination_host"] =  ""; 
$_SESSION["service"] = ""; 
$_SESSION["service_text"] =  ""; 
$_SESSION["direction"] = ""; 
$_SESSION["am_status_code"]= ""; 
$_SESSION["am_status_code_text"]= ""; 
$_SESSION["fromDate"]= "";
$_SESSION["toDate"]= "";


//echo "else";
}


//echo "destination_user_name: ".$destination_user_name;

$TRecord = $con->viewCurrentLogin($gateway,$user_name,$destination_user_name,$source_host,$destination_host,$service_text,$direction,$am_status_code_text,$fromDate,$toDate,"","","ON",$sort,$how,$cn);

 $RecordCount = mysql_num_rows($TRecord);

 //Set Maximum Page
 $MaxPage = $RecordCount % $PageSize;
 if($RecordCount % $PageSize == 0){
    $MaxPage = $RecordCount / $PageSize;
 }else{
    $MaxPage = ceil($RecordCount / $PageSize);
 }
?>
<body topmargin="0" leftmargin="0">
<table border="0" width="100%" id="table1" height="802" cellspacing="0">
	<tr>
		<td colspan="3" height="1%">
		<img border="0" src="images/gw-banner.jpg" width="100%" height="58"></td>
	</tr>
	<tr>
		<td width="15%" bgcolor="#E5E3F0" rowspan="17" valign="top">
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
				<td>&nbsp;</td>
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
		<td width="82%" height="1" colspan="2" bgcolor="#E3E5F0"></td>
	</tr>
	<tr>
		<td width="1%" align=center height="1">
		
           
		</td>
		<td width="81%" align=center height="1">
		
            </td>
	</tr>
	<tr>
		<td width="1%" align=center height="1">
		
           
		</td>
		<td width="81%" align=center height="1">
		
            </td>
	</tr>
	<tr>
		<td width="1%" align=center height="1">
		
           
		</td>
		<td width="81%" align=center height="1">
		
            </td>
	</tr>
	<tr>
		<td width="1%" align=center height="1">
		
           
		</td>
		<td width="81%" align=center height="1" valign="bottom">
		
            <p align="left"><font color="#800000"><b>CURRENT LOGIN</b></font></td>
	</tr>
	<tr>
		<td width="1%" align=center height="1">
		
           
		&nbsp;</td>
		<td width="81%" align=center height="1" valign="bottom">
		
            <hr></td>
	</tr>
	<tr>
		<td width="1%" align=center height="151" rowspan="11">
		
           
		</td>
		<td width="81%" align=center height="1" valign="top">
		
          
				

 
	<tr>
		<td width="81%" align=center height="1" valign="top">
		
          
				

<form method="POST" action="index.php?PageNo=1&sort=source_user&how=DESC&totalpages=<?php echo $PageSize;?>" name="historyForm">

		<table border="1" width="100%" style="border-collapse: collapse" id="table22" bordercolor="#D7D1E4" cellspacing="1" cellpadding="0">
			<tr>
				<td>
		
          
				

		<div align="center">
		
          
				
		<table border="0" width="100%" id="table23" cellpadding="2" cellspacing="0">
			<tr>
				<td background="images/15-green.jpg" width="50%" height="28">
					<font size="1" face="Verdana"><b>
					Select Criteria to Search currently logged in users</b></font></td>
				<td background="images/15-green.jpg" width="51%" height="28">
		&nbsp;</td>
				</tr>
			<tr>
				<td width="99%" height="28" colspan="2">
					<table border="0" width="100%" id="table24" cellspacing="3" cellpadding="2">
						<tr>
							<td width="25%"><font face="Verdana" size="1">
							Gateway</font></td>
							<td width="22%" colspan="2">
							<select size="1" name="gateway_list" onchange="document.historyForm.gateway.value=this[this.selectedIndex].text;">
							<option value="Select">Select</option>
							<?php
							
							while ($row1=$con->getTotalData($result3,$cn)) {
							?>
							<option value="<?php echo $row1["id"];?>" <?php if ($row1["name"]==$_SESSION["gateway"]) {?>selected<?php } ?> ><?php echo $row1["name"];?></option>
							<?php
							}
							?>
							</select><input type="hidden" name="gateway" size="20" value='<?php echo $_SESSION["gateway"];?>'></td>
							<td width="19%"><font face="Verdana" size="1">
							Service</font></td>
							<td width="32%">
							
							
								<select size="1" name="service" onchange="document.historyForm.service_text.value=this[this.selectedIndex].text;">
							<option value="Select">Select</option>
							<?php
							while ($row=$con->getTotalData($result,$cn)) {
							?>
							<option value="<?php echo $row["id"];?>" <?php if ($row["name"]==$_SESSION["service_text"]) {?>selected<?php } ?>><?php echo $row["name"];?></option>
							<?php
							}
							?>
							</select></td>
						</tr>
						<tr>
							<td width="25%"><font face="Verdana" size="1">Source 
							User</font></td>
							<td width="22%" colspan="2">
							
							
								<input type="text" name="user_name" size="20" value='<?php echo $_SESSION["user_name"];?>'></td>
							<td width="19%"><font face="Verdana" size="1">
							Destination User</font></td>
							<td width="32%">
							
							
								<input type="text" name="destination_user_name" size="20" value='<?php echo $_SESSION["destination_user_name"];?>'></td>
						</tr>
						<tr>
							<td width="25%"><font face="Verdana" size="1">Source 
							Host</font></td>
							<td width="22%" colspan="2">
							<input type="text" name="source_host" size="20"  value='<?php echo $_SESSION["source_host"];?>'></td>
							<td width="19%"><font face="Verdana" size="1">
							Destination Host</font></td>
							<td width="32%">
							<input type="text" name="destination_host" size="20"  value='<?php echo $_SESSION["destination_host"];?>'></td>
						</tr>
						<tr>
							<td width="25%"><font face="Verdana" size="1">
							Direction</font></td>
							<td width="22%" colspan="2"><input type="hidden" name="service_text" size="20" value='<?php echo $_SESSION["service_text"]; ?>'><select size="1" name="direction">
							<option value="Select">Select</option>
							<option value="Incoming" <?php if ($_SESSION["direction"]=="Incoming") { ?>selected<?php } ?>>Incoming</option>
							<option value="Outgoing" <?php if ($_SESSION["direction"]=="Outgoing") { ?>selected<?php } ?>>Outgoing</option>
							</select></td>
							<td width="19%"><font face="Verdana" size="1">AM 
							Status Code</font></td>
							<td width="32%">
							<select size="1" name="am_status_code" onchange="document.historyForm.am_status_code_text.value=this[this.selectedIndex].text;">
							<option value="Select">Select</option>
							<?php
							while ($row=$con->getTotalData($result1,$cn)) {
							?>
							<option value="<?php echo $row["am_id"];?>" <?php if ($row["am_return_code_description"]==$_SESSION["am_status_code_text"]) {?>selected<?php } ?>><?php echo $row["am_return_code_description"];?></option>
							<?php
							}
							?>

							</select><input type="hidden" name="am_status_code_text" size="20" value='<?php echo $_SESSION["am_status_code_text"];?>'></td>
						</tr>
						<tr>
							<td width="19%"><font face="Verdana" size="1">Login 
							Date</font></td>
							<td width="24%" colspan="2">
							<select size="1" name="loginDate" onchange="javascript:getLoginDate(this.value);">
							<option value="Select"  <?php if ($_SESSION["lloginDate"]=="Select") { ?>selected<?php } ?> selected>Select</option>
							<option value="lastday" <?php if ($_SESSION["lloginDate"]=="lastday") { ?>selected<?php } ?>>Last Day (Last 24 Hours)
							</option>
							<option value="lastweek" <?php if ($_SESSION["lloginDate"]=="lastweek") { ?>selected<?php } ?>>Last Week (Last 7 Days)
							</option>
							<option value="lastmonth" <?php if ($_SESSION["lloginDate"]=="lastmonth") { ?>selected<?php } ?>>Last Month (Last 30 Days)
							</option>
							<option value="lastyear" <?php if ($_SESSION["lloginDate"]=="lastyear") { ?>selected<?php } ?>>Last Year (Last 365 Days)
							</option>
							<option value="Custom" <?php if ($_SESSION["lloginDate"]=="Custom") { ?>selected<?php } ?>>Custom</option>
							</select></td>
							<td width="19%">&nbsp;</td>
							<td width="32%">&nbsp;</td>
						</tr>
						<tr id="loginDateRow"  <?php if ($_SESSION["lloginDate"]!="Custom") { ?> style="display:none" <?php } ?> >
							<td width="19%"><font face="Verdana" size="1">Login Date 
							Range</font></td>
							<td width="21%"><font size="1" face="Verdana">
                                                    <input id="demo23" maxlength="25" size="20" name="fromDate" type="text" value='<?php echo $_SESSION["fromDate"]; ?>'>
                                                     <a href="javascript:NewCssCal('demo23','yyyymmdd','dropdown',true,24,false)">
                                                        <img src="Calendar/cal.gif" alt="Pick a date" width="16" height="16" border="0"></a>
</b>&nbsp;</font></td>
							<td width="3%"><font size="1" face="Verdana">
                                                    <b>- </b>
                                                    &nbsp;
</b></font></td>
							<td width="19%"><font size="1" face="Verdana">
                                                    <input id="demo24" maxlength="25" size="20" name="toDate" type="text" value='<?php echo $_SESSION["toDate"]; ?>'>
                                                     <a href="javascript:NewCssCal('demo24','yyyymmdd','dropdown',true,24,false)">
                                                        <img src="Calendar/cal.gif" alt="Pick a date" width="16" height="16" border="0"></a></font></td>
							<td width="32%">&nbsp;</td>
						</tr>
						<tr>
							<td width="25%">&nbsp;</td>
							<td width="22%" colspan="2">
							&nbsp;</td>
							<td width="19%">&nbsp;</td>
							<td width="32%">&nbsp;</td>
						</tr>
						<tr>
							<td width="100%" colspan="5" align="center" height="30">
							<input type="submit" value="Submit" name="B1" onclick="return Validate();"><input type="reset" value="Reset" name="B2"></td>
						</tr>
					</table>
				</td>
				</tr>
			
				</table>
			
		</div>
			
		</td>
			</tr>
		</table></form> 
	<tr>
		<td width="81%" align=center height="1" valign="top">
		
          
				

		<tr>
		<td width="81%" align=center height="1" valign="top">
		
          
		</td>
	</tr>
	<tr>
		<td width="81%" align=left height="1">
		
       
		<div style="width: 90%;">
		<font face=verdana size=2>
	<center><?php 
	if ($RecordCount>0) {

	print "$RecordCount record(s) founds - You are at page $PageNo  of $MaxPage"; 
	}
	?></center></font>

<div style="padding:0px 0px 30px 30px;">                
<?php 
if ($RecordCount>0) {

 $result = $con->viewCurrentLoginSpecificPage($gateway,$user_name,$destination_user_name,$source_host,$destination_host,$service_text,$direction,$am_status_code_text,$fromDate,$toDate,"","","ON",$sort,$how,$StartRow,$PageSize,$cn);
?>
               
<table width="100%" border="0" class="InternalHeader">
  <tr>
    <td>

      <div align="center"> <font face=verdana size=2>
      <?php
        //Print First & Previous Link is necessary
      
          if ($PageNo!=1)
            $PrevStart = $PageNo - 1;
          else 
          	$PrevStart = 1;
            print "<a href=index.php?PageNo=1&sort=$sort&how=$np&totalpages=$PageSize><< First </a> : ";
            print "<a href=index.php?PageNo=$PrevStart&sort=$sort&how=$np&totalpages=$PageSize>< Previous </a>";
        
        print " [ ";
        $c = 0;

        //Print Page No
        for($c=$CounterStart;$c<=$CounterEnd;$c++){
            if($c < $MaxPage){
                if($c == $PageNo){
                    if($c % $PageSize == 0){
                        print "$c ";
                    }else{
                        print "$c ,";
                    }
                }elseif($c % $PageSize == 0){
                    echo "<a href=index.php?PageNo=$c&sort=$sort&how=$np&totalpages=$PageSize>$c</a> ";
                }else{
                    echo "<a href=index.php?PageNo=$c&sort=$sort&how=$np&totalpages=$PageSize>$c</a> ,";
                }//END IF
            }else{
                if($PageNo == $MaxPage){
                    print "$c ";
                    break;
                }else{
                    echo "<a href=index.php?PageNo=$c&sort=$sort&how=$np&totalpages=$PageSize>$c</a> ";
                    break;
                }//END IF
            }//END IF
       }//NEXT

      echo "] ";

      if($PageNo < $MaxPage)
          $NextPage = $PageNo + 1;
       else
      		$NextPage=$MaxPage;
          echo "<a href=index.php?PageNo=$NextPage&sort=$sort&how=$np&totalpages=$PageSize>Next ></a>";
      

      //Print Last link if necessary
      if($CounterEnd < $MaxPage){
       $LastRec = $RecordCount % $PageSize;
        if($LastRec == 0){
            $LastStartRecord = $RecordCount - $PageSize;
        }
        else{
            $LastStartRecord = $RecordCount - $LastRec;
        }
}
        print " : ";
        echo "<a href=index.php?PageNo=$MaxPage&sort=$sort&how=$np&totalpages=$PageSize>Last >></a>";
        
      ?>
</font>
      </div>
    </td>
  </tr>
</table>
<br>
<div align="center">
<table border="0" width="100%" id="table25">
	<tr>
		<td width="25%">&nbsp;</td>
		<td width="66%">
     	
			<p align="right"><font size="1" face="Verdana">No of Records /Page</font></td>
		<td width="8%">
		<p align="center">
     	
          
				

			<select size="1" name="totalpages" style="font-size: 8pt; font-family: Verdana" onchange="javascript:getURL(this.value);">
			<option value="100" <?php if ($PageSize==200) {?>selected <?php } ?>>100</option>
			<option value="200" <?php if ($PageSize==200) {?>selected <?php } ?>>200</option>
			<option value="300" <?php if ($PageSize==300) {?>selected <?php } ?>>300</option>
			<option value="500" <?php if ($PageSize==500) {?>selected <?php } ?>>500</option>
			<option value="1000" <?php if ($PageSize==1000) {?>selected <?php } ?>>1000</option>
			</select></td>
	</tr>
	<tr>
		<td colspan="3">
		<table width="100%" Border="1" class="NormalTableTwo" style="border-collapse: collapse">
  <tr>
    <td class="InternalHeader" width="4%" bgcolor="#E1ECF9"><center><B>
	<font size="1" face="Verdana">No</font></B></center></td>
    <td class="InternalHeader" width="4%" bgcolor="#E1ECF9"><center>
	<a href="<?php echo $_SERVER["PHP_SELF"]."?page=index.php&PageNo=".$PageNo."&sort=source_user&totalpages=$PageSize&how=".$how; ?>" style="text-decoration: none">
	<font color="#000000" size="1">
	
	<img src='<?php 
	if ($sort=="source_user" and $how=="ASC")
		echo $aimg;
	else if ($sort=="source_user" and $how=="DESC")
		echo $dimg;
	else 
		echo $nimg;?>' border=0>
	</font>
	<B><font size="1" face="Verdana" color="#000000">Source User</font></B></a></center></td>
    <td class="InternalHeader" width="4%" bgcolor="#E1ECF9"><center><B>
	<a href="<?php echo $_SERVER["PHP_SELF"]."?page=index.php&PageNo=".$PageNo."&sort=remote_user&totalpages=$PageSize&how=".$how; ?>" style="text-decoration: none">
	<font size="1" face="Verdana" color="#000000">
	<img src='<?php 
	if ($sort=="remote_user" and $how=="ASC")
		echo $aimg;
	else if ($sort=="remote_user" and $how=="DESC")
		echo $dimg;
	else 
		echo $nimg;?>' border=0>
	Remote User</font></a></B></center></td>
    <td class="InternalHeader" width="20%" bgcolor="#E1ECF9"><center><B>
	<a href="<?php echo $_SERVER["PHP_SELF"]."?page=index.php&PageNo=".$PageNo."&sort=source_host&totalpages=$PageSize&how=".$how; ?>" style="text-decoration: none">
	<font size="1" face="Verdana" color="#000000">
	<img src='<?php 
	if ($sort=="source_host" and $how=="ASC")
		echo $aimg;
	else if ($sort=="source_host" and $how=="DESC")
		echo $dimg;
	else 
		echo $nimg;?>' border=0>
	Source Host</font></a></B></center></td>
    <td class="InternalHeader" width="20%" bgcolor="#E1ECF9"><center><B>
	<a href="<?php echo $_SERVER["PHP_SELF"]."?page=index.php&PageNo=".$PageNo."&sort=remote_host&totalpages=$PageSize&how=".$how; ?>" style="text-decoration: none">
	<font size="1" face="Verdana" color="#000000">
	<img src='<?php 
	if ($sort=="remote_host" and $how=="ASC")
		echo $aimg;
	else if ($sort=="remote_host" and $how=="DESC")
		echo $dimg;
	else 
		echo $nimg;?>' border=0>
	Remote Host</font></a></B></center></td>
    <td class="InternalHeader" width="5%" bgcolor="#E1ECF9"><center><B>
	<a href="<?php echo $_SERVER["PHP_SELF"]."?page=index.php&PageNo=".$PageNo."&sort=gw_name&totalpages=$PageSize&how=".$how; ?>" style="text-decoration: none">
	<font size="1" face="Verdana" color="#000000">
	<img src='<?php 
	if ($sort=="gw_name" and $how=="ASC")
		echo $aimg;
	else if ($sort=="gw_name" and $how=="DESC")
		echo $dimg;
	else 
		echo $nimg;?>' border=0>
	Gateway</font></a></B></center></td>
    <td class="InternalHeader" width="5%" bgcolor="#E1ECF9"><center><B>
	<a href="<?php echo $_SERVER["PHP_SELF"]."?page=index.php&PageNo=".$PageNo."&sort=login&totalpages=$PageSize&how=".$how; ?>" style="text-decoration: none">
	<font size="1" face="Verdana" color="#000000">
	<img src='<?php 
	if ($sort=="login" and $how=="ASC")
		echo $aimg;
	else if ($sort=="login" and $how=="DESC")
		echo $dimg;
	else 
		echo $nimg;?>' border=0>
	Login</font></a></B></center></td>
    <td class="InternalHeader" width="5%" bgcolor="#E1ECF9"><center><B>
	<a href="<?php echo $_SERVER["PHP_SELF"]."?page=index.php&PageNo=".$PageNo."&sort=name&totalpages=$PageSize&how=".$how; ?>" style="text-decoration: none">
	<font size="1" face="Verdana" color="#000000">
	
	<img src='<?php 
	if ($sort=="name" and $how=="ASC")
		echo $aimg;
	else if ($sort=="name" and $how=="DESC")
		echo $dimg;
	else 
		echo $nimg;?>' border=0>
	Service</font></a></B></center></td>
    <td class="InternalHeader" width="5%" bgcolor="#E1ECF9"><center><B>
	<a href="<?php echo $_SERVER["PHP_SELF"]."?page=index.php&PageNo=".$PageNo."&sort=direction&totalpages=$PageSize&how=".$how; ?>" style="text-decoration: none">
	<font size="1" face="Verdana" color="#000000">
	<img src='<?php 
	if ($sort=="direction" and $how=="ASC")
		echo $aimg;
	else if ($sort=="direction" and $how=="DESC")
		echo $dimg;
	else 
		echo $nimg;?>' border=0>


	Direction</font></a></B></center></td>
	<td class="InternalHeader" width="5%" bgcolor="#E1ECF9"><center><B>
	<a href="<?php echo $_SERVER["PHP_SELF"]."?page=index.php&PageNo=".$PageNo."&sort=amd&totalpages=$PageSize&how=".$how; ?>" style="text-decoration: none">
	<font size="1" face="Verdana" color="#000000">
	<img src='<?php 
	if ($sort=="amd" and $how=="ASC")
		echo $aimg;
	else if ($sort=="amd" and $how=="DESC")
		echo $dimg;
	else 
		echo $nimg;?>' border=0>
	AM Status</font></a></B></center></td>



  </tr>

<?php
$i = 1;

while ($row = mysql_fetch_array($result, MYSQL_NUM)) {

    $bil = $i + ($PageNo-1)*$PageSize;
    $div = $bil%2;
      if (($bil%2)==0)
    	$bgCol = "#EDF5FF";
   	else
   		 $bgCol = "#FFFFFF";
  
?>
  <tr bgcolor="<?php echo $bgCol;?>">
    <td class="NormalFieldTwo" width="4%"><font size="1" face="Verdana"><?php echo $bil; ?></font></td>
    <td class="NormalFieldTwo" width="4%"><font size="1" face="Verdana"><?php echo $row[0]; ?></font></td>
    <td class="NormalFieldTwo" width="4%"><font size="1" face="Verdana"><?php echo $row[1]; ?></font></td>
    <td class="NormalFieldTwo" width="20%"><font size="1" face="Verdana"><?php echo $row[2]; ?></font></td>
    <td class="NormalFieldTwo" width="20%"><font size="1" face="Verdana"><?php echo $row[3]; ?></font></td>
    <td class="NormalFieldTwo" width="5%"><font size="1" face="Verdana"><?php echo $row[4]; ?></font></td>
    <td class="NormalFieldTwo" width="4%"><font size="1" face="Verdana"><?php echo $row[5]; ?></font></td>
    <td class="NormalFieldTwo" width="4%"><font size="1" face="Verdana"><?php echo $row[6]; ?></font></td>
    <td class="NormalFieldTwo" width="20%"><font size="1" face="Verdana"><?php echo $row[7]; ?></font></td>
    <td class="NormalFieldTwo" width="20%"><font size="1" face="Verdana"><?php echo $row[9]; ?></font></td>
 
  </tr>
<?php
  $i++;
}?>
</table></td>
	</tr>
</table>
</div>
<br>
<table width="100%" border="0" class="InternalHeader">
  <tr>
    <td>

      <div align="center"> <font face=verdana size=2>
          <?php
        //Print First & Previous Link is necessary
      
          if ($PageNo!=1)
            $PrevStart = $PageNo - 1;
          else 
          	$PrevStart = 1;
            print "<a href=index.php?PageNo=1&sort=$sort&how=$np&totalpages=$PageSize><< First </a> : ";
            print "<a href=index.php?PageNo=$PrevStart&sort=$sort&how=$np&totalpages=$PageSize>< Previous </a>";
        
        print " [ ";
        $c = 0;

        //Print Page No
        for($c=$CounterStart;$c<=$CounterEnd;$c++){
            if($c < $MaxPage){
                if($c == $PageNo){
                    if($c % $PageSize == 0){
                        print "$c ";
                    }else{
                        print "$c ,";
                    }
                }elseif($c % $PageSize == 0){
                    echo "<a href=index.php?PageNo=$c&sort=$sort&how=$np&totalpages=$PageSize>$c</a> ";
                }else{
                    echo "<a href=index.php?PageNo=$c&sort=$sort&how=$np&totalpages=$PageSize>$c</a> ,";
                }//END IF
            }else{
                if($PageNo == $MaxPage){
                    print "$c ";
                    break;
                }else{
                    echo "<a href=index.php?PageNo=$c&sort=$sort&how=$np&totalpages=$PageSize>$c</a> ";
                    break;
                }//END IF
            }//END IF
       }//NEXT

      echo "] ";

      if($PageNo < $MaxPage)
          $NextPage = $PageNo + 1;
       else
      		$NextPage=$MaxPage;
          echo "<a href=index.php?PageNo=$NextPage&sort=$sort&how=$np&totalpages=$PageSize>Next ></a>";
      

      //Print Last link if necessary
      if($CounterEnd < $MaxPage){
       $LastRec = $RecordCount % $PageSize;
        if($LastRec == 0){
            $LastStartRecord = $RecordCount - $PageSize;
        }
        else{
            $LastStartRecord = $RecordCount - $LastRec;
        }
}
        print " : ";
        echo "<a href=index.php?PageNo=$MaxPage&sort=$sort&how=$np&totalpages=$PageSize>Last >></a>";
        
      ?></font>
      </div>
    </td>
  </tr>
</table>
<?php
    mysql_free_result($result);
 }
 else {
 echo "<font face=verdana size=2 color=red><b><center>No Record Found</center></b></font>";
 }
    mysql_free_result($TRecord);
    
?>
    

    
</div>   		</td>
	</tr>
	<tr>
		<td width="81%" align=center height="1">
		
          
				

		</td>
	</tr>
	<tr>
		<td width="81%" align=center height="1">
		
          
				

		</td>
	</tr>
	<tr>
		<td width="81%" align=center height="9">
		
          
				

		</td>
	</tr>
	<tr>
		<td width="81%" align=center height="9">
		
          
				

		</td>
	</tr>
	<tr>
		<td width="81%" align=center height="9">
		
          
				

		</td>
	</tr>
	<tr>
		<td width="81%" align=center height="9">
		
          
				

		</td>
	</tr>
	<tr>
		<td width="97%" colspan="3" height="26"><hr></td>
	</tr>
</table>


</body>
</html>
