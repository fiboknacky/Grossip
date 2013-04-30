<?php
// API_KEY of Alchemy API
define('API_KEY',      'eec4d7858b0d7606a196cc42bfcc80394fbc5e34'                                          );
// define('API_SECRET',   'IPMQifmffPBJiSsr'                                       );
// if (strpos($_SERVER['SERVER_NAME'], 'localhost') !== FALSE)
//     define('REDIRECT_URI', 'http://localhost:8888' . $_SERVER['SCRIPT_NAME']);
// else 
//     define('REDIRECT_URI', 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['SCRIPT_NAME']);
// define('SCOPE',        'r_fullprofile r_emailaddress rw_nus'                        );
 
// You'll probably use a database
session_name('linkedin-api');
session_start();

if (isset($_SESSION['alchemy-extraction']) && !empty($_SESSION['alchemy-extraction'])){
    $text = $_SESSION['alchemy-extraction'];
    // echo $text;
}
else {
    $text = 'Job ID 4992543
    Job Title: Program/Project Manager - Business Operations - Mobile / Social Games
    Job Functions: Project Management
    Description: Responsibilities We are looking for a talented Project/Program Manager or a former strategy consultant to join the Business Operations group to help run, innovate and continuously improve our operations in order to create the leading mobile social gaming ecosystem in the world.  You will have a wide range of leadership opportunities, and will be key in leading improvements and execution within G
    Location: London, United Kingdom
    Posted By: Dawood U. (Senior Recruiter)';
}
$query_array["html"] = $text;
$query_array["apikey"] = API_KEY;
$query_array["keywordExtractMode"] = "strict";
$query_array["outputMode"] = "json";

$json_res = fetch('POST', 'html/HTMLGetRankedKeywords', $query_array);
// echo "<br>";
$i = 0;
$keyword_arr = array();
foreach ($json_res->keywords as $keyword){
    // var_dump($keyword);
    if ($i++ == 10)
        break;
    $keyword_arr[ucwords($keyword->text)] = $keyword->relevance;
    // echo "<br>";
}
// arsort($keyword_arr);
$response = implode(', ',array_keys($keyword_arr));
echo $response;

function fetch($method, $resource, $query_array, $body = '') {
     
    // $url = 'https://api.linkedin.com' . $resource . '?' . http_build_query($params,'','&',PHP_QUERY_RFC3986);
    $params = str_replace('+', '%20', http_build_query($query_array));
    $url = 'http://access.alchemyapi.com/calls/' . $resource;
    // Tell streams to make a (GET, POST, PUT, or DELETE) request
    $context = stream_context_create(
                    array('http' => 
                        array('method' => $method,
                            'header'=> "Content-type: application/x-www-form-urlencoded",
                            'content'=> $params,
                        )
                    )
                );
 
    // print_r($url);
    $response = file_get_contents($url, false, $context);
 
    // Native PHP object, please
    return json_decode($response);
}
?>