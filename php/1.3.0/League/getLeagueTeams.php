<?php

ob_start();
require("constants.php");
$tbl_name="team"; // Table name 

// Set Variable
$leagueid = $_REQUEST['leagueid'];

// To protect mysqli injection
$leagueid = stripslashes($leagueid);
$leagueid = mysqli_real_escape_string($leagueid);


/*
 *
 * Get Teams in League  
 *
 */

$sql="SELECT TeamID, Name FROM $tbl_name WHERE (LeagueID = '$leagueid') AND (Inactive != '1') ORDER BY Name ASC";
$result=mysqli_query($sql);
$count=mysqli_num_rows($result);

if ($count == 0) {
    $awayteams = "<select id='leagueawayteam' data-mini='true' style='font-size: 8pt;'><option value='0'>No Teams Created</option></select>";
    $hometeams = "<select id='leaguehometeam' data-mini='true' style='font-size: 8pt;'><option value='0'>No Teams Created</option></select>"; 
    $allteams = "<select id='leaguehometeam' data-mini='true' style='font-size: 8pt;'><option value='0'>No Teams Created</option></select>"; 
} 
else {

    $awayteams = "<select id='leagueawayteam' data-mini='true' style='font-size: 8pt;'>";
    $hometeams = "<select id='leaguehometeam' data-mini='true' style='font-size: 8pt;'>";
    $allteams = "<select id='leagueallteam' data-mini='true' style='font-size: 8pt;'><option value='0'>All Teams</option>";
    $practiceteams = "<select id='leaguepracticeteam' data-mini='true' style='font-size: 8pt;'>";
    
    while ($row = mysqli_fetch_assoc($result)) {
        
        $awayteams = $awayteams . "<option value='" . $row['TeamID'] . "'>" . $row['Name'] . "</option>";
        $hometeams = $hometeams . "<option value='" . $row['TeamID'] . "'>" . $row['Name'] . "</option>";
        $allteams = $allteams . "<option value='" . $row['TeamID'] . "'>" . $row['Name'] . "</option>";
        $practiceteams = $practiceteams . "<option value='" . $row['TeamID'] . "'>" . $row['Name'] . "</option>";
    }
    
    $awayteams = $awayteams . "</select>";
    $hometeams = $hometeams . "</select>";
    $allteams = $allteams . "</select>";
    $practiceteams = $practiceteams . "</select>";
  
}

$arr = array(
    'awayteams' => $awayteams,
    'hometeams' => $hometeams,
    'allteams' => $allteams,
    'practiceteams' => $practiceteams
);

echo json_encode($arr);

ob_end_flush();

?>