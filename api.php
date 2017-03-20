<?php
$nasip=$_SERVER['REMOTE_ADDR'];
$link = mysql_connect('localhost', 'radius', 'rcFGmPSu68ZY') or die('Connection failed ' . mysql_error());
mysql_select_db('radius') or die('DB selection failed');
$query = 'select * from nas left join hotels on nas.hotel_id = hotels.id where nasname="'.$nasip.'"';
$result = mysql_query($query) or die('NAS query error ' . mysql_error());
$myrow = mysql_fetch_array($result);
echo $myrow['session_timeout'];
mysql_free_result($result);
mysql_close($link);
?>

