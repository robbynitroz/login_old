<?php

/*  Edd new template_variables */


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



// Get all email templates ID
$query = 'select f.id as f_id, f.hotel_id, e.id as e_id
            from templates f, templates e
            where f.name = "Facebook template"
            and e.name = "Email template"
            and f.hotel_id = e.hotel_id
            ORDER BY f.hotel_id';

$result = $conn->query($query);



$all_ids = [];
while($myrow =  $result->fetch_array()) {
    $all_ids[] = [
        'f_id' => intval($myrow['f_id']),
        'e_id' => intval($myrow['e_id']),
    ];
}
$result_array = [];
foreach ($all_ids as $item) {
    $query  = 'select * from templates_variables where template_id = "'. $item['e_id'] .'"';

    $result = $conn->query($query);
    $myrow =  $result->fetch_array();
    unset($myrow['id']);
    $myrow['template_id'] = $item['f_id'];

    $columns = implode(", ", array_keys($myrow));

    $template_id        = empty($myrow['template_id']) ? 0 : $myrow['template_id'];
    $hotel_bg_color     = $myrow['hotel_bg_color'];
    $hotel_bg_image     = $myrow['hotel_bg_image'];
    $hotel_logo         = $myrow['hotel_logo'];
    $hotel_centr_color  = $myrow['hotel_centr_color'];
    $hotel_btn_bg_color = $myrow['hotel_btn_bg_color'];
    $hotel_font_color1  = $myrow['hotel_font_color1'];
    $hotel_font_color2  = $myrow['hotel_font_color2'];
    $hotel_font_color3  = $myrow['hotel_font_color3'];
    $hotel_font_size1   = empty($myrow['hotel_font_size1']) ? 0 : $myrow['hotel_font_size1'];
    $hotel_font_size2   = empty($myrow['hotel_font_size2']) ? 0 : $myrow['hotel_font_size2'];
    $hotel_font_size3   = empty($myrow['hotel_font_size3']) ? 0 : $myrow['hotel_font_size3'];

    $query = "INSERT INTO templates_variables ($columns) VALUES ($template_id, '$hotel_bg_color', '$hotel_bg_image', '$hotel_logo', '$hotel_centr_color', '$hotel_btn_bg_color', '$hotel_font_color1','$hotel_font_color2', '$hotel_font_color3', $hotel_font_size1, $hotel_font_size2, $hotel_font_size3)";

    if($conn->query($query)!==true){

        die("MySQL error");
    };


}

/*  Edd new template */
"INSERT INTO templates (hotel_id, name)
SELECT DISTINCT hotel_id, 'Facebook template' FROM templates;";

$conn->close();