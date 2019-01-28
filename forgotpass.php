<?php

  require_once 'include/DB_Functions.php';
  $db = new DB_Functions();

if (!empty($_POST)) 
    { 
        if (empty($_POST['email'])) { 
		  // Create some data that will be the JSON response 
		  $response["success"] = 0; 
		  $response["message"] = "One or more fields are empty ."; 
		  //die is used to kill the page, will not let the code below to be executed. It will also 
		  //display the parameter, that is the json data which our android application will parse to be 
		  //shown to the users 
		  die(json_encode($response)); 
}

   $email= $_POST['email'];

$randomcode = $db->random_string();
  

$hash = $db->hashSSHA($randomcode);
        $encrypted_password = $hash["encrypted"]; // encrypted password
        $salt = $hash["salt"];
  $subject = "Password Recovery";
         $message = "Hello User,\n\nYour Password is sucessfully changed. Your new Password is $randomcode . Login with your new Password and change it in the User Panel.\n\nRegards,\nFroogal.";
          $from = "contact@froogal.com";
          $headers = "From:" . $from;
	if ($db->isUserExistedEmail($email)) {

 $user = $db->forgotPassword($email, $encrypted_password, $salt);
if ($user) {
         $response["success"] = 1;
         $response["error"] = "noErrors";
         
         $mail = mail($email,$subject,$message,$headers);
    if($mail){
        $response["error"] = "Thank you for using our mail form, $message";
    }

else{
  $response["error"] = "Mail sending failed. $forgotpassword ,$subject,$message,$headers"; 
}
         echo json_encode($response);
}
else {
$response["error"] = 1;
echo json_encode($response);
}


            // user is already existed - error response
           
           
        } 
           else {

            $response["error"] = 2;
            $response["error_msg"] = "User not exist";
             echo json_encode($response);

}
}
?>