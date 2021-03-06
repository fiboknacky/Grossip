<?php
// Change these
define('API_KEY',      'zsw4h3gaddha'                                          );
define('API_SECRET',   'IPMQifmffPBJiSsr'                                       );
if (strpos($_SERVER['SERVER_NAME'], 'localhost') !== FALSE)
    define('REDIRECT_URI', 'http://localhost:8888' . $_SERVER['SCRIPT_NAME']);
else 
    define('REDIRECT_URI', 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['SCRIPT_NAME']);
define('SCOPE',        'r_fullprofile r_emailaddress rw_nus'                        );
 
// You'll probably use a database
session_name('linkedin-api');
session_start();

/* for debugging */
// $_SESSION["searched"] = TRUE;
// $_SESSION["query"] = "GREE";

// OAuth 2 Control Flow
if (isset($_GET['error'])) {
    // LinkedIn returned an error
    print $_GET['error'] . ': ' . $_GET['error_description'];
    exit;
} elseif (isset($_GET['code'])) {
    // User authorized your application
    if ($_SESSION['state'] == $_GET['state']) {
        // Get token so you can make API calls
        getAccessToken();
    } else {
        // CSRF attack? Or did you mix up your states?
        exit;
    }
} else { 
    if ((empty($_SESSION['expires_at'])) || (time() > $_SESSION['expires_at'])) {
        // Token has expired, clear the state
        $_SESSION = array();
    }
    if (empty($_SESSION['access_token'])) {
        // Start authorization process
        getAuthorizationCode();
    }
}
 
// Congratulations! You have a valid token. Now fetch your profile 
// $user = fetch('GET', '/v1/people/~:(firstName,lastName)');
// print "<br>Hello $user->firstName $user->lastName.";
// var_dump($user);
// var_dump($_SESSION);
header("Location: main.php");
exit;
 
function getAuthorizationCode() {
    $params = array('response_type' => 'code',
                    'client_id' => API_KEY,
                    'scope' => SCOPE,
                    'state' => uniqid('', true), // unique long string
                    'redirect_uri' => REDIRECT_URI,
              );
 
    // Authentication request
    $url = 'https://www.linkedin.com/uas/oauth2/authorization?' . http_build_query($params);
     
    // Needed to identify request when it returns to us
    $_SESSION['state'] = $params['state'];
 
    // Redirect user to authenticate
    header("Location: $url");
    exit;
}
     
function getAccessToken() {
    $params = array('grant_type' => 'authorization_code',
                    'client_id' => API_KEY,
                    'client_secret' => API_SECRET,
                    'code' => $_GET['code'],
                    'redirect_uri' => REDIRECT_URI,
              );
     
    // Access Token request
    $url = 'https://www.linkedin.com/uas/oauth2/accessToken?' . http_build_query($params);
     
    // Tell streams to make a POST request
    $context = stream_context_create(
                    array('http' => 
                        array('method' => 'POST',
                        )
                    )
                );
 
    // Retrieve access token information
    $response = file_get_contents($url, false, $context);
 
    // Native PHP object, please
    $token = json_decode($response);
 
    // Store access token and expiration time
    $_SESSION['access_token'] = $token->access_token; // guard this! 
    $_SESSION['expires_in']   = $token->expires_in; // relative time (in seconds)
    $_SESSION['expires_at']   = time() + $_SESSION['expires_in']; // absolute time
     
    return true;
}
 
function fetch($method, $resource, $query_name = '', $query_value = '', $body = '') {
    if (empty($query_name)) {
        $params = array('oauth2_access_token' => $_SESSION['access_token'],
                        'format' => 'json',
                  );
    } else {
        $params = array('oauth2_access_token' => $_SESSION['access_token'],
                        'format' => 'json',
                        $query_name => $query_value,
                  );
    }
     
    // Need to use HTTPS
    // $url = 'https://api.linkedin.com' . $resource . '?' . http_build_query($params,'','&',PHP_QUERY_RFC3986);
    $params = str_replace('+', '%20', http_build_query($params));
    $url = 'https://api.linkedin.com' . $resource . '?' . $params;
    // Tell streams to make a (GET, POST, PUT, or DELETE) request
    $context = stream_context_create(
                    array('http' => 
                        array('method' => $method,
                        )
                    )
                );
 
 
    // Hocus Pocus
    // print_r($url);
    $response = file_get_contents($url, false, $context);
 
    // Native PHP object, please
    return json_decode($response);
}