<?php

ob_start();

    $host="192.168.2.7"; // Host name 
    $username="TallyRecWebUser"; // mysqli username 
    $password="webt00l"; // mysqli password 
    $db_name="tallyrec"; // Database name 
    $tbl_name="TeamNote"; // Table name 


    // Connect to server and select databse.
    mysqli_connect("$host", "$username", "$password")or die("cannot connect"); 
    mysqli_select_db("$db_name")or die("cannot select DB");

    // Set variable
    $teamid = $_REQUEST['teamid'];
    $teammanager = $_REQUEST['teammanager'];

    // mysqli Submit Chat
    $sql="SELECT * FROM $tbl_name WHERE (ToTeamID = '$teamid') ORDER BY TimeStamp DESC LIMIT 1";
    $result=mysqli_query($sql);  

    // mysqli_num_row is counting table row
    $count=mysqli_num_rows($result);

    // If no matching results
    if($count==0){
    
    echo "<form id='TeamNoteForm'>";
    echo "<ul data-role='listview' data-inset='true'>";
        echo "<li data-role='list-divider' style='text-align: left; font-size: 8pt;'>Team Message</li>";
        
        if ($teammanager == "1") {
            echo "<li style='text-align: center; font-size: 8pt;'>";
                echo "<table>";
                    echo "<tr>";
                        echo "<td style='text-align: left; font-size: 8pt;' id='teamNoteDiv'>";
                                echo "<a id='NewTeamNoteBtn' data-role='button'  data-inline='true' data-mini='true'>New</a>";
                        echo "</td>";
                        echo "<td>No Team Messages At This Time</td>";
                    echo "</tr>";
                echo "</table>";
                echo "<table id='NewTeamNote' style='display:none; width:100%;'>";
                    echo "<tr>";
                        echo "<td><a id='TeamNoteSendBtn' data-role='button' data-inline='true' data-mini='true'>Save</a></td>";
                        echo "<td><textarea id='TeamNoteMessage' maxlength='250' style='font-size:8pt;' placeholder='Team Notification...' data-mini='true' data-inline='true'></textarea></td>";
                        //echo "<td><input id='TeamNoteMessage' maxlength='250' style='font-size:8pt;' placeholder='Team Notification...' data-mini='true' data-inline='true' /></td>";
                    echo "</tr>";
                echo "</table>";
            echo "</li>";
        echo "</ul>";
        echo "</form>";
        }
        else {
            echo "<li style='font-size: 8pt;'>No Team Messages At This Time</li>";
            echo "</ul>";
        }
    }
    else {
    
        // Get SQL Results
        while ($row = mysqli_fetch_assoc($result)) {
        
            $Date = date_parse($row['TimeStamp']);
        
            echo "<form id='TeamNoteForm'>";
            echo "<ul data-role='listview' data-inset='true'>";            
            echo "<li data-role='list-divider'>";
                echo "<div class='ui-grid-c'>";
                    echo "<div class='ui-block-a' style='text-align: left; font-size: 8pt;'>Message</div>";
                    echo "<div class='ui-block-b' style='text-align: right; font-size: 8pt;'>";
                        //Time of message
                        //Time
                        if (date("Y-m-d") == substr($row['TimeStamp'], 0, 10)) {
                            echo "Today at ";
                        }
                        else {
                            echo $Date['month'] . "/" . $Date['day'] . "/" . $Date['year'] . " at ";
                        }
        
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
                echo "</div>";
            echo "</li>";
            
            if ($teammanager == "1") {
                    
                echo "<li style='text-align: center; font-size: 8pt; border-bottom:#3f576e;' data-icon='plus' data-iconpos='top'>";
                        echo "<div>";
                            echo "<table>";
                                echo "<tr>";
                                    echo "<td style='width: 15%;'>";
                                        echo "<a id='NewTeamNoteBtn' data-role='button' data-icon='arrow-d' data-mini='true'>New</a>";
                                    echo "</td>";
                                    echo "<td style='width: 85%';>";
                                        echo "<span id='teamNoteDiv' style='font-size: 8pt; width:100%;'>";
                                            echo $row['Message'];
                                        echo "</span>";
                                    echo "</td>";
                                echo "</tr>";
                            echo "</table>";
                            
                        echo "</div>";
                echo "</li>";
                echo "<li style='border-top:#3f576e;'>";
                        echo "<table id='NewTeamNote' style='display:none; width: 100%;'>";
                            echo "<tr>";
                                echo "<td style='width:15%;'><a id='TeamNoteSendBtn' data-role='button' data-inline='true' data-mini='true' >Save</a></td>";                           
                                echo "<td style='width:85%;'><textarea id='TeamNoteMessage' maxlength='250' style='font-size:8pt;' placeholder='Team Notification...' data-mini='true'></textarea></td>";  
                                //echo "<td style='width:90%;'><input id='TeamNoteMessage' maxlength='250' style='font-size:8pt;' placeholder='Team Notification...' data-mini='true' /></td>";
                            echo "</tr>";
                        echo "</table>";
                    echo "</li>";
                echo "</ul>";
                echo "</form>";
            }
            else {
                echo "<li style='font-size: 8pt;'>";
                // Message
                echo $row['Message'];
                echo "</li>";
                echo "</ul>";
            }
            
        }
    }

ob_end_flush();

?>