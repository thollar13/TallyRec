<?php

ob_start();

require("constants.php");
$tbl_name="searchteams"; // Table name 

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

    echo "<ul data-role='listview' style='font-size: 8pt;' data-inset='true' data-filter='true' data-mini='true' id='searchteams'>";
        echo "<li data-filtertext=''>";
            echo "<div class='ui-grid-a'>";
	            echo "<div class='ui-block-a' style='font-size:10pt; padding-top: 1%; text-align: left;'><span id='Span1'>No Results Matched</span></div>";
	            echo "<div class='ui-block-b' style='text-align: right;'><a data-mini='true' data-role='button' data-inline='true'></a></div>";
            echo "</div>";
        echo "</li>";
    echo "</ul>";
    
}

else {
    echo "<br />";
    echo "<ul data-role='listview' style='font-size: 8pt;' data-inset='true' data-inline='true' data-filter='true' data-mini='true' id='searchteams'>";

    // Get SQL Results
    while ($row = mysqli_fetch_assoc($result)) {
        
            echo "<li data-filtertext=''>";
                echo "<div class='ui-grid-a'>";
                echo "<div class='ui-block-a' style='font-size:8pt; padding-top: 1%; text-align: left;'><span id='Span1'>";
                    //Team Name
                    echo $row['Name'];
                    echo "<br />";
                    echo $row['City'] . ", " . $row['State'];
                echo "</span></div>";
                echo "<div class='ui-block-b' style='text-align: right;'><a class='FollowTeam' data-teamid='" . $row['TeamID'] . "' data-mini='true' data-role='button' data-inline='true'>Follow</a></div>";
                echo "</div>";
            echo "</li>";
    }
    
    echo "</ul>";

}

ob_end_flush();

?>