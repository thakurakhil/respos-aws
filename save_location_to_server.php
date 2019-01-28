<?php

  require_once 'include/DB_Functions.php';
  $db = new DB_Functions();

    if (!empty($_POST)) 
    { 
        echo "Posted";
        if (empty($_POST['uid']) || empty($_POST['longitude']) || empty($_POST['latitude'])) 
        { 
          
            // Create some data that will be the JSON response 
            $response["success"] = 0; 
            $response["error"] = 1;
            $response["message"] = "Fields missing"; 
            //die is used to kill the page, will not let the code below to be executed. It will also 
            //display the parameter, that is the json data which our android application will parse to be 
            //shown to the users 
            die(json_encode($response)); 
        
        }

            $uid = $_POST['uid'];
            $longitude = $_POST['longitude'];
            $latitude = $_POST['latitude'];

         if($db->updateLocation($uid, $longitude, $latitude))
         {
             
            $response["success"] = 1;
            $response["longitude"] = $longitude;
            $response["latitude"] = $latitude;
            echo json_encode($response);
          
          }
          else {
                
                $response["error"] = 2;
                $response["error_msg"] = "error in updating";
                echo json_encode($response);
            
           }




        }
        else{
            $response["success"] = 0; 
          $response["error"] = 3;
      $response["message"] = "nO POST METHOD"; 
      //die is used to kill the page, will not let the code below to be executed. It will also 
      //display the parameter, that is the json data which our android application will parse to be 
      //shown to the users 
      die(json_encode($response)); 
        }

?>