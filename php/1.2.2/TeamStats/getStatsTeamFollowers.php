<?php

ob_start();
$host="192.168.2.7"; // Host name 
$username="TallyRecWebUser"; // mysqli username 
$password="webt00l"; // mysqli password 
$db_name="tallyrec"; // Database name 
$tbl_name="userroster"; // Table name 

// Connect to server and select databse.
mysqli_connect("$host", "$username", "$password")or die("cannot connect"); 
mysqli_select_db("$db_name")or die("cannot select DB");

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