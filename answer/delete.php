<?php
    if ($_SERVER['REQUEST_METHOD'] === 'DELETE') { 

        $data = json_decode(file_get_contents('php://input')); // Received post body from client.

        if(!empty($data)) { // The state of the post body has been checked.
    
            require_once __DIR__ . '/../db/config.php'; // Database configuration is integrated.
    
            if (!$db) { // Checked the stability of the configuration.
    
                die('Incorrect connection : ' . mysqli_connect_error());
            }
            
            // The data inside the body has been received.
    
            $uid = $data->uid;
            $name = $data->name;
            $top = $data->top;
            $profile = $data->profile;
            $coin = $data->coin;
            $comment = $data->comment;
            $date = $data->date;
            $time = $data->time;
    
            // The requested answer information has been received.
    
            $db_answer = $db->query("SELECT * FROM answers WHERE uid = '$uid' AND top = '$top' AND coin = '$coin' AND comment = '$comment' AND date = '$date' AND time = '$time'")->fetch(PDO::FETCH_ASSOC);
    
            if(!empty($db_answer)) { // The status of the information has been checked.
    
                // The current user's answer has been deleted to the database.
    
                $run = $db->prepare("DELETE FROM answers WHERE comment = ?");
    
                $run->execute([$comment]);
    
                // Retrieved the current user's answer list for the specified coin.
    
                $answers = $db->query("SELECT * FROM answers WHERE uid = '$uid' AND top = '$top' AND coin = '$coin'")->fetchAll(PDO::FETCH_ASSOC); 
    
                if(empty($answers)) { // The status of the list has been checked.
    
                    // The current user's favorite coin has been deleted.
    
                    $run = $db->prepare("DELETE FROM favorites WHERE uid = ? AND coin = ?");
    
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
