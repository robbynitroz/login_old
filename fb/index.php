<?php
session_start();

require_once '../Facebook/autoload.php';
$fb = new Facebook\Facebook([
    'app_id'                => '1519471891398547',
    'app_secret'            => '47eead9613200c186954862b7e428c86',
    'default_graph_version' => 'v2.8',
]);

$helper = $fb->getRedirectLoginHelper();
$permissions = ['email']; // optional


try {
    if (isset($_SESSION['facebook_access_token'])) {
        $accessToken = $_SESSION['facebook_access_token'];

    } else {
        $accessToken = $helper->getAccessToken();

    }
} catch(Facebook\Exceptions\FacebookResponseException $e) {
    // When Graph returns an error
    echo 'Graph returned an error: ' . $e->getMessage();

    exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
    // When validation fails or other local issues
    echo 'Facebook SDK returned an error: ' . $e->getMessage();
    exit;
}
if (isset($accessToken)) {
    if (isset($_SESSION['facebook_access_token'])) {
        $fb->setDefaultAccessToken($_SESSION['facebook_access_token']);
    } else {
        $_SESSION['facebook_access_token'] = (string)$accessToken;
        // OAuth 2.0 client handler
        $oAuth2Client = $fb->getOAuth2Client();
        // Exchanges a short-lived access token for a long-lived one
        $longLivedAccessToken = $oAuth2Client->getLongLivedAccessToken($_SESSION['facebook_access_token']);
        $_SESSION['facebook_access_token'] = (string)$longLivedAccessToken;
        $fb->setDefaultAccessToken($_SESSION['facebook_access_token']);
    }
    // validating the access token
    try {
        $request = $fb->get('/me');
    } catch (Facebook\Exceptions\FacebookResponseException $e) {
        // When Graph returns an error
        if ($e->getCode() == 190) {
            unset($_SESSION['facebook_access_token']);
            $helper = $fb->getRedirectLoginHelper();
            $loginUrl = $helper->getLoginUrl('http://fbdev.guestcompass.nl/index.php', $permissions);
            echo "<script>window.top.location.href='" . $loginUrl . "'</script>";
            exit;
        }
    } catch (Facebook\Exceptions\FacebookSDKException $e) {
        // When validation fails or other local issues
        echo 'Facebook SDK returned an error: ' . $e->getMessage();
        exit;
    }
    // get list of pages liked by user
    try {
        $requestLikes = $fb->get('/me/likes/423646974653399');
        $likes = $requestLikes->getGraphEdge();
    } catch (Facebook\Exceptions\FacebookResponseException $e) {
        // When Graph returns an error
        echo 'Graph returned an error: ' . $e->getMessage();
        exit;
    } catch (Facebook\Exceptions\FacebookSDKException $e) {
        // When validation fails or other local issues
        echo 'Facebook SDK returned an error: ' . $e->getMessage();
        exit;
    }

    // printing data on screen

    $nasip      = isset($_SESSION['nasip'])? $_SESSION['nasip'] : null;
    $macaddress = isset($_SESSION['macaddress']) ? $_SESSION['macaddress'] : null;
    $url        = isset($_SESSION['url']) ? $_SESSION['url'] : null;
    $hotel_id   = isset($_SESSION['hotel_id']) ? $_SESSION['hotel_id'] : null;

    // Returns a `Facebook\FacebookResponse` object
    $response = $fb->get('/me?fields=id,email', $accessToken);

    $user = $response->getGraphUser();
    $user_email = $user['email'];

    $link = mysql_connect('localhost', 'root', 'Zq4F3R607h1K') or die('Connection failed ' . mysql_error());
    mysql_select_db('radius') or die('DB selection failed');

    // Get page from hotels table
    $query = "SELECT  facebook_page_id  FROM hotels where id = '$hotel_id'";
    $result = mysql_query($query) or die('Get hotel id ' . mysql_error());
    $myrow = mysql_fetch_array($result);
    $facebook_page_id = $myrow['facebook_page_id'];

    // Check have this user liked
    $query = "SELECT * FROM facebook where email='$user_email'";
    $result = mysql_query($query) or die('Get like ' . mysql_error());
    $myrow = mysql_fetch_array($result);

    // Such user haven't liked yet
    if (!$myrow) {
        $back_url = "http://login.com/index.php?clientmac=$macaddress&liked=true";
        header('Location: '. $back_url);
    } else {

    }

} else {
    $helper = $fb->getRedirectLoginHelper();
    $permissions = ['email']; // optional
    $loginUrl = $helper->getLoginUrl('http://fbdev.guestcompass.nl/index.php', $permissions);

    header("Location: $loginUrl");
}