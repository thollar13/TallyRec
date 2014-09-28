<?php

// Put your device token here (without spaces):
// Robert $deviceToken = '7d3985ba7538eefb18308d8db4c24edc091dec70a2186614618f963c5bcb861b';
//Thomas $deviceToken = '5a0691795d018b4e3f2d70e939fc3abbb79f8465689db69df6bec6f1da9207a8';

ob_start();

$host="192.168.2.7"; // Host name 
$username="TallyRecWebUser"; // mysqli username 
$password="webt00l"; // mysqli password 
$db_name="tallyrec"; // Database name 
$tbl_name="notes"; // Table name 

// Connect to server and select databse.
mysqli_connect("$host", "$username", "$password")or die("cannot connect"); 
mysqli_select_db("$db_name")or die("cannot select DB");

// Define Variables
$message = $_REQUEST['message'];
$touserid = $_REQUEST['touserid'];
$myuserid = $_REQUEST['userid'];

// To protect mysqli injection (more detail about mysqli injection)
$message = stripslashes($message);
$touserid = stripslashes($touserid);
$myuserid = stripslashes($myuserid);

$message = mysqli_real_escape_string($message);
$touserid = mysqli_real_escape_string($touserid);
$myuserid = mysqli_real_escape_string($myuserid);

        /*
         *
         * Get User Token
         *
         */
         
        $sql="SELECT Token, TokenDevice FROM User where (UserID = '$touserid')";
        $result=mysqli_query($sql);
        $count=mysqli_num_rows($result);

        if ($count == "0") {
            //Do nothing
        } 
        else {
        
            while ($row = mysqli_fetch_assoc($result)) {
                
                $token = $row['Token'];
                $tokenDeviceType = $row['TokenDevice'];
                
                echo $row['TokenDevice'];
            }
        
            /*
             *
             * Get User Badge Number
             *
             */
        

                $sql="SELECT * FROM notes WHERE (UserID = '$touserid') AND (Active = '1')";

                $result = mysqli_query($sql);    
                $count=mysqli_num_rows($result);
            
                $tokenBadgeNum = $count;
        
        
            /*
             *
             * Send Push Notifications
             *
             */
        
                if ($tokenDeviceType == "ios") {
                    //ios    
                    $deviceToken = $token;

                    // Put your private key's passphrase here:
                    $passphrase = 'accent5050';

                    // Put your alert message here:
                    $message = $message;

                    ////////////////////////////////////////////////////////////////////////////////

                    $ctx = stream_context_create();
                    stream_context_set_option($ctx, 'ssl', 'local_cert', 'ckprod.pem');
                    stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);

                    // Open a connection to the APNS server
                    $fp = stream_socket_client(
                        'ssl://gateway.push.apple.com:2195', $err,
                        $errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);

                    if (!$fp)
                        exit("Failed to connect: $err $errstr" . PHP_EOL);

                    echo 'Connected to APNS' . PHP_EOL;

                    // Create the payload body
                    $body['aps'] = array(
                        'alert' => $message,
                        'badge' => $tokenBadgeNum,
                        'sound' => 'default'
                        );

                    // Encode the payload as JSON
                    $payload = json_encode($body);

                    // Build the binary notification
                    $msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;

                    // Send it to the server
                    $result = fwrite($fp, $msg, strlen($msg));

                    if (!$result)
                        echo 'Message not delivered' . PHP_EOL;
                    else
                        echo 'Message successfully delivered' . PHP_EOL;

                    // Close the connection to the server
                    fclose($fp);
                }
                else if ($tokenDeviceType == "android") {
                    //Android
                    // Replace with real server API key from Google APIs        
                    $apiKey = "AIzaSyDwfHou92fGAMUnRj-jTGOX2beNQfUq1MA";

                    // Replace with real client registration IDs
                    $registrationIDs = array( $token );

                    // Message to be sent
                    $title = "TallyRec";
                    $message = $message;

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
                }
                else {
                    //Do nothing
                }
    
        }//End If

ob_end_flush();

?>