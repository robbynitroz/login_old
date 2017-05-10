<?php
error_reporting(0);


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





if (isset($_POST['page_id'])) {

    $mac_address = $_POST['mac_address'];
    $hotel_id    = $_POST['hotel_id'];
    $page_id     = $_POST['page_id'];
    $email       = urldecode($_POST['email']);


//Security check

//Security for MAC
    $mac_address=mysqli_real_escape_string($conn, $mac_address);
    $hotel_id=mysqli_real_escape_string($conn, $hotel_id);
    $page_id=mysqli_real_escape_string($conn, $page_id);
    $email=mysqli_real_escape_string($conn, $email);


    $query = "SELECT  *  FROM facebook where email='$email' and page_id='$page_id'";

    $result = $conn->query($query);


    // Such user already exists
    if ($result->num_rows == 0) {

        $record = $row = $result->fetch_assoc();

        $query = "INSERT INTO facebook (mac_address, hotel_id, email, page_id) VALUES ('$mac_address', '$hotel_id', '$email', '$page_id')";
        $result = $conn->query($query);

    }

    echo 1;
}
$conn->close();