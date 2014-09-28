<?php

ob_start();
$host="192.168.2.7"; // Host name 
$username="TallyRecWebUser"; // mysqli username 
$password="webt00l"; // mysqli password 
$db_name="tallyrec"; // Database name 
$tbl_name="schedule"; // Table name 

// Connect to server and select databse.
mysqli_connect("$host", "$username", "$password")or die("cannot connect"); 
mysqli_select_db("$db_name")or die("cannot select DB");

// Load  Variables
$teamid = $_REQUEST['teamid'];


$sql="SELECT * FROM $tbl_name WHERE (teamid = '$teamid') AND (Inactive != '1') AND (Inactive != '3')";
$result = mysqli_query($sql);    

// mysqli_num_row is counting table row
$count=mysqli_num_rows($result);

$awayPF = 0;
$awayCount = 0;


// No games on Schedule
if($count==0){
    echo "0";
}
else{


    while ($row = mysqli_fetch_assoc($result)) {

        // Determine if Win, Loss, Tie
        // Home
        if($row["HomeAway"] == "0"){
            if ($row["HomeScore"] == "-"){
                //do nothing
            }
            else {
                $awayPF = $awayPF + $row["HomeScore"];
                $awayCount++;
                
            }   
        }
        // Away
        else{
            " ";
        }
    }
    
    if ($awayPF == "0") {
        echo "0"; 
    }
    else {
    $awayPFAVG = $awayPF/$awayCount;
    echo "" . round($awayPFAVG,2) . "";
    }
}

ob_end_flush();

?>