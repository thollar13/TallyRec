<?php

ob_start();
require("constants.php");
$tbl_name="userroster"; // Table name 

// Load  Variables
$teamid = $_REQUEST['teamid'];

$sql="SELECT * FROM $tbl_name WHERE (teamid = '$teamid') AND (manager = '2')  AND (inactive != '1')";
$result = mysqli_query($sql);    
$counter = 0;
$count=mysqli_num_rows($result);

if($count==0){
    echo "";
}
else {
    
    // Get SQL Results
    while ($row = mysqli_fetch_assoc($result)) {

        $counter++;     
    }   
}

if ($counter == "0") {
    echo "0";
    }
else {
    echo $counter;
    }

ob_end_flush();

?>