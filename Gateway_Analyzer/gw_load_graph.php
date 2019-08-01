<!--<meta http-equiv="refresh" content="90">-->
<?php
include 'classes/Controller.php';
include("Config/config.inc.php");
$con = new Controller();
if (!$_SESSION) {
session_start();
}

if (isset($_GET['gt'])) {
$user_name =  $_SESSION["user_name"]; 
$destination_user_name =  $_SESSION["destination_user_name"]; 
$source_host = $_SESSION["source_host"] ; 
$destination_host =  $_SESSION["destination_host"]; 
$service = $_SESSION["service"]; 
$service_text =  $_SESSION["service_text"]; 
$direction = $_SESSION["direction"]; 
$am_status_code= $_SESSION["am_status_code"]; 
$am_status_code_text= $_SESSION["am_status_code_text"]; 
$fromDate= $_SESSION["fromDate"];
$toDate= $_SESSION["toDate"];
$loginStatus = $_SESSION["loginStatus"];
$logoutFromDate= $_SESSION["logoutFromDate"];
$logoutToDate= $_SESSION["logoutToDate"];
$graph_file_name=$_SESSION["graph_file_name"];


}
$cn = $con->getDBConnection($mysql_user,$mysql_pass,$mysql_host,$mysql_db);
$rs= $con->viewGatewayLoad("",$user_name,$destination_user_name,$source_host,$destination_host,$service,$direction,$am_status_code,$fromDate,$toDate,$logoutFromDate,$logoutToDate,$loginStatus,"gw_name",$cn);
$num = mysql_num_rows($rs);
if ($num>0) {
if (isset($_GET['gt'])) {
$graph_type = $_GET["gt"];
$con->generateChart("gw_load",$graph_type,$chart_path,$rs,$graph_file_name,$cn);
if ($graph_type =="pie_chart") {
$polyFile='polygons_points/gw_load_points.php';
$_SESSION["polyFile"]="pie";
}
else {
$polyFile='polygons_points/gw_load_bar_points.php';
$_SESSION["polyFile"]="bar";
}
}
else {
$con->generateChart("gw_load","pie_chart",$chart_path,$rs,$graph_file_name,$cn);
}

if ($_SESSION["polyFile"]=="pie")
	$polyFile='polygons_points/gw_load_points.php';
else if ($_SESSION["polyFile"]=="bar")
	$polyFile='polygons_points/gw_load_bar_points.php';
}
?>

<?php
$total=0;
?>
<table border="0" width="100%" style="border-collapse: collapse" id="table18" cellspacing="2" cellpadding="3">
				<tr>
					<td bgcolor="#EFEFEF" width="50%" height="97">
					
					<?php 
					if ($num>0) {
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
								<b><font face="Verdana" size="2">
		
Gateway</font></b></td>
								<td align="center" width="50%" background="images/15.jpg" colspan="2">
								<b><font face="Verdana" size="2">
No. of Users</font></b></td>
							</tr>
							<?php
							$i=1;
							$count=0;
						$link_text = $_SESSION["link_text"];

							mysql_data_seek($rs ,0);
							while ($row=mysql_fetch_array($rs))  {
							
							
								?>
							<tr>
								<td align="left" width="5%"></td>
								<td align="left" width="35%"><font face="Verdana" size="2"><a href='gw_detail_load_graph.php?criteria=<?php echo $link_text;?>&gw=<?php echo $row["gw_name"];?>'><?php echo $row["gw_name"];?></a></font></td>
								<td align="center" width="12%"></td>
								<td align="left" width="38%"><font face="Verdana" size="2"><?php echo $row["count"];?></font></td>
							</tr>
							<?php
							
							$count = $count+$row["count"];
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
					<?php 
						}else {
						echo "<font face=verdana size=1 color=red><b><center>No Record Found</center></b></font>";
						}
						?>
					</td>
				</tr>
				</table>
