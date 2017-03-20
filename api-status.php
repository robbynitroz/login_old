<?php
$nasip=$_SERVER['REMOTE_ADDR'];
$client_ip=$_GET['client_ip'];
$link = mysql_connect('localhost', 'radius', 'rcFGmPSu68ZY') or die('Connection failed ' . mysql_error());
mysql_select_db('radius') or die('DB selection failed');
$query = 'SELECT  * FROM radacct where nasipaddress="'.$nasip.'" and acctstoptime is null and framedipaddress="'.$client_ip.'"';
$result = mysql_query($query) or die('radacct query error ' . mysql_error());
$myrow = mysql_fetch_array($result);

if ($myrow[0]==0) {
	echo 0;

} else {
	echo "You connected: ".$client_ip.' Session started at: '.$myrow['acctstarttime'];
}
mysql_free_result($result);
mysql_close($link);
?>

