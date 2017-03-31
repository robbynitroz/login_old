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
        height: 20px;
        margin-bottom: 70px;
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
        padding: 0 30px;
        color: <?php echo $GLOBALS['font_color_1'];?>;
        font-size: calc(<?php echo $GLOBALS['font_size_1'];?>px * 2.0833333);
        text-align: center;
        margin: 50px 0;
    }

    .offer-inner {
        margin: 0 0 70px 0;
    }

    .login-for-internet {
        display: block;
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
        margin: 20px auto;
    }

    .login-for-internet:active {
        border-bottom: none;
    }

    .check-link {
        display: block;
        text-align: center;
        font-style: italic;
        color: <?php echo $GLOBALS['font_color_3'];?>;
        font-size: calc(<?php echo $GLOBALS['font_size_3'];?>px * 1.166666);
        text-decoration: none;
        margin: 10px 0;
    }

    .check-link span {
        font-style: normal;
    }

    .check-link:hover {
        color: <?php echo hex2rgba($GLOBALS['font_color_3'], false, -20);?>;
    }

    .logo {
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
        background: <?php echo hex2rgba($GLOBALS['hotel_centr_color'], 0.90, 0);?>;
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
        color: <?php echo $GLOBALS['font_color_1'];?>;
        font-size: calc(<?php echo $GLOBALS['font_size_1'];?>px * 2.0833333);
        text-align: center;
        margin: 10px 0;
    }

    .terms-self {
        text-align: center;
        color: <?php echo $GLOBALS['font_color_3'];?>;
        font-size: calc(<?php echo $GLOBALS['font_size_3'];?>px * 0.8333333);
        padding: 0 60px;
        margin: 60px auto;
    }

    .terms-self p {
        color: #e7e7e7;
        margin: 10px 0;
        text-indent: 20px;
    }

    /*--- eof terms page ---*/

    /*--- login for internet page ---*/

    .offer-email-input {
        width: 90%;
        display: block;
        height: 80px;
        padding: 5px 10px;
        background-color: #c2c0c0;
        font-family: 'NeoSansProRegular';
        text-align: center;
        font-size: 32px;
        color: rgba(0, 0, 0, 0.7);
        border: 3px solid #fff;
        margin: 40px auto;
    }

    #like_wrapper {
        left: 261px;
        top: 31px;
        transform: scale(9.3,3) !important;
        -ms-transform: scale(9.3,3) !important;
        -webkit-transform: scale(9.3,3) !important;
        -o-transform: scale(9.3,3) !important;
        -moz-transform: scale(9.3,3) !important;'
    }

    /*--- eof login for internet page ---*/
    @media screen and (min-width: 767px) and (max-width: 1600px) {

        #like_wrapper {
            left: 190px;
            top: 31px;
            transform: scale(7,3) !important;
            -ms-transform: scale(7,3) !important;
            -webkit-transform: scale(7,3) !important;
            -o-transform: scale(7,3) !important;
            -moz-transform: scale(7,3) !important;
        }

        .offer-wrapper {
            min-height: 500px;
            width: 500px;
            padding: 12px;
        }

        .terms-link {
            font-size: 16px;
        }

        .offer-inner {
            margin: 0;
        }

        .heading {
            margin: 40px 0;
            font-size: calc(<?php echo $GLOBALS['font_size_1'];?>px * 1.5);
        }

        .login-for-internet {
            height: 81px;
            padding: 4px 55px;
            font-size: calc(<?php echo $GLOBALS['font_size_2'];?>px * 1.166666);
            border-bottom: 3px solid <?php echo hex2rgba($GLOBALS['hotel_btn_bg_color'], false, 20);?>;
        }

        .login-for-internet:active {
            border-bottom: none;
        }

        .check-link {
            font-size: calc(<?php echo $GLOBALS['font_size_3'];?>px * 0.8333333);
            margin: 10px 0 70px 0;
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
            font-size: calc(<?php echo $GLOBALS['font_size_1'];?>px * 1.5);
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

        #like_wrapper {
            top: 31px;
            left:286px;
            transform: scale(10,3) !important;
            -ms-transform: scale(10,3) !important;
            -webkit-transform: scale(10,3) !important;
            -o-transform: scale(10,3) !important;
            -moz-transform: scale(10,3) !important;'
        }

        .login-big-wrapper {
            min-height: 550px;
            background: rgb(0, 0, 0);
            height: auto;

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

        .offer-inner {
            margin: 0;
            height: calc(70% - 20px);
            display: -webkit-box;
            display: -webkit-flex;
            display: -ms-flexbox;
            display: -webkit-box;
            display: -webkit-flex;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-orient: vertical;
            -webkit-box-direction: normal;
            -webkit-flex-direction: column;
            -ms-flex-direction: column;
            flex-direction: column;
            -webkit-box-pack: center;
            -webkit-justify-content: center;
            -ms-flex-pack: center;
            justify-content: center;
        }

        .offer-wrapper-xs {
            min-height: 550px;
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
            margin: 50px 0;
            font-size: calc(<?php echo $GLOBALS['font_size_1'];?>px * 1.166666);
        }

        .login-for-internet {
            margin: auto;
            height: 50px;
            padding: 4px 30px;
            font-size: <?php echo $GLOBALS['font_size_2'];?>px;
            border-bottom: 3px solid <?php echo hex2rgba($GLOBALS['hotel_btn_bg_color'], false, 20);?>;
        }

        .login-for-internet:active {
            border-bottom: none;
        }

        .check-link {
            margin: 10px 0 25px 0;
            font-size: calc(<?php echo $GLOBALS['font_size_3'];?>px * 0.8333333);
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
            /* margin: 70px auto 0; */
            height: 75px;
            width: 200px;
        }

        .logo-xs {
            margin: 0 auto;
        }

        /*--- terms page ---*/
        .terms_offer-wrapper {
            min-height: 100%;
            margin: 0;
            width: 100%;
            padding: 15px;
            border-radius: 0px;
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

        .terms_offer-wrapper.hidden {
            display: none;
        }

        .terms-back-link {
            font-size: 14px;
        }

        .terms-back-link:hover {
            color: #aeadad;
        }

        .terms_heading {
            padding: 0 25px;
            font-size: calc(<?php echo $GLOBALS['font_size_1'];?>px * 1.166666);
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
        /*--- login for internet page ---*/
        .offer-email-input {
            font-size: 24px;
            margin: 20px 0 20px 20px;

        }
        .form-grup button{
            top: 0!important;
        }
        .form-grup button{
            right: 13px!important;
        }


        .go-online:active {
            border-bottom: none;
        }

        /*--- eof login for internet page ---*/
    }

    .form-grup{
        position: relative;
    }
    .form-grup button{
        position: absolute;
        top: -20px;
        right: 24px;
    }
    .login-for-internet {
        height: 81px!important;

    }
    /*h1 {*/
        /*position: relative;*/
        /*font-size: 30px;*/
        /*z-index: 1;*/
        /*overflow: hidden;*/
        /*text-align: center;*/
    /*}*/
    /*h1:before {*/
        /*position: absolute;*/
        /*top: 46%;*/
        /*left: 0;*/
        /*overflow: hidden;*/
        /*width: 32%;*/
        /*height: 2px;*/
        /*content: '\a0';*/
        /*background-color: #ffffff;*/
    /*}*/
    /*h1:after {*/
        /*position: absolute;*/
        /*top: 51%;*/
        /*margin-left: 28px;*/
        /*overflow: hidden;*/
        /*width: 32%;*/
        /*height: 2px;*/
        /*content: '\a0';*/
        /*background-color: #ffffff;*/

    /*h1:before {*/
        /*margin-left: -50%;*/
        /*text-align: right;*/
    /*}*/
</style>

<div class="login-big-wrapper">
    <div class="offer-wrapper offer-wrapper-xs">
        <a href="#" class="terms-link terms-link-xs" onclick="return false">Terms & conditions></a>

        <h3 class="heading"><?php echo $GLOBALS['title']; ?></h3>

        <button style='display: block; position: relative; width: 93%; height: 90px;
            background-image: url("/images/fb.png");
            background-size: 100% 100%;
            background-repeat: no-repeat;
            background-position: center center;
            margin: 0 auto;
            border: 0px;'>
            <div id='like_wrapper' style='position: absolute;
                /*width: 100%;*/
                opacity: 0;
                margin: 0 auto;'
                 class="fb-like" data-href="https://www.facebook.com/coderiders.am/?fref=ts"
                 data-width="400"
                 data-layout="button"
                 data-action="like"
                 data-size="large"
                 data-show-faces="false"
                 data-share="false">
            </div>
            <?php //$GLOBALS['fb_title']; ?>
        </button>


        <div class="offer-inner">
            <div class="form-grup">
            <h1 class="heading "><span></span><?php echo $GLOBALS['middle_title']; ?><span></span></h1>
                </div>
            <form class="question_form go-online-form" action="http://login.com/emailSave.php" method="post">

                <!--                <input type="email" name="email" class="offer-email-input"-->
                <!--                       placeholder="echo $GLOBALS['hotel_label_2'];" formnovalidate required="required"> -->


                <div class="form-grup">
                    <input type="email" name="email" class="offer-email-input"
                           placeholder="<?php echo $GLOBALS['email_title']; ?>">

                    <button type="submit" class="login-for-internet">></button>


                </div>


                <input type="hidden" name="hotel_id" value="<?php echo $hotel_id; ?>">
                <input type="hidden" name="template_id" value="<?php echo $template_id; ?>">
                <input type="hidden" name="nasip" value="<?php echo $nasip; ?>">
                <input type="hidden" name="macaddress" value="<?php echo $macaddress; ?>">
                <input type="hidden" name="url" value="<?php echo $url; ?>">
                
            </form>
        </div>

        <div class="logo logo-xs"><img src="images/<?php echo $GLOBALS['image']; ?>" alt=""></div>
    </div>

    <div class="terms_offer-wrapper hidden"><a href="#" class="terms-back-link" onclick="return false">< Back</a>

        <h1 class="terms_heading">Terms & conditions</h1>

        <div class="terms-self">
            "<?php echo $GLOBALS['term_text']; ?>"
        </div>
        <a href="#" class="terms-back-link" onclick="return false">< Back</a>
    </div>
</div>
