<?php

  require_once 'include/DB_Functions.php';
  $db = new DB_Functions();

if (!empty($_POST)) 
    { 
        if (empty($_POST['userID']) || empty($_POST['resID']) ) { 
          // Create some data that will be the JSON response 
    	  $response["success"] = 0; 
          $response["error"] = 1;
		  $response["message"] = "One or both of the fields are empty ."; 
           $response["message1"] = "no res ID"; 
      if(empty($_POST['isFav'])){
      $response["message12"] = $_POST['isFav'];
          
      }
		  //die is used to kill the page, will not let the code below to be executed. It will also 
		  //display the parameter, that is the json data which our android application will parse to be 
		  //shown to the users 
		  die(json_encode($response)); 
}

        $userID = $_POST['userID'];
        $resID = $_POST['resID'];
        $isFav = $_POST['isFav'];
        
        

        $result = $db->processFav($userID, $resID, $isFav);
        if ($result == "true") {
            // echo json with success = 1
            $response["success"] = 1;
            $response["result"] = $result;
            echo json_encode($response);
        } 
        
        else {
           
            $response["success"] = 0;
            $response["error"] = 1;
            $response["message"] = $userID . " " . $resID . " " . $isFav;
            $response["result"] = $result; 
            echo json_encode($response);
        }
}
?>