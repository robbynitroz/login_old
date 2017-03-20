<?php
$language_codes = [
    'en' => 'English',
    'fr' => 'French',
    'de' => 'German',
    'es' => 'Spanish',
    'it' => 'Italian',
    'nl' => 'Dutch'
];

$nasip = $_SERVER['REMOTE_ADDR'];

//Device language
$lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);

//CONNECT TO DB
$link = mysql_connect('localhost', 'radius', 'rcFGmPSu68ZY') or die('Status >> Connection failed ' . mysql_error());
mysql_select_db('radius') or die('DB selection failed');

// Get Hotel ID
$query = "select hotel_id from nas where nasname='$nasip'";
$result = mysql_query($query) or die('Status query error 1 ' . mysql_error());
$myrow = mysql_fetch_array($result);
$hotel_id = $myrow['hotel_id'];


$query = "select * from templates
                  left join templates_variables on templates.id = templates_variables.template_id
                  where templates.name='Login template' and hotel_id='$hotel_id'";

$result = mysql_query($query) or die('Status query error 2 ' . mysql_error());
$myrow = mysql_fetch_array($result);

$GLOBALS['template_name'] = 'Login template';

$GLOBALS['image'] = $myrow['hotel_logo'];
$GLOBALS['bg_color'] = $myrow['hotel_bg_color'];
//Color of Header
$GLOBALS['font_color_1'] = $myrow['hotel_font_color1'];
//Color of button
$GLOBALS['font_color_2'] = $myrow['hotel_font_color2'];
//Color of label 3
$GLOBALS['font_color_3'] = $myrow['hotel_font_color3'];
$GLOBALS['font_size_1'] = $myrow['hotel_font_size1'];
$GLOBALS['font_size_2'] = $myrow['hotel_font_size2'];
$GLOBALS['font_size_3'] = $myrow['hotel_font_size3'];
$GLOBALS['hotel_bg_image'] = $myrow['hotel_bg_image'];
$GLOBALS['hotel_centr_color'] = $myrow['hotel_centr_color'];
$GLOBALS['hotel_btn_bg_color'] = $myrow['hotel_btn_bg_color'];


/*********************** Get translated text variables ***************************/
// Check if device's language exists in language_codes
$query = "select * from hotel_language
          left join languages on languages.id = hotel_language.language_id
          where hotel_language.hotel_id='$hotel_id' and languages.name='$language_codes[$lang]'";
$result = mysql_query($query) or die('Status query error 3 ' . mysql_error());
$check_language = mysql_num_rows($result);

$translate_id = 0;

if ($check_language) {
    $translate_id_query = "select translate_id from hotel_language
                              left join languages on languages.id = hotel_language.language_id
                              where languages.name='$language_codes[$lang]' and hotel_language.hotel_id='$hotel_id'";
    $result = mysql_query($translate_id_query) or die('Status query error 4 ' . mysql_error());
    $translate_id = mysql_fetch_array($result)['translate_id'];

    $query = "select * from translate_login
              where translate_id='$translate_id'";
    $result = mysql_query($query) or die('Status query error 5 ' . mysql_error());
    $translate_data = mysql_fetch_array($result);

    $GLOBALS['hotel_label_1'] = $translate_data['hotel_label_1'];
    $GLOBALS['hotel_label_2'] = $translate_data['hotel_label_2'];
    $GLOBALS['hotel_btn_label'] = $translate_data['hotel_btn_label'];

} else {
    $translate_id_query = "select translate_id from hotel_language
                              left join languages on languages.id = hotel_language.language_id
                              where hotel_language.is_default='1' and hotel_language.hotel_id='$hotel_id'";
    $result = mysql_query($translate_id_query) or die('Status query error 6 ' . mysql_error());
    $translate_id = mysql_fetch_array($result)['translate_id'];

    $query = "select * from translate_login
              where translate_id='$translate_id'";
    $result = mysql_query($query) or die('Status query error 7 ' . mysql_error());
    $translate_data = mysql_fetch_array($result);

    $GLOBALS['hotel_label_1'] = $translate_data['hotel_label_1'];
    $GLOBALS['hotel_label_2'] = $translate_data['hotel_label_2'];
    $GLOBALS['hotel_btn_label'] = $translate_data['hotel_btn_label'];
}

function hex2rgba($color, $opacity = false, $darkness = 0)
{

    $default = 'rgb(0,0,0)';

    //Return default if no color provided
    if (empty($color))
        return $default;

    //Sanitize $color if "#" is provided
    if ($color[0] == '#') {
        $color = substr($color, 1);
    }

    //Check if color has 6 or 3 characters and get values
    if (strlen($color) == 6) {
        $hex = array($color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5]);
    } elseif (strlen($color) == 3) {
        $hex = array($color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2]);
    } else {
        return $default;
    }

    //Convert hexadec to rgb
    $rgb = array_map('hexdec', $hex);

    foreach ($rgb as $key => $value) {
        $rgb[$key] = intval($value - $value * ($darkness / 100));
    }

    //Check if opacity is set(rgba or rgb)
    if ($opacity) {
        if (abs($opacity) > 1)
            $opacity = 1.0;
        $output = 'rgba(' . implode(",", $rgb) . ',' . $opacity . ')';
    } else {
        $output = 'rgb(' . implode(",", $rgb) . ')';
    }

    //Return rgb(a) color string
    return $output;
}

mysql_free_result($result);
mysql_close($link);

?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Load remote content into object element</title>

    <style>
        body {
            background-color: <?php echo $GLOBALS['bg_color']; ?>;
        }

        *,
        *:after,
        *:before {
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
            padding: 0;
            margin: 0;
            font-family: 'NeoSansProRegular';
        }

        body, html {
            min-height: 100%;
            height: 100%;
        }

        .clear {
            clear: both;
        }

        @font-face {
            font-family: 'NeoSansProRegular';
            src: url('css/fonts/NeoSansProRegular.eot');
            src: local('â˜º'), url('css/fonts/NeoSansProRegular.woff') format('woff'), url('css/fonts/NeoSansProRegular.ttf') format('truetype'), url('css/fonts/NeoSansProRegular.svg') format('svg');
            font-weight: normal;
            font-style: normal;
        }

        @font-face {
            font-family: 'NeoSansProBold';
            src: url('css/fonts/NeoSansProBold.eot');
            src: local('â˜º'), url('css/fonts/NeoSansProBold.woff') format('woff'), url('css/fonts/NeoSansProBold.ttf') format('truetype'), url('css/fonts/NeoSansProBold.svg') format('svg');
            font-weight: normal;
            font-style: normal;
        }

        .login-big-wrapper {
            width: 100%;
            min-height: 100%;
            background: url("images/<?php echo $GLOBALS['hotel_bg_image']; ?>") center;
            background-size: cover;
            display: -webkit-box;
            display: -webkit-flex;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-align: center;
            -webkit-align-items: center;
            -ms-flex-align: center;
            align-items: center;
            -webkit-box-pack: center;
            -webkit-justify-content: center;
            -ms-flex-pack: center;
            justify-content: center;
        }

        /*--- main login page ---*/
        .offer-wrapper {
            min-height: 700px;
            margin: 30px 0;
            width: 660px;
            /*background: rgba(0, 0, 0, 0.90);*/
            background-color: <?php echo hex2rgba($GLOBALS['hotel_centr_color'], 0.90, 0);?>;
            padding: 15px;
            border-radius: 10px;
            display: -webkit-box;
            display: -webkit-flex;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-orient: vertical;
            -webkit-box-direction: normal;
            -webkit-flex-direction: column;
            -ms-flex-direction: column;
            flex-direction: column;
            -webkit-box-pack: justify;
            -webkit-justify-content: space-between;
            -ms-flex-pack: justify;
            justify-content: space-between;
        }

        .terms-link {
            /*height: 10%;*/
            height: 20px;
            margin-bottom: 50px;
            display: block;
            width: 100%;
            text-align: right;
            text-transform: uppercase;
            color: #706f6f;
            text-decoration: none;
            font-size: 18px;
        }

        .terms-link:hover {
            color: #aeadad;
        }

        .heading {
            /*height: 20%;*/
            /*min-height: 150px;*/
            height: 155px;
            margin-bottom: 30px;
            padding: 0 60px;
            color: <?php echo $GLOBALS['font_color_1'];?>;
            font-size: calc(<?php echo $GLOBALS['font_size_1'];?>px * 2.0833333);
            text-align: center;
            /*margin: 50px 0;*/
        }

        #siteloader_hidden {
            text-align: center;
            margin: 20px 0;
        }

        #siteloader_hidden object {
            height: 220px;
            /*background: rgba(255, 255, 255, 0.4);*/
        }

        #siteloader_hidden object body {
            color: #fff;
        }

        .go-online-form {
            display: -webkit-box;
            display: -webkit-flex;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-pack: center;
            -webkit-justify-content: center;
            -ms-flex-pack: center;
            justify-content: center;
            -webkit-box-align: center;
            -webkit-align-items: center;
            -ms-flex-align: center;
            align-items: center;
            /*height: 20%;*/
            min-height: 100px;
            position: relative;
        }

        .go-online-button {
            white-space: nowrap;
            cursor: pointer;
            height: 80px;
            padding: 5px 70px;
            background-color: <?php echo hex2rgba($GLOBALS['hotel_btn_bg_color'], false, 0);?>;
            font-family: 'NeoSansProBold';
            font-size: calc(<?php echo $GLOBALS['font_size_2'];?>px * 1.3333333);
            text-transform: uppercase;
            color: <?php echo $GLOBALS['font_color_2']?>;
            border: none;
            border-bottom: 4px solid <?php echo hex2rgba($GLOBALS['hotel_btn_bg_color'], false, 20);?>;
            /*margin: 0 auto;*/
        }

        .go-online-button:active {
            border-bottom: none;
        }

        .check-link {
            /*height: 10%;*/
            /*min-height: 50px;*/
            height: 25px;
            margin: 55px 0;
            display: block;
            text-align: center;
            font-style: italic;
            color: <?php echo $GLOBALS['font_color_3'];?>;
            font-size: calc(<?php echo $GLOBALS['font_size_3'];?>px * 1.166666);
            text-decoration: none;
            /*margin: 10px 0;*/
        }

        .check-link span {
            font-style: normal;
        }

        .check-link:hover {
            color: <?php echo hex2rgba($GLOBALS['font_color_3'], false, -20);?>;
        }

        .logo {
            /*height: 20%;*/
            /*min-height: 150px;*/
            margin: 0 auto;
            height: 150px;
            width: 100%;
            display: -webkit-box;
            display: -webkit-flex;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-pack: center;
            -webkit-justify-content: center;
            -ms-flex-pack: center;
            justify-content: center;
            /*-webkit-box-align: end;
            -webkit-align-items: flex-end;
            -ms-flex-align: end;
            align-items: flex-end;*/
        }

        .logo > img {
            max-height: 100%;
            height: 120px;
            width: 320px;
        }

        /*--- eof main login page ---*/

        /*--- terms page ---*/

        .terms_offer-wrapper {
            margin: 80px 0;
            width: 60%;
            background: rgba(0, 0, 0, 0.90);
            padding: 15px;
            border-radius: 10px;
        }

        .terms_offer-wrapper.hidden {
            display: none;
        }

        .terms-back-link {
            display: block;
            width: 100%;
            text-align: left;
            text-transform: uppercase;
            color: #706f6f;
            text-decoration: none;
            font-size: 18px;
        }

        .back-link:hover {
            color: #aeadad;
        }

        .terms_heading {
            padding: 0 60px;
            color: #c09e4c;
            font-size: 50px;
            text-align: center;
            margin: 10px 0;
        }

        .terms-self {
            text-align: center;
            color: #e7e7e7;
            padding: 0 60px;
            margin: 60px auto;
        }

        .terms-self p {
            color: #e7e7e7;
            margin: 10px 0;
            text-indent: 20px;
        }

        /*--- eof terms page ---*/
        /*--- site loader div ---*/

        @media screen and (min-width: 767px) and (max-width: 1600px) {
            .offer-wrapper {
                min-height: 500px;
                width: 500px;
                padding: 12px;
            }

            .terms-link {
                font-size: 16px;
            }

            .heading {
                font-size: calc(<?php echo $GLOBALS['font_size_1'];?>px * 1.5);
                margin-bottom: 35px;
                padding: 0 40px;
                height: 130px;
            }

            #siteloader_hidden {

            }

            .go-online-form {
                min-height: auto;
                margin-bottom: 20px;
            }

            .go-online-button {
                height: 60px;
                padding: 4px 55px;
                font-size: calc(<?php echo $GLOBALS['font_size_2'];?>px * 1.166666);
                border-bottom: 3px solid <?php echo hex2rgba($GLOBALS['hotel_btn_bg_color'], false, 20);?>;
            }

            .go-online-button:active {
                border-bottom: none;
            }

            .check-link {
                font-size: <?php echo $GLOBALS['font_size_3'];?>px;
                /*margin: 10px 0 70px 0;*/
                margin-bottom: 40px;
                margin-top: 50px;
            }

            /*--- terms page ---*/
            .terms_offer-wrapper {
                margin: 30px 0;
                width: 80%;
                padding: 10px;
            }

            .terms_offer-wrapper.hidden {
                display: none;
            }

            .terms-back-link {
                font-size: 16px;
            }

            .terms_heading {
                padding: 0 40px;
                font-size: 36px;
                margin: 10px 0;
            }

            .terms-self {
                padding: 0 40px;
                margin: 30px auto;
            }

            /*--- eof terms page ---*/
        }

        @media screen and (max-width: 767px) {
            body {
                background: rgb(0, 0, 0);
            }

            .login-big-wrapper {
                min-height: 100%;
                background: rgb(0, 0, 0);
                height: auto;
                -webkit-box-align: stretch;
                -webkit-align-items: stretch;
                -ms-flex-align: stretch;
                -ms-grid-row-align: stretch;
                align-items: stretch;
            }

            .offer-wrapper {
                width: 100%;
                /*background: rgb(0, 0, 0);*/
                background-color: <?php echo $GLOBALS['hotel_centr_color'];?>;
                padding: 10px;
                border-radius: 0;
                display: -webkit-box;
                display: -webkit-flex;
                display: -ms-flexbox;
                display: flex;
                -webkit-box-orient: vertical;
                -webkit-box-direction: normal;
                -webkit-flex-direction: column;
                -ms-flex-direction: column;
                flex-direction: column;
                -webkit-box-pack: justify;
                -webkit-justify-content: space-between;
                -ms-flex-pack: justify;
                justify-content: space-between;
            }

            .offer-wrapper-xs {
                min-height: 100%;
                height: auto;
                position: relative;
                margin: 0;
                padding: 10px;
            }

            .terms-link {
                font-size: 14px;
                height: 10%;
                margin-bottom: 0px;
            }

            .heading {
                min-height: 90px;
                height: 20%;
                margin: 0;
                padding: 0 25px;
                font-size: calc(<?php echo $GLOBALS['font_size_1'];?>px * 1.166666);
            }

            .go-online-form {
                height: calc(20% - 20px);
            }

            .go-online-button {
                margin: auto;
                height: 50px;
                padding: 4px 30px;
                font-size: <?php echo $GLOBALS['font_size_2'];?>px;
                border-bottom: 3px solid <?php echo hex2rgba($GLOBALS['hotel_btn_bg_color'], false, 20);?>;
            }

            .go-online-button:active {
                border-bottom: none;
            }

            .check-link {
                font-size: calc(<?php echo $GLOBALS['font_size_3'];?>px * 0.8333333);
                height: 10%;
                min-height: 50px;
                margin: 0;
            }

            .logo {
                min-height: 90px;
                height: 20%;
                -webkit-box-align: center;
                -webkit-align-items: center;
                -ms-flex-align: center;
                -ms-grid-row-align: center;
                align-items: center;
            }

            .logo > img {
                margin: 0 auto;
                /*margin: 70px auto 0;*/
                height: 75px;
                width: 200px;
            }

            /*--- terms page ---*/
            .terms_offer-wrapper {
                display: -webkit-box;
                display: -webkit-flex;
                display: -ms-flexbox;
                display: flex;
                -webkit-box-orient: vertical;
                -webkit-box-direction: normal;
                -webkit-flex-direction: column;
                -ms-flex-direction: column;
                flex-direction: column;
                -webkit-box-pack: justify;
                -webkit-justify-content: space-between;
                -ms-flex-pack: justify;
                justify-content: space-between;
                min-height: 100%;
                margin: 0;
                width: 100%;
                padding: 15px;
                border-radius: 0px;
            }

            .terms_offer-wrapper.hidden {
                display: none;
            }

            .terms-back-link {
                font-size: 14px;
            }

            .back-link:hover {
                color: #aeadad;
            }

            .terms_heading {
                padding: 0 25px;
                font-size: 36px;
                margin: 10px 0;
            }

            .terms-self {
                padding: 0 10px;
                margin: 20px auto;
            }

            .terms-self p {
                color: #e7e7e7;
                margin: 10px 0;
                text-indent: 20px;
            }

            /*--- eof terms page ---*/
        }

    </style>

    <script src="js/jquery.min.js"></script>

</head>
<body>


<div class="login-big-wrapper">
    <div class="offer-wrapper offer-wrapper-xs">

        <a href="#" class="terms-link" onclick="return false">Terms & conditions ></a>

        <div id="siteloader_hidden" style="display: block"></div>
        <?php
        echo '<form class="go-online-form" action="http://' . $nasip . ':64873/logout?erase-cookie=true" method="post">';
        ?>
        <button class="go-online-button"><?php echo strtoupper('Logout'); ?></button>
        </form>

        <div class="logo"><img src="images/<?php echo $GLOBALS['image']; ?>" alt=""></div>
    </div>
    <div class="terms_offer-wrapper hidden"><a href="#" class="terms-back-link" onclick="return false">< Back</a>

        <h1 class="terms_heading">Terms & conditions</h1>

        <div class="terms-self">
            "CONTENT adfskgmnslegmnsljdjksd"
        </div>
        <a href="#" class="terms-back-link" onclick="return false">< Back</a>
    </div>
</div>

<script>
    $("#siteloader_hidden").html('<object data="http://<?php echo $nasip; ?>:64873/status">');

    var content = $("#siteloader_hidden").html();

    var search_string = 'http-equiv="refresh" content="0;url=http://login.com/index.php';

    if (content.indexOf(search_string) == -1) {
        $("#siteloader_hidden").html('<object data="http://<?php echo $nasip; ?>:64873/status">');
//                $("#siteloader_hidden").html('');

    }
    else {
        windows.location = 'http://login.com/index.php';
    }

</script>

</body>
</html>
