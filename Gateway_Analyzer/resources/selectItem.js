var xmlhttp;
var xmlhttp1;
var xmlhttp2;
var xmlhttp3;
var xmlhttp4;
var xmlhttp5;
var xmlhttp6;
var divCount;

function getProperGraph(str1,str2)
{


xmlhttp1=GetXmlHttpObject();
if (xmlhttp1==null)
  {
  alert ("Your browser does not support AJAX!");
  return;
  }
if (str2=='gw_load') 
var url="gw_load_graph.php";
if (str2=='service_load') 
var url="service_load_graph.php";
if (str2=='top_ten_users') 
var url="top_ten_users_graph.php";
if (str2=='direction_load') 
var url="direction_load_graph.php";
if (str2=='am_return_codes') 
var url="am_return_codes_graph.php";
if (str2=='destination_host_load') 
var url="destination_host_load_graph.php";
if (str2=='history_load') 
var url="statistics_history_load_graph.php";

url=url+"?gt="+str1;



url=url+"&sid="+Math.random();

xmlhttp1.onreadystatechange=graphStateChanged;
xmlhttp1.open("GET",url,true);
xmlhttp1.send(null);
}

function graphStateChanged()
{

	
if (xmlhttp1.readyState==4)
  {
  document.getElementById("mainDiv").innerHTML=xmlhttp1.responseText;
  }
}

function get_detail_graph(str1,str2)
{


xmlhttp1=GetXmlHttpObject();
if (xmlhttp1==null)
  {
  alert ("Your browser does not support AJAX!");
  return;
  }
  
if (str2=='gw_load') 
var url="gw_detail_load_graph.php";
if (str2=='service_load') 
var url="service_detail_load_graph.php";
if (str2=='top_ten_users') 
var url="top_ten_users_detail_graph.php";
if (str2=='direction_load') 
var url="direction__detailload_graph.php";
if (str2=='am_return_codes') 
var url="am_return_codes_detail_graph.php";
if (str2=='destination_host_load') 
var url="destination_host_detail_load_graph.php";

url=url+"?gw="+str1;

alert(url);

url=url+"&sid="+Math.random();

xmlhttp1.onreadystatechange=detailGraphStateChanged;
xmlhttp1.open("GET",url,true);
xmlhttp1.send(null);
}

function detailGraphStateChanged()
{

	
if (xmlhttp1.readyState==4)
  {
  document.getElementById("detailDiv").innerHTML=xmlhttp1.responseText;
  }
}

function getRecord(str1)
{


xmlhttp1=GetXmlHttpObject();
if (xmlhttp1==null)
  {
  alert ("Your browser does not support AJAX!");
  return;
  }
  

var url="Listing_Query.php";

url=url+"?pg="+str1;

alert(url);

url=url+"&sid="+Math.random();

xmlhttp1.onreadystatechange=detailGraphStateChanged;
xmlhttp1.open("GET",url,true);
xmlhttp1.send(null);
}

function detailGraphStateChanged()
{

	
if (xmlhttp1.readyState==4)
  {
  document.getElementById("fileArea").innerHTML=xmlhttp1.responseText;
  }
}


function logoutUser() {
setTimeout('location.reload(true)', 1000);
xmlhttp = GetXmlHttpObject();

if (xmlhttp==null) {
return;
}

var url = "index.php";

xmlhttp.open('GET', url, true, "dummy_user", "dummy_password");

xmlhttp.setRequestHeader( "If-Modified-Since", "Sat, 1 Jan 2000 00:00:00 GMT" );
xmlhttp.setRequestHeader( 'Accept', 'message/x-formresult' );   
xmlhttp.send(null);
}


function GetXmlHttpObject()
{
if (window.XMLHttpRequest)
  {
  // code for IE7+, Firefox, Chrome, Opera, Safari
  return new XMLHttpRequest();
  }
if (window.ActiveXObject)
  {
  // code for IE6, IE5
  return new ActiveXObject("Microsoft.XMLHTTP");
  }
return null;
}