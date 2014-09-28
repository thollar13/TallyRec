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

$overallwin = 0;
$overallloss = 0;
$overalltie = 0;

$homewin = 0;
$homeloss = 0;
$hometie = 0;

$awaywin = 0;
$awayloss = 0;
$awaytie = 0;

// No games on Schedule
if($count==0){
    //Do Nothing
}
else{
    while ($row = mysqli_fetch_assoc($result)) {

        // Determine if Win, Loss, Tie
        // Home
        if($row["HomeAway"] == "1"){
            if ($row["HomeScore"]>$row["AwayScore"]){
                $overallwin =  $overallwin + 1;
                $overallloss = 0;
                $overalltie = 0;
                
                $homewin =  $homewin + 1;
                $homeloss = 0;
                $hometie = 0;
            } 
            elseif ($row["HomeScore"]<$row["AwayScore"]){
                $overallwin = 0;
                $overallloss =  $overallloss + 1;
                $overalltie = 0;
                
                $homewin = 0;
                $homeloss =  $homeloss + 1;
                $hometie = 0;
            } 
            else {
                if ($row["HomeScore"]==""&&$row["AwayScore"]==""||$row["HomeScore"]=="-"&&$row["AwayScore"]=="-"){
                }
                else{
                    $overalltie =  $overalltie + 1;
                    $overallwin = 0;
                    $overallloss = 0;
                    
                    $hometie =  $hometie + 1;
                    $homewin = 0;
                    $homeloss = 0;
                }
            }   
        }
        // Away
        else{
            if ($row["HomeScore"]<$row["AwayScore"]){
                $overallwin =  $overallwin + 1;
                $overallloss = 0;
                $overalltie = 0;
                
                $awaywin =  $awaywin + 1;
                $awayloss = 0;
                $awaytie = 0;
            } 
            elseif ($row["HomeScore"]>$row["AwayScore"]){
                $overallwin = 0;
                $overallloss =  $overallloss + 1;
                $overalltie = 0;
                
                $awaywin = 0;
                $awayloss =  $awayloss + 1;
                $awaytie = 0;
            } 
            else {
                if ($row["HomeScore"]==""&&$row["AwayScore"]==""||$row["HomeScore"]=="-"&&$row["AwayScore"]=="-"){
                }
                else{
                    $overalltie =  $overalltie + 1;
                    $overallwin = 0;
                    $overallloss = 0;
                    
                    $awaytie =  $awaytie + 1;
                    $awaywin = 0;
                    $awayloss = 0;
                }
            }
        }
    }
    
}

//Overall Streak
if ($overalltie == $overallwin && $overalltie == $overallloss) {
    $overallStreak = "None";
}
else if ($overalltie > $overallwin && $overalltie > $overallloss){
    $overallStreak = "Tied " . $overalltie;
} 
else if ($overallwin > $overallloss) {
    $overallStreak = "Won " . $overallwin;
}
else {
    $overallStreak = "Lost " . $overallloss;
}

//Home Streak
if ($hometie == $homewin && $hometie == $homeloss) {
    $homeStreak = "None";
}
else if ($hometie > $homewin && $hometie > $homeloss){
    $homeStreak = "Tied " . $hometie;
} 
else if ($homewin > $homeloss) {
    $homeStreak = "Won " . $homewin;
}
else {
    $homeStreak = "Lost " . $homeloss;
}

//Away Streak
if ($awaytie == $awaywin && $awaytie == $awayloss) {
    $awayStreak = "None";
}
else if ($awaytie > $awaywin && $awaytie > $awayloss){
    $awayStreak = "Tied " . $awaytie;
} 
else if ($awaywin > $awayloss) {
    $awayStreak = "Won " . $awaywin;
}
else {
    $awayStreak = "Lost " . $awayloss;
}

//Create Array
$arr = array(
    'overallStreak' => $overallStreak,
    'homeStreak' => $homeStreak,
    'awayStreak' => $awayStreak
);

echo json_encode($arr);

ob_end_flush();

?>