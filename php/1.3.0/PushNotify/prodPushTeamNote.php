<?php

// Put your device token here (without spaces):
// Robert $deviceToken = '7d3985ba7538eefb18308d8db4c24edc091dec70a2186614618f963c5bcb861b';
//Thomas $deviceToken = '5a0691795d018b4e3f2d70e939fc3abbb79f8465689db69df6bec6f1da9207a8';

ob_start();

require("constants.php");
$tbl_name="notes"; // Table name 

// Define Variables
$message = $_REQUEST['message'];
$teamid = $_REQUEST['teamid'];
$teamname = $_REQUEST['teamname'];
$myuserid = $_REQUEST['myuserid'];

// To protect mysqli injection (more detail about mysqli injection)
$message = stripslashes($message);
$teamid = stripslashes($teamid);
$teamname = stripslashes($teamname);
$myuserid = stripslashes($myuserid);

$message = mysqli_real_escape_string($message);
$teamid = mysqli_real_escape_string($teamid);
$teamname = mysqli_real_escape_string($teamname);
$myuserid = mysqli_real_escape_string($myuserid);

//Check for selected userid
$sql="SELECT UserID, AcceptTeamNote FROM roster where (TeamID = '$teamid') AND (Inactive != '1') AND (UserID != '$myuserid') AND (AcceptTeamNote = '1')";
$result=mysqli_query($sql);

$count=mysqli_num_rows($result);

$userid = array();
$totalarraycount = "0";//Will count the total number of users in the array

if($count==0){
    //Do Nothing
}
else {
    
    while ($row = mysqli_fetch_assoc($result)) {
        
        // Creating array of userid's on roster
        $userid[] = $row['UserID'];
        
        $totalarraycount++;
    }//End While
    
    /*
     *
     * Send Team Note to TallyRec notifications
     *
     */
     $countloop = "0";
     
     while ($countloop<=$totalarraycount) {
        
         $sql="INSERT INTO notes (NoteType, Message, Active, UserID, FromTeam, FromTeamID, TimeStamp) VALUES ('1', '$message','1', '$userid[$countloop]', '$teamname', '$teamid', now())";
        $result = mysqli_query($sql);
     
        $countloop++;
     }
    
     //Cuts message for Push Note to Phone
     if (strlen($message)>40) {
         $message = substr($message, 0, 40) . "...";
     }
     
    /*
     *
     * Get Tokens if exists
     *
     */
    
    $token = array();
    $tokenUserID = array();
    $tokenDeviceType = array();
    
    $countloop = "0";
    $numTotalTokens = "0"; //Counting number of users with tokens
    
    while ($countloop<=$totalarraycount) {
        
        $sql="SELECT UserID, Token, TokenDevice FROM User where (UserID = '$userid[$countloop]')";
        $result=mysqli_query($sql);
        $row = mysqli_fetch_assoc($result);
        
        // Getting Token ID's
        if (strlen($row['Token'])>2) {
            
            $tokenUserID[] = $row['UserID'];
            $token[] = $row['Token'];
            $tokenDeviceType[] = $row['TokenDevice'];
            
            $numTotalTokens++;
        }
        else {
            //Do Nothing
        }
        
        $countloop++;
    } //End While
    
    
    //Checking if any tokens were received.
    if ($numTotalTokens=="0") {
        //Do nothing
    } 
    else {
        
        /*
         *
         * Get User Badge Number
         *
         */
        
        $arraycount = "0";
        $tokenBadgeNum = array();
        
        while ($arraycount<=$numTotalTokens) {
            
            
            $sql="SELECT * FROM notes WHERE (UserID = '$tokenUserID[$arraycount]') AND (Active = '1')";

            $result = mysqli_query($sql);    
            $count=mysqli_num_rows($result);
            
            $tokenBadgeNum[] = $count;
            
            $arraycount++;
        }// End While
        
        
        /*
         *
         * Send Push Notifications
         *
         */
        
        $pushcount = "0";
        
        while ($pushcount<=$arraycount) {
            
                        if ($tokenDeviceType[$pushcount] == "ios") {
                            //ios    
                            $deviceToken = $token[$pushcount];

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
                                'badge' => $tokenBadgeNum[$pushcount],
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
                        else if ($tokenDeviceType[$pushcount] == "android") {
                            //Android
                                 // Replace with real server API key from Google APIs        
                                 $apiKey = "AIzaSyDwfHou92fGAMUnRj-jTGOX2beNQfUq1MA";

                                 // Replace with real client registration IDs
                                 $registrationIDs = array( $token[$pushcount] );

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
                        
            $pushcount++;
            
        }//End while
        
        
    } //End Else
    
}//End If


?>