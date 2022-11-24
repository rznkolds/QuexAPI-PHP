<?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $data = json_decode(file_get_contents("php://input")); // Received post body from client.

        if(!empty($data)) { // The state of the post body has been checked.
    
            require_once __DIR__ . '/../db/config.php'; // Database configuration is integrated.
    
            if (!$db) { // Checked the stability of the configuration.
    
                die("Incorrect connection : " . mysqli_connect_error());
            }
    
            // The data inside the body has been received.
    
            $uid = $data->uid;
            $name = $data->name;
            $description = $data->description;
            $profile = $data->profile;
    
            $user = $db->query("SELECT * FROM users WHERE uid = '$uid'")->fetch(PDO::FETCH_ASSOC); // The requested user information has been received.
    
            if(empty($user)){ // The status of the information has been checked.
                
                // User data added to database.
    
                $run = $db->prepare("INSERT INTO users SET uid = ?,  name = ?, description = ?, profile = ? ");
                
                $run->execute([$uid, $name , $description , $profile]);

                $response['success'] = true;

                echo json_encode($response);
            } else { 
            
                $response['success'] = false;

                echo json_encode($response);
            }
        }
    }
?>