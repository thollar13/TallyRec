<?php

ob_start();

require("../../constants.php");
$tbl_name="notes"; // Table name 

// Load  Variables
$userid = $_REQUEST['userid'];

$userid = stripslashes($userid);

$sql="SELECT * FROM $tbl_name WHERE (UserID = '$userid') AND (Active = '1')";
$result = $dbh->query($sql);    
$result->execute();
// mysqli_num_row is counting table row
$count=$result->rowCount();

$counter = "";
// Get SQL Results
while ($row = $result->fetch()) {
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