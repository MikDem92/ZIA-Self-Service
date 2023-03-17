<?php
// Get the parent directory path using the __DIR__ magic constant
$parent_dir = dirname(__DIR__);

// Construct the relative path to the JSON file
$json_file_path = $parent_dir . '/config.json';

// Read the contents of the JSON file into a string
$json_string = file_get_contents($json_file_path);

// Parse the JSON string into a PHP object
$config_data = json_decode($json_string);

// Access the values of the "client_id", "client_secret", and "scope" keys
$client_id = $config_data->client_id;
$client_secret = $config_data->client_secret;
$scope = $config_data->scope;

$user = $_POST["user"];
$url = $_POST["url"];

echo $user."\n";
echo $url."\n";
echo $client_id."\n";
echo $client_secret."\n";
echo $scope;
?>

