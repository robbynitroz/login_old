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
        height: 10%;
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

    .check-link {
        display: block;
        text-align: center;
        font-style: italic;
        color: <?php echo $GLOBALS['font_color_3'];?>;
        font-size: calc(<?php echo $GLOBALS['font_size_3'];?>px * 1.166666);
        text-decoration: none;
        margin: 10px 0 70px 0;
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
        font-style: italic;
        color: <?php echo $GLOBALS['font_color_3'];?>;
        font-size: calc(<?php echo $GLOBALS['font_size_3'];?>px * 1.166666);
        padding: 0 60px;
        margin: 60px auto;
    }

    .terms-self p {
        color: #e7e7e7;
        margin: 10px 0;
        text-indent: 20px;
    }

    /*--- eof terms page ---*/

    /*--- choose a smile page ---*/

    .smiles-wrapper {
        width: 80%;
        margin: 0 auto;
    }

    .smile-wrapper {
        width: 33.3333%;
        float: left;
        padding: 15px;
    }

    .smile-border {
        border: 8px solid transparent;
        border-radius: 50%;
        background-color: transparent;
        transition: all 0.2s;
        -webkit-tap-highlight-color: rgba(0, 0, 0, 0);
        -moz-tap-highlight-color: rgba(0, 0, 0, 0);
    }

    .smile-border:hover {
        border: 8px solid #acacac;
        border-radius: 50%;
        background-color: #acacac;
    }

    .smile-border.chosen {
        border: 8px solid #c09e4c;
        border-radius: 50%;
        background-color: #c09e4c;
    }

    .smile-border img {
        width: 100%;
        height: auto;
        cursor: pointer;
    }

    .smile-border button {
        background: none;
        border: none;
        outline: none;
        -webkit-tap-highlight-color: rgba(0, 0, 0, 0);
        -moz-tap-highlight-color: rgba(0, 0, 0, 0);
    }

    /*--- eof choose a smile page ---*/

    @media screen and (min-width: 767px) and (max-width: 1600px) {
        .offer-wrapper {
            min-height: 500px;
            width: 500px;
            padding: 12px;
        }

        .go-online-form{
            margin: 50px 0;
        }

        .terms-link {
            font-size: 16px;
        }

        .heading {
            margin: 40px 0;
            font-size: calc(<?php echo $GLOBALS['font_size_1'];?>px * 1.5);
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
            font-size: calc(<?php echo $GLOBALS['font_size_3'];?>px * 0.8333333);
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
        }

        .heading {
            margin: 20px 0;
            font-size: calc(<?php echo $GLOBALS['font_size_1'];?>px * 1.166666);
        }

        .offer-inner{
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

        .go-online-form{
            margin: 50px 0;
        }

        .check-link {
            margin: 10px 0 20px 0;
            font-size: calc(<?php echo $GLOBALS['font_size_3'];?>px * 0.8333333);
        }

        .logo{
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
            font-size: calc(<?php echo $GLOBALS['font_size_3'];?>px * 0.8333333);
        }

        .terms-self p {
            color: #e7e7e7;
            margin: 10px 0;
            text-indent: 20px;
        }

        /*--- eof terms page ---*/
        /*--- choose a smile page ---*/
        .smile-wrapper {
            padding: 5px;
        }

        /*--- eof choose a smile page ---*/
    }

</style>

<div class="login-big-wrapper">
    <div class="offer-wrapper offer-wrapper-xs">
        <a href="#" class="terms-link terms-link-xs" onclick="return false">Terms & conditions ></a>

        <div class="offer-inner">
            <h1 class="heading">"<?php echo $question_data['question']; ?>"</h1>

            <form class="question_form go-online-form" action="http://login.com/answerSave.php" method="post">
                <div class="smiles-wrapper">
                    <div class="smile-wrapper">
                        <div class="smile-border">
                            <input type="hidden" name="answer" value="">
                            <input type="hidden" name="hotel_id" value="<?php echo $hotel_id; ?>">
                            <input type="hidden" name="template_id" value="<?php echo $template_id; ?>">
                            <input type="hidden" name="question_id"
                                   value="<?php echo $question_data['question_id']; ?>">
                            <input type="hidden" name="nasip" value="<?php echo $nasip; ?>">
                            <input type="hidden" name="macaddress" value="<?php echo $macaddress; ?>">
                            <input type="hidden" name="url" value="<?php echo $url; ?>">

                            <button type="button" class="go-online-button" data-answer="-1"><img
                                    src="images/<?php echo $question_data['icon_1']; ?>" alt=""></button>
                        </div>
                    </div>
                    <div class="smile-wrapper">
                        <div class="smile-border">
                            <button type="button" class="go-online-button" data-answer="0"><img
                                    src="images/<?php echo $question_data['icon_2']; ?>" alt=""></button>
                        </div>
                    </div>
                    <div class="smile-wrapper">
                        <div class="smile-border">
                            <button type="button" class="go-online-button" data-answer="1"><img
                                    src="images/<?php echo $question_data['icon_3']; ?>" alt=""></button>
                        </div>
                    </div>
                    <div class="clear"></div>
                </div>
            </form>
            <a href="#" class="check-link"><?php echo strtoupper($GLOBALS['translate_question_label']); ?><span></span></a>
        </div>

        <div class="logo"><img src="images/<?php echo $GLOBALS['image']; ?>" alt=""></div>

    </div>

    <div class="terms_offer-wrapper hidden"><a href="#" class="terms-back-link" onclick="return false">< Back</a>

        <h1 class="terms_heading">Terms & conditions</h1>

        <div class="terms-self">
            "<?php echo $GLOBALS['term_text']; ?>"
        </div>
        <a href="#" class="terms-back-link" onclick="return false">< Back</a>
    </div>
</div>

