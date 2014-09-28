<?php

ob_start();

require("constants.php");
$tbl_name="myteams"; // Table name 

// Load  Variables
$userid = $_REQUEST['userid'];

$sql="SELECT teamid FROM $tbl_name WHERE (UserID = '$userid') AND (Archived != '1') AND (manager != '2')";
$result = mysqli_query($sql);    
$count=mysqli_num_rows($result);

if($count==0){
    //No Teams
    
    $contacts = $contacts . "<form><table style='width:95%;margin:auto;'>";
    $contacts = $contacts . "<tr><td style='width:50%;font-size:12pt;'><select id='sendto'>";
    $contacts = $contacts . "<option value='noteammates'>No Teammates Available</option>";
    $contacts = $contacts . "</table></form>";
    
}
else {

    /*
    *
    *   Get My Teams
    *
    */
    
    $teamid = array();
    $totalteams = 0;

    while ($row = mysqli_fetch_assoc($result)) {
    
        $teamid[] = $row['teamid'];
    
        $totalteams++;    
    }
    
    /*
     *
     *   Get My Team's Roster
     *
     */
     
     
     $loop = 0;
     $contactID = array();
     $contactName = array();
     $contactImg = array();
     
     $totalcount = 0;
     
     while ($loop < $totalteams) {
     
         $sql="SELECT * FROM userroster WHERE (teamid = '$teamid[$loop]') AND (UserID > '0') AND (Inactive != '1') AND (UserID != '$userid') AND (manager != '2')";
         $result = mysqli_query($sql);
     
         
         while ($row = mysqli_fetch_assoc($result)) {
         
             if (in_array($row['UserID'], $contactID)) {
                // Do Nothing
             }
             else {
                $contactID[] = $row['UserID'];
                $contactName[] = $row['fname'] . " " . $row['lname'];
                $contactImg[] = $row['imgurl'];
                
                $totalcount++;
             }
             
         }
         
     $loop++;
    }
    
    /*
     *
     *   Display Results
     *
     */
     
     if ($totalcount == 0) {
         $contacts = $contacts . "<form><table style='width:95%;margin:auto;'>";
         $contacts = $contacts . "<tr><td style='width:50%;font-size:12pt;'><select id='sendto'>";
         $contacts = $contacts . "<option value='noteammates'>No Teammates Available</option>";
         $contacts = $contacts . "</table></form>";
     } 
     else {
     
         $contacts = "";
     
         $contacts = $contacts . "<form>";
     
         $loop = 0;
     
            
            $contacts = $contacts . "<table style='width:95%;margin:auto;'>";
            $contacts = $contacts . "<tr>";
                    $contacts = $contacts . "<td style='width:50%;font-size:12pt;'><select id='sendto'>";
                    while ($loop < $totalcount) {
                        $contacts = $contacts . "<option value='" . $contactID[$loop] . "'>" . $contactName[$loop] . "</option>";
                    $loop++;
                    }
            $contacts = $contacts . "</td></tr></table>";
     
         $contacts = $contacts . "</form>";
     }

}

//Create Array
$arr = array(
    'myContacts' => $contacts
);

echo json_encode($arr);

ob_end_flush();

?>