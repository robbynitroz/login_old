<?php


session_start();

require_once '../Facebook/autoload.php';
$fb = new Facebook\Facebook([
    'app_id' => '696113500523537',
    'app_secret' => 'f7c94fe5f0f51cc9a04fc2512b5c58cd',
    'default_graph_version' => 'v2.5',
]);

$helper = $fb->getRedirectLoginHelper();
$permissions = ['email', 'user_likes']; // optional


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
    $totalLikes = array();
    if ($fb->next($likes)) {
        $likesArray = $likes->asArray();
        $totalLikes = array_merge($totalLikes, $likesArray);
        while ($likes = $fb->next($likes)) {
            $likesArray = $likes->asArray();
            $totalLikes = array_merge($totalLikes, $likesArray);
        }
    } else {
        $likesArray = $likes->asArray();
        $totalLikes = array_merge($totalLikes, $likesArray);
    }
    // printing data on screen



    if($totalLikes & !empty($totalLikes)){

        var_dump($totalLikes); exit;

        //echo "You have internet now";
        $key = md5(microtime().rand());
        header("Location: http://login.com/index.php?like=true&key=$key");

        exit();

    }else{

        die('chexav');
        $key = md5(microtime().rand());
        header("Location: http://login.com/index.php?like=false&key=$key");

        exit();



    }


} else {
    $helper = $fb->getRedirectLoginHelper();
    $permissions = ['email', 'user_likes']; // optional
    $loginUrl = $helper->getLoginUrl('http://fbdev.guestcompass.nl/index.php', $permissions);

    header("Location: $loginUrl");
}