<?php

 require_once(__DIR__.'/include/DB_Functions.php');
  $db = new DB_Functions();

if (!empty($_POST)) 
    { 
            if (empty($_POST['fname']) || empty($_POST['lname']) ||empty($_POST['ip_address']) || empty($_POST['imei'])  || empty($_POST['longitude']) 
                || empty($_POST['latitude']) || empty($_POST['registered_through'])  
                    || empty($_POST['registered_at']) || empty($_POST['image_url']) || 
                        empty($_POST['gcm_token']) || empty($_POST['special_id']) ) { 
		  // Create some data that will be the JSON response 
		  $response["success"] = 0; 
		  $response["message"] = "One or more fields are empty ."; 
		  //die is used to kill the page, will not let the code below to be executed. It will also 
		  //display the parameter, that is the json data which our android application will parse to be 
		  //shown to the users 
		  die(json_encode($response)); 
}

   // Request type is Register new user
        $fname = $_POST['fname'];
		$lname = $_POST['lname'];
        $email = $_POST['email'];
       	$mobile = $_POST['mobile'];
        $password = $_POST['password'];
        $ip_address = $_POST['ip_address'];
        $imei = $_POST['imei']; 
        $longitude =  $_POST['longitude']; 
        $latitude = $_POST['latitude'];
        $registered_through = $_POST['registered_through'];  
        $registered_at = $_POST['registered_at'];
        $image_url = $_POST['image_url'];
        $gcm_token =$_POST['gcm_token'];
        $special_id = $_POST['special_id'];
        $birthday = $_POST['birthday'];

        
        // check if user is already existed
        $user = $db->getUserDataSpecial($special_id);
        if ($user)
         {
             if($registered_through == "f"){
            // user is already existed - error response
            
            $response["success"] = 1;
            $response["user"]["fname"] = $user["firstname"];
            $response["user"]["lname"] = $user["lastname"];
            $response["user"]["email"] = $user["email"];
            $response["user"]["mobile"] = $user["mobile"];
            $response["user"]["mobile_verified"] = $user["mobile_verified"];
            $response["user"]["uid"] = $user["uid"];
            $response["user"]["unique_id"] = $user["unique_id"];
            $response["user"]["created_at"] = $user["created_at"];
             }
             else{
                  $response["error"] = 2;
                  $response["success"] = 0;
                  
             }
            $response["message"] = "User already existed";
            echo json_encode($response);
        } 
           

else 
{

    if ($db->isUserExisted($email))
         {
            // user is already existed - error response
            $response["success"] = 0;
            $response["error"] = 2;
            $response["error_msg"] = "Email already existed";
            echo json_encode($response);
        } 
        
        else if(!$db->validEmail($email))
           {
               $response["success"] = 0;
            $response["error"] = 3;
            $response["error_msg"] = "Invalid Email Id";
            echo json_encode($response);             

}

        else{
            // store user
            $user = $db->storeUser($fname, $lname, $email, $password, $longitude, $latitude, $ip_address, $registered_at, $imei, $registered_through, $image_url, $gcm_token, $special_id, $birthday);
            if ($user) {
                // user stored successfully
            $response["success"] = 1;
            $response["user"]["fname"] = $user["firstname"];
            $response["user"]["lname"] = $user["lastname"];
            $response["user"]["email"] = $user["email"];
	        $response["user"]["mobile"] = $user["mobile"];
            $response["user"]["uid"] = $user["uid"];
            $response["user"]["unique_id"] = $user["unique_id"];
            $response["user"]["created_at"] = $user["created_at"];
            $response["user"]["mobile_verified"] = $user["mobile_verified"];
            $response["error"] = "$fname, $lname, $email, $mobile, $password";     
                echo json_encode($response);
            } else {
                // user failed to store
                $response["success"] = 0;
                $response["error"] = 1;
                $response["error_msg"] = "JSON Error occured in Registartion";
                echo json_encode($response);
            
        }
        }
    }
     
}
else{
    $response["success"] = 0;
     $response["error"] = 2;
                $response["error_msg"] = "No post Method";
                echo json_encode($response);
}
?>