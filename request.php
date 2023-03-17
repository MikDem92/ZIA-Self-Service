<?php

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
    $status_code = curl_getinfo($curl, CURLINFO_RESPONSE_CODE);
    $response = curl_exec($curl);
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
       return array(
            "access_token" => $response_data->access_token,
            "expires_on" => time() + $response_data->expires_in
        ); 
    }

}

// Check if ACCESS_TOKEN environment variable exists
if (!getenv("ACCESS_TOKEN") or !getenv("EXPIRES_ON") or time() > getenv("EXPIRES_ON")) {
    // Get the parent directory path using the __DIR__ magic constant
    $parent_dir = dirname(__DIR__);

    // Construct the relative path to the JSON file
    $json_file_path = $parent_dir . '/config.json';

    // Read the contents of the JSON file into a string
    $json_string = file_get_contents($json_file_path);

    // Parse the JSON string into a PHP object
    $config_data = json_decode($json_string);

    // Access the values of the "client_id", "client_secret", and "scope" keys
    $auth_server = $config_data->auth_server;
    $client_id = $config_data->client_id;
    $client_secret = $config_data->client_secret;
    $scope = $config_data->scope;

    echo "I am here";
    /*
    // Initialize ACCESS_TOKEN & EXPIRES_ON
    $token_info = get_access_token($auth_server, $client_id, $client_secret, $scope);
    putenv("ACCESS_TOKEN=".$token_info["access_token"]);
    putenv("EXPIRES_ON=".$token_info["expires_on"]);

    echo getenv("ACCESS_TOKEN");
    echo getenv("EXPIRES_ON");
    */
}


/*
$user = $_POST["user"];
$url = $_POST["url"];

echo $user."\n";
echo $url."\n";
echo $client_id."\n";
echo $client_secret."\n";
echo $scope;
*/
?>

