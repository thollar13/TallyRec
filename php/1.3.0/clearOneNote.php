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

// Define Variables
$noteid = $_REQUEST['noteid'];


// To protect mysqli injection (more detail about mysqli injection)
$noteid = stripslashes($noteid);
$noteid = mysqli_real_escape_string($noteid);

$sql="UPDATE $tbl_name SET Active='0' WHERE (NoteID='$noteid')";
$result = mysqli_query($sql);

echo "Success";

ob_end_flush();

?>