<?php



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





$hotel_id    = $_POST['hotel_id'];
$router_ip   = $_POST['router_ip'];
$macaddress  = $_POST['macaddress'];
$template_id = $_POST['template_id'];
$answer      = $_POST['answer'];

$question_id = $_POST['question_id'];

$nasip       = $_POST['nasip']; //router ip
$url         = $_POST['url'];

//Security
$hotel_id=mysqli_real_escape_string($conn, $hotel_id);
$router_ip=mysqli_real_escape_string($conn, $router_ip);
$macaddress=mysqli_real_escape_string($conn, $macaddress);
$template_id=mysqli_real_escape_string($conn, $template_id);
$answer=mysqli_real_escape_string($conn, $answer);
$question_id=mysqli_real_escape_string($conn, $question_id);
$nasip=mysqli_real_escape_string($conn, $nasip);
$url=mysqli_real_escape_string($conn, $url);

$query  = "SELECT text
          FROM hotel_language
          LEFT JOIN languages on languages.id = hotel_language.language_id
          LEFT JOIN translate_question on translate_question.translate_id = hotel_language.translate_id
          WHERE hotel_language.hotel_id='$hotel_id'
          AND languages.name='English'";



$result = $conn->query($query);
$text = $result->fetch_array()['text'];


// Check if there is a row already exists with answers

$result = $conn->query($query);



if ($result->num_rows > 0) {
    $result = $result->fetch_array();
    $current_answer = json_decode($myrow['answer'], true);
    $current_answer[$question_id] = $answer;
    $new_answer = json_encode($current_answer);
    $query = "UPDATE answers SET  answer='$new_answer' WHERE mac_address='$macaddress'";
    $result = $conn->query($query);

}
 else {
    $new_answer = json_encode(array($question_id => $answer));


    $query = "INSERT INTO answers (hotel_id, router_ip, mac_address, template_id, answer)
                          VALUES ('$hotel_id', '$nasip', '$macaddress', '$template_id', '$new_answer')";
     $result = $conn->query($query);

}

// Insert data to stats table
$query = "INSERT INTO stats (hotel_id, router_ip, mac_address, template_id, answer, question_id, question_text)
                          VALUES ('$hotel_id', '$nasip', '$macaddress', '$template_id', '$answer', '$question_id', '$text')";
$result = $conn->query($query);
$conn->close();




header("Location: http://$nasip:64873/login?username=$macaddress&password=$macaddress&dst=$url");
