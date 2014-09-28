<?php

ob_start();

$host="192.168.2.7"; // Host name 
$username="TallyRecWebUser"; // mysqli username 
$password="webt00l"; // mysqli password 
$db_name="tallyrec"; // Database name 
$tbl_name="myteams"; // Table name 

// Connect to server and select databse.
mysqli_connect("$host", "$username", "$password")or die("cannot connect"); 
mysqli_select_db("$db_name")or die("cannot select DB");

// Load  Variables
$username = $_REQUEST['username'];

$sql="SELECT * FROM $tbl_name WHERE (Username = '$username') AND (Archived != '1') AND (manager = '3')";
$result = mysqli_query($sql);    
// mysqli_num_row is counting table row
$count=mysqli_num_rows($result);

$counter = "";
// Get SQL Results
if($count==0){
    echo "<ul data-role='listview' data-inset='true'>";
        echo "<li data-role='list-divider'>Prospect Requests:</li>";
        echo "<li>";
            echo "<div data-role='collapsible' data-iconpos='right' data-mini='true'>";
                echo "<h3>No Teams</h3>";
            echo "</div>";
        echo "</li>";
    echo "</ul>";
}
else {
   
    echo "<ul data-role='listview' data-inset='true'>";
    echo "<li data-role='list-divider'>Prospect Requests:</li>";
    
    while ($row = mysqli_fetch_assoc($result)) {
        $counter++;
    
        echo "<li>";
            echo "<div data-role='collapsible' data-iconpos='right' data-mini='true'>";
                echo "<h3>";
                    // Team Name
                    echo $row["name"];
                echo "</h3>";
                echo "<p data-role='controlgroup' data-type='horizontal'>";
                echo "<a data-role='button' data-mini='true' data-rosterid=" . $row["RosterID"] . " class='AcceptPending'>Accept</a>";
                echo "<a data-role='button' data-mini='true' data-rosterid=" . $row["RosterID"] . " class='DenyPending'>Deny</a>";
                echo "</p>";
            echo "</div>";
        echo "</li>";
    }
    echo "</ul>";
}

ob_end_flush();

?>