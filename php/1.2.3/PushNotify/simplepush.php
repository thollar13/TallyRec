<?php

// Put your device token here (without spaces):
// Robert 
$deviceToken = '7d3985ba7538eefb18308d8db4c24edc091dec70a2186614618f963c5bcb861b';
//Thomas $deviceToken = '5a0691795d018b4e3f2d70e939fc3abbb79f8465689db69df6bec6f1da9207a8';
//Lindsey $deviceToken = '8ed0fbb5f068231580197b8ecb453b06b86700d7aa64bc15fd150c717f8937bd';

// Put your private key's passphrase here:
$passphrase = 'accent5050';

// Put your alert message here:
$message = 'Testing ios Push';

////////////////////////////////////////////////////////////////////////////////

$ctx = stream_context_create();
stream_context_set_option($ctx, 'ssl', 'local_cert', 'ck.pem');
stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);

// Open a connection to the APNS server
$fp = stream_socket_client(
	'ssl://gateway.sandbox.push.apple.com:2195', $err,
	$errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);

if (!$fp)
	exit("Failed to connect: $err $errstr" . PHP_EOL);

echo 'Connected to APNS' . PHP_EOL;

// Create the payload body
$body['aps'] = array(
	'alert' => $message,
    'badge' => 1,
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
