<?php 
include("Config/config.inc.php");
if (!$_SESSION) {
session_start();
}

$count = $_SESSION["gw_loop"];
$image_name = $_SESSION["image_name"];
if ($_SESSION["gw_url"]=="gw_load_criteria.php") 
	$link_text = "direction:Incoming,from:lastyear";
else
$link_text = $_SESSION["link_text"];
echo " <map name=pieChart127010033813264224.png>";
for ($i=0;$i<$count;$i++) {
	$poly_string = $_SESSION["gw_load_bar".$i];
	$labelName = $_SESSION["gw_load_labels".$i]; 
	echo "<area shape=RECT coords=\"$poly_string\" title='$labelName' href='gw_detail_load_graph.php?criteria=$link_text&gw=$labelName'>";
}
echo "</map>";
?>
<p>
<img border="0" src="<?php echo  $chart_path;?><?php echo $image_name;?>" usemap="#pieChart127010033813264224.png"></p>
