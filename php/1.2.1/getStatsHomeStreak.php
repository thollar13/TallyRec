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

$win = 0;


// No games on Schedule
if($count==0){
    echo "0";
}
else{
    while ($row = mysqli_fetch_assoc($result)) {

        // Determine if Win, Loss, Tie
        // Home
        if($row["HomeAway"] == "1"){
            if ($row["HomeScore"]>$row["AwayScore"]){
                $win =  $win + 1;
            } elseif ($row["HomeScore"]<$row["AwayScore"]){
                $win = 0;
                $loss = $loss + 1;
            } else {
                if ($row["HomeScore"]==""&&$row["AwayScore"]==""||$row["HomeScore"]=="-"&&$row["AwayScore"]=="-"){
                }
                else{
                    $win = 0;
                }
            }   
        }
        // Away
        else{
            " ";
        }
    }
    
    if ($win > $loss) {
        
        echo "Won " . $win;
    } 
    elseif ($win < $loss){
        echo "Lost " . $loss;
    }
    elseif ($win == "1") {
        echo "Won " . $win;
    }
    elseif ($loss == "1") {
        echo "Lost " .$loss;
    }
    else {
        echo "0";
    }
}

ob_end_flush();

?>