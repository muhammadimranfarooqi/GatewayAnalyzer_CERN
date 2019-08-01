<?php
session_start();
include("Config/config.inc.php");
 
$count = $_SESSION["destination_host_loop"];
$image_name = $_SESSION["image_name"];
if ($_SESSION["destination_host_url"]=="destination_host_load_criteria.php") 
	$link_text = "direction:Incoming,from:lastyear";
else
	$link_text = $_SESSION["link_text"];


echo " <map name=pieChart127010033813264224.png>";

for ($i=0;$i<$count;$i++) {
$j=1;
foreach($_SESSION["destination_host_load_point".$i] as $key=>$value)
    {
    if ($j==1) {
			$poly_string = $value;
			} 
	else  {
			$poly_string = $poly_string . "," .$value;
		}
	$labelName = $_SESSION["destination_host_load_labels".$i]; 	
    $j++;
    }
  
 echo "<area shape=POLY coords=\"$poly_string\" title='$labelName' href='destination_host_detail_graph.php?criteria=$link_text&dest_id=$labelName'>";
}  
echo "</map>";
?>
<p>
<img border="0" src="<?php echo  $chart_path;?><?php echo $image_name;?>" usemap="#pieChart127010033813264224.png"></p>

