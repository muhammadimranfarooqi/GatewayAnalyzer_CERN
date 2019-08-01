<?php
session_start();

if ($_GET) {
include 'classes/Controller.php';
$con = new Controller();
$graph_type = $_GET["gt"];


/*$gateway = $_SESSION["gateway"]; 
$user_name=$_SESSION["user_name"]; 
$source_host = $_SESSION["source_host"]; 
$destination_host=$_SESSION["destination_host"]; 
$service=$_SESSION["service"]; 
$service_text=$_SESSION["service_text"]; 
$direction=$_SESSION["direction"]; 
$am_status_code=$_SESSION["am_status_code"]; 
$am_status_code_text=$_SESSION["am_status_code_text"]; 
$fromDate=$_SESSION["fromDate"];
$toDate=$_SESSION["toDate"];*/
$gateway = $_SESSION["shgateway"]; 
$user_name =  $_SESSION["shuser_name"]; 
$destination_user_name =  $_SESSION["shdestination_user_name"]; 
$source_host = $_SESSION["shsource_host"] ; 
$destination_host =  $_SESSION["shdestination_host"]; 
$service = $_SESSION["shservice"]; 
$service_text =  $_SESSION["shservice_text"]; 
$direction = $_SESSION["shdirection"]; 
$am_status_code= $_SESSION["sham_status_code"]; 
$am_status_code_text= $_SESSION["sham_status_code_text"]; 
$loginDate = $_SESSION["shloginDate"];
$fromDate= $_SESSION["shfromDate"];
$toDate= $_SESSION["shtoDate"];
$logoutDate = $_SESSION["shlogoutDate"];
$logoutFromDate= $_SESSION["shlogoutFromDate"];
$logoutToDate= $_SESSION["shlogoutToDate"];

$graph_file_name=$_SESSION["graph_file_name"];
}
$result = $con->viewStatisticsHistoryLoad($gateway,$user_name,$source_host,$destination_host,$service,$direction,$am_status_code,$fromDate,$toDate);
$total=0;

$num_rows = mysql_num_rows($result);
if ($num_rows!=0) {

$polyFile='polygons_points/statistics_history_load_points.php';
 $link_text = $_SESSION["link_text"];
$urlType = $_SESSION["historyBased"];
if ($urlType== "per_month") {
$url = "gw_history_detail.php?criteria=$link_text";
}
else {
$url = "gw_history_detail_graph.php?criteria=$graph_file_name";

}

if ($_GET) {

$con->generateHistoryChart($graph_type,$gateway,$user_name,$source_host,$destination_host,$service,$direction,$am_status_code,$fromDate,$toDate,$graph_file_name,$gateway,chart_path);

if ($graph_type=="pie_chart") {
$polyFile='polygons_points/statistics_history_load_points.php';
}
else {
$polyFile='polygons_points/statistics_history_load_bar_points.php';
}

}


			
?>
<table border="0" width="100%" style="border-collapse: collapse" id="table18" cellspacing="2" cellpadding="3">
				<tr>
					<td bgcolor="#EFEFEF" width="50%" height="97">
					<?php 
					include $polyFile;
					?></td>
					<td width="50%" height="97">
					<div align="center">
						<table border="1" width="80%" style="border-collapse: collapse" id="table30" bordercolor="#D7D1E4">
							<tr>
								<td>
					<div align="center">
					
						<table border="0" width="100%" id="table31" cellpadding="3">
							<tr>
								<td align="center" width="50%" background="images/15.jpg" colspan="2">
								<b><font face="Verdana" size="2">Gateway</font></b></td>
								<td align="center" width="50%" background="images/15.jpg" colspan="2">
								<b><font face="Verdana" size="2">No. of Logins</font></b></td>
							</tr>
							<?php
							$i=1;
							$count=0;
							while ( $row = mysql_fetch_array($result) )  {
							
							 if ($gateway!="") {
							 	$mon            =     date("M", strtotime($row["login"]));  
    							$yr 			= 	  date('Y', strtotime($row["login"]));
							

								?>
							<tr>
								<td align="left" width="5%"></td>
								<td align="left" width="35%"><font face="Verdana" size="2"><a href='<?php echo $url."&id=".$mon."-".$yr;?>'><?php  echo $mon."-".$yr;?></a></font></td>
								<td align="center" width="12%"></td>
								<td align="left" width="38%"><font face="Verdana" size="2"><?php echo $row["total_login"];?></font></td>
							</tr>
							<?php
							}
							else
							{
							?>
							<tr>
								<td align="left" width="5%"></td>
								<td align="left" width="35%"><font face="Verdana" size="2"><a href="history_detail_load_graph.php?gw=<?php echo $row[2];?>"><?php echo $row["gw_name"];?></a></font></td>
								<td align="center" width="12%"></td>
								<td align="left" width="38%"><font face="Verdana" size="2"><?php echo $row["total_login"];?></font></td>
							</tr>

							<?php
							}
							$count=$count+$row["total_login"];
							}
							?>
							<tr>
								<td align="left" width="90%" colspan="4" height="1%">
								<hr size="1"></td>
							</tr>

							<tr>
								<td align="left" width="5%"></td>
								<td align="left" width="35%"><font face="Verdana" size="2">Total</font></td>
								<td align="center" width="12%"></td>
								<td align="left" width="38%"><font face="Verdana" size="2"><?php echo $count;?></font></td>
							</tr>

						</table>
						
					</div>
								</td>
							</tr>
						</table>
					</div>
					</td>
				</tr>
				</table>
				<?php
				}
				else {				
				echo "<br><BR><BR><font face=verdana size=2 color=red><b><center>No record Found</center></b></font><br><BR><BR>";
				}
				?>