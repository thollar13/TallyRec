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
                $homewin = $homewin + 1;
            } elseif ($row["HomeScore"]<$row["AwayScore"]){
                $overallloss =  $overallloss + 1;
                $homeloss = $homeloss + 1;
            } else {
                if ($row["HomeScore"]==""&&$row["AwayScore"]==""||$row["HomeScore"]=="-"&&$row["AwayScore"]=="-"){
                }
                else{
                    $overalltie =  $overalltie + 1;
                    $hometie = $hometie + 1;
                }
            }   
        }
        // Away
        else{
            if ($row["HomeScore"]<$row["AwayScore"]){
                $overallwin =  $overallwin + 1;
                $awaywin = $awaywin + 1;
            } elseif ($row["HomeScore"]>$row["AwayScore"]){
                $overallloss =  $overallloss + 1;
                $awayloss = $awayloss + 1;
            } else {
                if ($row["HomeScore"]==""&&$row["AwayScore"]==""||$row["HomeScore"]=="-"&&$row["AwayScore"]=="-"){
                }
                else{
                    $overalltie =  $overalltie + 1;
                    $awaytie = $awaytie + 1;
                }
            }
        }
    }
}

$overallRecord =  $overallwin . "-" . $overallloss . "-" . $overalltie;
$homeRecord = $homewin . "-" . $homeloss . "-" . $hometie;
$awayRecord = $awaywin . "-" . $awayloss . "-" . $awaytie;

//Create Array
$arr = array(
    'overallRecord' => $overallRecord,
    'homeRecord' => $homeRecord,
    'awayRecord' => $awayRecord,
);

echo json_encode($arr);

ob_end_flush();

?>