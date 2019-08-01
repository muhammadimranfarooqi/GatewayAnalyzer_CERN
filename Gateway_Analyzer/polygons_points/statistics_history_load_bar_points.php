<?php 
include("Config/config.inc.php");

$file_name = $_SESSION["file_name"];
$ln = strpos($file_name,"_bar");
$len = strlen($file_name);
$label_name = substr($file_name,0,$len-4);

$count = $_SESSION[$file_name."_loop"];
$image_name= $file_name.".png";
$link_text = $_SESSION["link_text"];
$urlType = $_SESSION["historyBased"];
if ($urlType== "per_month") {
$url = "gw_history_detail.php?criteria=$link_text";
}
else {
$url = "gw_statistics_history_detail_graph.php?criteria=$link_text";

}

echo " <map name=pieChart127010033813264224.png>";
for ($i=0;$i<$count;$i++) {
	
		
	$poly_string = $_SESSION[$file_name."_load_point".$i];	
	$labelName = $_SESSION[$label_name."_load_labels".$i]; 	
    

	echo "<area shape=RECT coords=\"$poly_string\" title='$labelName' href='$url&id=$labelName'>";
	
	
}

echo "</map>";


?>
<p>
<img border="0" src="<?php echo  $chart_path;?><?php echo $image_name;?>" usemap="#pieChart127010033813264224.png"></p>

