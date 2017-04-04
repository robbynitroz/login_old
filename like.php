<?php

$link = mysql_connect('localhost', 'root', 'Zq4F3R607h1K') or die('Connection failed ' . mysql_error());

mysql_select_db('radius') or die('DB selection failed');

if (isset($_POST['likes'])) {

    $mac_address = $_POST['mac_address'];
    $url         = $_POST['url'];

    $query = "SELECT  COUNT(*)  FROM facebook where mac_address='$mac_address' and page_url='$url'";
    $result = mysql_query($query) or die('Radius query error 100' . mysql_error());
    $result_count = mysql_num_rows($result);

    // Such user already exists
    if ($result_count) {
        $record = mysql_fetch_assoc($result);

        $like_count = $record['likes'] + 1;

        $query = "UPDATE facebook SET mac_address='$mac_address', page_url='$url', likes='$like_count', where username='$mac_address' and page_url='$url'";
        $result = mysql_query($query) or die('Radius query error 101' . mysql_error());

    } else {
        $record = mysql_fetch_assoc($result);

        $query = "INSERT INTO facebook (mac_address, page_url, likes, dislikes) VALUES ('$mac_address', '$url', '0', '0')";
        $result = mysql_query($query) or die('Radius query error 102' . mysql_error());
    }


} elseif (isset($_POST['dislikes'])) {

    $mac_address = $_POST['mac_address'];
    $url         = $_POST['url'];

    $query = "SELECT  COUNT(*)  FROM facebook where mac_address='$mac_address' and page_url='$url'";
    $result = mysql_query($query) or die('Radius query error 103' . mysql_error());
    $result_count = mysql_num_rows($result);

    // Such user already exists
    if ($result_count) {
        $record = mysql_fetch_assoc($result);
var_dump($record);exit;
        $dislikes_count = $record['dislikes'] + 1;

        $query = "UPDATE facebook SET mac_address='$mac_address', page_url='$url', dislikes='$dislikes_count', where username='$mac_address' and page_url='$url'";
        $result = mysql_query($query) or die('Radius query error 104' . mysql_error());

    } else {
        $record = mysql_fetch_assoc($result);

        $query = "INSERT INTO facebook (mac_address, page_url, likes, dislikes) VALUES ('$mac_address', '$url', '0', '0')";
        $result = mysql_query($query) or die('Radius query error 105' . mysql_error());
    }
}
