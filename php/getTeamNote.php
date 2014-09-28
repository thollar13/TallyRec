<?php

ob_start();

    require("constants.php");
    $tbl_name="TeamNote"; // Table name 

    // Set variable
    $teamid = $_REQUEST['teamid'];

    // mysqli Submit Chat
    $sql="SELECT * FROM $tbl_name WHERE (ToTeamID = '$teamid') ORDER BY TimeStamp DESC LIMIT 1";
    $result=mysqli_query($sql);  

    // mysqli_num_row is counting table row
    $count=mysqli_num_rows($result);

    // If no matching results
    if($count==0){
        echo "<ul data-role='listview' data-inset='true'>";
            echo "<li data-role='list-divider'>";
                echo "<div class='ui-grid-c'>";
                    echo "<div class='ui-block-a' style='text-align: left; font-size: 8pt;'></div>";
                    echo "<div class='ui-block-b' style='text-align: right; font-size: 8pt;'></div>";
                    echo "<div class='ui-block-c'></div>";
                    echo "<div class='ui-block-d'></div>";
                echo "</div>";
            echo "</li>";
            echo "<li style='font-size: 8pt;'>No Messages At This Time.</li>";
        echo "</ul>";
    }
    else {
    
        // Get SQL Results
        while ($row = mysqli_fetch_assoc($result)) {
        
            $Date = date_parse($row['TimeStamp']);
        
            echo "<ul data-role='listview' data-inset='true' id='teamnote'>";
            echo "<li data-role='list-divider'>";
                echo "<div class='ui-grid-c'>";
                    echo "<div class='ui-block-a' style='text-align: left; font-size: 8pt;'>Message</div>";
                    echo "<div class='ui-block-b' style='text-align: right; font-size: 8pt;'>";
                        //Time of message
                        echo $Date['month'] . "/" . $Date['day'] . "/" . $Date['year'] . " at ";
        
                            // Checking for PM
                            if ($Date['hour']>12) {
                                echo ($Date['hour']-12) . ":";
            
                                // Checking for single digit.
                                if (strlen($Date['minute'])>1) {
                                    echo $Date['minute'];
                                }
                                else {
                                    echo "0" . $Date['minute'];    
                                } 
                                echo " PM";
                            }
                            else {
                                echo $Date['hour'] . ":";
                                if (strlen($Date['minute'])>1) {
                                    echo $Date['minute'];
                                }
                                else {
                                    echo "0" . $Date['minute'];    
                                } 
                                echo " AM";
                                }
                    echo "</div>";
                    echo "<div class='ui-block-c'></div>";
                    echo "<div class='ui-block-d'></div>";
                echo "</div>";
            echo "</li>";
            echo "<li style='font-size: 8pt;'>";
                // Message
                echo $row['Message'];
            echo "</li>";
            echo "</ul>";
        }
    }

ob_end_flush();

?>