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

$overallPF = 0;
$overallPA = 0;
$overallGameCount = 0;

$homePF = 0;
$homePA = 0;
$homeGameCount = 0;

$awayPF = 0;
$awayPA = 0;
$awayGameCount = 0;

// No games on Schedule
if($count==0){
    //Do Nothing
}
else{

    while ($row = mysqli_fetch_assoc($result)) {
    
        if ($row["AwayScore"] == "-" || $row["HomeScore"] == "-") {
            //Do nothing
        }
        else {
            if($row["HomeAway"] == "1"){
            //Home Team
                $overallPF = $overallPF + $row["HomeScore"];
                $overallPA = $overallPA + $row["AwayScore"];
                
                $homePF = $homePF + $row["HomeScore"];
                $homePA = $homePA + $row["AwayScore"];
                
                $overallGameCount++;
                $homeGameCount++;
            }
            else {
            //Away Team
                $overallPF = $overallPF + $row["AwayScore"];
                $overallPA = $overallPA + $row["HomeScore"];
            
                $awayPF = $awayPF + $row["AwayScore"];
                $awayPA = $awayPA + $row["HomeScore"];
                
                $overallGameCount++;
                $awayGameCount++;
            }
        }
    }
}

// Getting PF, PA Averages
$overallAvgPF = $overallPF / $overallGameCount;
$overallAvgPA = $overallPA / $overallGameCount;
$homeAvgPF = $homePF / $homeGameCount;
$homeAvgPA = $homePA / $homeGameCount;
$awayAvgPF = $awayPF / $awayGameCount;
$awayAvgPA  = $awayPA / $awayGameCount;

$overallAvgPF = round($overallAvgPF, 2);
$overallAvgPA = round($overallAvgPA, 2);
$homeAvgPF = round($homeAvgPF, 2);
$homeAvgPA = round($homeAvgPA, 2);
$awayAvgPF = round($awayAvgPF, 2);
$awayAvgPA = round($awayAvgPA, 2);


    //Create Array
    $arr = array(
        'overallPF' => $overallPF,
        'overallPA' => $overallPA,
        'homePF' => $homePF,
        'homePA' => $homePA,
        'awayPF' => $awayPF,
        'awayPA' => $awayPA,
        'overallAvgPF' => $overallAvgPF,
        'overallAvgPA' => $overallAvgPA,
        'homeAvgPF' => $homeAvgPF,
        'homeAvgPA' => $homeAvgPA,
        'awayAvgPF' => $awayAvgPF,
        'awayAvgPA' => $awayAvgPA
    );
    
    echo json_encode($arr);

ob_end_flush();

?>