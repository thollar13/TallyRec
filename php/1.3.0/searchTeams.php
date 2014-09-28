<?php

ob_start();

$host="192.168.2.7"; // Host name 
$username="TallyRecWebUser"; // mysqli username 
$password="webt00l"; // mysqli password 
$db_name="tallyrec"; // Database name 
$tbl_name="searchteams"; // Table name 

// Connect to server and select databse.
mysqli_connect("$host", "$username", "$password")or die("cannot connect"); 
mysqli_select_db("$db_name")or die("cannot select DB");

// Load  Variables
$searchinfo = $_REQUEST['searchinfo'];

// To protect mysqli injection (more detail about mysqli injection)
$searchinfo = stripslashes($searchinfo);
$searchinfo = mysqli_real_escape_string($searchinfo);


$sql="SELECT * FROM $tbl_name WHERE (Name LIKE '%$searchinfo%') OR (City LIKE '%$searchinfo%') OR (State LIKE '%$searchinfo%') OR (Park LIKE '%$searchinfo%') OR (League LIKE '%$searchinfo%') ORDER BY name ASC";
$result = mysqli_query($sql);    
// mysqli_num_row is counting table row
$count=mysqli_num_rows($result);

if($count==0){

    echo "<ul data-role='listview' style='font-size: 8pt;' data-inset='false' data-inline='true' data-mini='true' id='searchteams' >";
        
        //echo "<li data-filter='true' data-mini='true' id='searchteams' >";
        echo "<li data-filtertext=''>";
            echo "<div class='ui-grid-a'>";
	            echo "<div class='ui-block-a' style='font-size:10pt; padding-top: 1%; text-align: left;'><span id='Span1'>No Results Matched</span></div>";
	            //echo "<div class='ui-block-b' style='text-align: right;'><a data-mini='true' data-role='button' data-inline='true'></a></div>";
            echo "</div>";
        echo "</li>";
    echo "</ul>";
    
}

else {
    echo "<br />";

    echo "<ul data-role='listview' style='font-size: 8pt;' data-inset='false' data-inline='true' data-mini='true' id='searchteams'>";
    //echo "<ul data-role='listview' style='font-size: 8pt;' data-inset='false' data-inline='true' data-filter='true' data-mini='true' id='searchteams' data-filter-placeholder='Filter Teams'>";

    // Get SQL Results
    while ($row = mysqli_fetch_assoc($result)) {
        
            echo "<li data-filtertext=''>";
                echo "<table style='width: 100%';>";
                    echo "<tr>";
                        echo "<td style='width: 5%;'>";
                            echo "<img src='images/sport/" . $row["SportID"] . ".png' alt='' class='ui-li-icon' style='position: relative; top: 50%; right: 50%;'/>";
                        echo "</td>";
                        echo "<td style='width: 90%';><span id='Span1'>";
                                //Team Name
                    
                                echo $row['Name'];
                                echo "<br />";
                                echo $row['City'] . ", " . $row['State'];
                                echo "<br />";
                    
                                if ($row['Park'] == "-"){
                                }
                                else {
                                    echo "Park: " . $row['Park'];
                                    echo "<br />";
                                }
                    
                                //League
                                if ($row['League'] == "-"){
                                }
                                else {
                                    echo "League: " . $row['League'];
                                }
                
                                echo "</span>";
                        echo "</td>";
                        echo "<td style='width: 5%';>";
                            echo "<a class='FollowTeam' data-teamid='" . $row['TeamID'] . "' data-teamname='" . $row['Name'] . "' data-mini='true' data-role='button' data-inline='true'>Follow</a>";
                        echo "</td>";
                    echo "</tr>";
                echo "</table>";

            echo "</li>";
    }
    
    echo "</ul>";

}

ob_end_flush();

?>