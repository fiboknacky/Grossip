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

// if (!isset($_SESSION["companyname"]))
// {
//     header("Location: main.php");
//     exit;
// }

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
        header("Location: main.php");
        exit;
        // $tmp = $_SESSION["query"];
        // $_SESSION = array();
        // $_SESSION["searched"] = TRUE;
        // $_SESSION["query"] = $tmp;
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
$query_company = (!empty($_SESSION["companyname"]))?$_SESSION["companyname"]:'microsoft';
$job_obj = fetch('GET', '/v1/job-search','company-name',$query_company);
var_dump($job_obj);
$job_list = $job_obj->jobs->values;

echo "<br><br><hr>";
foreach ($job_list as $job){
    print_r($job->id);
        echo "<br>";
    print_r($job->company->name);
        echo "<br>";
    print_r($job->jobPoster->firstName);
        echo "<br>";
    print_r($job->jobPoster->lastName);
        echo "<br>";
    print_r($job->jobPoster->headline);
        echo "<br>";
    print_r(nl2br($job->descriptionSnippet));
        echo "<br>";
    print_r($job->locationDescription);
    echo "<br>";
        echo "<br>";
    // print "<br>$company->name<br>{$_SESSION['query']}";
    // if perfect matchd, use this company entry
    // if (strcasecmp(trim($company->name), trim($_SESSION["query"]))==0)
    // {
    //     $matched_company = $company;
    //     break;
    // }
    // // if partly matched, use the first one that occurs
    // if (!isset($matched_company) && (stristr($company->name, $_SESSION["query"]) || 
    //     stristr($_SESSION["query"], $company->name) )){
    //     $matched_company = $company;
    // }
}
// var_dump($matched_company);

// $field_selectors = ':(id,name,ticker,description,universal-name,website-url,logo-url,industries'.
//     ',blog-rss-url,twitter-id,employee-count-range,stock-exchange,locations,founded-year)';
// $company_obj = fetch('GET', '/v1/companies/'.$matched_company->id.$field_selectors);

// print_r($company_obj);
// echo "<br>info";
// foreach ($company_obj as $name => $item) {
//     echo "<br><b>$name </b>";
//     print_r($item);
// }

/*
$_SESSION["companyid"] = $company_obj->id;
$_SESSION["company"] = $company_obj;
ob_start();
require "sendback-company-info.php";
$response = ob_get_clean();
// var_dump($response);

// print "<br>Company {$matched_company->name}<br>";

// $query_string = 'linkedin';
// $job = fetch('GET', '/v1/job-search','keywords',$query_string);
// print "<br>Job $job->name";
// var_dump($job);

// return response to jQuery
echo $response;
*/
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