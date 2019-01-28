<?php

  require_once 'include/DB_Functions.php';
  $db = new DB_Functions();

if (!empty($_POST)) 
    { 
        if (empty($_POST['userID']) || empty($_POST['resID'])) { 
    	  // Create some data that will be the JSON response 
		  $response["success"] = 0; 
          $response["error"] = 1;
		  $response["message"] = "One or both of the fields are empty ."; 
		  //die is used to kill the page, will not let the code below to be executed. It will also 
		  //display the parameter, that is the json data which our android application will parse to be 
		  //shown to the users 
		  die(json_encode($response)); 
}

        $userID = $_POST['userID'];
        $resID = $_POST['resID'];
        $rating = $_POST['rating'];
        $title = $_POST['title'];
        $description = $_POST['description'];
        
        

        $result = $db->addReview($userID, $resID, $rating, $title, $description);
        if ($result != false) {
            // echo json with success = 1
            $response["success"] = 1;
            $response["result"] = $result;
            
            $res = $db->updateRating($resID);
            if($res != false){
                $response["updateReview"] = 1;
            }
            else{
                $response["updateReview"] = 0;
            }
            echo json_encode($response);
        } 
        
        else {
            // user not found
            // echo json with error = 1
            $response["success"] = 0;
            $response["error"] = 1;
            $response["message"] = "Incorrect email or password! +  $email + $password ";
            echo json_encode($response);
        }
}
?>