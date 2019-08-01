<?php
include("Config/config.inc.php");

$count = $_SESSION["direction_loop"];
$image_name = $_SESSION["image_name"];
$link_text = $_SESSION["link_text"];

echo " <map name=pieChart127010033813264224.png>";
for ($i=0;$i<$count;$i++) {
	$poly_string = $_SESSION["direction_load_bar".$i];
	$labelName = $_SESSION["direction_load_labels".$i]; 
	echo "<area shape=RECT coords=\"$poly_string\" title='$labelName' href='direction_detail_load_graph.php?criteria=$link_text&dir_id=$labelName'>";
}
echo "</map>";
?>
<p>
<img border="0" src="<?php echo  $chart_path;?><?php echo $image_name;?>" usemap="#pieChart127010033813264224.png"></p>

