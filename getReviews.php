<?php

  require_once 'include/DB_Functions.php';
  $db = new DB_Functions();

if (!empty($_GET)) 
    { 
        if (empty($_GET['resID']) || empty($_GET['userID'])) { 
          // Create some data that will be the JSON response 
      $response["success"] = 0; 
          $response["error"] = 1;
      $response["message"] = "Fields missing"; 
      //die is used to kill the page, will not let the code below to be executed. It will also 
      //display the parameter, that is the json data which our android application will parse to be 
      //shown to the users 
      die(json_encode($response)); 
        }

        $resID = $_GET['resID'];
        $userID = $_GET['userID'];
        $reviews = $db->getReviews($resID, $userID);
          if($reviews){
            $response["success"] = 1;
            $response["reviews"] = $reviews;
                echo json_encode($response);
            

          }


            else {
            $response["success"] = 1;
            $response["reviews"] = $reviews;
            $response["error"] = 1;
            $response["error_msg"] = "error in getting";
            echo json_encode($response);
            
        }




        }

else {
                $response["error"] = 2;
                $response["error_msg"] = "error in get method";
                echo json_encode($response);
            
        }



?>