<?php

  require_once 'include/DB_Functions.php';
  $db = new DB_Functions();

if (!empty($_GET)) 
    { 
        if (empty($_GET['longitude']) || empty($_GET['latitude']) || empty($_GET['userID'])) { 
          // Create some data that will be the JSON response 
      $response["success"] = 0; 
          $response["error"] = 1;
      $response["message"] = "Fields missing"; 
      //die is used to kill the page, will not let the code below to be executed. It will also 
      //display the parameter, that is the json data which our android application will parse to be 
      //shown to the users 
      die(json_encode($response)); 
        }

        $longitude = $_GET['longitude'];
        $latitude = $_GET['latitude'];
        $userID = $_GET['userID'];
        $restaurants = $db->getPopRestaurants($latitude, $longitude, $userID);
          if($restaurants){
            $response["success"] = 1;
            $response["longitude"] = $longitude;
            $response["latitude"] = $latitude;
            $response["restaurants"] = $restaurants;
            echo json_encode($response);
            

          }


            else {
                
           
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