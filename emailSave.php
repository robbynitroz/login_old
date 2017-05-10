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

//Security for MAC
$macaddress=mysqli_real_escape_string($conn, $macaddress);




$hotel_id    = $_POST['hotel_id'];
$router_ip   = $_POST['router_ip'];
$macaddress  = $_POST['macaddress'];
$template_id = $_POST['template_id'];
$email       = $_POST['email'];

$nasip       = $_POST['nasip']; //router ip
$url         = $_POST['url'];

$type = 'wifi';


//Security for MAC
$hotel_id=mysqli_real_escape_string($conn, $hotel_id);
$router_ip=mysqli_real_escape_string($conn, $router_ip);
$macaddress=mysqli_real_escape_string($conn, $macaddress);
$template_id=mysqli_real_escape_string($conn, $template_id);
$email=mysqli_real_escape_string($conn, $email);
$nasip=mysqli_real_escape_string($conn, $nasip);
$url=mysqli_real_escape_string($conn, $url);

//if(!filter_var($email, FILTER_VALIDATE_EMAIL))
//{
//    header('Location: ' . $_SERVER['HTTP_REFERER']);
//    exit;
//}

// Check does such mac_address exists for current hotel or not
$query = "SELECT * FROM emails WHERE mac_address = '$macaddress' AND hotel_id = '$hotel_id' ";

$result = $conn->query($query);


if ($result->num_rows > 0) {
    // We need update existed row
    $query = "UPDATE emails SET  email='$email', email_type='wifi'  WHERE mac_address='$macaddress' AND hotel_id = '$hotel_id'";

     if($conn->query($query)!==true){

         die("MySQL Error");
     };

} else {
    // We need to insert new row
    $query = "INSERT INTO emails (hotel_id, router_ip, mac_address, template_id, email, email_type) VALUES ('$hotel_id', '$nasip', '$macaddress', '$template_id', '$email', '$type')";

    if($conn->query($query)!==true){

        die("MySQL Error");
    };


}


$conn->close();

header("Location: http://$nasip:64873/login?username=$macaddress&password=$macaddress&dst=$url");
