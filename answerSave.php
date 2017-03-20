<?php

$link = mysql_connect('localhost', 'radius', 'rcFGmPSu68ZY') or die('Connection failed ' . mysql_error());
mysql_select_db('radius') or die('DB selection failed');


$hotel_id    = $_POST['hotel_id'];
$router_ip   = $_POST['router_ip'];
$macaddress  = $_POST['macaddress'];
$template_id = $_POST['template_id'];
$answer      = $_POST['answer'];

$question_id = $_POST['question_id'];

$nasip       = $_POST['nasip']; //router ip
$url         = $_POST['url'];



$query  = "SELECT text
          FROM hotel_language
          LEFT JOIN languages on languages.id = hotel_language.language_id
          LEFT JOIN translate_question on translate_question.translate_id = hotel_language.translate_id
          WHERE hotel_language.hotel_id='$hotel_id'
          AND languages.name='English'";
//var_dump($query);exit;
$result = mysql_query($query) or die('AnswerSave NAS query error 1 ' . mysql_error());
$text = mysql_fetch_array($result)['text'];

// Check if there is a row already exists with answers
$query  = "SELECT * FROM answers WHERE mac_address='$macaddress'";
$result = mysql_query($query) or die('AnswerSave NAS query error 2 ' . mysql_error());

if(mysql_num_rows($result)) {
    $myrow  = mysql_fetch_array($result);
    $current_answer = json_decode($myrow['answer'], true);
    $current_answer[$question_id] = $answer;
    $new_answer = json_encode($current_answer);

    $query = "UPDATE answers SET  answer='$new_answer' WHERE mac_address='$macaddress'";
    mysql_query($query) or die('AnswerSave NAS query error 3' . mysql_error());
} else {
    $new_answer = json_encode(array($question_id => $answer));
    $query = "INSERT INTO answers (hotel_id, router_ip, mac_address, template_id, answer)
                          VALUES ('$hotel_id', '$nasip', '$macaddress', '$template_id', '$new_answer')";
    mysql_query($query) or die('AnswerSave NAS query error 4' . mysql_error());
}

// Insert data to stats table
$query = "INSERT INTO stats (hotel_id, router_ip, mac_address, template_id, answer, question_id, question_text)
                          VALUES ('$hotel_id', '$nasip', '$macaddress', '$template_id', '$answer', '$question_id', '$text')";
mysql_query($query) or die('AnswerSave NAS query error 5' . mysql_error());


mysql_free_result($result);
mysql_close($link);

header("Location: http://$nasip:64873/login?username=$macaddress&password=$macaddress&dst=$url");
