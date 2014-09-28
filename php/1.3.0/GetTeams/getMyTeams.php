<?php

ob_start();

    require("constants.php");
    $tbl_name="myteams"; // Table name 

    // Load  Variables
    $username = $_REQUEST['username'];

    $sql="SELECT * FROM $tbl_name WHERE (username = '$username') AND (Archived != '1') AND ((manager = '0') OR (manager = '1')) ORDER BY name ASC";
    $result = mysqli_query($sql);    
    // mysqli_num_row is counting table row
    $count=mysqli_num_rows($result);
    
    echo "<ul data-role='listview' data-inset='true'>";
    echo "<li data-role='list-divider'>My Teams</li>";
    
        // Get SQL Results
        while ($row = mysqli_fetch_assoc($result)) {
        
            echo "<li class='ui-icon-nodisc'>";
            
            //echo "<a data-teamid='" . $row["teamid"] . "' data-teamname='" . htmlspecialchars($row["name"], ENT_QUOTES) . "' data-manager='" . $row["manager"] . "' data-city='" . htmlspecialchars($row["City"], ENT_QUOTES) . "' data-state='" . $row["State"] . "' data-park='" . htmlspecialchars($row["Park"], ENT_QUOTES) . "' data-sport='" . $row["SportID"] . "' data-league='" . htmlspecialchars($row["League"], ENT_QUOTES) . "' data-teamnote='" . $row["AcceptTeamNote"] . "' data-chat='" . $row["AcceptChat"] . "' data-followers='" . $row["AcceptFollowNote"] . "' rel='external' data-ajax='false' class='createteamlink ui-link-inherit' data-transition='slide'>";
            echo "<a data-teamid='" . $row["teamid"] . "' data-leagueid='" . $row["LeagueID"] . "' data-teamname='" . htmlspecialchars($row["name"], ENT_QUOTES) . "' data-manager='" . $row["manager"] . "' data-city='" . htmlspecialchars($row["City"], ENT_QUOTES) . "' data-state='" . $row["State"] . "' data-park='" . htmlspecialchars($row["Park"], ENT_QUOTES) . "' data-sport='" . $row["SportID"] . "'";
            if (strlen($row['LeagueID']) >= 1) {
                echo "data-leagueid='" . $row['LeagueID'] . "' ";
            }
            echo "data-league='" . htmlspecialchars($row["League"], ENT_QUOTES) . "' data-teamnote='" . $row["AcceptTeamNote"] . "' data-chat='" . $row["AcceptChat"] . "' data-followers='" . $row["AcceptFollowNote"] . "' rel='external' data-ajax='false' class='createteamlink ui-link-inherit' data-transition='slide'>";
            
            
            echo "<img src='images/sport/" . $row["SportID"] . ".png' alt='' class='ui-li-icon' />";                
            
            echo $row["name"];

                echo "</a>";
            echo "</li>"; 
        }
        if($count==0){
            echo "<li>";
            echo "None";
            echo "</li>";
        }
    echo "</ul>";

ob_end_flush();

?>