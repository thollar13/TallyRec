<?php

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
$userid = $_REQUEST['userid'];

$userid = stripslashes($userid);
$userid = mysqli_real_escape_string($userid);

$sql="SELECT * FROM $tbl_name WHERE (UserID = '$userid') AND (Active = '1')";

$result = mysqli_query($sql);    
// mysqli_num_row is counting table row
$count=mysqli_num_rows($result);

$counter = "";
// Get SQL Results
while ($row = mysqli_fetch_assoc($result)) {
   $counter++;
}
if($count==0){
    echo "0";
}
else {
    echo $counter;
}

ob_end_flush();

?>