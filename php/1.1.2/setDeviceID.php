<?php


ob_start();

$host="192.168.2.7"; // Host name 
$username="TallyRecWebUser"; // mysqli username 
$password="webt00l"; // mysqli password 
$db_name="tallyrec"; // Database name 
$tbl_name="user"; // Table name 

// Connect to server and select databse.
mysqli_connect("$host", "$username", "$password")or die("cannot connect"); 
mysqli_select_db("$db_name")or die("cannot select DB");

// Define SQL Variables
$username = $_REQUEST['username'];
$deviceid = $_REQUEST['deviceid'];
$devicetype = $_REQUEST['devicetype'];

if ($devicetype=="" || $devicetype==null){
    $devicetype='ios';
}

// To protect mysqli injection (more detail about mysqli injection)
$username = stripslashes($username);
$username = mysqli_real_escape_string($username);
$deviceid = stripslashes($deviceid);
$deviceid = mysqli_real_escape_string($deviceid);
$devicetype = stripslashes($devicetype);
$devicetype = mysqli_real_escape_string($devicetype);

// mysqli Create User
$sql="UPDATE $tbl_name SET Token='$deviceid', TokenDevice='$devicetype' WHERE (Username='$username')";
$result=mysqli_query($sql);

$sql="SELECT * FROM $tbl_name WHERE Token='$deviceid'";
$result=mysqli_query($sql);

// mysqli_num_row is counting table row
$count=mysqli_num_rows($result);

// If result matched $myusername and $mypassword, table row must be 1 row
if($count==0){
    echo "E-C";
}
else {
    echo "No Errors";
}

ob_end_flush();

?>