<?php

ob_start();
    $host="192.168.2.7"; // Host name 
    $username="TallyRecWebUser"; // mysqli username 
    $password="webt00l"; // mysqli password 
    $db_name="tallyrec"; // Database name 
    $tbl_name="userroster"; // Table name 

    // Connect to server and select databse.
    mysqli_connect("$host", "$username", "$password")or die("cannot connect"); 
    mysqli_select_db("$db_name")or die("cannot select DB");

    // Load  Variables
    $teamid = $_REQUEST['teamid'];

    $sql="SELECT * FROM $tbl_name WHERE (teamid = '$teamid') AND (manager = '2')  AND (inactive != '1')";
    $result = mysqli_query($sql);    
    $counter = 0;
    $count=mysqli_num_rows($result);
    
    echo "<ul data-role='listview' data-inset='true' id='teamFollowersDiv'>";
        echo "<li data-role='list-divider' style='border-bottom:1px solid #000;'>";
            echo "<div class='ui-grid-a'>";
            echo "<div class='ui-block-a' style='text-align: left;'>Followers</div>";
            echo "</div>";
        echo "</li>";

        if($count==0){
            echo "<li class='ui-field-contain ui-body ui-br ui-btn-up-c ui-corner-top' style='text-align: center;font-size: 8pt; border: 1px solid #000; border-top: none;'>No Followers</li>";
        }
        else {
        
                // Get SQL Results
                while ($row = mysqli_fetch_assoc($result)) {
            
                    echo "<li>";
      
                        echo "<table style='width: 100%;'>";
                                echo "<tr>";
                                    echo "<td style='width: 15%;'>";
                                        // Check For Picture
                                            if ($row["imgurl"] == ""){
                                                echo "<img src='http://mobile.tallyrec.com/images/portraits/unknown.png' class='rosterImg'>";
                                            }
                                            else {
                                                echo "<img src='http://mobile.tallyrec.com/" . $row["imgurl"] . "' class='rosterImg'>";
                                            }
                                    echo "</td>";
                                    echo "<td style='width: 80%; font-size: 8pt;'>";
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
                                            echo "<br />";
                                            echo "Username: " . $row["username"];
                                            
                                    echo "</td>";
                                            echo "<td style='width: 5%;'>";
                                            echo "<a class='AddtoTeam' data-rosterimg='" . $row["imgurl"] . "' data-rosterid='" . $row["rosterid"] . "' data-rostername='";
                                                //Name
                                                 if ($row['nickname'] == ""){
                                                     echo $row["lname"] . ", " . $row["fname"];
                                                 }
                                                 else {
                                                     echo $row["nickname"];
                                                 }
                                            echo "'data-role='button' data-inline='true' data-mini='true'>Add</a>";
                                    echo "</td>";
                                echo "</tr>";
                            echo "</table>";
                    echo "</li>";
        
                    $counter++;     
                }   
        }

    echo "</ul>";
    
ob_end_flush();

?>