<?php

// Get UserID and Username
ob_start();
require("constants.php");
$tbl_name="FutureGames"; // Table name 

// Set variable
if(!isset($_SESSION)){session_start(); }
$teamid = $_REQUEST['teamid'];
$teamname = $_REQUEST['teamname'];

// mysqli Submit Chat
$sql="SELECT * FROM $tbl_name WHERE teamid = '$teamid' LIMIT 1";
$result=mysqli_query($sql);  

// mysqli_num_row is counting table row
$count=mysqli_num_rows($result);
$row = mysqli_fetch_assoc($result);

// If result matched $myusername and $mypassword, table row must be 1 row
if($count==0){
    
    echo "<ul data-role='listview' data-inset='true'>";
    echo "<li data-role='list-divider'>";
    echo "<div class='ui-grid-c'>";
    echo "<div class='ui-block-a' style='text-align: left; font-size: 8pt;'>&nbsp;</div>";
    echo "<div class='ui-block-b' style='text-align: right; font-size: 8pt;'>&nbsp;</div>";
    echo "<div class='ui-block-c'></div>";
    echo "<div class='ui-block-d'></div>";
    echo "</div>";
    echo "</li>";
    echo "<li class='ui-field-contain ui-body ui-br ui-btn-up-c ui-corner-top'>";
    echo "<div class='ui-grid-d'>";
    echo "<div class='ui-block-a' style='margin-top: 5%; text-align: center; font-size: 10pt'>&nbsp;</div>";
    echo "<div class='ui-block-b' style='margin-top: 5%; text-align: center; font-size: 8pt;'>No games at this time</div>";
    echo "<div class='ui-block-c' style='margin-top: 5%; text-align: center; font-size: 10pt'>&nbsp;</div>";
    echo "</div>";
    echo "<!-- /grid-b -->";
    echo "<div class='ui-grid-d'>";
    echo "<div class='ui-block-a' style='text-align: center; font-size: 8pt'>";
    echo "</div>";
    echo "<div class='ui-block-b' style='margin-top: 10%; text-align: center; font-size: 8pt'>";
    echo "</div>";
    echo "<div class='ui-block-c' style='text-align: center; font-size: 8pt'>";
    echo "</div>";
    echo "<div class='ui-block-d' style='text-align: center; font-size: 8pt'>";
    echo "</div>";
    echo "<div class='ui-block-e' style='text-align: center; font-size: 8pt'>";
    echo "</div>";
    echo "</div>";
    echo "<div class='ui-grid-d'>";
    echo "<div class='ui-block-a' style='text-align: center; font-size: 8pt'>";
    echo "</div>";
    echo "<div class='ui-block-b' style='text-align: center; font-size: 8pt'>";
    echo "</div>";
    echo "<div class='ui-block-c' style='text-align: center; font-size: 8pt'>";
    echo "</div>";
    echo "<div class='ui-block-d' style='text-align: center; font-size: 8pt'>";
    echo "</div>";
    echo "<div class='ui-block-e' style='text-align: center; font-size: 8pt'>";
    echo "</div>";
    echo "</div>";
    echo "<!-- /grid-b -->";
}
else {
    
    echo "<ul data-role='listview' data-inset='true'>";
    echo "<li data-role='list-divider'>";
        echo "<div class='ui-grid-b'>";
            echo "<div class='ui-block-a' style='text-align: left; font-size: 8pt;'>";
                // Game Date
                    $month =  substr($row["Date"], 5, 2);
                    if ($month>"11"){echo "December";}
                    else if ($month>"10"){echo "November";}
                    else if ($month>"9"){echo "October";}
                    else if ($month>"8"){echo "September";}
                    else if ($month>"7"){echo "August";}
                    else if ($month>"6"){echo "July";}
                    else if ($month>"5"){echo "June";}
                    else if ($month>"4"){echo "May";}
                    else if ($month>"3"){echo "April";}
                    else if ($month>"2"){echo "March";}
                    else if ($month>"1"){echo "February";}
                    else {echo "January";}
    
                    echo " " . substr($row["Date"], 8);
                    echo ", " . substr($row["Date"], 0, 4);
            echo "</div>";
            echo "<div class='ui-block-b'></div>";
            echo "<div class='ui-block-c' style='text-align: right; font-size: 8pt;'>";
                // Game Time 
                    if ($row['Time']==""||$row['Time']=="0"){
                        echo "nbsp;";
                    }
                    else {
                        echo $row['Time'];
                    }
            echo "</div>";
            
            echo "<div class='ui-block-d'></div>";
        echo "</div>";
    echo "</li>";
    echo "<li class='ui-field-contain ui-body ui-br ui-btn-up-c ui-corner-top'>";
    echo "<div class='ui-grid-b'>";
        //Check if Home or Away
            if ($row['HomeAway']=="1"){
        
                echo "<div class='ui-block-a' style='margin-top: 5%; text-align: center; font-size: 10pt'>" . $row['Opponent'] . "</div>";
                echo "<div class='ui-block-b' style='margin-top: 5%; text-align: center; font-size: 8pt;'> @ </div>";
                echo "<div class='ui-block-c' style='margin-top: 5%; text-align: center; font-size: 10pt'>" . $teamname . "</div>";
            }
            else {
        
                echo "<div class='ui-block-a' style='margin-top: 5%; text-align: center; font-size: 10pt'>" . $teamname ."</div>";
                echo "<div class='ui-block-b' style='margin-top: 5%; text-align: center; font-size: 8pt;'> @ </div>";
                echo "<div class='ui-block-c' style='margin-top: 5%; text-align: center; font-size: 10pt'>" . $row['Opponent'] . "</div>";
            }
        
    echo "</div>";
    echo "<!-- /grid-b -->";
    echo "<div class='ui-grid-d'>";
        echo "<div class='ui-block-a' style='text-align: center; font-size: 8pt'></div>";
        echo "<div class='ui-block-b' style='margin-top: 10%; text-align: center; font-size: 8pt'>";
            // Game Park
                if ($row['Park']==""||$row['Park']=="0"){
                    echo "&nbsp";
                }
                else {
                    if ($row['Park']=="-"){
                        echo "&nbsp;";
                    }
                    else {
                        echo $row['Park'];
                        }
                }
        echo "</div>";
        echo "<div class='ui-block-c' style='text-align: center; font-size: 8pt'></div>";
        echo "<div class='ui-block-d' style='text-align: center; font-size: 8pt'></div>";
        echo "<div class='ui-block-e' style='text-align: center; font-size: 8pt'></div>";
    echo "</div>";
    echo "<div class='ui-grid-d'>";
        echo "<div class='ui-block-a' style='text-align: center; font-size: 8pt'></div>";
        echo "<div class='ui-block-b' style='text-align: center; font-size: 8pt'>";
            // Game City, State
            echo $row['City'] . ", " . $row['State'];
        echo "</div>";
        echo "<div class='ui-block-c' style='text-align: center; font-size: 8pt'></div>";
        echo "<div class='ui-block-d' style='text-align: center; font-size: 8pt'></div>";
        echo "<div class='ui-block-e' style='text-align: center; font-size: 8pt'></div>";
    echo "</div>";
    echo "<!-- /grid-b -->";
    
}
           
    echo "<div class='ui-grid-b'>";
            
        //<!-- Previous Game Information Div -->";
        echo "<div class='ui-block-a' style='text-align: center; font-size: 8pt' id='previousGame'>";
            // If no results match    
            echo "<ul data-role='listview' data-inset='true'>";
            echo "<li data-role='list-divider' style='font-size: 7pt; text-align: center'>Previous Game</li>";
            echo "<li style='font-size: 7pt; text-align: center;'>";
            echo "<table style='width: 100%;'>";
            echo "<tr>";
            echo "<td style='text-align: center;'>No games</td>";
            echo "</tr>";
            echo "<tr>";
            echo "<td style='text-align: center;'>&nbsp;</td>";
            echo "</tr>";
            echo "</table>";
            echo "</li>";
            echo "</ul>";
        echo "</div>";
        
        echo "<div class='ui-block-b' style='text-align: left; font-size: 8pt'></div>";

        //<!-- Next Game Information Div -->";
        echo "<div class='ui-block-c' style='text-align: center; font-size: 8pt' id='upcomingGame'>";
            //If no Results match
            echo "<ul data-role='listview' data-inset='true'>";
            echo "<li data-role='list-divider' style='font-size: 7pt; text-align: center'>Upcoming Game</li>";
            echo "<li style='font-size: 7pt; text-align: center; background: none;'>";
            echo "<table style='width: 100%; ;'>";
            echo "<tr>";
            echo "<td style='text-align: center;'>No Games</td>";
            echo "</tr>";
            echo "<tr>";
            echo "<td style='text-align: center;'>&nbsp;</td>";
            echo "</tr>";
            echo "</table>";
            echo "</li>";
            echo "</ul>";
        
        echo "</div>";
                
    echo "</div>";
    echo "<!-- /grid-b -->";
echo "</li>";
echo "</ul>";

ob_end_flush();                
                
?>