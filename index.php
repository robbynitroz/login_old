<?php
error_reporting(E_ERROR);

$language_codes = [
    'en' => 'English',
    'fr' => 'French',
    'de' => 'German',
    'es' => 'Spanish',
    'it' => 'Italian',
    'nl' => 'Dutch'
];

$GLOBALS = array();

$nasip = $_SERVER['REMOTE_ADDR'];
$macaddress = $_GET['clientmac'];
include "UserAgentParser.php";
$ua_info = parse_user_agent();
$ua_info['platform'];
$ua_info['browser'];
$lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);

if ($macaddress == '') {
    header('Location: http://login.com/status.php', true, 301);
    exit;
}

$link = mysql_connect('localhost', 'root', 'Zq4F3R607h1K') or die('Connection failed ' . mysql_error());

mysql_select_db('radius') or die('DB selection failed');

$query = 'SELECT  COUNT(username)  FROM radcheck where username="' . $macaddress . '" and attribute="User-Password"';
$result = mysql_query($query) or die('Radius query error ' . mysql_error());
$myrow = mysql_fetch_array($result);

if ($myrow[0] == 0) {
    $query = 'INSERT INTO radcheck set username ="' . $macaddress . '", attribute="User-Password", op="==", value="' . $macaddress . '"';
    mysql_query($query) or die('NAS query error 1 ' . mysql_error());
};

$query = 'SELECT  COUNT(username)  FROM radcheck where username="' . $macaddress . '" and attribute="Auth-Type"';
$result = mysql_query($query) or die('Radius query error ' . mysql_error());
$myrow = mysql_fetch_array($result);

if ($myrow[0] == 0) {
    $query = 'INSERT INTO radcheck set username ="' . $macaddress . '", attribute="Auth-Type", op=":=", value="Accept"';
    mysql_query($query) or die('Radius query error ' . mysql_error());
};

$query = 'SELECT COUNT(client_mac)  FROM clients_mac where client_mac="' . $macaddress . '"';
$result = mysql_query($query) or die('Radius query error ' . mysql_error());
$myrow = mysql_fetch_array($result);

if ($myrow[0] == 0) {
    $query = 'INSERT INTO clients_mac set client_mac="' . $macaddress . '", os="' . $ua_info['platform'] . '", browser="' . $ua_info['browser'] . '", language="' . $lang . '"';
    mysql_query($query) or die('Radius query error ' . mysql_error());
}

$query = 'select * from nas left join hotels on nas.hotel_id=hotels.id where nasname="' . $nasip . '"';
$result = mysql_query($query) or die('NAS query error 2' . mysql_error());
$myrow = mysql_fetch_array($result);
$url         = $myrow['url'];
$hotel_id    = $myrow['hotel_id'];
$hotel_name  = $myrow['name'];
$template_id = '';

if(empty($myrow['active_template_id']))
{
    $query = "select * from templates where hotel_id='$hotel_id' and name='Login template'";
    $result = mysql_query($query) or die('NAS query error 3' . mysql_error());
    $tmp_template = mysql_fetch_array($result);
    $template_id = $tmp_template['id'];
}
else
{
    $template_id = $myrow['active_template_id'];
}

// Find Active template's name
$query = "select name from templates where id='$template_id'";
$result = mysql_query($query) or die('Find Active template name ' . mysql_error());
$myrow = mysql_fetch_array($result);
$GLOBALS['template_name'] = $myrow['name'];

$query = "select * from templates
          left join templates_variables on templates.id = templates_variables.template_id
          where templates.id='$template_id' and hotel_id='$hotel_id'";

$result = mysql_query($query) or die('NAS query error 4' . mysql_error());
$myrow = mysql_fetch_array($result);
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
$query = "select * from hotel_language
          left join languages on languages.id = hotel_language.language_id
          where hotel_language.hotel_id='$hotel_id' and languages.name='$language_codes[$lang]'";
$result = mysql_query($query) or die('NAS query error 5' . mysql_error());
$check_language = mysql_num_rows($result);

$translate_id = 0;

if($check_language)
{
    $translate_id_query = "select translate_id from hotel_language
                              left join languages on languages.id = hotel_language.language_id
                              where languages.name='$language_codes[$lang]' and hotel_language.hotel_id='$hotel_id'";
    $result = mysql_query($translate_id_query) or die('NAS query error 6 ' . mysql_error());
    $translate_id = mysql_fetch_array($result)['translate_id'];

    if ($GLOBALS['template_name'] == 'Question template')
    {
        $query = "select * from translate_question_label
                  where translate_id='$translate_id'";
        $result = mysql_query($query) or die('NAS query error 7 ' . mysql_error());
        $translate_data = mysql_fetch_array($result);

        $GLOBALS['translate_question_label'] = $translate_data['translate_question_label'];
    }
    if ($GLOBALS['template_name'] == 'Login template')
    {
        $query = "select * from translate_login
                  where translate_id='$translate_id'";
        $result = mysql_query($query) or die('NAS query error 8 ' . mysql_error());
        $translate_data = mysql_fetch_array($result);

        $GLOBALS['hotel_label_1']      = $translate_data['hotel_label_1'];
        $GLOBALS['hotel_label_2']      = $translate_data['hotel_label_2'];
        $GLOBALS['hotel_btn_label']    = $translate_data['hotel_btn_label'];
    }
    if ($GLOBALS['template_name'] == 'Email template')
    {
        $query = "select * from translate_email
                  where translate_id='$translate_id'";
        $result = mysql_query($query) or die('NAS query error 9 ' . mysql_error());
        $translate_data = mysql_fetch_array($result);

        $GLOBALS['hotel_label_1']      = $translate_data['hotel_label_1'];
        $GLOBALS['hotel_label_2']      = $translate_data['hotel_label_2'];
        $GLOBALS['hotel_btn_label']    = $translate_data['hotel_btn_label'];
    }

    if ($GLOBALS['template_name'] == 'Facebook template')
    {
        $query = "select * from translate_fb
                  where translate_id='$translate_id'";
        $result = mysql_query($query) or die('NAS query error 9_1' . mysql_error());
        $translate_data = mysql_fetch_assoc($result);

        $GLOBALS['title']        = $translate_data['title'];
        $GLOBALS['middle_title'] = $translate_data['middle_title'];
        $GLOBALS['email_title']  = $translate_data['email_title'];
        $GLOBALS['fb_title']     = $translate_data['fb_title'];
    }

    //Get terms texts for current language
    $translate_term = "select * from translate_term
                              left join languages on languages.id = translate_term.language_id
                              where languages.name='$language_codes[$lang]'";
    $result = mysql_query($translate_id_query) or die('NAS query error 9_1 ' . mysql_error());
    $translate_term_data = mysql_fetch_array($result);

    $GLOBALS['term_title'] = $translate_term_data['title'];
    $GLOBALS['term_text'] = $translate_term_data['text'];

}
else
{
    $translate_id_query = "select translate_id, language_id from hotel_language
                              left join languages on languages.id = hotel_language.language_id
                              where hotel_language.is_default='1' and hotel_language.hotel_id='$hotel_id'";
    $result = mysql_query($translate_id_query) or die('NAS query error 10' . mysql_error());
    $data = mysql_fetch_array($result);
    $translate_id = $data['translate_id'];
    $language_id  = $data['language_id'];

    if ($GLOBALS['template_name'] == 'Question template')
    {
        $query = "select * from translate_question_label
                  where translate_id='$translate_id'";
        $result = mysql_query($query) or die('NAS query error 11' . mysql_error());
        $translate_data = mysql_fetch_array($result);

        $GLOBALS['translate_question_label'] = $translate_data['translate_question_label'];
    }
    if ($GLOBALS['template_name'] == 'Login template')
    {
        $query = "select * from translate_login
                  where translate_id='$translate_id'";
        $result = mysql_query($query) or die('NAS query error 12' . mysql_error());
        $translate_data = mysql_fetch_array($result);

        $GLOBALS['hotel_label_1']      = $translate_data['hotel_label_1'];
        $GLOBALS['hotel_label_2']      = $translate_data['hotel_label_2'];
        $GLOBALS['hotel_btn_label']    = $translate_data['hotel_btn_label'];
    }
    if ($GLOBALS['template_name'] == 'Email template')
    {
        $query = "select * from translate_email
                  where translate_id='$translate_id'";
        $result = mysql_query($query) or die('NAS query error 13' . mysql_error());
        $translate_data = mysql_fetch_array($result);

        $GLOBALS['hotel_label_1']      = $translate_data['hotel_label_1'];
        $GLOBALS['hotel_label_2']      = $translate_data['hotel_label_2'];
        $GLOBALS['hotel_btn_label']    = $translate_data['hotel_btn_label'];
    }

    if ($GLOBALS['template_name'] == 'Facebook template')
    {
        $query = "select * from translate_fb
                  where translate_id='$translate_id'";
        $result = mysql_query($query) or die('NAS query error 13_1' . mysql_error());
        $translate_data = mysql_fetch_assoc($result);

        $GLOBALS['title']        = $translate_data['title'];
        $GLOBALS['middle_title'] = $translate_data['middle_title'];
        $GLOBALS['email_title']  = $translate_data['email_title'];
        $GLOBALS['fb_title']     = $translate_data['fb_title'];
    }

    //Get terms texts for current language
    $translate_term = "select * from translate_term
                              left join languages on languages.id = translate_term.language_id
                              where languages.id='$language_id'";
    $result = mysql_query($translate_term) or die('NAS query error 13_1 ' . mysql_error());
    $translate_term_data = mysql_fetch_array($result);

    $GLOBALS['term_title'] = $translate_term_data['title'];
    $GLOBALS['term_text'] = $translate_term_data['text'];
}


/**
 * Show question that user haven't seen yet
 * @param $mac_address
 * @param $hotel_id
 * @param $translate_id
 * @param $template_id
 * @return array
 */
function checkFirstLogin($mac_address, $hotel_id, $translate_id)
{
    //Get hotel questions timeout
    $query = "SELECT questions_timeout FROM hotels WHERE id = '$hotel_id'";
    $result = mysql_query($query) or die('NAS query error 14 ' . mysql_error());
    $myrow = mysql_fetch_array($result);

    // Get timeout in days
    $questions_timeout = intval($myrow['questions_timeout']);

    // Convert days to seconds
    $questions_timeout = $questions_timeout * 24 * 3600;

    //First of all we should check if timeout is expired so we delete all old questions and stat from scratch
    $query  = 'SELECT updated_at FROM answers WHERE mac_address = "'. $mac_address .'"';
    $result = mysql_query($query) or die('NAS query error 15 ' . mysql_error());
    $myrow = mysql_fetch_array($result);
    $last_answer_time = strtotime($myrow['updated_at']);

    //current time
    $current_time = time();

    //If current time more than $last_answer_time so timeout was expired
    if($current_time - $last_answer_time > $questions_timeout) {
        $query = "DELETE FROM answers WHERE mac_address='$mac_address'";
        mysql_query($query) or die('NAS query error 15_1 ' . mysql_error());
    }

    $query  = 'SELECT * FROM answers WHERE mac_address = "'. $mac_address .'"';
    $result = mysql_query($query) or die('NAS query error 16 ' . mysql_error());

    if(mysql_num_rows($result)) {
        // This mean that user already has minimum one answer
        // And we check are there any non-answered questions
        return checkIfExistsNonAnsweredQuestion($mac_address, $hotel_id, $translate_id);

    } else {
        // This mean that user hasn't even one answer so we show 'is_first' question
        //Find Hotel's Question template's is_first question
        $query_1 = "select * from translate_question
                    left join hotel_question on hotel_question.question_id = translate_question.question_id
                    where translate_id='$translate_id' and hotel_id='$hotel_id' and is_first='1'";
        $result = mysql_query($query_1) or die('NAS query error 17' . mysql_error());
        $myrow = mysql_fetch_array($result);

        //Get template icon set
        $icon_set_id = $myrow['icon_set_id'];

        $query_2 = "select icon_1, icon_2, icon_3 from icon_sets where id='$icon_set_id'";
        $result = mysql_query($query_2) or die('Get Icons ' . mysql_error());
        $myrow_2 = mysql_fetch_array($result);

        return [
            'question'    => $myrow['text'],
            'question_id' => $myrow['question_id'],
            'icon_1'      => $myrow_2['icon_1'],
            'icon_2'      => $myrow_2['icon_2'],
            'icon_3'      => $myrow_2['icon_3']
        ];
    }
}

function checkIfExistsNonAnsweredQuestion($mac_address, $hotel_id, $translate_id)
{
    //Get all answers of this user
    $query  = 'SELECT answer FROM answers WHERE mac_address = "'. $mac_address .'"';
    $result = mysql_query($query) or die('NAS query error 18' . mysql_error());
    $myrow  = mysql_fetch_array($result);
    $answers_arr = json_decode($myrow['answer'], true);

    $answered_ids = array_keys($answers_arr);

    //Get all answers ids for this hotel
    $query   =  'SELECT question_id FROM hotel_question WHERE hotel_id = "'. $hotel_id .'"';
    $result  = mysql_query($query) or die('NAS query error 19' . mysql_error());
    $all_answers_ids = [];
    while($myrow_2 =  mysql_fetch_array($result)) {
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

        $result = mysql_query($query) or die('NAS query error 20' . mysql_error());
        $myrow = mysql_fetch_array($result);
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
        $result = mysql_query($query) or die('NAS query error 21' . mysql_error());
        $translate_data = mysql_fetch_array($result);

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
        $result = mysql_query($query_1) or die('NAS query error 22' . mysql_error());
        $myrow = mysql_fetch_array($result);

        //Get template icon set
        $query_2 = "select icon_1, icon_2, icon_3 from icon_sets
                    left join hotel_question on  hotel_question.icon_set_id = icon_sets.id
                    where question_id='$non_answered_question_id'";
        $result = mysql_query($query_2) or die('NAS query error 23' . mysql_error());
        $myrow_2 = mysql_fetch_array($result);

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
function checkEmailLogin($mac_address, $translate_id, $hotel_id)
{
    //Get hotel emails timeout
    $query = "SELECT emails_timeout FROM hotels WHERE id = '$hotel_id'";
    $result = mysql_query($query) or die('NAS query error 24' . mysql_error());
    $myrow = mysql_fetch_array($result);
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
    $result = mysql_query($query) or die('NAS query error 25' . mysql_error());
    $myrow = mysql_fetch_array($result);

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
        $result = mysql_query($query) or die('NAS query error 26' . mysql_error());
        $myrow = mysql_fetch_array($result);

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
        $result = mysql_query($query) or die('NAS query error 27' . mysql_error());
        $translate_data = mysql_fetch_array($result);

        $GLOBALS['hotel_label_1']      = $translate_data['hotel_label_1'];
        $GLOBALS['hotel_label_2']      = $translate_data['hotel_label_2'];
        $GLOBALS['hotel_btn_label']    = $translate_data['hotel_btn_label'];

    }

}


if ($GLOBALS['template_name'] == 'Question template') {
    $question_data = checkFirstLogin($macaddress, $hotel_id, $translate_id, $template_id);
}
else if($GLOBALS['template_name'] == 'Email template') {
    checkEmailLogin($macaddress, $translate_id, $hotel_id);
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


mysql_free_result($result);
mysql_close($link);

?>

<html lang="en" class="no-js">

<head>
    <meta charset="UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?=$hotel_name?></title>

    <meta name="description" content="description"/>
    <meta name="keywords" content=""/>
    <meta name="author" content=""/>

    <!--    <script src="js/modernizr-latest.js"></script>-->
    <!--    <script src="js/html5shiv.min.js"></script>-->

    <script src="js/jquery.min.js"></script>
    <script src="js/script.js"></script>

    <!-- You can use open graph tags to customize link previews.
    Learn more: https://developers.facebook.com/docs/sharing/webmasters -->
    <meta property="og:url"           content="http://login.com/index.php" />
    <meta property="og:type"          content="website" />
    <meta property="og:title"         content="Your Website Title" />
    <meta property="og:description"   content="Your description" />

</head>


<body>

<?php

if($GLOBALS['template_name'] == 'Facebook template') {
    echo "<script>(function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = '//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.8&appId=696113500523537';
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));

    $(document).ready(function() {
        $.ajaxSetup({ cache: true });
        $.getScript('//connect.facebook.net/en_US/sdk.js', function(){
            FB.init({
                appId: '696113500523537',
                status: false, // check login status
                oauth: false,
                version: 'v2.8' // or v2.1, v2.2, v2.3, ...
            });
            $('#loginbutton,#feedbutton').removeAttr('disabled');

            FB.Event.subscribe('edge.create', function(response) {
                window.location = 'http://$nasip:64873/login?username=$macaddress&password=$macaddress&dst=$url';
            });

            FB.Event.subscribe('edge.remove', function(response) {
                window.location = 'http://$nasip:64873/login?username=$macaddress&password=$macaddress&dst=$url';
            });


            FB.Event.subscribe('auth.statusChange', function(response) {
                if (response.status === 'connected') {
                              //the user is logged and has granted permissions
                } else if (response.status === 'not_authorized') {
                      //ask for permissions
                } else {
                      //ask the user to login to facebook
                }
            });

        });
    });

</script>";
}

?>

<?php
if($GLOBALS['template_name'] == 'Login template'):
    include 'login.php';
elseif ($GLOBALS['template_name'] == 'Question template'):
    include 'question.php';
elseif($GLOBALS['template_name'] == 'Email template'):
    include 'email.php';
elseif($GLOBALS['template_name'] == 'Facebook template'):
    include 'facebook.php';
endif
?>

</body>

</html>
