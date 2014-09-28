<?php

// Replace with real server API key from Google APIs        
$apiKey = "AIzaSyDwfHou92fGAMUnRj-jTGOX2beNQfUq1MA";

// Replace with real client registration IDs
$registrationIDs = array( "APA91bH-RLNMLtz7ZDiiNKB6JOZCvywGY7K_7LYNV00JBMrsvUdrclnIyta5taUS7BO5udHAF5Qr-s5p3-eJQrpZhGDgLXb4yf-NRXiMrXjK8WZQO5NIeuPk5oJSBA8D8Ny45aO8SE0NsxO2t_KjU7FtYOVxHbnD6g");

// Message to be sent
$title = "TallyRec";
$message = "Practice tomorrow";

// Set POST variables
$url = 'https://android.googleapis.com/gcm/send';

$fields = array(
    'registration_ids' => $registrationIDs,
    'data' => array(    
                    "message" => $message, 
                    "title" => $title
                    ),
);

$headers = array(
    'Authorization: key=' . $apiKey,
    'Content-Type: application/json'
);

// Open connection
$ch = curl_init();

// Set the url, number of POST vars, POST data
curl_setopt($ch, CURLOPT_URL, $url );
curl_setopt($ch, CURLOPT_POST, true );
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true );
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode( $fields ));

// Execute post
$result = curl_exec($ch);

// Close connection
curl_close($ch);
echo $result;

?>