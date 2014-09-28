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

                // Load  Variables
                $rosterid = $_REQUEST['rosterid'];

                $rosterid = stripslashes($rosterid);
                $rosterid = mysqli_real_escape_string($rosterid);
                
                    //Check for selected userid
                    $sql="SELECT UserID FROM roster WHERE RosterID='$rosterid'";
                    $result=mysqli_query($sql);
                    $row = mysqli_fetch_assoc($result);
                    $userid = $row['UserID'];

                $sql="SELECT * FROM $tbl_name WHERE (UserID = '$userid') AND (Active = '1')";

                $result = mysqli_query($sql);    
                // mysqli_num_row is counting table row
                $count=mysqli_num_rows($result);

                $counter = 0;
                // Get SQL Results
                while ($row = mysqli_fetch_assoc($result)) {
                    $counter++;
                }
                if($count==0){
                    $badgenum = 0;
                }
                else {
                    $badgenum = $counter;
                }



$deviceToken = $_REQUEST['token'];

// Put your private key's passphrase here:
$passphrase = 'accent5050';

// Put your alert message here:
$message = $_REQUEST['message'];

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
    'badge' => $badgenum,
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


?>