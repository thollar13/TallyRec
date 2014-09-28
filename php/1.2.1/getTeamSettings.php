<?php

ob_start();

    $host="192.168.2.7"; // Host name 
    $username="TallyRecWebUser"; // mysqli username 
    $password="webt00l"; // mysqli password 
    $db_name="tallyrec"; // Database name 
    $tbl_name="team"; // Table name 

    // Connect to server and select databse.
    mysqli_connect("$host", "$username", "$password")or die("cannot connect"); 
    mysqli_select_db("$db_name")or die("cannot select DB");

    // Define $myusername and $mypassword from form
    $teamid = $_REQUEST['teamid'];

    // To protect mysqli injection (more detail about mysqli injection)
    $teamid = stripslashes($teamid);
    $teamid = mysqli_real_escape_string($teamid);

    // mysqli Update Password
    $sql="SELECT * FROM $tbl_name WHERE (TeamID='$teamid')";
    $result=mysqli_query($sql);
    
    $row = mysqli_fetch_assoc($result);
    
    
                echo "<ul data-role='listview' data-inset='true' class='ui-listview ui-listview-inset ui-corner-all'>";
                    echo "<li data-role='fieldcontain' class='ui-field-contain ui-body ui-br ui-li ui-li-static ui-btn-up-c ui-corner-top'>";
                        echo "<div class='ui-grid-c'>";
                            echo "<div class='ui-block-a' style='font-size: 8pt;'>Team Name:</div>";
                            echo "<div class='ui-block-b' style='font-size: 8pt;'>";
                                echo "<input id='settingsName' value='" . $row["Name"] . "' type='text' style='font-size: 8pt;' />";
                            echo "</div>";
                        echo "</div>";
                    echo "</li>";
                    echo "<li data-role='fieldcontain' class='ui-field-contain ui-body ui-br ui-li ui-li-static ui-btn-up-c ui-corner-top'>";
                        echo "<div class='ui-grid-c'>";
                            echo "<div class='ui-block-a' style='font-size: 8pt;'>Sport:</div>";
                            echo "<div class='ui-block-b' style='font-size: 8pt;'>";
                            echo "<select name='select-choice-1' id='settingsSport' data-mini='true'>";
                                
                                echo "<option value='1'";
                                if ($row['SportID'] =="1") { echo "selected";}
                                echo ">Airsoft</option>";
                                echo "<option value='2'";
                                if ($row['SportID'] =="2") { echo "selected";}
                                echo ">Baseball</option>";
                                echo "<option value='3'";
                                if ($row['SportID'] =="3") { echo "selected";}
                                echo ">Basketball</option>";
                                echo "<option value='4'";
                                if ($row['SportID'] =="4") { echo "selected";}
                                echo ">Cheerleading</option>";
                                echo "<option value='16'";
                                if ($row['SportID'] =="16") { echo "selected";}
                                echo ">Dance</option>";
                                echo "<option value='5'";
                                if ($row['SportID'] =="5") { echo "selected";}
                                echo ">Football</option>";
                                echo "<option value='6'";
                                if ($row['SportID'] =="6") { echo "selected";}
                                echo ">Hockey</option>";
                                echo "<option value='17'";
                                if ($row['SportID'] =="17") { echo "selected";}
                                echo ">Kickball</option>";
                                echo "<option value='7'";
                                if ($row['SportID'] =="7") { echo "selected";}
                                echo ">Lacrosse</option>";
                                echo "<option value='8'";
                                if ($row['SportID'] =="8") { echo "selected";}
                                echo ">Paintball</option>";
                                echo "<option value='15";
                                if ($row['SportID'] =="15") { echo "selected";}
                                echo "'>Racquetball</option>";
                                echo "<option value='9'";
                                if ($row['SportID'] =="9") { echo "selected";}
                                echo ">Rugby</option>";
                                echo "<option value='10'";
                                if ($row['SportID'] =="10") { echo "selected";}
                                echo ">Soccer</option>";
                                echo "<option value='11'";
                                if ($row['SportID'] =="11") { echo "selected";}
                                echo ">Softball</option>";
                                echo "<option value='12'";
                                if ($row['SportID'] =="12") { echo "selected";}
                                echo ">Tennis</option>";
                                echo "<option value='13'";
                                if ($row['SportID'] =="13") { echo "selected";}
                                echo ">Volleyball</option>";
                                echo "<option value='14'";
                                if ($row['SportID'] =="14") { echo "selected";}
                                echo ">Wrestling</option>";
                                echo "<option value='100'";
                                if ($row['SportID'] =="100") { echo "selected";}
                                echo ">Other</option>";

                            echo "</select>";
                            echo "</div>";
                        echo "</div>";
                    echo "</li>";
                    echo "<li data-role='fieldcontain' class='ui-field-contain ui-body ui-br ui-li ui-li-static ui-btn-up-c'>";
                        echo "<div class='ui-grid-c'>";
                            echo "<div class='ui-block-a' style='font-size: 8pt;'>State:</div>";
                            echo "<div class='ui-block-b' style='font-size: 8pt;'>";
                                echo "<input id='settingsState' value='" . $row["State"] . "' type='text' style='font-size: 8pt;' />";
                            echo "</div>";
                        echo "</div>";
                    echo "</li>";
                    echo "<li data-role='fieldcontain' class='ui-field-contain ui-body ui-br ui-li ui-li-static ui-btn-up-c'>";
                        echo "<div class='ui-grid-c'>";
                            echo "<div class='ui-block-a' style='font-size: 8pt;'>City:</div>";
                            echo "<div class='ui-block-b' style='font-size: 8pt;'>";
                                echo "<input id='settingsCity' value='" . $row['City'] . "' type='text' style='font-size: 8pt;' />";
                            echo "</div>";
                        echo "</div>";
                    echo "</li>";
                    echo "<li data-role='fieldcontain' class='ui-field-contain ui-body ui-br ui-li ui-li-static ui-btn-up-c'>";
                        echo "<div class='ui-grid-c'>";
                            echo "<div class='ui-block-a' style='font-size: 8pt;'>Park:</div>";
                            echo "<div class='ui-block-b' style='font-size: 8pt;'>";
                                echo "<input id='settingsPark' value='" . $row["Park"] . "' type='text' style='font-size: 8pt;' />";
                            echo "</div>";
                        echo "</div>";
                    echo "</li>";
                    echo "<li data-role='fieldcontain' class='ui-field-contain ui-body ui-br ui-li ui-li-static ui-btn-up-c'>";
                        echo "<div class='ui-grid-c'>";
                            echo "<div class='ui-block-a' style='font-size: 8pt;'>League:</div>";
                            echo "<div class='ui-block-b' style='font-size: 8pt;'>";
                                echo "<input id='settingsLeague' value='" . $row["League"] . "' type='text' style='font-size: 8pt;' />";
                            echo "</div>";
                        echo "</div>";
                        echo "</li>";
                echo "</ul>";

ob_end_flush();


?>