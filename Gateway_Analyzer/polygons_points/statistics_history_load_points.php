<?php 
session_start();
include("Config/config.inc.php");

$file_name = $_SESSION["file_name"];
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


if ($_SESSION["gateway"]=="") {
$_SESSION["url"] = "gw_statistics_history_detail_graph.php?criteria=$link_text";

}
else {
}
echo " <map name=pieChart127010033813264224.png>";

for ($i=0;$i<$count;$i++) {
$j=1;
foreach($_SESSION[$file_name."_load_point".$i]  as $key=>$value)
    {
    if ($j==1) {
			$poly_string = $value;
			} 
	else  {
			$poly_string = $poly_string . "," .$value;
		}
	$labelName = $_SESSION[$file_name."_load_labels".$i]; 	
    $j++;
    }
  
 echo "<area shape=POLY coords=\"$poly_string\" title='$labelName' href='$url&id=$labelName'>";
}  
echo "</map>";

?>
<p>

<img border="0" src="<?php echo  $chart_path;?><?php echo $image_name;?>" usemap="#pieChart127010033813264224.png">
</p>

