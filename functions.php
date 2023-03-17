<?php

function add_url_to_category($auth_server, $category_name, $category_id, $url, $access_token){
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => $auth_server,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'PUT',
        CURLOPT_POSTFIELDS =>'{  
            "configuredName":"'.$category_name.'",
            "customCategory":true,
            "superCategory":"USER_DEFINED",
            "urls":[  
                "'.$url.'"
            ],
            "id":"'.$category_id.'"
        }',
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
            'Authorization: Bearer '.$access_token
        ),
    ));

    $response = curl_exec($curl);
    $status_code = curl_getinfo($curl, CURLINFO_RESPONSE_CODE);
    curl_close($curl);
    
    if ($response === false) {
        echo 'Curl error: ' . curl_error($curl);
    }

    if ($status_code !== 200) {
        echo "Request failed! Please contact the administrator.";
    } else {
       echo "Request successful"; 
    }
}
?>