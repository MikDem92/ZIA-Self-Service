<?php
include(
    "functions.php"
);

if (session_status() == 0){
    session_start();
    $_SESSION["ACCESS_TOKEN"] = "";
    $_SESSION["EXPIRES_ON"] = 0;
}

// Get access token
function get_access_token($auth_server, $client_id, $client_secret, $scope){ 
    $curl = curl_init(); 

    curl_setopt_array($curl, array(
      CURLOPT_URL => $auth_server,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS => array('grant_type' => 'client_credentials','client_id' => $client_id,'client_secret' => $client_secret,'scope' => $scope)
    ));
    $response = curl_exec($curl);
    if ($response === false) {
        echo 'Curl error: ' . curl_error($curl);
    }
    $status_code = curl_getinfo($curl, CURLINFO_RESPONSE_CODE);
    curl_close($curl);
 
    // Check if request failed
    if ($status_code !== 200) {
        echo "Request failed! Please contact the administrator.";
        return array(
            "access_token" => "",
            "expires_on" => 0
        );
    } else {
       $response_data = json_decode($response);
       echo "Request successful";
       return array(
            "access_token" => $response_data->access_token,
            "expires_on" => time() + $response_data->expires_in
        ); 
    }
}

// Check if ACCESS_TOKEN environment variable exists
if ($_SESSION["ACCESS_TOKEN"] == "" or time() > $_SESSION["EXPIRES_ON"]) {
    // Get the parent directory path using the __DIR__ magic constant
    $parent_dir = dirname(__DIR__);
    // Construct the relative path to the JSON file
    $config_path = $parent_dir . '/config.json';

    // Read the contents of the JSON file into a string
    $config_string = file_get_contents($config_path);

    // Parse the JSON string into a PHP object
    $config_data = json_decode($config_string);

    // Access the values of the "client_id", "client_secret", and "scope" keys
    $auth_server = $config_data->auth_server;
    $client_id = $config_data->client_id;
    $client_secret = $config_data->client_secret;
    $scope = $config_data->scope;

    // Initialize ACCESS_TOKEN & EXPIRES_ON
    $token_info = get_access_token($auth_server, $client_id, $client_secret, $scope);
    $_SESSION["ACCESS_TOKEN"] = $token_info["access_token"];
    $_SESSION["EXPIRES_ON"] = $token_info["expires_on"];
    //print_r($_SESSION);
}

$user = $_POST["user"];
$url = $_POST["url"];
$category_name = "API Test Category";
$category_id = "CUSTOM_03";

add_url_to_category($auth_server, $category_name, $category_id, $url, $_SESSION["ACCESS_TOKEN"]);


?>

