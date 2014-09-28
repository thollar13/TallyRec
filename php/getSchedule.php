<?php

ob_start();
    require("constants.php");
    $tbl_name="schedule"; // Table name 

    // Load  Variables
    $teamid = $_REQUEST['teamid'];
    $TeamManageID = $_REQUEST['manage'];

    $sql="SELECT * FROM $tbl_name WHERE (teamid = '$teamid') AND (Inactive != '1') AND (Inactive != '3')";
    $result = mysqli_query($sql);    

    // mysqli_num_row is counting table row
    $count=mysqli_num_rows($result);

    $win = 0;
    $loss = 0;
    $tie = 0;

    // No games on Schedule
    if($count==0){
       echo "<ul data-role='listview' data-inset='true'>";
            echo "<li data-role='list-divider'>";
                echo "<div class='ui-grid-b'>";
                        echo "<div class='ui-block-a' style='text-align: left;'>Schedule</div>";
                        echo "<div class='ui-block-b' style='text-align: right;'></div>";
                        echo "<div class='ui-block-c' style='text-align: right;' id='teamWLTdiv'>Record: 0-0-0</div>";
                echo "</div>";
            echo "</li>";
            echo "<li class='ui-field-contain ui-body ui-br ui-btn-up-c ui-corner-top'>";
                echo "<div class='ui-grid-d'>";
	                echo "<div class='ui-block-a' style='text-align: left; font-size: 8pt'></div>";
	                echo "<div class='ui-block-b' style='text-align: center ; font-size: 8pt'>No games</div>";
	                echo "<div class='ui-block-c' style='text-align: center; font-size: 8pt'></div>";
                    echo "<div class='ui-block-d' style='text-align: center; font-size: 8pt'></div>";
                    echo "<div class='ui-block-e' style='text-align: center; font-size: 8pt;'></div>";
                echo "</div><!-- /grid-b -->";
                echo "<div class='ui-grid-d'>";
	                echo "<div class='ui-block-a' style='text-align: center; font-size: 8pt'></div>";
	                echo "<div class='ui-block-b' style='text-align: left; font-size: 8pt'></div>";
	                echo "<div class='ui-block-c' style='text-align: center; font-size: 8pt'></div>";
                    echo "<div class='ui-block-d' style='text-align: center; font-size: 8pt'></div>";
                    echo "<div class='ui-block-e' style='text-align: center; font-size: 8pt;'></div>";
                echo "</div><!-- /grid-b -->  ";
                echo "<div class='ui-grid-d'>";
	                echo "<div class='ui-block-a' style='text-align: center; font-size: 8pt'></div>";
	                echo "<div class='ui-block-b' style='text-align: left; font-size: 8pt'></div>";
	                echo "<div class='ui-block-c' style='text-align: center; font-size: 8pt'></div>";
                    echo "<div class='ui-block-d' style='text-align: center; font-size: 8pt'></div>";
                    echo "<div class='ui-block-e' style='text-align: center; font-size: 8pt;'></div>";
                echo "</div><!-- /grid-b -->";
            echo "</li>";
        echo "</ul>";
    
    
    
    }
    else{

        echo "<ul data-role='listview' data-inset='true'>";
    
            // Schedule Header
            echo "<li data-role='list-divider'>";
                echo "<div class='ui-grid-b'>";
                    echo "<div class='ui-block-a' style='text-align: left;'>Schedule</div>";
                    echo "<div class='ui-block-b' style='text-align: right;'></div>";
                    echo "<div class='ui-block-c' style='text-align: right;' id='teamWLTdiv'>Record: 0-0-0</div>";
                echo "</div>";
            echo "</li>";   
        
            // Get Games
            while ($row = mysqli_fetch_assoc($result)) {
                // Scheduled Games
                echo "<li class='ui-field-contain ui-body ui-br ui-btn-up-c ui-corner-top'>";
                    echo "<div class='ui-grid-d'>";
	                    echo "<div class='ui-block-a' style='text-align: left; font-size: 8pt'>";
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
                                                                              else {
                                                                                  echo "Dec. ";
                                                                              }
                            // Day
                            if (substr($row["Date"], 8, 1) == "0"){
                                echo substr($row["Date"], 9);
                            } 
                            else {
                                echo substr($row["Date"], 8);
                            }
                        echo "</div>";
	                    echo "<div class='ui-block-b' style='text-align: left ; font-size: 8pt'>";
                        // Opponent
                            // Determine if Home or Away
                            if($row["HomeAway"] == "1"){
                                echo $row["Opponent"];
                            }
                            else{
                                echo "@ " . $row["Opponent"];
                            }
                        echo "</div>";
	                    echo "<div class='ui-block-c' style='text-align: center; font-size: 8pt'></div>";
                        echo "<div class='ui-block-d' style='text-align: center; font-size: 8pt'></div>";
                        echo "<div class='ui-block-e' style='text-align: center; font-size: 8pt;'>";
                        // Determine if Win, Loss, Tie
                            // Home
                            if($row["HomeAway"] == "1"){
                                if ($row["HomeScore"]>$row["AwayScore"]){
                                    echo "Won";
                                    $win =  $win + 1;
                                } elseif ($row["HomeScore"]<$row["AwayScore"]){
                                    echo "Loss";
                                    $loss =  $loss + 1;
                                } else {
                                    if ($row["HomeScore"]==""&&$row["AwayScore"]==""||$row["HomeScore"]=="0"&&$row["AwayScore"]=="0"){
                                    }
                                    else{
                                        echo "Tie";
                                        $tie =  $tie + 1;
                                    }
                                }   
                            }
                            // Away
                            else{
                                if ($row["HomeScore"]<$row["AwayScore"]){
                                    echo "Won";
                                    $win =  $win + 1;
                                } elseif ($row["HomeScore"]>$row["AwayScore"]){
                                    echo "Loss";
                                    $loss =  $loss + 1;
                                } else {
                                    if ($row["HomeScore"]==""&&$row["AwayScore"]==""||$row["HomeScore"]=="0"&&$row["AwayScore"]=="0"){
                                    }
                                    else{
                                        echo "Tie";
                                        $tie =  $tie + 1;
                                    }
                                }
                            }
                        echo "</div>";
                    echo "</div><!-- /grid-b -->";
                    echo "<div class='ui-grid-d'>";
                        echo "<div class='ui-block-a' style='text-align: left; font-size: 8pt'>";
                        // Determine Time
                        echo $row["Time"];
                        echo "</div>";
	                    echo "<div class='ui-block-b' style='text-align: left; font-size: 8pt'>";
                        // Determine Location - City, State
                            if ($row["State"] == ""||$row["State"] == "0"){
                            }
                            else {
                            echo $row["City"] . ", " . $row["State"];
                            }
                        echo "</div>";
	                    echo "<div class='ui-block-c' style='text-align: center; font-size: 8pt'></div>";
                        echo "<div class='ui-block-d' style='text-align: center; font-size: 8pt'></div>";
                        echo "<div class='ui-block-e' style='text-align: center; font-size: 8pt;'>";
                        // Determine Score
                            // Home
                                if($row["HomeAway"] == "1"){
                                    if ($row["HomeScore"]>$row["AwayScore"]){
                                        echo $row["HomeScore"] . " - " . $row["AwayScore"];                
                                    } elseif ($row["HomeScore"]<$row["AwayScore"]){
                                        echo $row["HomeScore"] . " - " . $row["AwayScore"];
                                    } else {
                                        if ($row["HomeScore"]==""&&$row["AwayScore"]==""||$row["HomeScore"]=="0"&&$row["AwayScore"]=="0"){
                                            echo " - ";
                                        }
                                        else{
                                            echo $row["HomeScore"] . " - " . $row["AwayScore"];
                                        }
                                    }   
                                }
                                // Away
                                else{
                                    if ($row["HomeScore"]<$row["AwayScore"]){
                                        echo $row["AwayScore"] . " - " . $row["HomeScore"];
                                    } elseif ($row["HomeScore"]>$row["AwayScore"]){
                                        echo $row["AwayScore"] . " - " . $row["HomeScore"];
                                    } else {
                                        if ($row["HomeScore"]==""&&$row["AwayScore"]==""||$row["HomeScore"]=="0"&&$row["AwayScore"]=="0"){
                                            echo " - ";
                                        }
                                        else{
                                            echo $row["AwayScore"] . " - " . $row["HomeScore"];
                                        }
                                    }
                                }
                        echo "</div>";
                    echo "</div><!-- /grid-b -->  ";
                    echo "<div class='ui-grid-d'>";
	                    echo "<div class='ui-block-a' style='text-align: center; font-size: 8pt'></div>";
	                    echo "<div class='ui-block-b' style='text-align: left; font-size: 8pt'>";
                        // Determine Location - Park and Field
                            if ($row["Park"] == ""||$row["Park"] == "0"){
                            }
                            else {
                                echo $row["Park"];
                                if ($row["FieldNumber"] == ""||$row["FieldNumber"] == "0"){
                                }
                                else {
                                    echo " - Field " . $row["FieldNumber"];
                                }
                            }
                        echo "</div>";
	                    echo "<div class='ui-block-c' style='text-align: center; font-size: 8pt'></div>";
                        echo "<div class='ui-block-d' style='text-align: center; font-size: 8pt'></div>";
                        echo "<div class='ui-block-e' style='text-align: center; font-size: 8pt;'>";
                            if ($TeamManageID == "1") {
                                    echo "<a data-role='button' class='EditGameBtn' data-gameid='" . $row['GameID'] . "' data-opponent='" . $row["Opponent"] . "' data-date='" . $row['Date'] . "' data-time='" . $row['Time'] . "' data-park='" . $row['Park'] . "' data-homeaway='" . $row['HomeAway'] . "' data-city='" . $row['City'] . "' data-state='" . $row['State'] . "' data-homescore='" . $row['HomeScore'] . "' data-awayscore='" . $row['AwayScore'] . "' data-iconpos='notext' data-icon='arrow-r' data-mini='true' data-inline='true' style='font-size: 6pt; color: #48739d; margin-right: 3px;'>Edit</a>";
                                }
                                else {
                                    echo "&nbsp";
                                }
                        echo "</div>";
                    echo "</div>";
                echo "</li>";
            }
    
        echo "</ul>";
    }

ob_end_flush();

?>