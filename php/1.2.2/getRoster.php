<?php

ob_start();
    $host="192.168.2.7"; // Host name 
    $username="TallyRecWebUser"; // mysqli username 
    $password="webt00l"; // mysqli password 
    $db_name="tallyrec"; // Database name 
    $tbl_name="teamroster"; // Table name 

    // Connect to server and select databse.
    mysqli_connect("$host", "$username", "$password")or die("cannot connect"); 
    mysqli_select_db("$db_name")or die("cannot select DB");

    // Load  Variables
    $teamid = $_REQUEST['teamid'];

    $sql="SELECT * FROM $tbl_name WHERE (teamid = '$teamid') AND (Inactive != '1') AND (manager != '2')";
    $result = mysqli_query($sql);    
    $counter = 0;

    echo "<ul data-role='listview' data-inset='true'>";
        echo "<li data-role='list-divider'>";
            echo "<div class='ui-grid-a'>";
            echo "<div class='ui-block-a' style='text-align: left;'>Roster</div>";
            echo "<div class='ui-block-b' style='text-align: right;' id='teamRosterCount'>Players: 0</div>";
            echo "</div>";
        echo "</li>";

    // Get SQL Results
    while ($row = mysqli_fetch_assoc($result)) {
            
        echo "<li class='ui-field-contain ui-body ui-br ui-btn-up-c ui-corner-top'>";
        echo "<a class='RosterSelect' data-rosterimg='" . $row["ImgURL"] . "' data-rosterid='" . $row["rosterid"] . "' data-managercode='" . $row["manager"] . "' data-rosternumber='" . $row["playernumber"] . "' data-rostername='";
            //Name
            if ($row['nickname'] == ""){
                echo $row["lname"] . ", " . $row["fname"];
            }
            else {
                echo $row["nickname"];
            }
        echo "'data-rosterphone='" . $row["Phone"] . "' data-playertype='" . $row["PlayerType"] . "'>";
            echo "<table style='width: 100%;'>";
                    echo "<tr>";
                            
                        echo "<td style='width:15%;'>";
                            // Check For Picture
                                if ($row["ImgURL"] == ""){
                                    echo "<img src='http://mobile.tallyrec.com/images/portraits/unknown.png' class='rosterImg'>";
                                }
                                else {
                                    echo "<img src='http://mobile.tallyrec.com/" . $row["ImgURL"] . "' class='rosterImg'>";
                                }
                        echo "</td>";
                        echo "<td style='width: 85%; font-size: 8pt;'>";
                            // Get Number and Name
                                //Number
                                if ($row["playernumber"] == ""||$row["playernumber"] == "-"){
                                    echo "  ";
                                }
                                else {
                                    echo $row["playernumber"] . " ";
                                }
                                //Name
                                if ($row['nickname'] == ""){
                                    echo $row["lname"] . ", " . $row["fname"];
                                }
                                else {
                                    echo $row["nickname"];
                                }
 
                        echo "</td>";
                        
                    echo "</tr>";
                echo "</table>";
            echo "</a>";
        echo "</li>";
        
        $counter++;     
    }   
    
    echo "</ul>";
    
ob_end_flush();

?>