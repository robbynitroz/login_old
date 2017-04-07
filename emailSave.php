<?php

$link = mysql_connect('localhost', 'radius', 'rcFGmPSu68ZY') or die('Connection failed ' . mysql_error());
mysql_select_db('radius') or die('DB selection failed');


$hotel_id    = $_POST['hotel_id'];
$router_ip   = $_POST['router_ip'];
$macaddress  = $_POST['macaddress'];
$template_id = $_POST['template_id'];
$email       = mysql_real_escape_string($_POST['email']);

$nasip       = $_POST['nasip']; //router ip
$url         = $_POST['url'];

$type = 'wifi';

//if(!filter_var($email, FILTER_VALIDATE_EMAIL))
//{
//    header('Location: ' . $_SERVER['HTTP_REFERER']);
//    exit;
//}

// Check does such mac_address exists for current hotel or not
$query = "SELECT * FROM emails WHERE mac_address = '$macaddress' AND hotel_id = '$hotel_id' ";
$result = mysql_query($query) or die('emailSave NAS query error 1' . mysql_error());

if(mysql_num_rows($result)) {
    // We need update existed row
    $query = "UPDATE emails SET  email='$email', email_type='wifi'  WHERE mac_address='$macaddress' AND hotel_id = '$hotel_id'";
    mysql_query($query) or die('emailSave NAS query error 2' . mysql_error());
} else {
    // We need to insert new row
    $query = "INSERT INTO emails (hotel_id, router_ip, mac_address, template_id, email, email_type) VALUES ('$hotel_id', '$nasip', '$macaddress', '$template_id', '$email', '$type')";
    mysql_query($query) or die('emailSave NAS query error 3' . mysql_error());
}


mysql_free_result($result);
mysql_close($link);

header("Location: http://$nasip:64873/login?username=$macaddress&password=$macaddress&dst=$url");
