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
	                echo "<div class='ui-block-b' style='text-align: center ; font-size: 8pt'>No Events</div>";
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
                echo "<table style='width:100%;'>";
                    echo "<tr>";
                        echo "<td style='width:50%;'>Schedule</td>";
                        echo "<td id='teamWLTdiv' style='text-align:right;'>Record: 0-0-0</td>";
                    echo "</tr>";
                echo "</table>";
            echo "</li>";   
        
            // Get Games
            while ($row = mysqli_fetch_assoc($result)) {
                // Scheduled Games
                echo "<li class='ui-field-contain ui-body ui-br ui-btn-up-c ui-corner-top'>";
                if ($TeamManageID == "1") {
                    echo "<a class='EditGameBtn' data-gameid='" . $row['GameID'] . "' data-opponent='" . htmlspecialchars($row["Opponent"], ENT_QUOTES) . "' data-date='" . $row['Date'] . "' data-time='" . $row['Time'] . "' data-park='" . htmlspecialchars($row['Park'], ENT_QUOTES) . "' data-homeaway='" . $row['HomeAway'] . "' data-city='" . htmlspecialchars($row['City'], ENT_QUOTES) . "' data-state='" . $row['State'] . "' data-homescore='" . $row['HomeScore'] . "' data-awayscore='" . $row['AwayScore'] . "' data-eventtype='" . $row['EventType'] . "' >";
                }
                else {
                    //echo "&nbsp";
                }    
                echo "<table style='width:100%;'>";
                        echo "<tr style='vertical-align:top;'>";
                            echo "<td style='text-align:left; font-size:8pt; width:25%;'>";
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
                            echo "<br />";
                                // Determine Time
                                if ( $row["Time"] == "-") {
                                    echo "&nbsp;";
                                }
                                else {
                                    echo $row["Time"];
                                }
                                
                            echo "<br />";
                            echo "</td>";
                            echo "<td style='text-align:left; font-size:8pt; width:50%; '>";
                                // Opponent
                                // Determine if Home or Away
                                if($row["HomeAway"] == "1"){
                                    echo $row["Opponent"];
                                }
                                else{
                                    echo "@ " . $row["Opponent"];
                                }
                                
                                echo "<br />";
                                // Determine Location - City, State
                                if ($row["State"] == ""||$row["State"] == "0"){
                                }
                                else {
                                    echo $row["City"] . ", " . $row["State"];
                                }
                             echo "<br />";
                                    // Determine Location - Park and Field
                                    if ($row["Park"] == ""||$row["Park"] == "-"){
                                    echo "&nbsp;";
                                    }
                                    else {
                                        echo $row["Park"];
                                    }
                            echo "</td>";
                            echo "<td style='text-align:center; font-size:8pt; width:20%;'>";
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
                                        if ($row["HomeScore"]==""&&$row["AwayScore"]==""||$row["HomeScore"]=="-"&&$row["AwayScore"]=="-"){
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
                                        if ($row["HomeScore"]==""&&$row["AwayScore"]==""||$row["HomeScore"]=="-"&&$row["AwayScore"]=="-"){
                                        }
                                        else{
                                            echo "Tie";
                                            $tie =  $tie + 1;
                                        }
                                    }
                                }
                                echo "<br />";
                                // Determine Score
                                // Home
                                if($row["HomeAway"] == "1"){
                                    if ($row["HomeScore"]>$row["AwayScore"]){
                                        echo $row["HomeScore"] . " - " . $row["AwayScore"];                
                                    } elseif ($row["HomeScore"]<$row["AwayScore"]){
                                        echo $row["HomeScore"] . " - " . $row["AwayScore"];
                                    } else {
                                        if ($row["HomeScore"]==""&&$row["AwayScore"]==""||$row["HomeScore"]=="-"&&$row["AwayScore"]=="-"){
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
                                        if ($row["HomeScore"]==""&&$row["AwayScore"]==""||$row["HomeScore"]=="-"&&$row["AwayScore"]=="-"){
                                            echo " - ";
                                        }
                                        else{
                                            echo $row["AwayScore"] . " - " . $row["HomeScore"];
                                        }
                                    }
                                }
                                echo "<br />";
                            echo "</td>";
                        echo "</tr>";
                    echo "</table>";
                    if ($TeamManageID == "1") {
                        echo "</a>";
                    }
                echo "</li>";
            }
    
        echo "</ul>";
    }

ob_end_flush();

?>