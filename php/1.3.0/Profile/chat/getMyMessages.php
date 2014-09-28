<?php


ob_start();
require("constants.php");
$tbl_name="myMessages"; // Table name

// Set variable
$userid = $_REQUEST['userid'];

$userid = stripslashes($userid);
$userid = mysqli_real_escape_string($userid);

/*
*
*   Get All Messages Between You and Other
*
*/

$sql="SELECT * FROM mymessagesto WHERE (ToUserID = '$userid') OR ((UserID = '$userid') AND (ToUserID >'0')) ORDER BY TimeStamp DESC";
$result=mysqli_query($sql);  
$count=mysqli_num_rows($result);

$totalNewMessage = 0;

if($count==0){
    // Do nothing
    $messageTbl = $messageTbl . "<ul data-role='listview' data-inset='true'><li data-role='list-divider'>My Messages</li><li style='font-size:8pt;'>No Messages</li></ul>";
}
else {

    $contactID = array();
    $contactIDName = array();
    $contactIDMessage = array();
    $contactIDPhoto = array();
    $contactIDTimeStamp = array();
    $contactIDNewMsg = array();
    
    $contactcount = 0; 
    
    while ($row = mysqli_fetch_assoc($result)) {
    
        if ($row['UserID'] == $userid) {
            // UserID is mine
            
            // Check to see if ToID is in Array    
            if (in_array($row['ToUserID'], $contactID)) {
                
            }
            else {
                
                $contactID[] = $row['ToUserID'];
                $contactIDName[] = $row['ToFName'] . " " . $row['ToLName'];
                
                if (strlen($row['Message'])>35) {
                    $contactIDMessage[] = substr($row['Message'], 0, 35) . "...";
                }
                else {
                    $contactIDMessage[] = $row['Message'];
                }
                
                if($row['ToImgURL'] == "" || $row['ToImgURL'] == null) {
                    $contactIDPhoto[] = "images/portraits/unknown.png";
                }
                else {
                    $contactIDPhoto[] = $row['ToImgURL'];
                }
                
                $contactIDTimeStamp[] = $row['TimeStamp'];
                $contactIDNewMsg[] = 0;

                $contactcount++;
            }
        
        }
        else {
            //ToUserID is mine
        
            // Check to see if ID is in Array    
            if (in_array($row['UserID'], $contactID)) {
                
                    // Check Table to see if message is active
                    if ($row['Active'] == "1") {
                        
                        $key = array_search($row['UserID'], $contactID);
                        
                        $cnt = $contactIDNewMsg[$key];
                        $cnt++;
                        $contactIDNewMsg[$key] = $cnt;    
                        $totalNewMessage++;
                    }
            }
            else {
                
                $contactID[] = $row['UserID'];
                $contactIDName[] = $row['FName'] . " " . $row['Lname'];
                
                if (strlen($row['Message'])>35) {
                    $contactIDMessage[] = substr($row['Message'], 0, 35) . "...";
                }
                else {
                    $contactIDMessage[] = $row['Message'];
                }
                
                if($row['ImgURL'] == "" || $row['ImgURL'] == null) {
                    $contactIDPhoto[] = "images/portraits/unknown.png";
                }
                else {
                    $contactIDPhoto[] = $row['ImgURL'];
                }
                
                $contactIDTimeStamp[] = $row['TimeStamp'];
                
                if ($row['Active'] == "1") {
                    $contactIDNewMsg[] = 1;
                    $totalNewMessage++;
                }
                
                $contactcount++;
            }
            
        }
        
    }
   
    
    /*
     *
     *   Output Data
     *
     */
    
        $messageTbl = "<ul data-role='listview' data-inset='true'><li data-role='list-divider'>My Messages</li>";
    
        
        $messageTbl = $messageTbl . "";
    
        $loop = 0;
        
        while ($loop < $contactcount) {
        
            $messageTbl = $messageTbl . "<li data-icon='false'><a class='seeOurConvo' data-newmessages='" . $contactIDNewMsg[$loop] . "' data-contactid='" . htmlspecialchars($contactID[$loop], ENT_QUOTES) . "' data-contactname='" . $contactIDName[$loop] . "' >";
                $messageTbl = $messageTbl . "<img src='http://mobile.tallyrec.com/" . $contactIDPhoto[$loop] . "' />";
                $messageTbl = $messageTbl . "<table style='width:100%;font-size:8pt;text-align:left;'><tr style='vertical-align:top;'><td style='width:75%;white-space:normal;'><span style='font-size:12pt;'>" . $contactIDName[$loop] . "</span><br/>" . $contactIDMessage[$loop] . "</td><td style='text-align:center;'>";
       
                //Time
                $Date = date_parse($contactIDTimeStamp[$loop]);
                if (date("Y-m-d") == substr($contactIDTimeStamp[$loop], 0, 10)) {
                    $messageTbl = $messageTbl . "Today";
                }
                else {
                    $messageTbl = $messageTbl . $Date['month'] . "/" . $Date['day'] . "/" . $Date['year'];
                }
                
                //New Messages
                if ($contactIDNewMsg[$loop]>0){
                    $messageTbl = $messageTbl . "<br/>" . $contactIDNewMsg[$loop] . " New</td></tr></table>";
                }
                else {
                    $messageTbl = $messageTbl . "</td></tr></table>";
                }
            
        
                $messageTbl = $messageTbl . "</a></li>";
            $loop++;
        }
        
        $messageTbl = $messageTbl . "</ul>";
    
}

$arr = array(
    'messagetbl' => $messageTbl,
    'newmessagecount' => $totalNewMessage
);

echo json_encode($arr);

ob_end_flush();

?>