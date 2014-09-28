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
    
        echo "<ul data-role='listview' data-inset='true' data-split-icon='gear'>";
            echo "<li data-role='list-divider' style='text-align: left; font-size: 8pt;'>Team Message</li>";
        
            if ($teammanager == "1") {
            
                echo "<li style='text-align: center; font-size: 8pt; border-bottom:#3f576e;' data-icon='plus' data-iconpos='top'>";
            
                    echo "<a href=''>";
                    echo "<h2></h2>";
                    echo "<p class='ui-li-desc' style='text-align: left;'>No Team Messages At This Time</p>";
                    echo "<a href='#newNoteTeam' data-rel='popup' data-position-to='window' data-icon='edit' data-transition='pop'></a>";
            
                echo "</li>";
                echo "</ul>";
            
                echo "<div data-role='popup' id='newNoteTeam' class='ui-content' style='background-color:#3f576e;padding:10px;width:200px;border:1px solid black;'>";
                    echo "<form id='TeamNoteForm'>";
                        echo "<textarea id='TeamNoteMessage' maxlength='250' style='font-size:8pt;background:#c0c0c0;color:#3f576e' placeholder='Team Notification...' data-mini='true' data-inline='true'></textarea>"; 
                        echo "<a id='TeamNoteSendBtn' data-role='button'>Send</a>";   
                    echo "</form>";
                    echo "<a href='#' id='noteCloseBtn' data-rel='back' data-role='button' data-icon='delete' data-iconpos='notext' class='ui-btn-right'></a>"; 
                echo "</div>";
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
        
            echo "<ul data-role='listview' data-inset='true' data-split-icon='edit'>";            
            echo "<li data-role='list-divider'>";
                echo "<table style='width:100%'><tr>";
                    echo "<td style='text-align:left;font-size:8pt;width:50%;'>Message</td>";
                    echo "<td style='text-align:right;font-size:8pt;'>";
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
                    echo "</td>";
                echo "</tr></table>";
            echo "</li>";
            
            if ($teammanager == "1") {
                    
                echo "<li style='text-align: center; font-size: 8pt; border-bottom:#3f576e;' data-icon='plus' data-iconpos='top'>";
                        
                    echo "<a href=''>";
                    echo "<h2></h2>";
                    echo "<p class='ui-li-desc' style='text-align:left;white-space:normal;'>" . $row['Message'] . "</p>";
                    echo "<a href='#newNoteTeam' data-rel='popup' data-position-to='window' data-icon='edit' data-transition='pop'></a>";
                
                    echo "</li>";
                echo "</ul>";
                echo "<div data-role='popup' id='newNoteTeam' class='ui-content' style='background-color:#3f576e;padding:10px;width:200px;border:1px solid black;'>";
                    echo "<form id='TeamNoteForm'>";
                        echo "<textarea id='TeamNoteMessage' maxlength='250' style='font-size:8pt;background:#c0c0c0;color:#3f576e' placeholder='Team Notification...' data-mini='true' data-inline='true'></textarea>"; 
                        echo "<a id='TeamNoteSendBtn' data-role='button'>Send</a>";   
                    echo "</form>";
                        echo "<a href='#' id='noteCloseBtn' data-rel='back' data-role='button' data-icon='delete' data-iconpos='notext' class='ui-btn-right'></a>"; 
                echo "</div>";
            }
            else {
                    echo "<li style='font-size:8pt;white-space:normal;'>";
                    // Message
                    echo $row['Message'];
                    echo "</li>";
                echo "</ul>";
            }
            
        }
    }

ob_end_flush();

?>