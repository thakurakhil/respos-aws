<?php
error_reporting(E_ALL);
 ini_set('display_errors', 1);
  require_once 'include/DB_Functions.php';
  $db = new DB_Functions();
/*
if (!empty($_GET)) 
    { 
        if (empty($_GET['resid'])) { 
          // Create some data that will be the JSON response 
      $response["success"] = 0; 
          $response["error"] = 1;
      $response["message"] = "no res ID"; 
      //die is used to kill the page, will not let the code below to be executed. It will also 
      //display the parameter, that is the json data which our android application will parse to be 
      //shown to the users 
      die(json_encode($response)); 
}

        $resid = $_GET['resid'];

*/
$resid = 1;
if ($db->isResPresent($resid))
         {
            $menu = $db->getMenu($resid);
            if ($menu) {
                // user stored successfully
            $response["success"] = 1;
            $response["menu"] = $menu;
            echo json_encode($response);
            } 


            else {
                // user failed to store
                $response["error"] = 1;
                $response["error_msg"] = "JSON Error occured";
                echo json_encode($response);
            
        }




        }         
else{
            $response["error"] = 2;
            $response["error_msg"] = "No restaurant";
            echo json_encode($response);
  

}



?>
