<?php

ob_start();
require("constants.php");
$tbl_name="scheduleall"; // Table name 

// Load  Variables
$leagueid = $_REQUEST['leagueid'];
$TeamManageID = $_REQUEST['manage'];

/*
$sql="SELECT TeamID FROM team WHERE (LeagueID = '$leagueid') AND (Inactive != '1')";
$result=mysqli_query($sql);
$count=mysqli_num_rows($result);

$teamid = array();
$totalteamcount = 0;

while ($row = mysqli_fetch_assoc($result)) {
    $teamid[] = $row['TeamID'];
    
    $totalteamcount++;
}

$counter = 0;
$statement = "";
while ($counter<$totalteamcount) {
    if ($counter == 0) {
        $statement = $statement . "SELECT * FROM $tbl_name WHERE (Inactive != '1') AND (leagueid = '$leagueid') OR (teamid = '$teamid[$counter]')";
    }
    else {
        $statement = $statement . " OR (teamid = '$teamid[$counter]')";
    }

$counter++;
}

$statement = "SELECT * FROM $tbl_name WHERE (Inactive != '1') AND (leagueid = '$leagueid') ORDER BY Date ASC, TIME ASC";
*/

$sql="SELECT * FROM $tbl_name WHERE (Inactive != '1') AND (leagueid = '$leagueid') ORDER BY Date ASC, TIME ASC";
$result = mysqli_query($sql);    

// mysqli_num_row is counting table row
$count=mysqli_num_rows($result);

// No games on Schedule
if($count==0){
    echo "<ul data-role='listview' data-inset='true'>";
        echo "<li data-role='list-divider'>";
            echo "<table style='width:100%;text-align:center;font-size:8pt;'>";
                echo "<tr>";
                    echo "<td>Date</td>";
                    echo "<td>Visitor</td>";
                    echo "<td>&nbsp;</td>";
                    echo "<td>Home</td>";
                echo "</tr>";
            echo "</table>";
        echo "</li>";
        echo "<li class='ui-field-contain ui-body ui-br ui-btn-up-c ui-corner-top'>";
            echo "<table style='width:100%;text-align:center;font-size:8pt;'>";
                echo "<tr>";
                    echo "<td>";
                        echo "No Events";
                    echo "</td>";
                echo "</tr>";
            echo "</table>";
        echo "</li>";
    echo "</ul>";
}
else{

    echo "<ul data-role='listview' data-inset='true'>";
    
        // Schedule Header
        echo "<li data-role='list-divider'>";
            echo "<table style='width:100%;text-align:left;font-size:8pt;'>";
                echo "<tr>";
                    echo "<td style='width:20%;'>Date</td>";
                    echo "<td style='width:35%;'>Visitor</td>";
                    echo "<td style='width:10%;'>&nbsp;</td>";
                    echo "<td style='width:35%;'>Home</td>";
                echo "</tr>";
            echo "</table>";
        echo "</li>";   
        
        // Get Games
        while ($row = mysqli_fetch_assoc($result)) {
                    
                    // Scheduled Games
                    echo "<li class='ui-field-contain ui-body ui-br ui-btn-up-c ui-corner-top'>";
                    if ($TeamManageID == "4") {
                        echo "<a class='EditLeagueGameBtn' data-gameid='" . $row['GameID'] . "' data-hometeam='" . htmlspecialchars($row["HomeTeam"], ENT_QUOTES) . "' data-hometeamid='" . $row['HomeTeamID'] . "' data-awayteam='" . htmlspecialchars($row["AwayTeam"], ENT_QUOTES) . "' data-awayteamid='" . $row['AwayTeamID'] . "' data-date='" . $row['Date'] . "' data-time='" . $row['Time'] . "' data-park='" . htmlspecialchars($row['Park'], ENT_QUOTES) . "' data-city='" . htmlspecialchars($row['City'], ENT_QUOTES) . "' data-state='" . $row['State'] . "' data-homescore='" . $row['HomeScore'] . "' data-awayscore='" . $row['AwayScore'] . "' data-eventtype='" . $row['EventType'] . "' >";
                    }  
                    echo "<table style='width:100%;'>";
                        echo "<tr style='vertical-align:top;'>";
                            echo "<td style='text-align:left; font-size:8pt;width:20%;'>";
                                // Date
                                // Month
                                if (substr($row["Date"], 5, 2) == "1") {
                                    echo "Jan. ";
                                }
                                else if (substr($row["Date"], 5, 2) == "2") {
                                    echo "Feb. ";
                                }
                                else if (substr($row["Date"], 5, 2) == "3") {
                                    echo "Mar. ";
                                }
                                else if (substr($row["Date"], 5, 2) == "4") {
                                    echo "Apr. ";
                                }
                                else if (substr($row["Date"], 5, 2) == "5") {
                                    echo "May ";
                                }
                                else if (substr($row["Date"], 5, 2) == "6") {
                                    echo "Jun. ";
                                }
                                else if (substr($row["Date"], 5, 2) == "7") {
                                    echo "Jul. ";
                                }
                                else if (substr($row["Date"], 5, 2) == "8") {
                                    echo "Aug. ";
                                }
                                else if (substr($row["Date"], 5, 2) == "9") {
                                    echo "Sept. ";
                                }
                                else if (substr($row["Date"], 5, 2) == "10") {
                                    echo "Oct. ";
                                }
                                else if (substr($row["Date"], 5, 2) == "11") {
                                    echo "Nov. ";
                                }
                                else if (substr($row["Date"], 5, 2) == "12") {
                                    echo "Dec. ";
                                }
                                else {
                                    //Do Nothing
                                }
                                // Day
                                if (substr($row["Date"], 8, 1) == "0"){
                                    echo substr($row["Date"], 9);
                                } 
                                else {
                                    echo substr($row["Date"], 8);
                                }
                                echo "<br/>";
                                // Determine Time
                                if ( $row["Time"] == "-") {
                                    echo "&nbsp;";
                                }
                                else {
                                    echo $row["Time"];
                                }
                            echo "</td>";
                            echo "<td style='text-align:left; font-size:8pt; width:35%; '>";
                                // Away
                                if ($row['EventType'] == "0"){
                                    
                                    echo $row["AwayTeam"];
                                    
                                    if ($row["HomeScore"]==""&&$row["AwayScore"]==""||$row["HomeScore"]=="-"&&$row["AwayScore"]=="-"){
                                    }
                                    else {
                                        echo " ";
                                        echo $row["AwayScore"];
                                    }
                                }
                                else {
                                    echo $row["AwayTeam"];
                                    echo "<br/>";
                                    echo $row["HomeTeam"];
                                }
                            echo "</td>";
                            echo "<td style='text-align:left;font-size:8pt;width:10%'>";
                                if ($row['EventType'] == "0"){
                                    echo "@";
                                }
                                else {
                                    echo "&nbsp;";
                                }
                            echo "</td>";
                            echo "<td style='text-align:left;font-size:8pt;width:35%; '>";
                                // Home
                                if ($row['EventType'] == "0"){
                                    echo $row["HomeTeam"];
                                    if ($row["HomeScore"]==""&&$row["AwayScore"]==""||$row["HomeScore"]=="-"&&$row["AwayScore"]=="-"){
                                    }
                                    else {
                                        echo " ";
                                        echo $row["HomeScore"];
                                    }
                                }
                                else {
                                    echo "&nbsp;";
                                }

                            echo "</td>";
                        echo "</tr>";
                    echo "</table>";
                    if ($TeamManageID == "4") {
                        echo "</a>";
                    }
                    echo "</li>";
                            
        }//End While
    
    echo "</ul>";
}

ob_end_flush();

?>