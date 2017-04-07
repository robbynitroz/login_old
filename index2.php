<html lang="en" class="no-js">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?=$hotel_name?></title>

    <meta name="description" content="description"/>
    <meta name="keywords" content=""/>
    <meta name="author" content=""/>

    <!--    <script src="js/modernizr-latest.js"></script>-->
    <!--    <script src="js/html5shiv.min.js"></script>-->

    <script src="js/jquery.min.js"></script>
    <script src="js/script.js"></script>

</head>
<body>

<?php
if ($GLOBALS['template_name'] == 'Login template') {
    include 'login.php';
}
elseif ($GLOBALS['template_name'] == 'Question template') {
    include 'question.php';
}
elseif ($GLOBALS['template_name'] == 'Email template'){
    include 'email.php';
}
?>

</body>

</html>