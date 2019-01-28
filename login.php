<?php
//var_dump($_POST);

require_once(__DIR__.'/include/DB_Functions.php');
  $db = new DB_Functions();

if (!empty($_POST)) 
    { 
$response["values22"] = $_POST['email'];
                $response["values221"] = $_POST['password'];

        if (empty($_POST['email']) || empty($_POST['password'])) { 
		  // Create some data that will be the JSON response 
		  $response["success"] = 0; 
          $response["error"] = 1;
		  $response["message"] = "One or both of the fields are empty ."; 
		  //die is used to kill the page, will not let the code below to be executed. It will also 
		  //display the parameter, that is the json data which our android application will parse to be 
		  //shown to the users 
		  die(json_encode($response)); 
}
}

  // Request type is check Login
        $email = $_POST['email'];
        $password = $_POST['password'];

        // check for user
        $user = $db->getUserByEmailAndPassword($email, $password);
        if ($user != false) {
            // user found
            // echo json with success = 1
            $response["success"] = 1;
            $response["user"]["uid"] = $user["uid"];
            $response["user"]["fname"] = $user["firstname"];
            $response["user"]["lname"] = $user["lastname"];
            $response["user"]["email"] = $user["email"];
	        $response["user"]["mobile"] = $user["mobile"];
            $response["user"]["mobile_verified"] = $user["mobile_verified"];
            $response["user"]["unique_id"] = $user["unique_id"];
            $response["user"]["created_at"] = $user["created_at"];
            
            echo json_encode($response);
        } else {
            // user not found
            // echo json with error = 1
            $response["success"] = 0;
            $response["values"] = $email;
		$response["values1"] = $password;
		$response["error"] = 1;
            $response["message"] = "Incorrect email or password!";
            
echo json_encode($response);
        }

?>
