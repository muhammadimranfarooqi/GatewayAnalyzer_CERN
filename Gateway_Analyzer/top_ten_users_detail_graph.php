<?php
session_start();

$polyFile="";


include 'classes/Controller.php';
include("Config/config.inc.php");
$con = new Controller();
//echo $_SESSION["ucount"];
$cn = $con->getDBConnection($mysql_user,$mysql_pass,$mysql_host,$mysql_db);
if ($_GET) {
$criteria1 = $_GET["criteria"];
$user_id = $_GET["user_name"];

$criteria =$criteria1.",user_name:".$user_id;

$_SESSION["user_id"] = $user_id;
}
else {
$criteria = $_SESSION["criteria"];
$user_id= $_SESSION["user_id"];

}
$_SESSION["link_text"] = $criteria;
$loginStatus = $_SESSION["loginStatus"];

$rs = $con->viewGatewayLoadDetail($criteria,$loginStatus,$cn);
$num_rows = mysql_num_rows($rs);

if ($num_rows>1 ) {
$my_array = array ();
 	while ( $row = mysql_fetch_array($rs) )  {
 	    $my_array[] = $row["count"];
	}

if (count(array_unique($my_array)) == 1) 
	$flag="true";
else
	$flag="false";
//echo $flag;
 if ($flag=="false") {
 	mysql_data_seek($rs ,0);

$con->generateDetailChart("top_ten_users",$user_id,$chart_path,$rs,$cn);
$polyFile='polygons_points/top_ten_users_detail_bar_points.php';
	}
}
$_SESSION["user_detail"]=$_SERVER['REQUEST_URI'];
//echo $SESSION["user_detail"];
$total=0;
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
		
            <p align="left"><font color="#800000"><b>GATEWAY LOAD</b></font></td>
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
		
          
			<div id="detailDiv">	

		<table border="1" width="100%" style="border-collapse: collapse" id="table2" bordercolor="#D7D1E4">
			<tr>
				<td>
		
          
				

		<table border="0" width="100%" id="table17" cellspacing="0">
			<tr>
				<td background="images/15-green.jpg" width="48%" height="28">
					<font size="1" face="Verdana"><b>
					Gateway <blink>(<?php echo $user_id;?>)</blink> Load Per Month Statistics&nbsp; </b>(<a style="text-decoration: none" href='<?php echo $_SESSION["user_url"];?>'><img border="0" src="images/back_arrow.jpg" width="9" height="12">
					Back to 
					Main View</a>)</font></td>
				<td background="images/15-green.jpg" width="51%" height="28">
		&nbsp;</td>
				</tr>
			<tr>
				<td colspan="2">
		<div id="mainDiv0">
          
				<table border="0" width="100%" style="border-collapse: collapse" id="table32" cellspacing="2" cellpadding="3">
				<tr>
					<td bgcolor="#EFEFEF" width="50%" height="97">
					<?php 
					if ($polyFile=="")
						echo "<center><font face=verdana size=1 color=red>Graph can not be generated due to small data range</font></center>";
					else 
						include $polyFile;
					?></td>
					<td width="50%" height="97">
					<div align="center">
						<table border="1" width="80%" style="border-collapse: collapse" id="table33" bordercolor="#D7D1E4">
							<tr>
								<td>
					<div align="center">
						<table border="0" width="100%" id="table34" cellpadding="3">
							<tr>
								<td align="center" width="50%" background="images/15.jpg" colspan="2">
								<b><font face="Verdana" size="2">Gateway</font></b></td>
								<td align="center" width="50%" background="images/15.jpg" colspan="2">
								<b><font face="Verdana" size="2">No. of Users</font></b></td>
							</tr>
							<?php
							$total=0;
							mysql_data_seek($rs,0);
     						$link_text = $_SESSION["link_text"];
							$groupby = $_SESSION["gw_group"];
							while ( $row = mysql_fetch_array($rs) )  {
									
							 if ($groupby=="ByMonth") {
						    $mon            =     date("M", strtotime($row[login]));  
    						$yr 			= date('Y', strtotime($row[login]));
							$firstCol = "$mon-$yr";
							}
							else {
							$firstCol = $row["gw_name"];
							}
							
							  
								?>
							<tr>
								<td align="left" width="5%"></td>
								<td align="left" width="35%"><font face="Verdana" size="2"><a href="user_load_details.php?criteria=<?php echo $link_text?>&id=<?php echo $firstCol;?>"><?php echo $firstCol;?></a></font></td>
								<td align="center" width="12%"></td>
								<td align="left" width="38%"><font face="Verdana" size="2"><?php echo $row["count"];?></font></td>
							</tr>
							<?php
							$total+=$row["count"];
							}
							
							?>
							
							</tr>
								<tr>
								<td align="left" width="90%" colspan="4" height="1%">
								<hr size="1"></td>
							</tr>

							<tr>
								<td align="left" width="5%"></td>
								<td align="left" width="35%"><font face="Verdana" size="2">Total</font></td>
								<td align="center" width="12%"></td>
								<td align="left" width="38%"><font face="Verdana" size="2"><?php echo $total;?></font></td>
							</tr>

						</table>
					</div>
								</td>
							</tr>
						</table>
					</div>
					</td>
				</tr>
				</table>				</div>
		</td>
				</tr>
			<tr>
				<td colspan="2">
		
		</td>
				</tr>
				</table>
			
		</td>
			</tr>
		</table></div>
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
