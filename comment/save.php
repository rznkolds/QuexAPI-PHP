<?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') { 

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
    
            // The requested comment information has been received.
    
            $db_comment = $db->query("SELECT * FROM comments WHERE uid = '$uid' AND coin = '$coin' AND comment = '$comment' AND date = '$date' AND time = '$time'")->fetch(PDO::FETCH_ASSOC);
    
            if(empty($db_comment)) { // The status of the information has been checked.
    
                $row = $db->query("SELECT name , profile FROM users WHERE uid = '$uid'")->fetch(PDO::FETCH_ASSOC); // The current user's name and profile data have been retrieved.
    
                // The current user's comment has been added to the database.
    
                $run = $db->prepare("INSERT INTO comments SET uid = ?, name = ?, profile = ?, coin = ?, comment = ?, date = ?, time = ?");
    
                $run->execute([$uid, $row['name'], $row['profile'], $coin, $comment, $date, $time]);
    
                $favorite = $db->query("SELECT * FROM favorites WHERE uid = '$uid' AND coin = '$coin'")->fetch(PDO::FETCH_ASSOC); // The current user's favorite information received.
    
                if(empty($favorite)) { // The existence of the favorite coin in the database has been checked.
    
                    // The coin name is defined in the favorite list for the current user.
    
                    $run = $db->prepare("INSERT INTO favorites SET uid = ?, coin = ?");
    
                    $run->execute([$uid, $coin]);
                }
                
                $response['success'] = true;

                echo json_encode($response);
            } else { 
            
                $response['success'] = false;

                echo json_encode($response);
            }
        }
    }
?>
