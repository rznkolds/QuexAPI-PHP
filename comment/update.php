<?php
    if ($_SERVER['REQUEST_METHOD'] === 'PUT') {

        $data = json_decode(file_get_contents('php://input')); // Received post body from client.

        if(!empty($data)) { // The state of the post body has been checked.
    
            require_once __DIR__ . '/../db/config.php'; // Database configuration is integrated.
    
            if (!$db) { // Checked the stability of the configuration.
    
                die('Incorrect connection : ' . mysqli_connect_error());
            }
    
            // The data inside the body has been received.
    
            $uid = $data->uid;
            $name = $data->name;
            $profile = $data->profile;
            $coin = $data->coin;
            $comment = $data->comment;
            $date = $data->date;
            $time = $data->time;
    
            // The requested answer information has been received.
    
            $db_comment = $db->query("SELECT * FROM comments WHERE uid = '$uid' AND coin = '$coin' AND date = '$date' AND time = '$time'")->fetch(PDO::FETCH_ASSOC);
    
            if(!empty($db_comment)) { // The status of the information has been checked.
    
                $row = $db->query("SELECT name , profile FROM users WHERE uid = '$uid'")->fetch(PDO::FETCH_ASSOC); // The current user's name and profile data have been retrieved.
    
                // The current user's comment response added to database.
    
                $run = $db->prepare("UPDATE comments SET comment = ? WHERE uid = '$uid' AND name = '$row[name]' AND profile = '$row[profile]' AND coin = '$coin' AND date ='$date' AND time ='$time'");
    
                $run->execute([$comment]);
                
                $response['success'] = true;

                echo json_encode($response);
            } else { 
            
                $response['success'] = false;

                echo json_encode($response);
            }
        }
    }
?>
