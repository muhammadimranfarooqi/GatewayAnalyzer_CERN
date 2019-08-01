<?php 
include("Config/config.inc.php");
if (!$_SESSION) {
session_start();
}


$count = $_SESSION["sv_loop"];
$image_name = $_SESSION["image_name"];
if ($_SESSION["sv_url"]=="service_load_criteria.php") 
$link_text = "direction:Incoming,from:lastyear";
else
	$link_text = $_SESSION["link_text"];

echo " <map name=pieChart127010033813264224.png>";

for ($i=0;$i<$count;$i++) {
$j=1;
foreach($_SESSION["sv_load_point".$i] as $key=>$value)
    {
    if ($j==1) {
			$poly_string = $value;
			} 
	else  {
			$poly_string = $poly_string . "," .$value;
		}
	$labelName = $_SESSION["sv_load_labels".$i]; 	
	
    $j++;
    }
 // echo $poly_string;
 echo "<area shape=POLY coords=\"$poly_string\" title='$labelName' href='service_detail_load_graph.php?criteria=$link_text&sv=$labelName'>";
}  
echo "</map>";
?>
<p>
<img border="0" src="<?php echo  $chart_path;?><?php echo $image_name;?>" usemap="#pieChart127010033813264224.png"></p>

