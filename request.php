<?php
ini_set('variables_order', 'EGPCE');

$user = $_POST["user"];
$url = $_POST["url"];
$client_id = $_ENV["CLIENT_ID"];

echo $user;
echo $url;
echo $client_id;
?>

