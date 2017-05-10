<?php
$nasip=$_SERVER['REMOTE_ADDR'];
$client_ip=$_GET['client_ip'];


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
$client_ip=mysqli_real_escape_string($conn, $client_ip);

$nasip=mysqli_real_escape_string($conn, $nasip);


$query = 'SELECT  * FROM radacct where nasipaddress="'.$nasip.'" and acctstoptime is null and framedipaddress="'.$client_ip.'"';

$result = $conn->query($query);
$myrow = $result->fetch_array();

if ($myrow[0]==0) {
	echo 0;

} else {
	echo "You connected: ".$client_ip.' Session started at: '.$myrow['acctstarttime'];
}
$conn->close();
?>

