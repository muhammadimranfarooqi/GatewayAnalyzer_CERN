<html>

<head>
<meta http-equiv="Content-Language" content="en-us">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<title>ATLAS TDAQ - Gateway Analyzer</title>
<link href="resources/style.css" rel="stylesheet" type="text/css">
     
<script type="text/javascript" src="resources/selectItem.js"></script>
<script language=javascript>
function getURL(str) {
	var url = window.location.href;
	var query_string = url.split("?");
	var pageIndex = query_string[1].indexOf("PageNo=");

	if (pageIndex>=0) {
		
		var sortIndex = query_string[1].indexOf("&sort=");
		var diff = sortIndex - pageIndex;
		
		var firstStr = query_string[1].substring(0,pageIndex);

		var preStr = query_string[1].substring(pageIndex,diff);
		var newStr =preStr.replace(preStr, "PageNo=1");

		var nextStr = query_string[1].substring(sortIndex);
		var strIndex = nextStr.indexOf("&totalpages");
		
		if (strIndex>0) {
			var start = strIndex+11;
			
			var str1 = nextStr.substring(0,strIndex);
			var pg = nextStr.substring(start,start+5);
			
			var lastchr = pg.substring(start+5,4);
			if (lastchr==0) {
			var str2 = nextStr.substring(strIndex,strIndex+16);
			var str3 = nextStr.substring(strIndex+16);

			}
			else {
			var str2 = nextStr.substring(strIndex,strIndex+15);
			var str3 = nextStr.substring(strIndex+15);
			}
			if (firstStr=="") {
				var str4 = newStr + str1 + str3;
			}
			else {
				var str4 = firstStr + newStr + str1 + str3;
			}
			var newurl = query_string[0] + "?"+str4;
			window.location.href = newurl+"&totalpages="+str;
		}
	}
	else {
		var strIndex = query_string[1].indexOf("&totalpages");

		if (strIndex>0) {
		
			var str1 = query_string[1].substring(0,strIndex);
			var pg = query_string[1].substring(start,start+5);
			
			var lastchr = pg.substring(start+5,4);
			if (lastchr==0) {
			var str2 = query_string[1].substring(strIndex,strIndex+16);
			var str3 = query_string[1].substring(strIndex+16);

			}
			else {

			var str2 = query_string[1].substring(strIndex,strIndex+15);
			var str3 = query_string[1].substring(strIndex+15);
			}
			var str4 = str1 + str3;

			var newurl = query_string[0] + "?"+str4;
			window.location.href = newurl+"&totalpages="+str;

		}
		else
		{
			window.location.href = window.location.href+"&totalpages="+str;
		}
	}
}//end function
</script>
</head>

<?php 
if (!$_SESSION) {
session_start();
}
$id = $_GET["id"];
$criteria = $_GET["criteria"];
$url = $_SESSION["sv_detail"];
$groupby = $_SESSION["gw_group"];
if ($groupby=="ByGateway") {
	$criteria1 = $criteria.",gateway:".$id;
	$id1="";
} 
else {
	$criteria1 = $criteria;
	$id1=$id;
}
include "classes/Controller.php";
include("Config/config.inc.php");

$con = new Controller();
$cn = $con->getDBConnection($mysql_user,$mysql_pass,$mysql_host,$mysql_db);

$nimg = "images/bg.gif";
$aimg = "images/asc.gif";
$dimg = "images/desc.gif";

if (!isset($_GET['how'])) {
    $_GET['how'] = "DESC";
     $PageSize = 200;

    $query ="";
    
}

if ($_GET['how'] == "ASC") {
	$np=$_GET['how'];
    $how="DESC";
    if (!isset($_GET['sort']))
    	$sort = "source_user";
    else
        $sort = $_GET["sort"];
	if (!$_SESSION['totalpages']) {
 	 if (!isset($_GET['totalpages'])) {
	 	$PageSize = 200;
	 	$_SESSION['totalpages'] = $PageSize;
	 	}
	else {
	     $PageSize = $_GET['totalpages'];
	     $_SESSION['totalpages'] = $PageSize;

	    }
	}
	else {
		     if (!isset($_GET['totalpages'])) {
	 		$PageSize = $_SESSION['totalpages'];
			$_SESSION['totalpages'] = $PageSize;	 	
			}
		else {
	    	 $PageSize = $_GET['totalpages'];
	    	 $_SESSION['totalpages'] = $PageSize;
	    }
	}
    $query="";
} elseif ($_GET['how'] == "DESC") {
	$np=$_GET['how'];
    $how="ASC";
    if (!isset($_GET['sort']))
    	$sort = "source_user";
    else
        $sort = $_GET["sort"];
	if (!$_SESSION['totalpages']) {
 	 if (!isset($_GET['totalpages'])) {
	 	$PageSize = 200;
	 	$_SESSION['totalpages'] = $PageSize;
	 	}
	else {
	     $PageSize = $_GET['totalpages'];
	     $_SESSION['totalpages'] = $PageSize;

	    }
	}
	else {
		     if (!isset($_GET['totalpages'])) {
	 		$PageSize = $_SESSION['totalpages'];
			$_SESSION['totalpages'] = $PageSize;	 	
			}
		else {
	    	 $PageSize = $_GET['totalpages'];
	    	 $_SESSION['totalpages'] = $PageSize;
	    }
	}
}


//Set the page size
$StartRow = 0;

//Set the page no
if(empty($_GET['PageNo'])){
    if($StartRow == 0){
        $PageNo = $StartRow + 1;
    }
}else{
    $PageNo = $_GET['PageNo'];
    $StartRow = ($PageNo - 1) * $PageSize;
}

//Set the counter start
if($PageNo % $PageSize == 0){
    $CounterStart = $PageNo - ($PageSize - 1);
}else{
    $CounterStart = $PageNo - ($PageNo % $PageSize) + 1;
}

//Counter End
$CounterEnd = $CounterStart + ($PageSize - 1);

$loginStatus = $_SESSION["loginStatus"];





$TRecord = $con->viewGatewayLoadInformation($criteria1,$id1,$sort,$how,$loginStatus,$cn);
 $RecordCount = mysql_num_rows($TRecord);

 //Set Maximum Page
 $MaxPage = $RecordCount % $PageSize;
 if($RecordCount % $PageSize == 0){
    $MaxPage = $RecordCount / $PageSize;
 }else{
    $MaxPage = ceil($RecordCount / $PageSize);
 }


?>

<body topmargin="0" leftmargin="0">

<table border="0" width="100%" id="table1" height="695" cellspacing="0">
	<tr>
		<td colspan="7" height="1%">
		<img border="0" src="images/gw-banner.jpg" width="100%" height="58"></td>
	</tr>
	<tr>
		<td width="15%" bgcolor="#E5E3F0" rowspan="6" valign="top">
		<table border="0" width="100%" id="table8">
			<tr>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
			</tr>
				<tr>
				<td>
				<div align="center">
					<?php include "main_menu.htm"; ?>

				</div>
				</td>
			</tr>
			</tr>
			<tr>
				<td height="24">
				<p align="center">&nbsp;</td>
			</tr>

			<tr>
				<td>
				<div align="center">
					<?php include "gw_login_menu.php"; ?>

				</div>
				</td>
			</tr>
			
			<tr>
				<td height="24">
				<p align="center">&nbsp;</td>
			</tr>
			<tr>
				<td>
				<div align="center">
					<?php include "gw_statistics_menu.htm"; ?>

				</div>
				</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
			</tr>
		</table>
		</td>
		<td width="85%" height="1" colspan="6"></td>
	</tr>
	<tr>
		<td width="1%" align=center height="1">
		
           
		</td>
		<td width="83%" align=center height="1" colspan="5">
		
            <p align="left"><font color="#800000"><b>SERVICE LOAD   <font color=green>(<?php echo $sv_id;?> on <?php echo $id?>) </font></b></font></td>
	</tr>
	<tr>
		<td width="1%" align=center height="1">
		
           
		&nbsp;</td>
		<td width="83%" align=center height="1" colspan="5">
		
            <hr>
		
            </td>
	</tr>
	<tr>
		<td width="1%" align=center height="22">
		
           
		&nbsp;</td>
		<td width="83%" align=center height="22" valign="top" colspan="5">
		
          
					<font face=verdana size=2><center><?php 
	if ($RecordCount>0) {

	print "$RecordCount record(s) founds - You are at page $PageNo  of $MaxPage"; 
	}
	?></center></font>
<div style="padding:0px 0px 30px 30px;">
<?php 
if ($RecordCount>0) {

 $result = $con->viewGatewayLoadInformationByPage($criteria1,$id1,$sort,$how,$StartRow,$PageSize,$loginStatus,$cn);
?>
               
<table width="100%" border="0" class="InternalHeader" id="table9">
  <tr>
    <td>

      <div align="center"> <font face=verdana size=2>
      <?php
        //Print First & Previous Link is necessary
         if ($PageNo!=1)
            $PrevStart = $PageNo - 1;
          else 
          	$PrevStart = 1;
            print "<a href='service_load_details.php?PageNo=1&sort=$sort&how=$np&totalpages=$PageSize&criteria=$criteria&id=$id'><< First </a> : ";
            print "<a href='service_load_details.php?PageNo=$PrevStart&sort=$sort&how=$np&totalpages=$PageSize&criteria=$criteria&id=$id'>< Previous </a>";
        
        print " [ ";
        $c = 0;

        //Print Page No
        for($c=$CounterStart;$c<=$CounterEnd;$c++){
            if($c < $MaxPage){
                if($c == $PageNo){
                    if($c % $PageSize == 0){
                        print "$c ";
                    }else{
                        print "$c ,";
                    }
                }elseif($c % $PageSize == 0){
                    echo "<a href='service_load_details.php?PageNo=$c&sort=$sort&how=$np&totalpages=$PageSize&criteria=$criteria&id=$id'>$c</a> ";
                }else{
                    echo "<a href='service_load_details.php?PageNo=$c&sort=$sort&how=$np&totalpages=$PageSize&criteria=$criteria&id=$id'>$c</a> ,";
                }//END IF
            }else{
                if($PageNo == $MaxPage){
                    print "$c ";
                    break;
                }else{
                    echo "<a href='service_load_details.php?PageNo=$c&sort=$sort&how=$np&totalpages=$PageSize&criteria=$criteria&id=$id'>$c</a> ";
                    break;
                }//END IF
            }//END IF
       }//NEXT

      echo "] ";

      if($PageNo < $MaxPage)
          $NextPage = $PageNo + 1;
       else
      		$NextPage=$MaxPage;
          echo "<a href='service_load_details.php?PageNo=$NextPage&sort=$sort&how=$np&totalpages=$PageSize&criteria=$criteria&id=$id'>Next ></a>";
     

      //Print Last link if necessary
      if($CounterEnd < $MaxPage){
       $LastRec = $RecordCount % $PageSize;
        if($LastRec == 0){
            $LastStartRecord = $RecordCount - $PageSize;
        }
        else{
            $LastStartRecord = $RecordCount - $LastRec;
        }
}
        print " : ";
        echo "<a href='service_load_details.php?PageNo=$MaxPage&sort=$sort&how=$np&totalpages=$PageSize&criteria=$criteria&id=$id'>Last >></a>";
        
      ?>
</font>
      </div>
    </td>
  </tr>
</table>
</td>
	</tr>
	<tr>
		<td width="1%" align=center height="22">
		
           
		&nbsp;</td>
		<td width="4%" align=center height="22" valign="top">
<p align="left"></td>
		<td width="38%" align=center height="22" valign="top">
	<p align="left"><font size="1" face="Verdana">(<a href="<?php echo $url;?>"><img border="0" src="images/back_arrow.jpg" width="9" height="12"></a>
		<a style="text-decoration: none" href="<?php echo $url;?>">Back to 
					Graphical View</a>)</font></td>
		<td width="30%" align=center height="22" valign="top">
		
          
				

			<p align="right"><font size="1" face="Verdana">No of Records /Page</font></td>
		<td width="6%" align=center height="22" valign="top">
		
          
				

			<select size="1" name="totalpages" style="font-size: 8pt; font-family: Verdana" onchange="javascript:getURL(this.value);">
			<option value="100" <?php if ($PageSize==200) {?>selected <?php } ?>>100</option>
			<option value="200" <?php if ($PageSize==200) {?>selected <?php } ?>>200</option>
			<option value="300" <?php if ($PageSize==300) {?>selected <?php } ?>>300</option>
			<option value="500" <?php if ($PageSize==500) {?>selected <?php } ?>>500</option>
			<option value="1000" <?php if ($PageSize==1000) {?>selected <?php } ?>>1000</option>
			</select></td>
		<td width="5%" align=center height="22" valign="top">
		
          
				

		&nbsp;</td>
	</tr>
	<tr>
		<td width="1%" align=center height="280">
		
           
		</td>
		<td width="83%" align=center height="280" valign="top" colspan="5">
		
          
				

			<div style="width: 95%;">
<div style="padding:0px 0px 30px 30px;">                
<div style="width: 100%;"><font face=verdana size=2>

<br>
<div align="center">
<table width="95%" Border="1" class="NormalTableTwo" style="border-collapse: collapse" id="table10">
  <tr>
    <td class="InternalHeader" width="4%" bgcolor="#E1ECF9"><center><B>
	<font size="1" face="Verdana">No</font></B></center></td>
    <td class="InternalHeader" width="4%" bgcolor="#E1ECF9"><center>
	<a href="<?php echo $_SERVER["PHP_SELF"]."?page=service_load_details.php&PageNo=".$PageNo."&sort=source_user&totalpages=$PageSize&criteria=$criteria&id=$id&how=".$how; ?>" style="text-decoration: none">
	<font color="#000000" size="1">
	
	<img src='<?php 
	if ($sort=="source_user" and $how=="ASC")
		echo $aimg;
	else if ($sort=="source_user" and $how=="DESC")
		echo $dimg;
	else 
		echo $nimg;?>' border=0>
	</font>
	<B><font size="1" face="Verdana" color="#000000">Source User</font></B></a></center></td>
    <td class="InternalHeader" width="4%" bgcolor="#E1ECF9"><center><B>
	<a href="<?php echo $_SERVER["PHP_SELF"]."?page=service_load_details.php&PageNo=".$PageNo."&sort=remote_user&totalpages=$PageSize&criteria=$criteria&id=$id&how=".$how; ?>" style="text-decoration: none">
	<font size="1" face="Verdana" color="#000000">
	<img src='<?php 
	if ($sort=="remote_user" and $how=="ASC")
		echo $aimg;
	else if ($sort=="remote_user" and $how=="DESC")
		echo $dimg;
	else 
		echo $nimg;?>' border=0>
	Remote User</font></a></B></center></td>
    <td class="InternalHeader" width="20%" bgcolor="#E1ECF9"><center><B>
	<a href="<?php echo $_SERVER["PHP_SELF"]."?page=service_load_details.php&PageNo=".$PageNo."&sort=source_host&totalpages=$PageSize&criteria=$criteria&id=$id&how=".$how; ?>" style="text-decoration: none">
	<font size="1" face="Verdana" color="#000000">
	<img src='<?php 
	if ($sort=="source_host" and $how=="ASC")
		echo $aimg;
	else if ($sort=="source_host" and $how=="DESC")
		echo $dimg;
	else 
		echo $nimg;?>' border=0>
	Source Host</font></a></B></center></td>
    <td class="InternalHeader" width="20%" bgcolor="#E1ECF9"><center><B>
	<a href="<?php echo $_SERVER["PHP_SELF"]."?page=service_load_details.php&PageNo=".$PageNo."&sort=remote_host&totalpages=$PageSize&criteria=$criteria&id=$id&how=".$how; ?>" style="text-decoration: none">
	<font size="1" face="Verdana" color="#000000">
	<img src='<?php 
	if ($sort=="remote_host" and $how=="ASC")
		echo $aimg;
	else if ($sort=="remote_host" and $how=="DESC")
		echo $dimg;
	else 
		echo $nimg;?>' border=0>
	Remote Host</font></a></B></center></td>
    <td class="InternalHeader" width="5%" bgcolor="#E1ECF9"><center><B>
	<a href="<?php echo $_SERVER["PHP_SELF"]."?page=service_load_details.php&PageNo=".$PageNo."&sort=gw_name&totalpages=$PageSize&criteria=$criteria&id=$id&&how=".$how; ?>" style="text-decoration: none">
	<font size="1" face="Verdana" color="#000000">
	<img src='<?php 
	if ($sort=="gw_name" and $how=="ASC")
		echo $aimg;
	else if ($sort=="gw_name" and $how=="DESC")
		echo $dimg;
	else 
		echo $nimg;?>' border=0>
	Gateway</font></a></B></center></td>
    <td class="InternalHeader" width="5%" bgcolor="#E1ECF9"><center><B>
	<a href="<?php echo $_SERVER["PHP_SELF"]."?page=service_load_details.php&PageNo=".$PageNo."&sort=login&totalpages=$PageSize&criteria=$criteria&id=$id&how=".$how; ?>" style="text-decoration: none">
	<font size="1" face="Verdana" color="#000000">
	<img src='<?php 
	if ($sort=="login" and $how=="ASC")
		echo $aimg;
	else if ($sort=="login" and $how=="DESC")
		echo $dimg;
	else 
		echo $nimg;?>' border=0>
	Login</font></a></B></center></td>
    <td class="InternalHeader" width="5%" bgcolor="#E1ECF9">
	<p align="center"><font face=verdana size=2>

	<B>
	<a href="<?php echo $_SERVER["PHP_SELF"]."?page=service_load_details.php&PageNo=".$PageNo."&sort=logout&totalpages=$PageSize&&criteria=$criteria&id=$id&how=".$how; ?>" style="text-decoration: none">
	<font size="1" face="Verdana" color="#000000">
	<img src='<?php 
	if ($sort=="login" and $how=="ASC")
		echo $aimg;
	else if ($sort=="login" and $how=="DESC")
		echo $dimg;
	else 
		echo $nimg;?>' border=0>
	Logout</font></a></B></td>
    <td class="InternalHeader" width="5%" bgcolor="#E1ECF9"><center><B>
	<a href="<?php echo $_SERVER["PHP_SELF"]."?page=service_load_details.php&PageNo=".$PageNo."&sort=name&totalpages=$PageSize&criteria=$criteria&id=$id&how=".$how; ?>" style="text-decoration: none">
	<font size="1" face="Verdana" color="#000000">
	
	<img src='<?php 
	if ($sort=="name" and $how=="ASC")
		echo $aimg;
	else if ($sort=="name" and $how=="DESC")
		echo $dimg;
	else 
		echo $nimg;?>' border=0>
	Service</font></a></B></center></td>
    <td class="InternalHeader" width="5%" bgcolor="#E1ECF9"><center><B>
	<a href="<?php echo $_SERVER["PHP_SELF"]."?page=service_load_details.php&PageNo=".$PageNo."&sort=direction&totalpages=$PageSize&criteria=$criteria&id=$id&how=".$how; ?>" style="text-decoration: none">
	<font size="1" face="Verdana" color="#000000">
	<img src='<?php 
	if ($sort=="direction" and $how=="ASC")
		echo $aimg;
	else if ($sort=="direction" and $how=="DESC")
		echo $dimg;
	else 
		echo $nimg;?>' border=0>


	Direction</font></a></B></center></td>
	<td class="InternalHeader" width="5%" bgcolor="#E1ECF9"><center><B>
	<a href="<?php echo $_SERVER["PHP_SELF"]."?page=service_load_details.php&PageNo=".$PageNo."&sort=amd&totalpages=$PageSize&criteria=$criteria&id=$id&how=".$how; ?>" style="text-decoration: none">
	<font size="1" face="Verdana" color="#000000">
	<img src='<?php 
	if ($sort=="amd" and $how=="ASC")
		echo $aimg;
	else if ($sort=="amd" and $how=="DESC")
		echo $dimg;
	else 
		echo $nimg;?>' border=0>
	AM Status</font></a></B></center></td>



  </tr>

<?php
$i = 1;

while ($row = mysql_fetch_array($result)) {

    $bil = $i + ($PageNo-1)*$PageSize;
    $div = $bil%2;
      if (($bil%2)==0)
    	$bgCol = "#EDF5FF";
   	else
   		 $bgCol = "#FFFFFF";
  
?>
 <tr bgcolor="<?php echo $bgCol;?>">
    <td class="NormalFieldTwo" width="4%"><font size="1" face="Verdana"><?php echo $bil; ?></font></td>
    <td class="NormalFieldTwo" width="4%"><font size="1" face="Verdana"><?php echo $row["source_user"]; ?></font></td>
    <td class="NormalFieldTwo" width="4%"><font size="1" face="Verdana"><?php echo $row["remote_user"]; ?></font></td>
    <td class="NormalFieldTwo" width="20%"><font size="1" face="Verdana"><?php echo $row["source_host"]; ?></font></td>
    <td class="NormalFieldTwo" width="20%"><font size="1" face="Verdana"><?php echo $row["remote_host"]; ?></font></td>
    <td class="NormalFieldTwo" width="5%"><font size="1" face="Verdana"><?php echo $row["gw_name"]; ?></font></td>
    <td class="NormalFieldTwo" width="4%"><font size="1" face="Verdana"><?php echo $row["login"]; ?></font></td>
    <td class="NormalFieldTwo" width="4%"><font size="1" face="Verdana"><?php echo $row["logout"]; ?></font></td>
    <td class="NormalFieldTwo" width="4%"><font size="1" face="Verdana"><?php echo $row["name"]; ?></font></td>
    <td class="NormalFieldTwo" width="20%"><font size="1" face="Verdana"><?php echo $row["direction"]; ?></font></td>
    <td class="NormalFieldTwo" width="20%"><font size="1" face="Verdana"><?php echo $row["amd"]; ?></font></td>
 
  </tr>
<?php
  $i++;
}?>
</table></div>
<br>
<table width="100%" border="0" class="InternalHeader" id="table11">
  <tr>
    <td>

      <div align="center"> <font face=verdana size=2>
            <?php
        //Print First & Previous Link is necessary
         if ($PageNo!=1)
            $PrevStart = $PageNo - 1;
          else 
          	$PrevStart = 1;
            print "<a href='service_load_details.php?PageNo=1&sort=$sort&how=$np&totalpages=$PageSize&criteria=$criteria&id=$id'><< First </a> : ";
            print "<a href='service_load_details.php?PageNo=$PrevStart&sort=$sort&how=$np&totalpages=$PageSize&criteria=$criteria&id=$id'>< Previous </a>";
        
        print " [ ";
        $c = 0;

        //Print Page No
        for($c=$CounterStart;$c<=$CounterEnd;$c++){
            if($c < $MaxPage){
                if($c == $PageNo){
                    if($c % $PageSize == 0){
                        print "$c ";
                    }else{
                        print "$c ,";
                    }
                }elseif($c % $PageSize == 0){
                    echo "<a href='service_load_details.php?PageNo=$c&sort=$sort&how=$np&totalpages=$PageSize&criteria=$criteria&id=$id'>$c</a> ";
                }else{
                    echo "<a href='service_load_details.php?PageNo=$c&sort=$sort&how=$np&totalpages=$PageSize&criteria=$criteria&id=$id'>$c</a> ,";
                }//END IF
            }else{
                if($PageNo == $MaxPage){
                    print "$c ";
                    break;
                }else{
                    echo "<a href='service_load_details.php?PageNo=$c&sort=$sort&how=$np&totalpages=$PageSize&criteria=$criteria&id=$id'>$c</a> ";
                    break;
                }//END IF
            }//END IF
       }//NEXT

      echo "] ";

      if($PageNo < $MaxPage)
          $NextPage = $PageNo + 1;
       else
      		$NextPage=$MaxPage;
          echo "<a href='service_load_details.php?PageNo=$NextPage&sort=$sort&how=$np&totalpages=$PageSize&criteria=$criteria&id=$id'>Next ></a>";
     

      //Print Last link if necessary
      if($CounterEnd < $MaxPage){
       $LastRec = $RecordCount % $PageSize;
        if($LastRec == 0){
            $LastStartRecord = $RecordCount - $PageSize;
        }
        else{
            $LastStartRecord = $RecordCount - $LastRec;
        }
}
        print " : ";
        echo "<a href='service_load_details.php?PageNo=$MaxPage&sort=$sort&how=$np&totalpages=$PageSize&criteria=$criteria&id=$id'>Last >></a>";
        
      ?></font>
      </div>
    </td>
  </tr>
</table>
<?php
    mysql_free_result($result);
 }
 else {
 echo "<font face=verdana size=2 color=red><b><center>No Record Found</center></b></font>";
 }
    mysql_free_result($TRecord);
    
?>

    
</div>   

		
          
				

		</td>
	</tr>
	<tr>
		<td width="15%" bgcolor="#E5E3F0" valign="top">&nbsp;</td>
		<td width="85%" colspan="6">&nbsp;</td>
	</tr>
	<tr>
		<td width="100%" colspan="7" height="18"><hr></td>
	</tr>
</table>

</body>

</html>