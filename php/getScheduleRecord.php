<?php

ob_start();
require("constants.php");
$tbl_name="schedule"; // Table name 

// Load  Variables
$teamid = $_REQUEST['teamid'];


$sql="SELECT * FROM $tbl_name WHERE (teamid = '$teamid') AND (Inactive != '1') AND (Inactive != '3')";
$result = mysqli_query($sql);    

// mysqli_num_row is counting table row
$count=mysqli_num_rows($result);

$win = 0;
$loss = 0;
$tie = 0;

// No games on Schedule
if($count==0){
  echo "Record: 0-0-0";
}
else{
    while ($row = mysqli_fetch_assoc($result)) {

            // Determine if Win, Loss, Tie
            // Home
            if($row["HomeAway"] == "1"){
                if ($row["HomeScore"]>$row["AwayScore"]){
                    $win =  $win + 1;
                } elseif ($row["HomeScore"]<$row["AwayScore"]){
                    $loss =  $loss + 1;
                } else {
                    if ($row["HomeScore"]==""&&$row["AwayScore"]==""||$row["HomeScore"]=="0"&&$row["AwayScore"]=="0"){
                    }
                    else{
                        $tie =  $tie + 1;
                    }
                }   
            }
            // Away
            else{
                if ($row["HomeScore"]<$row["AwayScore"]){
                    $win =  $win + 1;
                } elseif ($row["HomeScore"]>$row["AwayScore"]){
                    $loss =  $loss + 1;
                } else {
                    if ($row["HomeScore"]==""&&$row["AwayScore"]==""||$row["HomeScore"]=="0"&&$row["AwayScore"]=="0"){
                    }
                    else{
                        $tie =  $tie + 1;
                    }
                }
            }
        }
        
    echo "Record: " . $win . "-" . $loss . "-" . $tie;
}

ob_end_flush();

?>