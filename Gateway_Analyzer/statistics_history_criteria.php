<?php
include "classes/Controller.php";
include("Config/config.inc.php");
session_start();

$con = new Controller();
$cn = $con->getDBConnection($mysql_user,$mysql_pass,$mysql_host,$mysql_db);

$result = $con->viewServices($cn);
$result1 = $con->viewAMStatusCode($cn);
$result2 = $con->viewGateways($cn);

$_SESSION["gwLoad"]="";
$_SESSION["service_load"] = "";
$_SESSION["top_ten_users"] ="";
$_SESSION["direction_load"]="";
$_SESSION["destination_host_load"]="";
$_SESSION["am_return_codes"]="";
$_SESSION["file_name"]="";


$_SESSION["gwLoadBar"] = "";
$_SESSION["service_load_bar"]="";
$_SESSION["top_ten_users_bar"]="";
$_SESSION["direction_load_bar"]="";
$_SESSION["destination_host_load_bar"]="";
$_SESSION["am_return_codes_bar"]="";
$_SESSION["gwLoadDetail"] = "";
$_SESSION["svLoadDetail"]="";
$_SESSION["userLoadDetail"]="";
$_SESSION["dirLoadDetail"]="";
$_SESSION["amLoadDetail"]="";
$_SESSION["destLoadDetail"]="";

?>
<html>

<head>
<meta http-equiv="Content-Language" content="en-us">

<title>ATLAS TDAQ - Gateway Analyzer</title>
<script type="text/javascript" src="resources/selectItem.js"></script>
<script type="text/javascript" src="Calendar/datetimepicker_css.js"></script>


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
function getLogoutRow() {
var str = document.historyForm.loginStatus.checked;
if (str==false) {
	document.getElementById("logoutRow").style.display = '';
	document.historyForm.logoutDate.options[0].selected=true;
	document.historyForm.logoutFromDate.value="";
 }
else {
	document.getElementById("logoutRow").style.display = 'none';
	document.getElementById("logoutDateRow").style.display='none';
	}
}
function getLogoutDate(str) {
if (str=="Custom") {
	document.getElementById("logoutDateRow").style.display = '';
	document.historyForm.logoutFromDate.value='<?php print $_SESSION[customLogoutFromDate];?>';
	document.historyForm.logoutToDate.value='<?php print $_SESSION["customLogoutToDate"];?>';

	}
else {
	document.getElementById("logoutDateRow").style.display = 'none';
	document.historyForm.logoutFromDate.value="";
	document.historyForm.logoutToDate.value="";
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
var loginDate =  document.historyForm.loginDate.value;
var fromDate = document.historyForm.fromDate.value;
var toDate = document.historyForm.toDate.value;
var logoutDate =  document.historyForm.logoutDate.value;
var logoutFromDate = document.historyForm.logoutFromDate.value;
var logoutToDate = document.historyForm.logoutToDate.value;
if (gateway=="" && user_name=="" && destination_user_name=="" && source_host=="" && destination_host=="" && service=="Select" && direction=="Select" && am_status_code=="Select" && loginDate=="Select"  && fromDate=="" && toDate=="" && logoutDate=="Select" && logoutFromDate==""  && logoutToDate=="") {
	alert("Please enter some criteria")
	document.historyForm.gateway.focus()
	return false;
}
if (loginDate=="Custom") {
	if (fromDate=="" || toDate=="") {
	alert("Please enter login date range")
	document.historyForm.fromDate.focus()
	return false;

	}
}
if (logoutDate=="Custom") {
	if (logoutFromDate=="" || logoutToDate=="") {
	alert("Please enter logout date range")
	document.historyForm.logoutFromDate.focus()
	return false;

	}
}

if (document.historyForm.fromDate.value!="" && document.historyForm.toDate.value!="") {

  var yr1 =  parseInt(fromDate.substring(0,4),10);
  var mon1  = parseInt(fromDate.substring(5,7),10);
  var dt1 = parseInt(fromDate.substring(8,10),10);

  var yr2 =  parseInt(toDate.substring(0,4),10);
  var mon2  = parseInt(toDate.substring(5,7),10);
  var dt2 = parseInt(toDate.substring(8,10),10);

 // var mon2  = parseInt(toDate.substring(0,2),10);
 // var dt2 = parseInt(toDate.substring(3,5),10);
//  var yr2  = parseInt(toDate.substring(6,10),10);
  var date1 = new Date(yr1, mon1-1, dt1);
  var date2 = new Date(yr2, mon2-1, dt2);
  
  if(date2 < date1)
    {
    alert("From date cannot be greater than End date")
    document.historyForm.toDate.focus()
	return false;
    } 
}	

if (document.historyForm.logoutFromDate.value!="" && document.historyForm.logoutToDate.value!="") {
	
  var yr3 =  parseInt(logoutFromDate.substring(0,4),10);
  var mon3  = parseInt(logoutFromDate.substring(5,7),10);
  var dt3 = parseInt(logoutFromDate.substring(8,10),10);

  var yr4 =  parseInt(logoutToDate.substring(0,4),10);
  var mon4  = parseInt(logoutToDate.substring(5,7),10);
  var dt4 = parseInt(logoutToDate.substring(8,10),10);

  var date3 = new Date(yr3, mon3-1, dt3);
  var date4 = new Date(yr4, mon4-1, dt4);
  if(date4 < date3)
    {
    alert("Logout From date cannot be greater than Logout End date")
    document.historyForm.logoutToDate.focus()
	return false;
    } 
}	



}
</script>

</head>

<body topmargin="0" leftmargin="0">
 

<table border="0" width="100%" id="table1" height="322" cellspacing="0">
	<tr>
		<td colspan="3" height="1%">
		<img border="0" src="images/gw-banner.jpg" width="100%" height="58"></td>
	</tr>
	<tr>
		<td width="15%" bgcolor="#E5E3F0" rowspan="9" valign="top">
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
				<td><div align="center">
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
		<td width="1%" align=center height="21">
		
           
		</td>
		<td width="83%" align=center height="21">
		
            <p align="left"><font color="#800000"><b>STATISTICS HISTORY</b></font></td>
	</tr>
	<tr>
		<td width="1%" align=center height="21">
		
           
		&nbsp;</td>
		<td width="83%" align=center height="21">
		
            <hr>
		
            </td>
	</tr>
	<tr>
		<td width="1%" align=center height="21">
		
           
		&nbsp;</td>
		<td width="83%" align=center height="21">
		
           &nbsp;</td>
	</tr>
	<tr>
		<td width="1%" align=center height="21">
		
           
		&nbsp;</td>
		<td width="83%" align=center height="21" valign="top">
		
           <form method="POST" action="statistics_history_load.php" name="historyForm">

		<table border="1" width="60%" style="border-collapse: collapse" id="table22" bordercolor="#D7D1E4" cellspacing="1" cellpadding="0">
			<tr>
				<td>
		
          
				

		<div align="center">
		
          
				
		<table border="0" width="100%" id="table23" cellpadding="2" cellspacing="0">
			<tr>
				<td background="images/15-green.jpg" width="50%" height="28">
					<font size="1" face="Verdana"><b>
					Select Criteria to Search Statistics</b></font></td>
				<td background="images/15-green.jpg" width="51%" height="28">
		&nbsp;</td>
				</tr>
			<tr>
				<td width="99%" height="28" colspan="2">
					<table border="0" width="100%" id="table24" cellspacing="3" cellpadding="2">
						<tr>
							<td width="36%"><font face="Verdana" size="1">
							Gateway</font></td>
							<td width="59%">
							<select size="1" name="gateway_list" onchange="document.historyForm.gateway.value=this[this.selectedIndex].text;">
							<option value="Select">Select</option>
							<?php
							while ($row=$con->getTotalData($result2,$cn)) {
							?>
							<option value="<?php echo $row["id"];?>"><?php echo $row["name"];?></option>
							<?php
							}
							?>
							</select><input type="hidden" name="gateway" size="20"></td>
						</tr>
						<tr>
							<td width="36%"><font face="Verdana" size="1">Source User</font></td>
							<td width="59%">
							
							
								<p>
								<input type="text" name="user_name" size="20"></p></td>
						</tr>
						<tr>
							<td width="36%"><font face="Verdana" size="1">
							Destination User</font></td>
							<td width="59%">
							
							
								<input type="text" name="destination_user_name" size="20"></td>
						</tr>
						<tr>
							<td width="36%"><font face="Verdana" size="1">Source 
							Host</font></td>
							<td width="59%">
							<input type="text" name="source_host" size="20"></td>
						</tr>
						<tr>
							<td width="36%"><font face="Verdana" size="1">
							Destination Host</font></td>
							<td width="59%">
							<input type="text" name="destination_host" size="20"></td>
						</tr>
						<tr>
							<td width="36%"><font face="Verdana" size="1">
							Service</font></td>
							<td width="59%"><select size="1" name="service" onchange="document.historyForm.service_text.value=this[this.selectedIndex].text;">
							<option value="Select">Select</option>
							<?php
							while ($row=$con->getTotalData($result,$cn)) {
							?>
							<option value="<?php echo $row["id"];?>"><?php echo $row["name"];?></option>
							<?php
							}
							?>
							</select><input type="hidden" name="service_text" size="20"></td>
						</tr>
						<tr>
							<td width="36%"><font face="Verdana" size="1">
							Direction</font></td>
							<td width="59%"><select size="1" name="direction">
							<option value="Select">Select</option>
							<option value="Incoming">Incoming</option>
							<option value="Outgoing">Outgoing</option>
							</select></td>
						</tr>
						<tr>
							<td width="36%"><font face="Verdana" size="1">AM 
							Status Code</font></td>
							<td width="59%">
							<select size="1" name="am_status_code" onchange="document.historyForm.am_status_code_text.value=this[this.selectedIndex].text;">
							<option value="Select">Select</option>
							<?php
							while ($row=$con->getTotalData($result1,$cn)) {
							?>
							<option value="<?php echo $row["am_id"];?>"><?php echo $row["am_return_code_description"];?></option>
							<?php
							}
							?>

							</select><input type="hidden" name="am_status_code_text" size="20"></td>
						</tr>
						<tr>
							<td width="36%"><font face="Verdana" size="1">Login 
							Date</font></td>
							<td width="59%">
							<font face="Verdana" size="1">
							<select size="1" name="loginDate" onchange="javascript:getLoginDate(this.value);">
							<option value="Select" selected>Select</option>
							<option value="lastday">Last Day (Last 24 Hours)
							</option>
							<option value="lastweek">Last Week (Last 7 Days)</option>
							<option value="lastmonth">Last Month (Last 30 Days)
							</option>
							<option value="lastyear">Last Year (Last 365 Days)
							</option>
							<option value="Custom">Custom</option>
							</select></font></td>
						</tr>
						<tr id="loginDateRow"  <?php if ($_SESSION["gloginDate"]!="Custom") { ?> style="display:none" <?php } ?>>
							<td width="36%"><font face="Verdana" size="1">Login Date 
							Range</font></td>
							<td width="59%"><font size="1" face="Verdana">
                                                    <input id="demo23" maxlength="25" size="20" name="fromDate" type="text">
                                                     <a href="javascript:NewCssCal('demo23','yyyymmdd','dropdown',true,24,false)">
                                                        <img src="Calendar/cal.gif" alt="Pick a date" width="16" height="16" border="0"></a>
</b>&nbsp;<b>- </b>
                                                    <input id="demo24" maxlength="25" size="20" name="toDate" type="text">
                                                     <a href="javascript:NewCssCal('demo24','yyyymmdd','dropdown',true,24,false)">
                                                        <img src="Calendar/cal.gif" alt="Pick a date" width="16" height="16" border="0"></a>
</b></font></td>
						</tr>
						<tr>
							<td width="19%" height="28">
							<font face="Verdana" size="1">Logout Date</font></td>
							<td width="21%" height="28">
							<select size="1" name="logoutDate" onchange="javascript:getLogoutDate(this.value);">
							<option value="Select"  <?php if ($_SESSION["hlogoutDate"]=="Select") { ?>selected<?php } ?>>
							Select</option>
							<option value="lastday" <?php if ($_SESSION["hlogoutDate"]=="lastday") { ?>selected<?php } ?>>
							Last Day (Last 24 Hours)
							</option>
							<option value="lastweek" <?php if ($_SESSION["hlogoutDate"]=="lastweek") { ?>selected<?php } ?>>
							Last Week (Last 7 Days)
							</option>
							<option value="lastmonth" <?php if ($_SESSION["hlogoutDate"]=="lastmonth") { ?>selected<?php } ?>>
							Last Month (Last 30 Days)
							</option>
							<option value="lastyear" <?php if ($_SESSION["hlogoutDate"]=="lastyear") { ?>selected<?php } ?>>Last Year (Last 365 Days)
							</option>
							<option value="Custom" <?php if ($_SESSION["hlogoutDate"]=="Custom") { ?>selected<?php } ?>>
							Custom</option>
							</select></td>
						</tr>
						<tr style="display:none" id="logoutDateRow">
							<td width="36%"><font face="Verdana" size="1">Logout 
							Date Range</font></td>
							<td width="59%"><font size="1" face="Verdana">
                                                    <input id="demo25" maxlength="25" size="20" name="logoutFromDate" type="text">
                                                     <a href="javascript:NewCssCal('demo25','yyyymmdd','dropdown',true,24,false)">
                                                        <img src="Calendar/cal.gif" alt="Pick a date" width="16" height="16" border="0"></a>
</b>&nbsp;<b>- </b>
                                                    <input id="demo26" maxlength="25" size="20" name="logoutToDate" type="text">
                                                     <a href="javascript:NewCssCal('demo26','yyyymmdd','dropdown',true,24,false)">
                                                        <img src="Calendar/cal.gif" alt="Pick a date" width="16" height="16" border="0"></a>
</b></font></td>
						</tr>
						<tr>
							<td width="100%" colspan="2" align="center" height="30">
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
		</td>
	</tr>
	<tr>
		<td width="100%" colspan="3" height="18"><hr></td>
	</tr>
</table>

</body>
</html>