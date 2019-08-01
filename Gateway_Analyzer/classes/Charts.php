<?php
include 'pChart/pData.class';  
include 'pChart/pChart.class';  

class Charts
{
    	
/*****************************************************************************************************************************************************************************

//View Current Login

*****************************************************************************************************************************************************************************/	
 

    function generateChart($chartType,$result,$graph_type,$chart_path,$graph_file_name)
	{
/************************************************************************Generate Gateway Load Graph ***********************************************************************/
 		$f_name = split("\,", $graph_file_name);
		$file_name_len = count($f_name);
		$file_name="";
		for ($i=0;$i<$file_name_len;$i++) {
		   if ($file_name=="")
				$file_name= $f_name[$i];
			else
				$file_name= $file_name."_".$f_name[$i];
			}
		
		mysql_data_seek($result ,0);
		$num = mysql_num_rows($result);
   		if ($chartType=="gw_load") {
		
		if ($graph_type=="pie_chart") {
	
		$_SESSION["gwLoad"] = $_SERVER["PHP_AUTH_USER"]."_gwload_".$file_name;
		
		$image_name= $_SESSION["gwLoad"].".png";

		$_SESSION["image_name"] = $image_name;
		
	
		$DataSet = new pData;  
		$j=1;
		while ($row = mysql_fetch_array($result) )  {
	   		     	$DataSet->AddPoint($row["count"],"Serie1");  
					$DataSet->AddPoint($row["gw_name"],"Serie2");  
			}
		
		
	
		$len = count($array1);
 		$DataSet->AddAllSeries();  
		$DataSet->SetAbsciseLabelSerie("Serie2");  
  
		 // Initialise the graph
		 $Test = new pChart(580,300);  
		 $Test->drawFilledRoundedRectangle(7,7,673,193,5,240,240,240);  
		 $Test->drawRoundedRectangle(5,5,575,195,5,230,230,230);  
  
		 // Draw the pie chart  
		$Test->setFontProperties("Fonts/tahoma.ttf",8);  
		$Test->drawPieGraph($DataSet->GetData(),$DataSet->GetDataDescription(),150,90,110,PIE_PERCENTAGE,TRUE,50,20,5);  
		$Test->drawPieLegend(410,15,$DataSet->GetData(),$DataSet->GetDataDescription(),250,250,250);  
  
		$Test->Render($chart_path."$image_name");  
		}
		else {
				
		 		$_SESSION["gwLoadBar"] = $_SERVER["PHP_AUTH_USER"]."_gwload_".$file_name;
		 		
				$image_name= $_SESSION["gwLoadBar"]."_bar.png";

				$_SESSION["image_name"] = $image_name;

			  $DataSet = new pData; 
				$j=1;
			
				while ($row=mysql_fetch_array($result))  {
			   				$gw_name = $row["gw_name"];
						    $DataSet->AddPoint($row["count"],"Serie.$j");  
						 	 $DataSet->SetSerieName("$gw_name","Serie.$j");  
						 
							$j++;
				}
		$DataSet->AddAllSeries();  

	   
  		  
			// Initialise the graph  
			$Test = new pChart(640,230);  
			$Test->setFontProperties("Fonts/tahoma.ttf",8);  
			$Test->setGraphArea(50,30,470,200);  
			$Test->drawFilledRoundedRectangle(7,7,500,223,5,240,240,240);  
			$Test->drawRoundedRectangle(5,5,500,225,5,230,230,230);  
			$Test->drawGraphArea(255,255,255,TRUE);  
			
			$Test->drawScale($DataSet->GetData(),$DataSet->GetDataDescription(),SCALE_NORMAL,150,150,150,TRUE,0,2,TRUE);     
			$Test->drawGrid(4,TRUE,230,230,230,50);  
	  
			// Draw the 0 line  
			$Test->setFontProperties("Fonts/tahoma.ttf",6);  
			$Test->drawTreshold(0,143,55,72,TRUE,TRUE);  
	  
			// Draw the bar graph  
			$Test->drawBarGraph($DataSet->GetData(),$DataSet->GetDataDescription(),TRUE);  
	  
			// Finish the graph  
			$Test->setFontProperties("Fonts/tahoma.ttf",8);  
			$Test->drawLegend(500,30,$DataSet->GetDataDescription(),250,250,250);  
			$Test->setFontProperties("Fonts/tahoma.ttf",10);  
			$Test->drawTitle(50,22,"Gateway Load",50,50,50,585);
			$Test->Render($chart_path."$image_name");  
			}
	 	 }
	 	 
/***************************************************************Generate Service Load Graph *********************************************************************************/

		if ($chartType=="service_load") {
		if ($graph_type=="pie_chart") {
	
		$_SESSION["service_load"] = $_SERVER["PHP_AUTH_USER"]."_serviceload_".$file_name;
		
		$image_name= $_SESSION["service_load"].".png";

		$_SESSION["image_name"] = $image_name;
		
	
		$DataSet = new pData;  
		$j=1;
		while ($row = mysql_fetch_array($result) )  {
	   		     	$DataSet->AddPoint($row["count"],"Serie1");  
	   		     	if ($row["name"]=="")
	   		     	$DataSet->AddPoint("Others","Serie2");  
	   		     	else
					$DataSet->AddPoint($row["name"],"Serie2");  
			}
		
		
	
		$len = count($array1);
 		$DataSet->AddAllSeries();  
		$DataSet->SetAbsciseLabelSerie("Serie2");  
  
		 // Initialise the graph
		 $Test = new pChart(580,300);  
		 $Test->drawFilledRoundedRectangle(7,7,673,193,5,240,240,240);  
		 $Test->drawRoundedRectangle(5,5,575,195,5,230,230,230);  
  
		 // Draw the pie chart  
		$Test->setFontProperties("Fonts/tahoma.ttf",8);  
		$Test->drawPieGraph($DataSet->GetData(),$DataSet->GetDataDescription(),150,90,110,PIE_PERCENTAGE,TRUE,50,20,5);  
		$Test->drawPieLegend(410,15,$DataSet->GetData(),$DataSet->GetDataDescription(),250,250,250);  
  
		$Test->Render($chart_path."$image_name");  
		}
		else {
				
		 		$_SESSION["service_load_bar"] = $_SERVER["PHP_AUTH_USER"]."_serviceload_".$file_name;
		 		
				$image_name= $_SESSION["service_load_bar"]."_bar.png";

				$_SESSION["image_name"] = $image_name;

			  $DataSet = new pData; 
				$j=1;
			
				while ($row=mysql_fetch_array($result))  {
			   				$name = $row["name"];
						    $DataSet->AddPoint($row["count"],"Serie.$j");  
						 	 $DataSet->SetSerieName("$name","Serie.$j");  
						 
							$j++;
				}
		$DataSet->AddAllSeries();  

	   
  		  
			// Initialise the graph  
			$Test = new pChart(640,230);  
			$Test->setFontProperties("Fonts/tahoma.ttf",8);  
			$Test->setGraphArea(50,30,470,200);  
			$Test->drawFilledRoundedRectangle(7,7,500,223,5,240,240,240);  
			$Test->drawRoundedRectangle(5,5,500,225,5,230,230,230);  
			$Test->drawGraphArea(255,255,255,TRUE);  
			
			$Test->drawScale($DataSet->GetData(),$DataSet->GetDataDescription(),SCALE_NORMAL,150,150,150,TRUE,0,2,TRUE);     
			$Test->drawGrid(4,TRUE,230,230,230,50);  
	  
			// Draw the 0 line  
			$Test->setFontProperties("Fonts/tahoma.ttf",6);  
			$Test->drawTreshold(0,143,55,72,TRUE,TRUE);  
	  
			// Draw the bar graph  
			$Test->drawBarGraph($DataSet->GetData(),$DataSet->GetDataDescription(),TRUE);  
	  
			// Finish the graph  
			$Test->setFontProperties("Fonts/tahoma.ttf",8);  
			$Test->drawLegend(500,30,$DataSet->GetDataDescription(),250,250,250);  
			$Test->setFontProperties("Fonts/tahoma.ttf",10);  
			$Test->drawTitle(50,22,"Gateway Load",50,50,50,585);
			$Test->Render($chart_path."$image_name");  
			}
			
			}

/********************************************************************Generate Top Ten users Graph *************************************************************************/
 
		if ($chartType=="top_ten_users") {
		if ($graph_type=="pie_chart") {

			$_SESSION["top_ten_users"] = $_SERVER["PHP_AUTH_USER"]."_userload_".$file_name;
			$image_name= $_SESSION["top_ten_users"].".png";

			$_SESSION["image_name"] = $image_name;
	
			$total=0;
			$array1 = Array(16);
			$i=0;

			$DataSet = new pData;  
			$j=1;
			
			while ( $row = mysql_fetch_array($result) )  {
			    if ($j<=10) {
				    $array1[$i] = $row[0];
				 	$DataSet->AddPoint($row[count],"Serie1");  
					$DataSet->AddPoint($row[source_user],"Serie2");  
					$j++;
				}
				else {
					$count=$row[count];
					$total+=$count;
				}
			$i++;
			}
			$array1[$j]=$total;
            if ($num>10) {
			$DataSet->AddPoint($total,"Serie1");  
			$DataSet->AddPoint("Others","Serie2"); 
			$len = count($array1);
		}
 
			$DataSet->AddAllSeries();  
			$DataSet->SetAbsciseLabelSerie("Serie2");  
  
			 // Initialise the graph
			$Test = new pChart(580,300);  
			$Test->drawFilledRoundedRectangle(7,7,673,193,5,240,240,240);  
			$Test->drawRoundedRectangle(5,5,575,195,5,230,230,230);  
   
			 // Draw the pie chart  
			$Test->setFontProperties("Fonts/tahoma.ttf",8);  
			$Test->drawPieGraph($DataSet->GetData(),$DataSet->GetDataDescription(),150,90,110,PIE_PERCENTAGE,TRUE,50,20,5);  
			$Test->drawPieLegend(410,15,$DataSet->GetData(),$DataSet->GetDataDescription(),250,250,250);  
  
			$Test->Render($chart_path."$image_name");
			}
			else {
				$_SESSION["top_ten_users_bar"]  = $_SERVER["PHP_AUTH_USER"]."_userload_".$file_name;
		 		
				$image_name= $_SESSION["top_ten_users_bar"] ."_bar.png";

				$_SESSION["image_name"] = $image_name;
 

			  $DataSet = new pData; 
				$j=1;
				$total=0;
				while ( $row = mysql_fetch_array($result) )  {
			   		 if ($j<=10) {
						    $DataSet->AddPoint($row[count],"Serie.$j");  
						 	$DataSet->SetSerieName("$row[source_user]","Serie.$j");  
							$j++;
						}
					else {
							$count=$row[count];
							$total+=$count;
						}
	
					}
			if ($num>10) {
			$array1[$j]=$total;
			$DataSet->AddPoint($total,"Serie.$j");  
			$DataSet->SetSerieName("Others","Serie.$j");  
			}
			$DataSet->AddAllSeries();  
  
			// Initialise the graph  
			$Test = new pChart(640,230);  
			$Test->setFontProperties("Fonts/tahoma.ttf",8);  
			$Test->setGraphArea(50,30,470,200);  
			$Test->drawFilledRoundedRectangle(7,7,500,223,5,240,240,240);  
			$Test->drawRoundedRectangle(5,5,500,225,5,230,230,230);  
			$Test->drawGraphArea(255,255,255,TRUE);  
			$Test->drawScale($DataSet->GetData(),$DataSet->GetDataDescription(),SCALE_NORMAL,150,150,150,TRUE,0,2,TRUE);     
			$Test->drawGrid(4,TRUE,230,230,230,50);  
	  
			// Draw the 0 line  
			$Test->setFontProperties("Fonts/tahoma.ttf",6);  
			$Test->drawTreshold(0,143,55,72,TRUE,TRUE);  
	  
			// Draw the bar graph  
			$Test->drawBarGraph($DataSet->GetData(),$DataSet->GetDataDescription(),TRUE);  
	  
			// Finish the graph  
			$Test->setFontProperties("Fonts/tahoma.ttf",8);  
			$Test->drawLegend(500,30,$DataSet->GetDataDescription(),250,250,250);  
			$Test->setFontProperties("Fonts/tahoma.ttf",10);  
			$Test->drawTitle(50,22,"Top Ten Users",50,50,50,585); 
			$Test->Render($chart_path."$image_name");  
			}
			}

/**************************************************************Generate Direction Load Graph *******************************************************************************/

		if ($chartType=="direction_load") {
		 if ($graph_type=="pie_chart") {

			$_SESSION["direction_load"] = $_SERVER["PHP_AUTH_USER"]."_direction_".$file_name;
			$image_name= $_SESSION["direction_load"].".png";

		    $_SESSION["image_name"] = $image_name;

			$total=0;
			$number=mysql_num_rows($result);
			$array1 = Array($number);
			$i=0;

			$DataSet = new pData;  
			while ( $row = mysql_fetch_array($result) )  {
			    $array1[$i] = $row[0];
  
				$DataSet->AddPoint($row["count"],"Serie1");  
				$DataSet->AddPoint($row["direction"],"Serie2");  
		 	}	
			$len = count($array1);

			$DataSet->AddAllSeries();  
			$DataSet->SetAbsciseLabelSerie("Serie2");  
  
			 // Initialise the graph
			 $Test = new pChart(580,300);  
			 $Test->drawFilledRoundedRectangle(7,7,673,193,5,240,240,240);  
			 $Test->drawRoundedRectangle(5,5,575,195,5,230,230,230);  
  
			 // Draw the pie chart  
			$Test->setFontProperties("Fonts/tahoma.ttf",8);  
			$Test->drawPieGraph($DataSet->GetData(),$DataSet->GetDataDescription(),150,90,110,PIE_PERCENTAGE,TRUE,50,20,5);  
			$Test->drawPieLegend(410,15,$DataSet->GetData(),$DataSet->GetDataDescription(),250,250,250);  
		  
			$Test->Render($chart_path."$image_name");
			}
			else {
			  $_SESSION["direction_load_bar"] = $_SERVER["PHP_AUTH_USER"]."_direction_".$file_name;
			  $image_name= $_SESSION["direction_load_bar"]."_bar.png";

		    	$_SESSION["image_name"] = $image_name;


			  $DataSet = new pData; 
				$j=1;
				
				while ( $row = mysql_fetch_array($result) )  {
				   

			   		 $DataSet->AddPoint($row["count"],"Serie.$j");  
					 $DataSet->SetSerieName($row[direction],"Serie.$j");  
					 $j++;
					
				}
			
			$DataSet->AddAllSeries();  
  
			// Initialise the graph  
			$Test = new pChart(640,230);  
			$Test->setFontProperties("Fonts/tahoma.ttf",8);  
			$Test->setGraphArea(50,30,470,200);  
			$Test->drawFilledRoundedRectangle(7,7,500,223,5,240,240,240);  
			$Test->drawRoundedRectangle(5,5,500,225,5,230,230,230);  
			$Test->drawGraphArea(255,255,255,TRUE);  
			$Test->drawScale($DataSet->GetData(),$DataSet->GetDataDescription(),SCALE_NORMAL,150,150,150,TRUE,0,2,TRUE);     
			$Test->drawGrid(4,TRUE,230,230,230,50);  
	  
			// Draw the 0 line  
			$Test->setFontProperties("Fonts/tahoma.ttf",6);  
			$Test->drawTreshold(0,143,55,72,TRUE,TRUE);  
	  
			// Draw the bar graph  
			$Test->drawBarGraph($DataSet->GetData(),$DataSet->GetDataDescription(),TRUE);  
	  
			// Finish the graph  
			$Test->setFontProperties("Fonts/tahoma.ttf",8);  
			$Test->drawLegend(500,30,$DataSet->GetDataDescription(),250,250,250);  
			$Test->setFontProperties("Fonts/tahoma.ttf",10);  
			$Test->drawTitle(50,22,"Service Load",50,50,50,585); 
			$Test->Render($chart_path."$image_name");  

			}
			}
			
/*********************************************************************Generate Destination host Load Graph *****************************************************************/

			if ($chartType=="destination_host_load") {
			 if ($graph_type=="pie_chart") {

			$_SESSION["destination_host_load"] = $_SERVER["PHP_AUTH_USER"]."_destinationload_".$file_name;
			$image_name= $_SESSION["destination_host_load"].".png";

			$_SESSION["image_name"] = $image_name;
			
			$total=0;
			$array1 = Array(16);
			$i=0;

			$DataSet = new pData;  
			$j=1;
			
			while ( $row = mysql_fetch_array($result) )  {
			    if ($j<=15) {
				    $array1[$i] = $row[count];
				 	$DataSet->AddPoint($row[count],"Serie1");  
					$DataSet->AddPoint($row[remote_host],"Serie2");  
					$j++;
				}
				else {
					$count=$row[count];
					$total+=$count;
				}
			$i++;
			}
			$array1[$j]=$total;
			if ($num>15) {
			$DataSet->AddPoint($total,"Serie1");  
			$DataSet->AddPoint("Others","Serie2"); 
			$len = count($array1);
 			}
 			
			$DataSet->AddAllSeries();  
			$DataSet->SetAbsciseLabelSerie("Serie2");  
  
			 // Initialise the graph
			$Test = new pChart(580,300);  
			$Test->drawFilledRoundedRectangle(7,7,673,193,5,240,240,240);  
			$Test->drawRoundedRectangle(5,5,575,195,5,230,230,230);  
   
			 // Draw the pie chart  
			$Test->setFontProperties("Fonts/tahoma.ttf",8);  
			$Test->drawPieGraph($DataSet->GetData(),$DataSet->GetDataDescription(),150,90,110,PIE_PERCENTAGE,TRUE,50,20,5);  
			$Test->drawPieLegend(410,15,$DataSet->GetData(),$DataSet->GetDataDescription(),250,250,250);  
  
			$Test->Render($chart_path."$image_name");
			}
			else {
			
			  $_SESSION["destination_host_load_bar"] = $_SERVER["PHP_AUTH_USER"]."_destinationload_".$file_name;
			   $image_name= $_SESSION["destination_host_load_bar"]."_bar.png";

			   $_SESSION["image_name"] = $image_name;

			  $DataSet = new pData; 
				$j=1;
				$total=0;
				while ( $row = mysql_fetch_array($result) )  {
			   		 if ($j<=15) {
						    $DataSet->AddPoint($row[count],"Serie.$j");  
						 	$DataSet->SetSerieName("$row[remote_host]","Serie.$j");  
							$j++;
						}
					else {
							$count=$row[count];
							$total+=$count;
						}
	
					}
			if ($num>15) {
			$array1[$j]=$total;
			$DataSet->AddPoint($total,"Serie.$j");  
			$DataSet->SetSerieName("Others","Serie.$j");  
			}
			$DataSet->AddAllSeries();  
			
		
  
			// Initialise the graph  
			$Test = new pChart(640,230);  
			$Test->setFontProperties("Fonts/tahoma.ttf",8);  
			$Test->setGraphArea(50,30,470,200);  
			$Test->drawFilledRoundedRectangle(7,7,520,223,5,240,240,240);  
			$Test->drawRoundedRectangle(5,5,520,225,5,230,230,230);  
			$Test->drawGraphArea(255,255,255,TRUE);  
			$Test->drawScale($DataSet->GetData(),$DataSet->GetDataDescription(),SCALE_NORMAL,150,150,150,TRUE,0,2,TRUE);     
			$Test->drawGrid(4,TRUE,230,230,230,50);  
	  
			// Draw the 0 line  
			$Test->setFontProperties("Fonts/tahoma.ttf",6);  
			$Test->drawTreshold(0,143,55,72,TRUE,TRUE);  
	  
			// Draw the bar graph  
			$Test->drawBarGraph($DataSet->GetData(),$DataSet->GetDataDescription(),TRUE);  
	  
			// Finish the graph  
			$Test->setFontProperties("Fonts/tahoma.ttf",8);  
			$Test->drawLegend(500,10,$DataSet->GetDataDescription(),250,250,250);  
			$Test->setFontProperties("Fonts/tahoma.ttf",10);  
			$Test->drawTitle(50,22,"Destination Host Load",50,50,50,585); 
			$Test->Render($chart_path."$image_name");  

			}
			}

	}


 function generateDetailChart($chartType,$result,$criteria,$chart_path)
	{
	
/************************************************************************Generate Gateway Load Graph ***********************************************************************/
 
	if ($chartType=="gw_load") {
				
				$_SESSION["gw_criteria"] = $criteria;
				$_SESSION["gwLoadDetail"] = $_SERVER["PHP_AUTH_USER"]."gw_".$criteria."_bar_load";
		 		$image_name =$_SERVER["PHP_AUTH_USER"]. "gw_".$criteria."_bar_load.png";
				$gw_id = $_SESSION["gw_id"];
				$title = "Gateway Load (".$gw_id.")";
				
			  $DataSet = new pData; 
				$j=1;
				$total=0;
			//	mysql_data_seek($result ,0);

				while ( $row = mysql_fetch_array($result) )  {
			   		 		$mon            =     date("M", strtotime($row["login"]));  
    						$yr 			= date('Y', strtotime($row["login"]));

						    $DataSet->AddPoint($row["count"],"Serie.$j");  
						 	$DataSet->SetSerieName($mon."-".$yr,"Serie.$j"); 
						 	$j++;
					}
			  
			$DataSet->AddAllSeries();  
  
			// Initialise the graph  
			$Test = new pChart(740,520);  
			$Test->setFontProperties("Fonts/tahoma.ttf",8);  
			$Test->setGraphArea(50,30,470,200);  
			$Test->drawFilledRoundedRectangle(7,7,600,513,5,240,240,240);  
			$Test->drawRoundedRectangle(5,5,600,515,5,230,230,230);  
			$Test->drawGraphArea(255,255,255,TRUE);  
			$Test->drawScale($DataSet->GetData(),$DataSet->GetDataDescription(),SCALE_NORMAL,150,150,150,TRUE,0,2,TRUE);     
			$Test->drawGrid(4,TRUE,230,230,230,50);  
	  
			// Draw the 0 line  
			$Test->setFontProperties("Fonts/tahoma.ttf",6);  
			$Test->drawTreshold(0,143,55,72,TRUE,TRUE);  
	  
			// Draw the bar graph  
			$Test->drawBarGraph($DataSet->GetData(),$DataSet->GetDataDescription(),TRUE);  
	  
			// Finish the graph  
			$Test->setFontProperties("Fonts/tahoma.ttf",8);  
			$Test->drawLegend(500,30,$DataSet->GetDataDescription(),250,250,250);  
			$Test->setFontProperties("Fonts/tahoma.ttf",10);  
			$Test->drawTitle(50,22,"$title",50,50,50,485); 
			$Test->Render($chart_path."$image_name");  			

 }
	 	 
/***************************************************************Generate Service Load Graph *********************************************************************************/

		if ($chartType=="service_load") {
		
			    $_SESSION["sv_criteria"] = $criteria;
				
		 		$_SESSION["svLoadDetail"] = $_SERVER["PHP_AUTH_USER"]."sv_".$criteria."_bar_load";
		 		$image_name = $_SERVER["PHP_AUTH_USER"]."sv_".$criteria."_bar_load.png";
				$sv_id = $_SESSION["sv_id"];
				$title = "Service Load (".$sv_id.")";
				
			  $DataSet = new pData; 
				$j=1;
				$total=0;
				$groupby = $_SESSION["gw_group"];
				
				while ( $row = mysql_fetch_array($result) )  {
			   		 		
						    $DataSet->AddPoint($row["count"],"Serie.$j");  
						    if ($groupby =="ByMonth") {
						    $mon            =     date("M", strtotime($row[login]));  
    						$yr 			= date('Y', strtotime($row[login]));
							$DataSet->SetSerieName($mon."-".$yr,"Serie.$j"); 
							}	
							else {
						 	$DataSet->SetSerieName($row["gw_name"],"Serie.$j");  
						 	}
							$j++;
					}
			  
			$DataSet->AddAllSeries();  
  
			// Initialise the graph  
			$Test = new pChart(740,520);  
			$Test->setFontProperties("Fonts/tahoma.ttf",8);  
			$Test->setGraphArea(50,30,470,200);  
			$Test->drawFilledRoundedRectangle(7,7,600,513,5,240,240,240);  
			$Test->drawRoundedRectangle(5,5,600,515,5,230,230,230);  
			$Test->drawGraphArea(255,255,255,TRUE);  
			$Test->drawScale($DataSet->GetData(),$DataSet->GetDataDescription(),SCALE_NORMAL,150,150,150,TRUE,0,2,TRUE);     
			$Test->drawGrid(4,TRUE,230,230,230,50);  
	  
			// Draw the 0 line  
			$Test->setFontProperties("Fonts/tahoma.ttf",6);  
			$Test->drawTreshold(0,143,55,72,TRUE,TRUE);  
	  
			// Draw the bar graph  
			$Test->drawBarGraph($DataSet->GetData(),$DataSet->GetDataDescription(),TRUE);  
	  
			// Finish the graph  
			$Test->setFontProperties("Fonts/tahoma.ttf",8);  
			$Test->drawLegend(500,30,$DataSet->GetDataDescription(),250,250,250);  
			$Test->setFontProperties("Fonts/tahoma.ttf",10);  
			$Test->drawTitle(50,22,"$title",50,50,50,485); 
			$Test->Render($chart_path."$image_name");  
						
			}
	 	 
/********************************************************************Generate Top Ten users Graph *************************************************************************/
 
		if ($chartType=="top_ten_users") {
		
			 $_SESSION["tt_users_criteria"] = $criteria;

			$_SESSION["userLoadDetail"] = $_SERVER["PHP_AUTH_USER"]."user_".$criteria."_bar_load";
		 		$image_name = $_SERVER["PHP_AUTH_USER"]."user_".$criteria."_bar_load.png";
				$user_id = $_SESSION["user_id"];
				$title = "User Load (".$user_id.")";
				
				$groupby = $_SESSION["gw_group"];
				
			  $DataSet = new pData; 
				$j=1;
				$total=0;
				while ( $row = mysql_fetch_array($result) )  {
			   		 	
						    $DataSet->AddPoint($row["count"],"Serie.$j");  
				 if ($groupby =="ByMonth") {
						    $mon            =     date("M", strtotime($row[login]));  
    						$yr 			= date('Y', strtotime($row[login]));
							$DataSet->SetSerieName($mon."-".$yr,"Serie.$j"); 
							}	
							else {
						 	$DataSet->SetSerieName($row["gw_name"],"Serie.$j");  
						 	}
						 	$j++;
					}
			  
			$DataSet->AddAllSeries();  
  
			// Initialise the graph  
			$Test = new pChart(740,520);  
			$Test->setFontProperties("Fonts/tahoma.ttf",8);  
			$Test->setGraphArea(50,30,470,200);  
			$Test->drawFilledRoundedRectangle(7,7,600,513,5,240,240,240);  
			$Test->drawRoundedRectangle(5,5,600,515,5,230,230,230);  
			$Test->drawGraphArea(255,255,255,TRUE);  
			$Test->drawScale($DataSet->GetData(),$DataSet->GetDataDescription(),SCALE_NORMAL,150,150,150,TRUE,0,2,TRUE);     
			$Test->drawGrid(4,TRUE,230,230,230,50);  
	  
			// Draw the 0 line  
			$Test->setFontProperties("Fonts/tahoma.ttf",6);  
			$Test->drawTreshold(0,143,55,72,TRUE,TRUE);  
	  
			// Draw the bar graph  
			$Test->drawBarGraph($DataSet->GetData(),$DataSet->GetDataDescription(),TRUE);  
	  
			// Finish the graph  
			$Test->setFontProperties("Fonts/tahoma.ttf",8);  
			$Test->drawLegend(500,30,$DataSet->GetDataDescription(),250,250,250);  
			$Test->setFontProperties("Fonts/tahoma.ttf",10);  
			$Test->drawTitle(50,22,"$title",50,50,50,485); 
			$Test->Render($chart_path."$image_name");  			
			}

/**************************************************************Generate Direction Load Graph *******************************************************************************/

		if ($chartType=="direction_load") {
		 
		 	$_SESSION["direction_criteria"] = $criteria;

			 $_SESSION["dirLoadDetail"] = $_SERVER["PHP_AUTH_USER"]."direction_".$criteria."_bar_load";
		 		$image_name = $_SERVER["PHP_AUTH_USER"]."direction_".$criteria."_bar_load.png";
				$dir_id = $_SESSION["dir_id"];
				$title = "Direction Load (".$dir_id.")";
				$groupby = $_SESSION["gw_group"];

			  $DataSet = new pData; 
				$j=1;
				$total=0;
				while ( $row = mysql_fetch_array($result) )  {
				 $DataSet->AddPoint($row["count"],"Serie.$j");  
			   		 		if ($groupby=="ByMonth") {
						   
						 	$mon            =     date("M", strtotime($row[login]));  
    						$yr 			= date('Y', strtotime($row[login]));
							$DataSet->SetSerieName($mon."-".$yr,"Serie.$j"); 
							}	
							else {
						 	$DataSet->SetSerieName($row["gw_name"],"Serie.$j");  
						 	}
							$j++;
					}
			  
			$DataSet->AddAllSeries();  
  
			// Initialise the graph  
			$Test = new pChart(740,520);  
			$Test->setFontProperties("Fonts/tahoma.ttf",8);  
			$Test->setGraphArea(50,30,470,200);  
			$Test->drawFilledRoundedRectangle(7,7,600,513,5,240,240,240);  
			$Test->drawRoundedRectangle(5,5,600,515,5,230,230,230);  
			$Test->drawGraphArea(255,255,255,TRUE);  
			$Test->drawScale($DataSet->GetData(),$DataSet->GetDataDescription(),SCALE_NORMAL,150,150,150,TRUE,0,2,TRUE);     
			$Test->drawGrid(4,TRUE,230,230,230,50);  
	  
			// Draw the 0 line  
			$Test->setFontProperties("Fonts/tahoma.ttf",6);  
			$Test->drawTreshold(0,143,55,72,TRUE,TRUE);  
	  
			// Draw the bar graph  
			$Test->drawBarGraph($DataSet->GetData(),$DataSet->GetDataDescription(),TRUE);  
	  
			// Finish the graph  
			$Test->setFontProperties("Fonts/tahoma.ttf",8);  
			$Test->drawLegend(500,30,$DataSet->GetDataDescription(),250,250,250);  
			$Test->setFontProperties("Fonts/tahoma.ttf",10);  
			$Test->drawTitle(50,22,"$title",50,50,50,485); 
			$Test->Render($chart_path."$image_name");  
						
			}
	
/*********************************************************************Generate Destination host Load Graph *****************************************************************/

			if ($chartType=="destination_host_load") {
			
				$_SESSION["destination_host_criteria"] = $criteria;

			  	$_SESSION["destLoadDetail"] = $_SERVER["PHP_AUTH_USER"]."destination_host_".$criteria."_bar_load";
		 		$image_name = $_SERVER["PHP_AUTH_USER"]."destination_host_".$criteria."_bar_load.png";
				$dest_id = $_SESSION["dest_id"];
				$title = "Destination Host Load (".$dest_id.")";
				$groupby = $_SESSION["gw_group"];
			  $DataSet = new pData; 
				$j=1;
				$total=0;
				while ( $row = mysql_fetch_array($result) )  {
			   		 		

						    $DataSet->AddPoint($row["count"],"Serie.$j");  
				if ($groupby=="ByMonth") {
						   
						 	$mon            =     date("M", strtotime($row[login]));  
    						$yr 			= date('Y', strtotime($row[login]));
							$DataSet->SetSerieName($mon."-".$yr,"Serie.$j"); 
							}	
							else {
						 	$DataSet->SetSerieName($row["gw_name"],"Serie.$j");  
						 	}
							$j++;
					}
			  
			$DataSet->AddAllSeries();  
  
			// Initialise the graph  
			$Test = new pChart(740,520);  
			$Test->setFontProperties("Fonts/tahoma.ttf",8);  
			$Test->setGraphArea(50,30,470,200);  
			$Test->drawFilledRoundedRectangle(7,7,600,513,5,240,240,240);  
			$Test->drawRoundedRectangle(5,5,600,515,5,230,230,230);  
			$Test->drawGraphArea(255,255,255,TRUE);  
			$Test->drawScale($DataSet->GetData(),$DataSet->GetDataDescription(),SCALE_NORMAL,150,150,150,TRUE,0,2,TRUE);     
			$Test->drawGrid(4,TRUE,230,230,230,50);  
	  
			// Draw the 0 line  
			$Test->setFontProperties("Fonts/tahoma.ttf",6);  
			$Test->drawTreshold(0,143,55,72,TRUE,TRUE);  
	  
			// Draw the bar graph  
			$Test->drawBarGraph($DataSet->GetData(),$DataSet->GetDataDescription(),TRUE);  
	  
			// Finish the graph  
			$Test->setFontProperties("Fonts/tahoma.ttf",8);  
			$Test->drawLegend(500,30,$DataSet->GetDataDescription(),250,250,250);  
			$Test->setFontProperties("Fonts/tahoma.ttf",10);  
			$Test->drawTitle(50,22,"$title",50,50,50,485); 
			$Test->Render($chart_path."$image_name");  
			

			}



	}


  function generateHistoryChart($result,$graph_type,$graph_file_name,$gateway,$chart_path)
	{
	
/************************************************************************Generate Gateway Load Graph ***********************************************************************/
 
		if ($graph_type=="pie_chart") {
		
		$f_name = split("\,", $graph_file_name);
		$file_name_len = count($f_name);
		
		$file_name="";
		for ($i=0;$i<$file_name_len;$i++) {
		   if ($file_name=="")
				$file_name= $f_name[$i];
			else
				$file_name= $file_name."_".$f_name[$i];
		}
		
		$_SESSION["file_name"] = $_SERVER["PHP_AUTH_USER"]."_".$file_name."_history";
		
		
		
		$image_name= $_SESSION["file_name"].".png";

		$DataSet = new pData;  
		
		while ( $row = mysql_fetch_array($result) )  {
	   		 

				   	$DataSet->AddPoint($row["total_login"],"Serie1");  
				   	if ($gateway!="") {
				   		$_SESSION["historyBased"] = "per_month";
						$mon            =     date("M", strtotime($row["login"]));  
    					$yr 			= 	  date('Y', strtotime($row["login"]));
						$DataSet->AddPoint("$mon-$yr","Serie2");  
					}
					else {
					$_SESSION["historyBased"] = "per_gw";
					$DataSet->AddPoint($row["gw_name"],"Serie2");  

					}
				}
				
	
		

 		$DataSet->AddAllSeries();  
		$DataSet->SetAbsciseLabelSerie("Serie2");  
  
		 // Initialise the graph
		 $Test = new pChart(740,520);  
		 $Test->drawFilledRoundedRectangle(7,7,673,513,5,240,240,240);  
		 $Test->drawRoundedRectangle(5,5,575,515,5,230,230,230);  
  
		 // Draw the pie chart  
		$Test->setFontProperties("Fonts/tahoma.ttf",8);  
		$Test->drawPieGraph($DataSet->GetData(),$DataSet->GetDataDescription(),150,90,110,PIE_PERCENTAGE,TRUE,50,20,5);  
		$Test->drawPieLegend(410,15,$DataSet->GetData(),$DataSet->GetDataDescription(),250,250,250);  
  
		$Test->Render($chart_path."$image_name");  
		}
		else {
		$f_name = split("\,", $graph_file_name);
		//echo $graph_file_name;
		$file_name_len = count($f_name);
		//echo $file_name_len;
		$file_name="";
		for ($i=0;$i<$file_name_len;$i++) {
		   if ($file_name=="")
				$file_name= $f_name[$i];
			else
				$file_name= $file_name."_".$f_name[$i];
			
			}
		
			//echo $file_name;
				$_SESSION["file_name"] = $_SERVER["PHP_AUTH_USER"]."_".$file_name."_history_bar";
		
		
		
		$image_name= $_SESSION["file_name"].".png";
		//echo $image_name;
		//echo $gateway;
					  $DataSet = new pData; 
				$j=1;
				
				while ( $row = mysql_fetch_array($result) )  {
			   		 $DataSet->AddPoint($row["total_login"],"Serie.$j");  
			   		 	if ($gateway!="") {
			   		 	$_SESSION["historyBased"] = "per_month";
						$mon            =     date("M", strtotime($row["login"]));  
    					$yr 			= 	  date('Y', strtotime($row["login"]));
						$DataSet->SetSerieName("$mon-$yr","Serie.$j");  
						}
						else {
						$_SESSION["historyBased"] = "per_gw";

					 $DataSet->SetSerieName($row["gw_name"],"Serie.$j");  
					 }
					 $j++;
				}
			
			$DataSet->AddAllSeries();  
  
			// Initialise the graph  	
			$Test = new pChart(740,520);  
			$Test->setFontProperties("Fonts/tahoma.ttf",8);  
			$Test->setGraphArea(50,30,470,200);  
			$Test->drawFilledRoundedRectangle(7,7,600,513,5,240,240,240);  
			$Test->drawRoundedRectangle(5,5,600,515,5,230,230,230);  
			$Test->drawGraphArea(255,255,255,TRUE);  
			$Test->drawScale($DataSet->GetData(),$DataSet->GetDataDescription(),SCALE_NORMAL,150,150,150,TRUE,0,2,TRUE);     
			$Test->drawGrid(4,TRUE,230,230,230,50);  
	  
			// Draw the 0 line  
			$Test->setFontProperties("Fonts/tahoma.ttf",6);  
			$Test->drawTreshold(0,143,55,72,TRUE,TRUE);  
	  
			// Draw the bar graph  
			$Test->drawBarGraph($DataSet->GetData(),$DataSet->GetDataDescription(),TRUE);  
	  
			// Finish the graph  
			$Test->setFontProperties("Fonts/tahoma.ttf",8);  
			$Test->drawLegend(500,30,$DataSet->GetDataDescription(),250,250,250);  
			$Test->setFontProperties("Fonts/tahoma.ttf",10);  
			$Test->drawTitle(50,22,"Load Graph ",50,50,50,430); 
			$Test->Render($chart_path."$image_name");  
			
		}
	 
}
}//end class
?>
