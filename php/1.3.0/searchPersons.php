<?php

ob_start();

$host="192.168.2.7"; // Host name 
$username="TallyRecWebUser"; // mysqli username 
$password="webt00l"; // mysqli password 
$db_name="tallyrec"; // Database name 
$tbl_name="searchperson"; // Table name 

// Connect to server and select databse.
mysqli_connect("$host", "$username", "$password")or die("cannot connect"); 
mysqli_select_db("$db_name")or die("cannot select DB");

// Load  Variables
$searchinfo = $_REQUEST['searchinfo'];

// To protect mysqli injection (more detail about mysqli injection)
$searchinfo = stripslashes($searchinfo);
$searchinfo = mysqli_real_escape_string($searchinfo);


$sql="SELECT * FROM $tbl_name WHERE (FName LIKE '%$searchinfo%') OR (LName LIKE '%$searchinfo%') OR (Phone LIKE '%$searchinfo%') OR (Username LIKE '%$searchinfo%') ORDER BY Username ASC";
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

    echo "<ul data-role='listview' style='font-size: 8pt;' data-inset='true' data-filter='true' data-mini='true' id='searchteams'>";

    // Get SQL Results
    while ($row = mysqli_fetch_assoc($result)) {
        
        echo "<li data-filtertext=''>";
        echo "<div class='ui-grid-a'>";
        echo "<div class='ui-block-a' style='font-size:10pt; padding-top: 1%; text-align: left;'><span id='Span1'>";
        //Team Name
        echo $row['LName'] . ", " . $row['FName'];
        echo "<br />Username: ";
        echo $row['Username'];
        echo "</span></div>";
        echo "<div class='ui-block-b' style='text-align: right;'><a class='AddtoTeam' data-userid='" . $row['UserID'] . "' data-mini='true' data-role='button' data-inline='true'>Add</a></div>";
        echo "</div>";
        echo "</li>";
    }
    
    echo "</ul>";

}

ob_end_flush();

?>