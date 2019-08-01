<?php 
include("Config/config.inc.php");

$count = $_SESSION["direction_loop"];
$image_name = $_SESSION["image_name"];
if ($_SESSION["direction_url"]=="direction_load_criteria.php") 
	$link_text = "from:lastyear";
else
	$link_text = $_SESSION["link_text"];

echo " <map name=pieChart127010033813264224.png>";

for ($i=0;$i<$count;$i++) {
$j=1;
foreach($_SESSION["direction_load_point".$i] as $key=>$value)
    {
    if ($j==1) {
			$poly_string = $value;
			} 
	else  {
			$poly_string = $poly_string . "," .$value;
		}
	$labelName = $_SESSION["direction_load_labels".$i]; 	
    $j++;
    }
  
 echo "<area shape=POLY coords=\"$poly_string\" title='$labelName' href='direction_detail_load_graph.php?criteria=$link_text&dir_id=$labelName'>";
}  
echo "</map>";
?>
<p>
<img border="0" src="<?php echo  $chart_path;?><?php echo $image_name;?>" usemap="#pieChart127010033813264224.png"></p>

