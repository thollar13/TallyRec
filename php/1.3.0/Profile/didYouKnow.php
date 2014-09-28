<?php

  ob_start();

  require("constants.php"); 
  $tbl_name="user"; // Table name 

  // Define $myusername and $mypassword from form
  $userid = $_REQUEST['userid'];

  // To protect mysqli injection (more detail about mysqli injection)
  $userid = stripslashes($userid);
  $userid = mysqli_real_escape_string($userid);

  // mysqli Update Password
  $sql="SELECT AppVersion, TokenDevice FROM $tbl_name WHERE (UserID='$userid')";
  $result=mysqli_query($sql);
  $row = mysqli_fetch_assoc($result);
  
  $appversion = $row["AppVersion"];
  $devicetype = $row["TokenDevice"];

  $currentversion = "1.2.4";
  
  if ($appversion == $currentversion) {
  
      // mysqli Update Password
      $sql="SELECT * FROM facts WHERE (Date = Date(now()))";
      $result=mysqli_query($sql);
      $row = mysqli_fetch_assoc($result);
      
      if ($row["Fact"] == "" || $row["Fact"] == null) {
        echo "";
      }
      else {
        echo $row["Fact"];
      }

  }
  else {
    if ($devicetype == "ios") {
        echo "There's a new version of TallyRec available. Click <a href='itms-apps://itunes.com/apps/tallyrec'>HERE</a> to update!";
    }
    else if ($devicetype == "android") {
             echo "There's a new version of TallyRec available. Click <a href='market://details?id=com.tallyrec.android'>HERE</a> to update!";
    }
  }
  
  ob_end_flush();

?>