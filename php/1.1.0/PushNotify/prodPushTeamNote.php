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
    $teamid = $_REQUEST['teamid'];
    $teamname = $_REQUEST['teamname'];

            // To protect mysqli injection (more detail about mysqli injection)
            $message = stripslashes($message);
            $teamid = stripslashes($teamid);
            $teamname = stripslashes($teamname);

            $message = mysqli_real_escape_string($message);
            $teamid = mysqli_real_escape_string($teamid);
            $teamname = mysqli_real_escape_string($teamname);

            if (strlen($message)>40) {
                $message = substr($message, 0, 40) . "...";
            }
            
            //Check for selected userid
            $sql="SELECT UserID FROM roster where (TeamID = '$teamid') AND (Inactive != '1') AND (Manager = '0')";
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
                * Get Tokens if exists
                *
                */
            
                $token = array();
                $tokenUserID = array();
            
                $countloop = "0";
                $numTotalTokens = "0"; //Counting number of users with tokens
                
                while ($countloop<=$totalarraycount) {
                
                    $sql="SELECT UserID, Token FROM User where (UserID = '$userid[$countloop]')";
                    $result=mysqli_query($sql);
                    $row = mysqli_fetch_assoc($result);
                
                    // Getting Token ID's
                    if (strlen($row['Token'])>2) {
                    
                        $tokenUserID[] = $row['UserID'];
                        $token[] = $row['Token'];
                    
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
                        
                        
                        $pushcount++;
                        
                    }//End while
                    
                    
                } //End Else
        
            }//End If

                                    
                    
                                    
                                    
                            
                            
                               





?>