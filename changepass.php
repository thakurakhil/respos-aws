<?php

  require_once 'include/DB_Functions.php';
  $db = new DB_Functions();

if (!empty($_POST)) 
    { 
    	if (empty($_POST['userID']) || empty($_POST['newpass'])  || empty($_POST['oldpass'])) { 
		  // Create some data that will be the JSON response 
		  $response["success"] = 0; 
		  $response["message"] = "One or more fields are empty ."; 
		  //die is used to kill the page, will not let the code below to be executed. It will also 
		  //display the parameter, that is the json data which our android application will parse to be 
		  //shown to the users 
		  die(json_encode($response)); 
}


  $userID = $_POST['userID'];
  $newpass = $_POST['newpass'];
  $oldpass = $_POST['oldpass'];

    if($db->getUserByIDAndPassword($userID, $oldpass)){
                $hash = $db->hashSSHA($newpass);
                $encrypted_password = $hash["encrypted"]; // encrypted password
                $salt = $hash["salt"];
                $subject = "Change Password Notification";
                $message = "Hello User,\n\nYour Password is sucessfully changed.\n\nRegards,\nFroogal.";
                $from = "contact@froogal.com";
                $headers = "From:" . $from;
                $user = $db->forgotPassword($email, $encrypted_password, $salt);
                if ($user) {
                     $response["success"] = 1;
                     $response["message"] = $message;
                     mail($email,$subject,$message,$headers);
                     echo json_encode($response);
                }
                else {
                $response["success"] = 0;
                $response["error"] = 1;
                echo json_encode($response);
                }

    }

  

            // user is already existed - error response 
           else {
            $response["success"] = 0;
            $response["error"] = 2;
            $response["error_msg"] = "User not exist";
             echo json_encode($response);

}
}


else{
            $response["success"] = 0;
            $response["error"] = 3;
            $response["error_msg"] = "Error in post";
             echo json_encode($response);
}
?>