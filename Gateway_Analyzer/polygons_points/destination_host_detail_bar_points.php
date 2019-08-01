<?php
include("Config/config.inc.php");

$count = $_SESSION["dh_loop"];
$criteria = $_SESSION["destination_host_criteria"];
$c_user = $_SERVER["PHP_AUTH_USER"];
$image_name = $c_user."destination_host_".$_SESSION["dest_id"]."_bar_load.png";
$link_text = $_SESSION["link_text"];

echo " <map name=pieChart127010033813264224.png>";
for ($i=0;$i<$count;$i++) {
	$poly_string = $_SESSION[$c_user."destination_host_".$criteria."_bar_load".$i];
	$labelName = $_SESSION[$c_user."destination_host_".$criteria."_bar_load"."_Labels".$i]; 
	echo "<area shape=RECT coords=\"trim($poly_string)\" title='$labelName' href='destination_host_load_details.php?criteria=$link_text&id=$labelName'>";
}
echo "</map>";
?>
<p>
<img border="0" src="<?php echo  $chart_path;?><?php echo $image_name;?>" usemap="#pieChart127010033813264224.png"></p>

