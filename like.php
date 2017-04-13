<?php

$link = mysql_connect('localhost', 'root', 'Zq4F3R607h1K') or die('Connection failed ' . mysql_error());

mysql_select_db('radius') or die('DB selection failed');

if (isset($_POST['page_id'])) {

    $mac_address = $_POST['mac_address'];
    $hotel_id    = $_POST['hotel_id'];
    $page_id     = $_POST['page_id'];
    $email       = urldecode($_POST['email']);

    $query = "SELECT  *  FROM facebook where email='$email' and page_id='$page_id'";
    $result = mysql_query($query) or die('Radius query error 100' . mysql_error());
    $result_count = mysql_num_rows($result);

    // Such user already exists
    if ($result_count == 0) {
        $record = mysql_fetch_assoc($result);

        $query = "INSERT INTO facebook (mac_address, hotel_id, email, page_id) VALUES ('$mac_address', '$hotel_id', '$email', '$page_id')";
        $result = mysql_query($query) or die('Radius query error 102' . mysql_error());

        echo 1;
    }

}
