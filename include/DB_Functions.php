<?php

class DB_Functions {

    private $db;
    
    //put your code here
    // constructor
    function __construct() {
       require_once(__DIR__.'/DB_Connect.php');
 
        // connecting to database
        $this->db = new DB_Connect();
       $this->db->connect();
	
    }

    // destructor
    function __destruct() {
        
    }


    /**
     * Random string which is sent by mail to reset password
     */


public function random_string()
{
    $character_set_array = array();
    $character_set_array[] = array('count' => 7, 'characters' => 'abcdefghijklmnopqrstuvwxyz');
    $character_set_array[] = array('count' => 1, 'characters' => '0123456789');
    $temp_array = array();
    foreach ($character_set_array as $character_set) {
        for ($i = 0; $i < $character_set['count']; $i++) {
            $temp_array[] = $character_set['characters'][rand(0, strlen($character_set['characters']) - 1)];
        }
    }
    shuffle($temp_array);
    return implode('', $temp_array);
}


public function forgotPassword($email, $newpassword, $salt){
    $val = "e";
    $result = mysql_query("UPDATE `users` SET `encrypted_password` = '$newpassword',`salt` = '$salt' 
                          WHERE `email` = '$email' AND registered_through='$val'");

if ($result) {
 
return true;

}
else
{
return false;
}

}
/**
     * Adding new user to mysql database
     * returns user details
     */

   
 public function storeUser($fname, $lname, $email, $password, $longitude, $latitude, $ip_address, $registered_at, $imei, $registered_through, $image_url, $gcm_token, $special_id, $birthday) {
        $uuid = uniqid('', true);
        $hash = $this->hashSSHA($password);
        $encrypted_password = $hash["encrypted"]; // encrypted password
        $salt = $hash["salt"]; // salt
        $result = mysql_query("INSERT INTO users(unique_id, firstname, lastname, email, encrypted_password, salt, created_at, longitude, 
        latitude, ip_address, registered_at, imei, registered_through, image_url, gcm_token, special_id, birthday) 
        VALUES('$uuid', '$fname', '$lname', '$email', '$encrypted_password', '$salt', NOW(), 
        '$longitude', '$latitude', '$ip_address', '$registered_at', '$imei', '$registered_through', 
        '$image_url', '$gcm_token', '$special_id', '$birthday')");
        // check for successful store
        if ($result) {
            // get user details 
            $uid = mysql_insert_id(); // last inserted id
            $result = mysql_query("SELECT * FROM users WHERE uid = $uid");
            // return user details
            return mysql_fetch_array($result);
        } else {
            return false;
        }
    }


    /**
     * Verifies user by email and password
     */
    public function getUserByEmailAndPassword($email, $password) {
        $result = mysql_query("SELECT * FROM users WHERE email = '$email'") or die(mysql_error());
        // check for result 
        $no_of_rows = mysql_num_rows($result);
        if ($no_of_rows > 0) {
            $result = mysql_fetch_array($result);
            $salt = $result['salt'];
            $encrypted_password = $result['encrypted_password'];
            $hash = $this->checkhashSSHA($salt, $password);
            // check for password equality
            if ($encrypted_password == $hash) {
                // user authentication details are correct
                return $result;
            }
        } else {
            // user not found
            return false;
        }
    }
    
     public function getUserByIDAndPassword($userID, $password) {
        $result = mysql_query("SELECT * FROM users WHERE uid = '$userID'") or die(mysql_error());
        // check for result 
        $no_of_rows = mysql_num_rows($result);
        if ($no_of_rows > 0) {
            $result = mysql_fetch_array($result);
            $salt = $result['salt'];
            $encrypted_password = $result['encrypted_password'];
            $hash = $this->checkhashSSHA($salt, $password);
            // check for password equality
            if ($encrypted_password == $hash) {
                if($result['registered_through'] == "e"){
                // user authentication details are correct
                return $result;
                }
                else{
                    return false;
                }
            }
        } else {
            // user not found
            return false;
        }
    }
    
    public function getUserData($email){
        $result = mysql_query("SELECT * FROM users WHERE email = '$email'") or die(mysql_error());
        // check for result 
        $no_of_rows = mysql_num_rows($result);
        if ($no_of_rows > 0) {
            $result = mysql_fetch_array($result);
                // user authentication details are correct
                return $result;
        } else {
            // user not found
            return false;
        }
    }

    public function getUserDataSpecial($special_id){
        $result = mysql_query("SELECT * FROM users WHERE special_id = '$special_id'") or die(mysql_error());
        // check for result 
        $no_of_rows = mysql_num_rows($result);
        if ($no_of_rows > 0) {
            $result = mysql_fetch_array($result);
                // user authentication details are correct
                return $result;
        } else {
            // user not found
            return false;
        }
    }
 /**
     * Checks whether the email is valid or fake
     */
public function validEmail($email)
{
   $isValid = true;
   $atIndex = strrpos($email, "@");
   if (is_bool($atIndex) && !$atIndex)
   {
      $isValid = false;
   }
   else
   {
      $domain = substr($email, $atIndex+1);
      $local = substr($email, 0, $atIndex);
      $localLen = strlen($local);
      $domainLen = strlen($domain);
      if ($localLen < 1 || $localLen > 64)
      {
         // local part length exceeded
         $isValid = false;
      }
      else if ($domainLen < 1 || $domainLen > 255)
      {
         // domain part length exceeded
         $isValid = false;
      }
      else if ($local[0] == '.' || $local[$localLen-1] == '.')
      {
         // local part starts or ends with '.'
         $isValid = false;
      }
      else if (preg_match('/\\.\\./', $local))
      {
         // local part has two consecutive dots
         $isValid = false;
      }
      else if (!preg_match('/^[A-Za-z0-9\\-\\.]+$/', $domain))
      {
         // character not valid in domain part
         $isValid = false;
      }
      else if (preg_match('/\\.\\./', $domain))
      {
         // domain part has two consecutive dots
         $isValid = false;
      }
      else if
(!preg_match('/^(\\\\.|[A-Za-z0-9!#%&`_=\\/$\'*+?^{}|~.-])+$/',
                 str_replace("\\\\","",$local)))
      {
         // character not valid in local part unless 
         // local part is quoted
         if (!preg_match('/^"(\\\\"|[^"])+"$/',
             str_replace("\\\\","",$local)))
         {
            $isValid = false;
         }
      }
      if ($isValid && !(checkdnsrr($domain,"MX") || 
 checkdnsrr($domain,"A")))
      {
         // domain not found in DNS
         $isValid = false;
      }
   }
   return $isValid;
}
 
 /**
     * Check user is existed or not
     */
    public function isUserExisted($email) {
        $result = mysql_query("SELECT email from users WHERE email = '$email'");
        $no_of_rows = mysql_num_rows($result);
        if ($no_of_rows > 0) {
            // user existed 
            return true;
        } else {
            // user not existed
            return false;
        }
    }
    
    public function isUserExistedEmail($email) {
        $val = "e";
        $result = mysql_query("SELECT email from users WHERE email = '$email' AND registered_through='$val'");
        $no_of_rows = mysql_num_rows($result);
        if ($no_of_rows > 0) {
            // user existed 
            return true;
        } else {
            // user not existed
            return false;
        }
    }
    
   
    

    

    public function mobileExists($mobile){
        $result = mysql_query("SELECT mobile from users WHERE mobile = '$mobile'");
        $no_of_rows = mysql_num_rows($result);
        if ($no_of_rows > 0) {
            // user existed 
            return true;
        } else {
            // user not existed
            return false;
        }
    }
    /**
     * Encrypting password
     * returns salt and encrypted password
     */
    public function hashSSHA($password) {

        $salt = sha1(rand());
        $salt = substr($salt, 0, 10);
        $encrypted = base64_encode(sha1($password . $salt, true) . $salt);
        $hash = array("salt" => $salt, "encrypted" => $encrypted);
        return $hash;
    }

    /**
     * Decrypting password
     * returns hash string
     */
    public function checkhashSSHA($salt, $password) {

        $hash = base64_encode(sha1($password . $salt, true) . $salt);

        return $hash;
    }





    public function isUserUIDExisted($uid) {
        $result = mysql_query("SELECT uid from users WHERE uid = '$uid'");
        $no_of_rows = mysql_num_rows($result);
        if ($no_of_rows > 0) {
            // user existed 
            return true;
        } else {
            // user not existed
            return false;
        }
    }
    
    public function updateLocation($uid, $longitude, $latitude){
      if($this->isUserUIDExisted($uid)){
        $result = mysql_query("UPDATE `users` 
          SET `longitude` = '$longitude', `latitude` = '$latitude' 
          WHERE uid = '$uid'");
          if($result)
            return true;
          else
            return false;
      }
      return false;

    }
    
    public function isResPresent($resID){
      $result = mysql_query("SELECT restaurant_id from restaurants WHERE restaurant_id = '$resID'");
        $no_of_rows = mysql_num_rows($result);
	//return true;
        if ($no_of_rows > 0) {
            return true;
        } else {
            return false;
        }
    }


    public function getMenu($resID){

      $result = mysql_query("SELECT category_id, name, status FROM `category` WHERE `restaurant_id` = '$resID'");
      $i = 0;
      while ($row = mysql_fetch_array($result)) {
          $menu["'$i'"] = $row;
          $categoryID = $row["category_id"];
          $result1 = mysql_query("SELECT `product_id`, `name`, `description`, `image_url`, `size`, `price`, `rating`  FROM `products` WHERE `category_id` = '$categoryID'");
          $j = 0;
            while($row1 = mysql_fetch_array($result1)){
              $menu["'$i'"]["items"]["'$j'"] = $row1;
                  $j = $j + 1;
            }     
        $i = $i + 1;
}
          
       return $menu;
        
    }
    
   

    public function distance($lat1, $lon1, $lat2, $lon2) {
    
      $theta = $lon1 - $lon2;
      $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
      $dist = acos($dist);
      $dist = rad2deg($dist);
      $miles = $dist * 60 * 1.1515;
      
    
    return ($miles * 1.609344);
      
    }




    public function getRestaurants($latitude, $longitude, $userID){
        $result = mysql_query("SELECT * FROM `restaurants`");
         $i = 0;
         $no_of_rows = mysql_num_rows($result);
        if ($no_of_rows > 0) {
        while ($row = mysql_fetch_array($result)) {
            if($this->distance($latitude, $longitude, $row[latitude], $row[longitude]) <= 5){
                $restaurants["'$i'"] = $row;
                $resID = $row["restaurant_id"];
                $result1 = mysql_query("SELECT * FROM `favourites` WHERE `user_id` = '$userID' 
                                                AND `restaurant_id`='$resID'");
                $no_of_rows1 = mysql_num_rows($result1);
                if ($no_of_rows1 > 0) {
                $restaurants["'$i'"]["isFav"] = "1";
                
                }
                else{
                    $restaurants["'$i'"]["isFav"] = "0";
                }
                $i = $i + 1;
          }
        }
        
        }
       return $restaurants;
    }
    
    public function getFavRestaurants($userID){
        $result = mysql_query("SELECT * FROM `favourites` WHERE `user_id` = '$userID'");
        $i = 0;
        $no_of_rows = mysql_num_rows($result);
        if ($no_of_rows > 0) {
        while ($row = mysql_fetch_array($result)) {
            $resid = $row["restaurant_id"];
                $result1 = mysql_query("SELECT * FROM `restaurants` WHERE `restaurant_id`='$resid'");
                
                while ($row1 = mysql_fetch_array($result1)) {
                        $restaurants["'$i'"] = $row1;
                        $restaurants["'$i'"]["isFav"] = "1";
                        $i = $i + 1;
                  
                }
        }
        }
        return $restaurants;
    }
    
   public function getPopRestaurants($latitude, $longitude, $userID){
        $result = mysql_query("SELECT * FROM `restaurants` ORDER BY rating DESC");
        $i = 0;
        $no_of_rows = mysql_num_rows($result);
        if ($no_of_rows > 0) {
        while ($row = mysql_fetch_array($result)) {
            if($this->distance($latitude, $longitude, $row[latitude], $row[longitude]) <= 10){
                    $restaurants["'$i'"] = $row;
                    $resID = $row["restaurant_id"];
                    $result1 = mysql_query("SELECT * FROM `favourites` WHERE `user_id` = '$userID' 
                                                AND `restaurant_id`='$resID'");
                    $no_of_rows1 = mysql_num_rows($result1);
                    if ($no_of_rows1 > 0) {
                        $restaurants["'$i'"]["isFav"] = "1";
                    }
                    else{
                        $restaurants["'$i'"]["isFav"] = "0";
                    }
                    $i = $i + 1;
                    if($i == 11){
                        break;
                    }
          }
        }
        }
        return $restaurants;
    }
    
    
    
    public function getReviews($resID, $userID){
        
        $result = mysql_query("SELECT reviews.review_id, reviews.title, reviews.description, reviews.rating, reviews.likes, reviews.dislikes, date(reviews.date), reviews.date,  users.firstname, users.image_url, users.uid
                                FROM reviews INNER JOIN users
                                ON reviews.user_id = users.uid
                                WHERE reviews.restaurant_id = '$resID'");
         $i = 0;
        $reviews["isReviewPresent"] = "0";
        $no_of_rows = mysql_num_rows($result);
        if ($no_of_rows > 0) {
        while ($row = mysql_fetch_array($result)) {
          $reviews["'$i'"] = $row;
          if($row["uid"] == $userID){
            $reviews["isReviewPresent"] = "1";
              
          }
          $i = $i + 1;
}
          
        return $reviews;
        }
        else{
            return false;
        }
    }
    
    public function addReview($userID, $resID, $rating, $title, $description){
        
        
        $result = mysql_query("INSERT INTO reviews(`user_id`, `restaurant_id`,  `rating`, `title`, `description`, `date`) 
        VALUES('$userID', '$resID', '$rating', '$title', '$description', NOW())");
        // check for successful store
        if($result == false){
            return false;
        }
        else {
            
            
           return $result;
        } 
    }
    
    public function updateRating($resID){
        $result = mysql_query("SELECT * FROM reviews WHERE `restaurant_id`='$resID'");
         $no_of_rows = mysql_num_rows($result);
         $i = 0;
         $sum = 0;
        if ($no_of_rows > 0) {
        while ($row = mysql_fetch_array($result)) {
                $sum = $sum + $row['rating'];
                $i = $i + 1;
                
        }
        $rating = $sum/$i;
        $result1 = mysql_query("UPDATE `restaurants` 
          SET `rating` = '$rating' WHERE `restaurant_id` = '$resID'");
        if($result1 == false){
            return false;
        }
        else {
           return $result1;
        } 
        }
        return false;
        
    }
    
    public function updateReview($userID, $resID, $rating, $title, $description){
        
        $result = mysql_query("UPDATE `reviews` 
          SET `rating` = '$rating', `title` = '$title', `description` = '$description' ,`date` = NOW() 
          WHERE `user_id` = '$userID' AND `restaurant_id` = '$resID'");
        // check for successful store
        if($result == false){
            return false;
        }
        else {
           return $result;
        } 
    }
    
    public function isOrderExisted($userID, $resID){
        $result = mysql_query("SELECT order_id from orders WHERE user_id = '$userID' AND restaurant_id = '$resID' AND status = 'notclosed'");
        $no_of_rows = mysql_num_rows($result);
        if ($no_of_rows > 0) {
           while ($row = mysql_fetch_array($result)) {
                return $row["order_id"];
           }
        }
        return false;
        
    }
    
    public function processOrder($userID, $resID, $products){
        $res = $this->isOrderExisted($userID, $resID);
        if($res == false){
          $result = mysql_query("INSERT INTO orders(user_id, restaurant_id, status) 
                                    VALUES('$userID', '$resID', '2')");
         if ($result) {
            $res = $this->isOrderExisted($userID, $resID);
            if($res == false){
                return false;
            }
            
             
        } 
       
        }
        
        for ($i = 0; $i < count($products); $i++) {
            $vars = $products[$i];
            $id = $vars["product_id"];
            $quantity = $vars["quantity"];
            $result1 = mysql_query("INSERT INTO `orderItems`(`order_id`, `product_id`, `quantity`)
                 VALUES('$res', '$id', '$quantity')");
           
             }
     return $res;      
    }
    
    public function closeOrder($userID, $resID){
        $result = mysql_query("UPDATE orders SET status='closed' 
                WHERE user_id = '$userID' AND restaurant_id = '$resID' AND status = 'notclosed'");
       
       if($result == true){
          $result1 = mysql_query("UPDATE checkin SET status='not active' 
                WHERE user_id = '$userID' AND restaurant_id = '$resID' AND status = 'active'");
          
          return true;
       }
        return false;
    }
    public function verificationStatus($userID, $mobile, $mobile_status){
        $result = mysql_query("UPDATE users SET `mobile_verified` = '$mobile_status', `mobile` = '$mobile' 
                WHERE `uid` = '$userID' AND `mobile_verified` = 'no'");
       
       if($result == true){
          return true;
       }
        return $result;
    }    
    public function checkIN($userID, $resID){
        $result = mysql_query("INSERT INTO checkin(user_id, restaurant_id, status, checkin_time) 
        VALUES('$userID', '$resID', 'active', NOW()");
       
       if($result){
           return true;
       }
        return false;
    }
    
    
    
    
     public function getProcessOrder($userID, $resID){
        $result = mysql_query("SELECT order_id from orders WHERE user_id = '$userID' AND restaurant_id = '$resID' AND status = 'notclosed'");
        $no_of_rows = mysql_num_rows($result);
        if ($no_of_rows > 0) {
           while ($row = mysql_fetch_array($result)) {
            $orderID =  $row["order_id"];
             $result1 = mysql_query("SELECT orderItems.product_id, orderItems.quantity, 
             products.name, products.rating, products.price, products.size, products.description, products.image_url
                                FROM orderItems INNER JOIN products
                                ON orderItems.product_id = products.product_id
                                WHERE orderItems.order_id = '$orderID'");
            
             $no_of_rows1 = mysql_num_rows($result1);
             $i = 0;
             if ($no_of_rows1 > 0) {
                while ($row1 = mysql_fetch_array($result1)) {
                $processing["'$i'"] = $row1;
                $i = $i + 1;
                }
           }
            return $processing;
        }
        }
        return false;
        
    }

public function getOffers($resID){
    $i = 0;
    
    $result1 = mysql_query("SELECT * FROM `offer_rewards` WHERE `restaurant_id`='$resID' AND NOW() BETWEEN `start_datetime` AND `end_datetime`");
     $no_of_rows1 = mysql_num_rows($result1);
        //orderID, description, reward are show in app
        if ($no_of_rows1 > 0) {
        while ($row = mysql_fetch_array($result1)) {
        $offers["'$i'"]["type"] = "rewards";
        $offers["'$i'"]["rewardsPercentage"] = $row["percentage"];
       // $offers["'$i'"]["rewardadsf"] = $date; //$row["start_datetime"] ;
        $offers["'$i'"]["buy"] = null;
        $offers["'$i'"]["get"] = null;
        $offers["'$i'"]["discount"] = null;
        $offers["'$i'"]["productID"] = null;
        $offers["'$i'"]["loyaltyCardID"] = null;
        $i = $i +1;
        
        }
        }
        
        //return $result1;
        //AND NOW() BETWEEN start_datetime AND end_datetime
    $result2 = mysql_query("SELECT * FROM `loyaltyCards` WHERE `restaurant_id`='$resID'  AND NOW() BETWEEN `start_datetime` AND `end_datetime`");
     $no_of_rows2 = mysql_num_rows($result2);
        //orderID, description, reward are show in app
        if ($no_of_rows2 > 0) {
        while ($row = mysql_fetch_array($result2)) {
        $offers["'$i'"]["type"] = "loyaltyCard";
        $offers["'$i'"]["rewardsPercentage"] = null;
        $offers["'$i'"]["buy"] = null;
        $offers["'$i'"]["get"] = null;
        $offers["'$i'"]["discount"] = null;
        $offers["'$i'"]["productID"] = null;
        $offers["'$i'"]["loyaltyCardID"] = $row["loyaltycard_id"];
        $i = $i +1;
        
        }
        }
       
    $result3 = mysql_query("SELECT * FROM `offer_bogo` WHERE `restaurant_id`='$resID'  AND NOW() BETWEEN `start_datetime` AND `end_datetime`");
     $no_of_rows3 = mysql_num_rows($result3);
        //orderID, description, reward are show in app
        if ($no_of_rows3 > 0) {
        while ($row = mysql_fetch_array($result3)) {
        $offers["'$i'"]["type"] = "bogo";
        $offers["'$i'"]["rewardsPercentage"] = null;
        $offers["'$i'"]["buy"] = $row["buy_id"];
        $offers["'$i'"]["get"] = $row["get_id"];
        $offers["'$i'"]["discount"] = null;
        $offers["'$i'"]["productID"] = null;
        $offers["'$i'"]["loyaltyCardID"] = null;
        $i = $i +1;
        
        }
        }
    $result4 = mysql_query("SELECT * FROM `offer_discount` WHERE `restaurant_id`='$resID'  AND NOW() BETWEEN `start_datetime` AND `end_datetime`");
     $no_of_rows4 = mysql_num_rows($result4);
        //orderID, description, reward are show in app
        if ($no_of_rows4 > 0) {
        while ($row = mysql_fetch_array($result4)) {
        $offers["'$i'"]["type"] = "discount";
        $offers["'$i'"]["rewardsPercentage"] = null;
        $offers["'$i'"]["buy"] = null;
        $offers["'$i'"]["get"] = null;
        $offers["'$i'"]["discount"] = $row["percentage"];
        $offers["'$i'"]["productID"] = $row["product_id"];
        $offers["'$i'"]["loyaltyCardID"] = null;
        $i = $i +1;
        
        }
        }
        
        return $offers;
        
}

public function getRewardsList($userID){
        $result = mysql_query("SELECT * FROM `rewards` WHERE `user_id`='$userID'");
        $i = 0;
        $no_of_rows = mysql_num_rows($result);
        //orderID, description, reward are show in app
        if ($no_of_rows > 0) {
        while ($row = mysql_fetch_array($result)) {
            
            $rewards["'$i'"]= $row;
            //it is an order
            if($row["type"] == "0"){
                
                $result1 = mysql_query("SELECT restaurants.name , restaurants.restaurant_id
                                    FROM `restaurants` INNER JOIN orders
                                    ON restaurants.restaurant_id = orders.restaurant_id
                                     WHERE orders.order_id ='$row[from_id]'");
                
                while ($row1 = mysql_fetch_array($result1)) {
                        $rewards["'$i'"]["order_id"] = $row["from_id"];
                        $rewards["'$i'"]["rewardType"] = "order";
                        $rewards["'$i'"]["description"] = "order from " . $row1["name"];
                        
                        break;
                        }
                }
                //it is referel
            else if($row[type] == "1"){
                $result1 = mysql_query("SELECT fname FROM `users` WHERE `user_id`='$row[from_id]'");
                
                while ($row1 = mysql_fetch_array($result1)) {
                        $rewards["'$i'"]["order_id"] = "--";
                        $rewards["'$i'"]["rewardType"] = "referel";
                        $rewards["'$i'"]["description"] = "referrel from " . $row1["fname"];
                        }
            }
                    
            $i = $i +1;
            
        }
        return $rewards;
        }
        return false;
    }
    
    public function getRewardsSpentList($userID){
        $i = 0;
        $result1 = mysql_query("SELECT * FROM `mobilerecharge` WHERE `user_id`='$userID'");
        $no_of_rows = mysql_num_rows($result1);
        //orderID, description, reward are show in app
        if ($no_of_rows > 0) {
        while ($row = mysql_fetch_array($result1)) {
            
            $rewards["'$i'"]["type"]= "Mobile Recharge";
            $rewards["'$i'"]["id"]= $row['recharge_id'];
            $rewards["'$i'"]["amount"]= $row['amount'];
            $rewards["'$i'"]["status"]= $row['status'];
            
                    
            $i = $i +1;
            
        }
        }
        $result2 = mysql_query("SELECT * FROM `banktransfer` WHERE `user_id`='$userID'");
        $no_of_rows1 = mysql_num_rows($result2);
        //orderID, description, reward are show in app
        if ($no_of_rows1 > 0) {
        while ($row1 = mysql_fetch_array($result2)) {
            
            $rewards["'$i'"]["type"]= "Bank Transfer";
            $rewards["'$i'"]["id"]= $row1['transfer_id'];
            $rewards["'$i'"]["amount"]= $row1['amount'];
            $rewards["'$i'"]["status"]= $row1['status'];
            
                    
            $i = $i +1;
            
        }
        }
        return $rewards;
    }
    public function processFav($userID, $resID, $isFav){
         $result = mysql_query("SELECT * FROM `favourites` WHERE `user_id`='$userID' AND `restaurant_id`='$resID'");
        $i = 0;
        $no_of_rows = mysql_num_rows($result);
        //orderID, description, reward are show in app
        if ($no_of_rows > 0) {
            while ($row = mysql_fetch_array($result)) {
                if ($isFav == "1"){
                    $result1 = mysql_query("DELETE FROM favourites WHERE `user_id`='$userID' AND `restaurant_id`='$resID'");
                                if($result1){
                                return "true";
                                 }
                                else{
                                    return "false1";
                                } 
                }
                return "false2";
                
            }
        }
        else{
            if($isFav == "0"){
               
                    $result21 = mysql_query("INSERT INTO favourites(user_id, restaurant_id, time) VALUES('$userID','$resID',NOW())");
               
                    if($result21){
                                return "true";
                                 }
                                else{
                                    die(mysql_error());
                                    return $result21 . "here" . " " . $userID . " " . $resID . " " . $isFav;
                                } 
                }
                
        }
        return "false4";
    }
    
    
    public function updateUser($userID, $fname, $lname, $email){
         $result = mysql_query("UPDATE users 
          SET `firstname` = '$fname', `lastname` = '$lname', `email` = '$email' 
          WHERE `uid` = '$userID'");
        // check for successful store
        if($result === true){
            return $result;
        }
        else {
           return $false;
        } 
        
    }
    
    
    public function invalidateMobile($userID, $mobile){
         $result = mysql_query("SELECT mobile FROM `users` WHERE `uid`='$userID'");
         $no_of_rows = mysql_num_rows($result);
        //orderID, description, reward are show in app
        if ($no_of_rows > 0) {
        while ($row = mysql_fetch_array($result)) {
                if($mobile == $row[mobile]){
                     $result1 = mysql_query("UPDATE `users` 
                                SET `mobile` = NULL , `mobile_verified` = 'no'
                                WHERE `uid` = '$userID'");
                             if($result1 === true){
                                return $result1;
                             }
                            else {
                               return false;
                            }        
                }
        }
        }

        return false;
    }
    
    
    public function rechargemobile($userID,$operator,$amount,$number){
        $result = mysql_query("SELECT rewards_all, rewards_used FROM `users` WHERE `uid`='$userID'");
         $no_of_rows = mysql_num_rows($result);
        //orderID, description, reward are show in app
        if ($no_of_rows > 0) {
        while ($row = mysql_fetch_array($result)) {
        if($row[rewards_all] - $row[rewards_used] >= $amount){
            $value = $this->recharge_function($userID,$operator,$amount,$number);
            if($value["success"] == "1"){
            $remaining_rewards = $amount + $row[rewards_used];
            $result1 = mysql_query("UPDATE `users` SET `rewards_used` = '$remaining_rewards' WHERE `uid` = '$userID'");
                             if($result1 === true){
                                return $value;
                             }
                            else {
                               return false;
                            }
            }
            return false;
        }
        }
        }
        return false;
    }
    
    
    public function recharge_function($userID,$operator,$amount,$number) {
    
    $error_code = '';
    $mode = "0";
    $orderid = substr(number_format(time() * rand(),0,'',''),0,10); 
    $myjoloappkey="662214997158655";
    $ch = Curl_init();
    $timeout = 1000;
    $myurl = "http://www.joloapi.com/api/recharge2.php?mode=$mode&userid=shopex&key=$myjoloappkey&operator=$operator&service=$number&amount=$amount&orderid=$orderid";
    curl_setopt ($ch, CURLOPT_URL, $myurl);
    curl_setopt ($ch, CURLOPT_HEADER, 0);
    curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
    $file_contents = curl_exec($ch);
    curl_close($ch);
    $maindata = explode(",", $file_contents);
    $countdatas = count($maindata);
    if($countdatas > 2)
    {
        //recharge is success
        $transactionid = $maindata[0]; //it is joloapi.com generated order id
        $status = $maindata[1]; //it is status of recharge SUCCESS,FAILED
        $operator= $maindata[2]; //operator code
        $number= $maindata[3]; //mobile number
        $amount= $maindata[4]; //amount
        $mywebsiteorderid= $maindata[5]; //your website order id
        $errorcode= $maindata[6]; // api error code 
        $operatorid= $maindata[7]; //original operator transaction id
        $myapibalance= $maindata[8]; //myjoloapi.com remaining balance
        $myapiprofit= $maindata[9]; //my earning on this recharge
        $txntime= $maindata[10]; // recharge time
    }
    else
    {
        //recharge is failed
        $transactionid = "Recharge Failed";
        $txnstatus = $maindata[0]; //it is status of recharge FAILED
        $errorcode= $maindata[1]; // api error code 
        $status= "FAILED";
    }
    $data['error_code'] = $error_code;
         
    $rechargeInsert = mysql_query("INSERT INTO mobilerecharge(order_id, transaction_id, user_id, status, operator, service, amount, date)
                    VALUES('$orderid', '$transactionid', '$userID', '$status', '$operator', '$number', '$amount', NOW())");
                    
    if($status == "SUCCESS")
    {
        $data["success"] = "1";
        return $data;
    }
    if($status == "PENDING")
    {
        $data["success"] = "0";
        $data["pending"] = "1";
        return $data;
    }
    if($data['error_code'] != '')
    {
        if($data['error_code'] == 7 || $data['error_code'] == 14 || $data['error_code'] == 16)
        {
            $data['error'] = "Amount is greater than 25000.";
        }
        if($data['error_code'] == 11 || $data['error_code'] == 19)
        {
            $data['error'] = "Mobile number is not valid.";
        }
        if($data['error_code'] == 20)
        {
            $data['error'] = "No IP address linked.";
        }
        if($data['error_code'] == 21)
        {
            $data['error'] = "IP address not matched.";
        }
        if($data['error_code'] == 22)
        {
            $data['error'] = "Balance is less than 10.";
        }
        if($data['error_code'] == 23)
        {
            $data['error'] = "Balance is less than requested recharge amount.";
        }
        if($data['error_code'] == 24)
        {
            $data['error'] = "Internal server error, try again after 2 seconds.";
        }
        if($data['error_code'] == 25)
        {
            $data['error'] = "Same number with same amount not allowed within 60 seconds.";
        }
        if($data['error_code'] == 102)
        {
            $data['error'] = "Service number barred temporary.";
        }
        if($data['error_code'] == 103)
        {
            $data['error'] = "Operator-jolo internal error.";
        }
        if($data['error_code'] == 105)
        {
            $data['error'] = "Recharge disabled on this operator.";
        }
        if($data['error_code'] == 106)
        {
            $data['error'] = "Operator not allowed.";
        }
        if($data['error_code'] == 109)
        {
            $data['error'] = "This recharge already in progress at operator end.";
        }
        if($data['error_code'] == 24)
        {
            $data['error'] = "Internal server error, try again after 2 seconds.";
        }
        if($data['error_code'] == 152 || $data['error_code'] == 153)
        {
            $data['error'] = "Amount / denomination not accepted by this operator.";
        }
        if($data['error_code'] == 155)
        {
            $data['error'] = "Retry after 5 minutes.";
        }
        if($data['error_code'] == 162)
        {
            $data['error'] = "Customer exceeded per day attempts on this numberAmount / denomination not accepted by this operator.";
        }
        if($data['error_code'] == 165)
        {
            $data['error'] = "Invalid denomination.";
        }
        if($data['error_code'] == 167)
        {
            $data['error'] = "Multiple transaction error from operator on this number.";
        }
        if($data['error_code'] == 152 || $data['error_code'] == 153)
        {
            $data['error'] = "Amount / denomination not accepted by this operator.";
        }
        if($data['error_code'] == 237)
        {
            $data['error'] = "Operator temporarily blocked.";
        }
        if($data['error_code'] == 232)
        {
            $data['error'] = "Operator blocked.";
        }
        if($data['error_code'] == 191)
        {
            $data['error'] = "Amount is not accepted by operator.";
        }
        if($data['error_code'] == 172 || $data['error_code'] == 173)
        {
            $data['error'] = "Operator is down at this moment.";
        }
        if($data['error_code'] == 168 || $data['error_code'] == 169 || $data['error_code'] == 170 || $data['error_code'] == 171)
        {
            $data['error'] = "Temporary operator end error.";
        }
    }
    else{
        $data['error'] = "Server Busy !";
    }
    $data["success"] = "0";
    $data["pending"] = "0";
    return $data;
}

    

public function bank_function($userID, $account_name,$bank_name,$account_number,$confirm_account_number,$ifsc_code,$amount_required,$phone_number)
    {
      $bankInsert = mysql_query("INSERT INTO banktransfer(user_id, bankname, accountnumber, accountnumber, ifsccode, amountrequired, phonenumber, date)
                    VALUES('$userID', '$bank_name', '$account_number', '$ifsc_code', '$amount_required', '$phone_number', NOW())");
     
     $no_of_rows = mysql_num_rows($bankInsert);
        //orderID, description, reward are show in app
        if ($no_of_rows > 0) {
        while ($row = mysql_fetch_array($bankInsert)) {
            return true;
        }
        }
        return false;
    }
    
}

?>
