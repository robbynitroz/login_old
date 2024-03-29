<?php

/*
 * Languages available
 * */
$language_codes = [
    'en' => 'English',
    'fr' => 'French',
    'de' => 'German',
    'es' => 'Spanish',
    'it' => 'Italian',
    'nl' => 'Dutch'
];

$GLOBALS = array();


/*
 * Getting reqired data with GET
 * */

//IP address
$nasip = $_SERVER['REMOTE_ADDR'];
//MAC adress
$macaddress = $_GET['clientmac'];

//Including
include "UserAgentParser.php";
$ua_info = parse_user_agent();
$ua_info['platform'];
$ua_info['browser'];
$lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);






if (empty($macaddress) or $macaddress===null) {
    header('Location: http://login.com/status.php', true, 301);
    exit;
}


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
//Security for IP
$nasip=mysqli_real_escape_string($conn, $nasip);
//Security for platform
$ua_info['platform']=mysqli_real_escape_string($conn, $ua_info['platform']);
//Security for browser
$ua_info['browser']=mysqli_real_escape_string($conn, $ua_info['browser']);

$lang=mysqli_real_escape_string($conn, $lang);









$sql = 'SELECT  COUNT(username)  FROM radcheck where username="' . $macaddress . '" and attribute="User-Password"';
$result = $conn->query($sql);





if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {

        $rezultat=$row;

    }
}

if ($rezultat["COUNT(username)"] == 0) {

    $sql="INSERT INTO radcheck (username, attribute, op, value)
VALUES ('$macaddress', 'User-Password', '==', '$macaddress')";



    if ($conn->query($sql) === false) {
        echo "Error: " . $sql . "<br>" . $conn->error;

    }
};


//First phase end


$sql = 'SELECT  COUNT(username)  FROM radcheck where username="' . $macaddress . '" and attribute="Auth-Type"';
$result = $conn->query($sql);



if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {

        $rezultat=$row;

    }
}


if ($rezultat["COUNT(username)"] == 0) {


    $sql="INSERT INTO radcheck (username, attribute, op, value)
VALUES ('$macaddress', 'Auth-Type', ':=', '\"Accept\"')";



    if ($conn->query($sql) === false) {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}




//Third phase



$sql = 'SELECT COUNT(client_mac)  FROM clients_mac where client_mac="' . $macaddress . '"';
$result = $conn->query($sql);



if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {

        $rezultat=$row;



    }
}


if ($rezultat["COUNT(client_mac)"] == 0) {

$sql="INSERT INTO clients_mac (client_mac, os, browser, language)
VALUES ('$macaddress', 'Auth-Type', ':=', '$lang')";

    if ($conn->query($sql) === false) {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
};




//Last phase


$sql ="SELECT * from nas LEFT JOIN hotels ON nas.hotel_id=hotels.id WHERE nas.nasname='$nasip'";
$result = $conn->query($sql);


    ;
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {

        $rezultat=$row;

    }

    }
else{

    die('DB error: Please try later');
}


$url         = $rezultat['url'];
$hotel_id    = $rezultat['hotel_id'];
$hotel_name  = $rezultat['name'];
$template_id = '';


// Get Facebook's like page's URL

$sql ="select facebook_page, facebook_page_id from hotels where id='$hotel_id'";
$result = $conn->query($sql);


if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {

        $fb=$row;

    }

}
else{

    die('DB error: Please try later');
}


$fb_url = $fb['facebook_page'];
$fb_page_id = $fb['facebook_page_id'];





if(empty($rezultat['active_template_id']))
{



    $sql ="select * from templates where hotel_id='$hotel_id' and name='Login template'";
    $result = $conn->query($sql);


    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {

            $tmp=$row;

        }

    }
    else{

        die('DB error: Please try later');
    }



    $template_id = $tmp['id'];
}
else
{
    $template_id = $rezultat['active_template_id'];
}



// Find Active template's name
$sql ="select name from templates where id='$template_id'";
$result = $conn->query($sql);


if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {

        $myrow=$row;

    }

}
else{

    die('DB error: Please try later');
}


$GLOBALS['template_name'] = $myrow['name'];



$sql ="select * from templates
          left join templates_variables on templates.id = templates_variables.template_id
          where templates.id='$template_id' and hotel_id='$hotel_id'";
$result = $conn->query($sql);


if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {

        $myrow=$row;

    }

}
else{

    die('DB error: Please try later');
}



$GLOBALS['image']              = $myrow['hotel_logo'];
$GLOBALS['bg_color']           = $myrow['hotel_bg_color'];
//Color of Header
$GLOBALS['font_color_1']       = $myrow['hotel_font_color1'];
//Color of button
$GLOBALS['font_color_2']       = $myrow['hotel_font_color2'];
//Color of label 3
$GLOBALS['font_color_3']       = $myrow['hotel_font_color3'];
$GLOBALS['font_size_1']        = $myrow['hotel_font_size1'];
$GLOBALS['font_size_2']        = $myrow['hotel_font_size2'];
$GLOBALS['font_size_3']        = $myrow['hotel_font_size3'];
$GLOBALS['hotel_bg_image']     = $myrow['hotel_bg_image'];
$GLOBALS['hotel_centr_color']  = $myrow['hotel_centr_color'];
$GLOBALS['hotel_btn_bg_color'] = $myrow['hotel_btn_bg_color'];







/*********************** Get translated text variables ***************************/
// Check if device's language exists in language_codes

if ( ! isset($language_codes[$lang])) {
    $lang = 'en';
}

$sql ="select * from hotel_language
          left join languages on languages.id = hotel_language.language_id
          where hotel_language.hotel_id='$hotel_id' and languages.name='$language_codes[$lang]'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {

        $check_language=$row;

    }

}
else{

    $check_language=null;
}



$translate_id = 0;









if($check_language) {
    $translate_id_query = "select translate_id from hotel_language
                              left join languages on languages.id = hotel_language.language_id
                              where languages.name='$language_codes[$lang]' and hotel_language.hotel_id='$hotel_id'";


    $result = $conn->query($translate_id_query);

    while ($row = $result->fetch_assoc()) {

        $translate_id = $row['translate_id'];

    }


    if ($GLOBALS['template_name'] == 'Question template') {
        $query = "select * from translate_question_label
                  where translate_id='$translate_id'";
        $result = $conn->query($query);

        while ($row = $result->fetch_assoc()) {

            $translate_data = $row;

        }


        $GLOBALS['translate_question_label'] = $translate_data['translate_question_label'];
    }
    if ($GLOBALS['template_name'] == 'Login template') {
        $query = "select * from translate_login
                  where translate_id='$translate_id'";


        $result = $conn->query($query);

        while ($row = $result->fetch_assoc()) {

            $translate_data = $row;

        }


        $GLOBALS['hotel_label_1'] = $translate_data['hotel_label_1'];
        $GLOBALS['hotel_label_2'] = $translate_data['hotel_label_2'];
        $GLOBALS['hotel_btn_label'] = $translate_data['hotel_btn_label'];
    }
    if ($GLOBALS['template_name'] == 'Email template') {
        $query = "select * from translate_email
                  where translate_id='$translate_id'";


        $result = $conn->query($query);

        while ($row = $result->fetch_assoc()) {

            $translate_data = $row;

        }

        $GLOBALS['hotel_label_1'] = $translate_data['hotel_label_1'];
        $GLOBALS['hotel_label_2'] = $translate_data['hotel_label_2'];
        $GLOBALS['hotel_btn_label'] = $translate_data['hotel_btn_label'];
    }

    if ($GLOBALS['template_name'] == 'Facebook template') {
        $query = "select * from translate_fb
                  where translate_id='$translate_id'";
        $result = $conn->query($query);

        while ($row = $result->fetch_assoc()) {

            $translate_data = $row;

        }

        $GLOBALS['title'] = $translate_data['title'];
        $GLOBALS['middle_title'] = $translate_data['middle_title'];
        $GLOBALS['email_title'] = $translate_data['email_title'];
        $GLOBALS['fb_title'] = $translate_data['fb_title'];
    }

    //Get terms texts for current language
    $translate_term = "select * from translate_term
                              left join languages on languages.id = translate_term.language_id
                              where languages.name='$language_codes[$lang]'";

    $result = $conn->query($translate_term);

    while ($row = $result->fetch_assoc()) {

        $translate_term_data = $row;

    }

    $GLOBALS['term_title'] = $translate_term_data['title'];
    $GLOBALS['term_text'] = $translate_term_data['text'];


}



else
{
    $translate_id_query = "select translate_id, language_id from hotel_language
                              left join languages on languages.id = hotel_language.language_id
                              where hotel_language.is_default='1' and hotel_language.hotel_id='$hotel_id'";


    $result = $conn->query($translate_id_query);
    while ($row = $result->fetch_assoc()) {

        $data = $row;
    }

    $translate_id = $data['translate_id'];
    $language_id  = $data['language_id'];

    if ($GLOBALS['template_name'] == 'Question template')
    {
        $query = "select * from translate_question_label
                  where translate_id='$translate_id'";

        $result = $conn->query($query);
        while ($row = $result->fetch_assoc()) {

            $translate_data = $row;
        }



        $GLOBALS['translate_question_label'] = $translate_data['translate_question_label'];
    }
    if ($GLOBALS['template_name'] == 'Login template')
    {
        $query = "select * from translate_login
                  where translate_id='$translate_id'";


        $result = $conn->query($query);
        while ($row = $result->fetch_assoc()) {

            $translate_data = $row;
        }


        $GLOBALS['hotel_label_1']      = $translate_data['hotel_label_1'];
        $GLOBALS['hotel_label_2']      = $translate_data['hotel_label_2'];
        $GLOBALS['hotel_btn_label']    = $translate_data['hotel_btn_label'];
    }
    if ($GLOBALS['template_name'] == 'Email template')
    {
        $query = "select * from translate_email
                  where translate_id='$translate_id'";


        $result = $conn->query($query);
        while ($row = $result->fetch_assoc()) {

            $translate_data = $row;
        }

        $GLOBALS['hotel_label_1']      = $translate_data['hotel_label_1'];
        $GLOBALS['hotel_label_2']      = $translate_data['hotel_label_2'];
        $GLOBALS['hotel_btn_label']    = $translate_data['hotel_btn_label'];
    }

    if ($GLOBALS['template_name'] == 'Facebook template')
    {
        $query = "select * from translate_fb
                  where translate_id='$translate_id'";


        $result = $conn->query($query);
        while ($row = $result->fetch_assoc()) {

            $translate_data = $row;
        }

        $GLOBALS['title']        = $translate_data['title'];
        $GLOBALS['middle_title'] = $translate_data['middle_title'];
        $GLOBALS['email_title']  = $translate_data['email_title'];
        $GLOBALS['fb_title']     = $translate_data['fb_title'];
    }

    //Get terms texts for current language
    $translate_term = "select * from translate_term
                              left join languages on languages.id = translate_term.language_id
                              where languages.id='$language_id'";
    $result = $conn->query($translate_term);
    while ($row = $result->fetch_assoc()) {

        $translate_term_data = $row;
    }

    $GLOBALS['term_title'] = $translate_term_data['title'];
    $GLOBALS['term_text'] = $translate_term_data['text'];
}







/**
 * Show question that user haven't seen yet
 * @param $mac_address
 * @param $hotel_id
 * @param $translate_id
 * @param $template_id
 * @param $conn - MySQL
 * @return array
 */
function checkFirstLogin($mac_address, $hotel_id, $translate_id, $conn)
{
    //Get hotel questions timeout
    $query = "SELECT questions_timeout FROM hotels WHERE id = '$hotel_id'";

    $result = $conn->query($query);
    while ($row = $result->fetch_assoc()) {

        $myrow = $row;
    }


    // Get timeout in days
    $questions_timeout = intval($myrow['questions_timeout']);

    // Convert days to seconds
    $questions_timeout = $questions_timeout * 24 * 3600;

    //First of all we should check if timeout is expired so we delete all old questions and stat from scratch
    $query  = 'SELECT updated_at FROM answers WHERE mac_address = "'. $mac_address .'"';

    $result = $conn->query($query);
    while ($row = $result->fetch_assoc()) {

        $myrow = $row;
    }

    $last_answer_time = strtotime($myrow['updated_at']);

    //current time
    $current_time = time();

    //If current time more than $last_answer_time so timeout was expired
    if($current_time - $last_answer_time > $questions_timeout) {
        $query = "DELETE FROM answers WHERE mac_address='$mac_address'";

        $conn->query($query);


    }

    $query  = 'SELECT * FROM answers WHERE mac_address = "'. $mac_address .'"';

    $result = $conn->query($query);


    //I AM HERE


    if ($result->num_rows > 0) {
        // output data of each row
        return checkIfExistsNonAnsweredQuestion($mac_address, $hotel_id, $translate_id);

        }

    else {
        // This mean that user hasn't even one answer so we show 'is_first' question
        //Find Hotel's Question template's is_first question
        $query_1 = "select * from translate_question
                    left join hotel_question on hotel_question.question_id = translate_question.question_id
                    where translate_id='$translate_id' and hotel_id='$hotel_id' and is_first='1'";

        $result = $conn->query($query_1);
        while ($row = $result->fetch_assoc()) {

            $myrow = $row;
        }

        //Get template icon set
        $icon_set_id = $myrow['icon_set_id'];


        $query_2 = "select icon_1, icon_2, icon_3 from icon_sets where id='$icon_set_id'";

        $result = $conn->query($query_2);
        while ($row = $result->fetch_assoc()) {

            $myrow_2 = $row;
        }

        return [
            'question'    => $myrow['text'],
            'question_id' => $myrow['question_id'],
            'icon_1'      => $myrow_2['icon_1'],
            'icon_2'      => $myrow_2['icon_2'],
            'icon_3'      => $myrow_2['icon_3']
        ];
    }
}




function checkIfExistsNonAnsweredQuestion($mac_address, $hotel_id, $translate_id, $conn)
{
    //Get all answers of this user
    $query  = 'SELECT answer FROM answers WHERE mac_address = "'. $mac_address .'"';

    $result = $conn->query($query);
    while ($row = $result->fetch_assoc()) {

        $myrow = $row;
    }


    $answers_arr = json_decode($myrow['answer'], true);

    $answered_ids = array_keys($answers_arr);

    //Get all answers ids for this hotel
    $query   =  'SELECT question_id FROM hotel_question WHERE hotel_id = "'. $hotel_id .'"';

    $result = $conn->query($query);
    while ($myrow_2 = $result->fetch_array()) {

        $all_answers_ids[] = intval($myrow_2['question_id']);
    }


//    sort($answered_ids);
//    sort($all_answers_ids);

    // Check this cause arrays can be different and $answered_ids.length > $all_answers_ids.length
    // but all available questions could be answered
    $arr_diff = array_diff($all_answers_ids, $answered_ids);

    if(count($arr_diff) == 0) {
        // two arrays are the same so user have answered to all questions so we show Login page
        $GLOBALS['template_name'] = 'Login template';

        $query = "select * from templates
                  left join templates_variables on templates.id = templates_variables.template_id
                  where templates.name='Login template' and hotel_id='$hotel_id'";


        $result = $conn->query($query);


        $myrow = $result->fetch_array();
        $GLOBALS['image']              = $myrow['hotel_logo'];
        $GLOBALS['bg_color']           = $myrow['hotel_bg_color'];
        //Color of Header
        $GLOBALS['font_color_1']       = $myrow['hotel_font_color1'];
        //Color of button
        $GLOBALS['font_color_2']       = $myrow['hotel_font_color2'];
        //Color of label 3
        $GLOBALS['font_color_3']       = $myrow['hotel_font_color3'];
        $GLOBALS['font_size_1']        = $myrow['hotel_font_size1'];
        $GLOBALS['font_size_2']        = $myrow['hotel_font_size2'];
        $GLOBALS['font_size_3']        = $myrow['hotel_font_size3'];
        $GLOBALS['hotel_bg_image']     = $myrow['hotel_bg_image'];
        $GLOBALS['hotel_centr_color']  = $myrow['hotel_centr_color'];
        $GLOBALS['hotel_btn_bg_color'] = $myrow['hotel_btn_bg_color'];

        $query = "select * from translate_login
                  where translate_id='$translate_id'";

        $result = $conn->query($query);
        $translate_data = $result->fetch_array();


        $GLOBALS['hotel_label_1']      = $translate_data['hotel_label_1'];
        $GLOBALS['hotel_label_2']      = $translate_data['hotel_label_2'];
        $GLOBALS['hotel_btn_label']    = $translate_data['hotel_btn_label'];

    } else {
        // two arrays aren't the same so user haven't answered to all questions
        // Get difference between arrays
        $non_answered_questions = array_diff($all_answers_ids, $answered_ids);

        //Getting one non answered question's id randomly
        $rand_key = array_rand($non_answered_questions);
        $non_answered_question_id = $non_answered_questions[$rand_key];

        $query_1 = "select * from translate_question
                    where translate_id='$translate_id' and question_id='$non_answered_question_id'";

        $result = $conn->query($query_1);
        $myrow = $result->fetch_array();



        //Get template icon set
        $query_2 = "select icon_1, icon_2, icon_3 from icon_sets
                    left join hotel_question on  hotel_question.icon_set_id = icon_sets.id
                    where question_id='$non_answered_question_id'";

        $result = $conn->query($query_2);
        $myrow_2 = $result->fetch_array();



        return [
            'question'    => $myrow['text'],
            'question_id' => $myrow['question_id'],
            'icon_1'      => $myrow_2['icon_1'],
            'icon_2'      => $myrow_2['icon_2'],
            'icon_3'      => $myrow_2['icon_3']
        ];
    }
}




/**
 * If user loged in more than 2 weeks ago so we show him again Email page, otherwise just Login page
 */
function checkEmailLogin($mac_address, $translate_id, $hotel_id, $conn)
{
    //Get hotel emails timeout
    $query = "SELECT emails_timeout FROM hotels WHERE id = '$hotel_id'";

    $result = $conn->query($query);
    $myrow = $result->fetch_array();
    $emails_timeout = intval($myrow['emails_timeout']);

    // Convert days to seconds
    $timeout = $emails_timeout * 24 * 3600;
//    print_r('timeout = '.$timeout);

    //current time
    $current_time = time();
//    print_r('current_time = '.$current_time);

    //Get user's last login
//    $query = "SELECT updated_at FROM emails WHERE mac_address='$mac_address' and hotel_id = '$hotel_id' and type = 'wifi'";
    $query = "SELECT updated_at FROM emails WHERE mac_address='$mac_address' and hotel_id = '$hotel_id'";
    $result = $conn->query($query);
    $myrow = $result->fetch_array();


    // Last time when user loged in via Email page
    $last_login_time = strtotime($myrow['updated_at']);
//    echo('last_login_time = '.$myrow['updated_at']);  echo "<br>";
//    echo('mac_address = '.$mac_address);  echo "<br>";
//    echo('hotel_id = '.$hotel_id);  echo "<br>";


    // Difference between last login and current time
    $diff_time = $current_time - $last_login_time;
//    echo('current_time = '.$current_time);exit;
    // User loged in more than 2 weeks ago
    if($diff_time > $timeout) {
        $GLOBALS['template_name'] = 'Email template';
    } else {
        // Show login page
        $GLOBALS['template_name'] = 'Login template';

        $query = "select * from templates left join templates_variables on templates.id = templates_variables.template_id
                  where templates.name='Login template' and hotel_id = '$hotel_id'";

        $result = $conn->query($query);
        $myrow = $result->fetch_array();

        $GLOBALS['image']              = $myrow['hotel_logo'];
        $GLOBALS['bg_color']           = $myrow['hotel_bg_color'];
        //Color of Header
        $GLOBALS['font_color_1']       = $myrow['hotel_font_color1'];
        //Color of button
        $GLOBALS['font_color_2']       = $myrow['hotel_font_color2'];
        //Color of label 3
        $GLOBALS['font_color_3']       = $myrow['hotel_font_color3'];
        $GLOBALS['font_size_1']        = $myrow['hotel_font_size1'];
        $GLOBALS['font_size_2']        = $myrow['hotel_font_size2'];
        $GLOBALS['font_size_3']        = $myrow['hotel_font_size3'];
        $GLOBALS['hotel_bg_image']     = $myrow['hotel_bg_image'];
        $GLOBALS['hotel_centr_color']  = $myrow['hotel_centr_color'];
        $GLOBALS['hotel_btn_bg_color'] = $myrow['hotel_btn_bg_color'];

        $query = "select * from translate_login
                  where translate_id='$translate_id'";

        $result = $conn->query($query);
        $translate_data = $result->fetch_array();


        $GLOBALS['hotel_label_1']      = $translate_data['hotel_label_1'];
        $GLOBALS['hotel_label_2']      = $translate_data['hotel_label_2'];
        $GLOBALS['hotel_btn_label']    = $translate_data['hotel_btn_label'];

    }

}


if ($GLOBALS['template_name'] == 'Question template') {
    $question_data = checkFirstLogin($macaddress, $hotel_id, $translate_id, $template_id);
}
else if($GLOBALS['template_name'] == 'Email template') {
    checkEmailLogin($macaddress, $translate_id, $hotel_id, $conn);
}




function hex2rgba($color, $opacity = false, $darkness = 0)
{

    $default = 'rgb(0,0,0)';

    //Return default if no color provided
    if(empty($color))
        return $default;

    //Sanitize $color if "#" is provided
    if ($color[0] == '#' ) {
        $color = substr( $color, 1 );
    }

    //Check if color has 6 or 3 characters and get values
    if (strlen($color) == 6) {
        $hex = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
    } elseif ( strlen( $color ) == 3 ) {
        $hex = array( $color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2] );
    } else {
        return $default;
    }

    //Convert hexadec to rgb
    $rgb =  array_map('hexdec', $hex);

    foreach($rgb as $key => $value){
        $rgb[$key] = intval($value - $value*($darkness/100));
    }

    //Check if opacity is set(rgba or rgb)
    if($opacity){
        if(abs($opacity) > 1)
            $opacity = 1.0;
        $output = 'rgba('.implode(",",$rgb).','.$opacity.')';
    } else {
        $output = 'rgb('.implode(",",$rgb).')';
    }

    //Return rgb(a) color string
    return $output;
}




$conn->close();





if ($GLOBALS['template_name'] == 'Facebook template'){

    // Include and instantiate the class.
    require_once 'lib/Mobile_Detect.php';
    $detect = new Mobile_Detect;

    // Any mobile device (phones or tablets).
    if ( $detect->isMobile() || $detect->isTablet() ) {
        include_once "fb_template/mobile.php";
    }

    // Exclude tablets.
    if( !$detect->isMobile() && !$detect->isTablet() ){
        include_once "fb_template/desktop.php";
    }

} else {
    include_once "index2.php";
}
?>

