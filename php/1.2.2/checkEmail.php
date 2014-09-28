<?php

ob_start();

// Set Database variable    
$host="192.168.2.7"; // Host name 
$username="TallyRecWebUser"; // mysqli username 
$password="webt00l"; // mysqli password 
$db_name="tallyrec"; // Database name 
$tbl_name="user"; // Table name 

// Connect to server and select databse.
mysqli_connect("$host", "$username", "$password")or die("cannot connect"); 
mysqli_select_db("$db_name")or die("cannot select DB");

// Define Variable
$email = $_REQUEST['email'];

// To protect mysqli injection (more detail about mysqli injection)
$email = stripslashes($email);
$email = mysqli_real_escape_string($email);

$sql="SELECT * FROM $tbl_name WHERE Email='$email'";
$result=mysqli_query($sql);

// mysqli_num_row is counting table row
$count=mysqli_num_rows($result);

if($count==0){
    echo "No Errors";
}
else {
    //Email in use
    echo "E-E";
}

ob_end_flush();

?>