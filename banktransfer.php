<?php

  require_once 'include/DB_Functions.php';
  $db = new DB_Functions();

if (!empty($_POST)) 
    { 
        if (empty($_POST['userID']) || empty($_POST['account_name']) || 
                empty($_POST['bank_name'])  || empty($_POST['account_number'])
                    empty($_POST['confirm_account_number'])  || empty($_POST['ifsc_code'])
                        empty($_POST['amount_required'])  || empty($_POST['phone_number'])) { 
          // Create some data that will be the JSON response 
          $response["success"] = 0; 
          $response["error"] = 1;
		  $response["message"] = "One or both of the fields are empty ."; 
           $response["message1"] = "no res ID"; 
      if(empty($_GET['userID'])){
      $response["message1"] = "no user ID"; 
          
      }
		  //die is used to kill the page, will not let the code below to be executed. It will also 
		  //display the parameter, that is the json data which our android application will parse to be 
		  //shown to the users 
		  die(json_encode($response)); 
}

    $userID =  $_POST['userID'];
    $account_name =  $_POST['account_name'];
    $bank_name =  $_POST['bank_name'];
    $account_number =  $_POST['account_number'];
    $confirm_account_number =  $_POST['confirm_account_number'];
    $ifsc_code  =  $_POST['ifsc_code'];
    $amount_required=  $_POST['amount_required'];
    $phone_number = $_POST['phone_number'] ;
        
                

        $result = $db->bank_function($userID, $account_name,$bank_name,$account_number,$confirm_account_number,$ifsc_code,$amount_required,$phone_number);
        if ($result != false) {
            // recharge attempted
            
            
                $response["success"] = 1;
                $response["result"] = $result;
           
              
          
            echo json_encode($response);
        } 
        
        else {
           
            $response["success"] = 0;
            $response["error"] = 1;
            $response["message"] = "Error";
            $response["result"] = $result;
            echo json_encode($response);
        }
}
?>