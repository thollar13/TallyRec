<?php

ob_start();

require("constants.php");
$tbl_name="myteams"; // Table name 

// Load  Variables
$username = $_REQUEST['username'];

$sql="SELECT * FROM $tbl_name WHERE (Username = '$username') AND (Archived != '1') AND (manager = '3')";
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