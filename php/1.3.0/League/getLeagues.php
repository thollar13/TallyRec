<?php

ob_start();

require("../../../constants.php");
$tbl_name="myleagues"; // Table name 

// Load  Variables
$username = $_REQUEST['username'];

$sql="SELECT * FROM $tbl_name WHERE (username = '$username') AND (Archived != '1') AND (Manager = '4') ORDER BY Name ASC";
$result = $dbh->query($sql);  

// mysqli_num_row is counting table row
$count= $result -> rowCount();

if($count==0){
//Show Nothing
}
else {

    echo "<ul data-role='listview' data-inset='true'>";
    echo "<li data-role='list-divider'>My Leagues</li>";

    // Get SQL Results
    while ($row = mysqli_fetch_assoc($result)) {
    
        echo "<li class='ui-field-contain ui-body ui-br ui-btn-up-c ui-corner-top'>";
    
        echo "<a data-leagueid='" . $row["LeagueID"] . "' data-leaguename='" . htmlspecialchars($row["Name"], ENT_QUOTES) . "' data-manager='" . $row["manager"] . "' data-city='" . htmlspecialchars($row["City"], ENT_QUOTES) . "' data-state='" . $row["State"] . "' data-park='" . htmlspecialchars($row["Park"], ENT_QUOTES) . "' data-sport='" . $row["SportID"] . "' data-season='" . $row["Season"] . "' data-year='" . $row["Year"] . "' data-division='" . htmlspecialchars($row["Division"], ENT_QUOTES) . "' data-leaguenote='" . $row["AcceptLeagueNote"] . "' data-leaguechat='" . $row["AcceptLeagueChat"] . "' data-leaguefollowers='" . $row["AcceptLeagueFollowNote"] . "' rel='external' data-ajax='false' class='createleaguelink ui-link-inherit' data-transition='slide'>";
        echo "<img src='images/sport/" . $row["SportID"] . ".png' alt='' class='ui-li-icon' data-inline='true'/>";                
        echo $row["Name"] . " ";
        
        if ($row["Season"] == 1) {
            echo "(Spring ";
            }
        else if ($row["Season"] == 2) {
            echo "(Summer ";
        }
        else if ($row["Season"] == 3) {
            echo "(Fall ";
        }
        else if ($row["Season"] == 4) {
            echo "(Winter ";
        }
        else echo " ";
        
        echo "" . $row["Year"] . ")";
        echo "<br/>";
        if (strlen($row['Park']) >= 1) {
            echo "<span style='font-size:8pt;'>" . $row['Park'] . " Park - " . $row['City'] . ", " . $row['State'] ."</span>";
        }
        
       

        echo "</a>";
        echo "</li>"; 
    }
    echo "</ul>";
}

ob_end_flush();

?>