<?php
/*
 * MySQL connection
 * */
$servername = "localhost";
$username = "radius";
$password = "rcFGmPSu68ZY";
$dbname = "radius";
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
//Security check
$nasip=$_SERVER['REMOTE_ADDR'];
//Security for nasIP
$nasip=mysqli_real_escape_string($conn, $nasip);
$query = 'select * from nas left join hotels on nas.hotel_id = hotels.id where nasname="'.$nasip.'"';
$result = $conn->query($query);
$myrow = $result->fetch_array();
echo $myrow['session_timeout'];
$conn->close();
?>

