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
            $profile = $data->profile;
            $coin = $data->coin;
            $comment = $data->comment;
            $date = $data->date;
            $time = $data->time;
    
            // The requested comment information has been received.
    
            $db_comment = $db->query("SELECT * FROM comments WHERE uid = '$uid' AND coin = '$coin' AND comment = '$comment' AND date = '$date' AND time = '$time'")->fetch(PDO::FETCH_ASSOC);
    
            if(!empty($db_comment)) { // The status of the information has been checked.
    
                // The current user's comment has been deleted to the database.
    
                $run = $db->prepare("DELETE FROM comments WHERE comment = ? AND date = ? AND time = ?");
    
                $run->execute([$comment, $date, $time]);
    
                // The sub-responses for the comment have been deleted.
    
                $run = $db->prepare("DELETE FROM answers WHERE top = ? AND date = ? AND time = ?");
    
                $run->execute([$uid, $date, $time]);
    
                // Retrieved the current user's comment list for the specified coin.
    
                $comments = $db->query("SELECT * FROM comments WHERE uid = '$uid' AND coin = '$coin'")->fetchAll(PDO::FETCH_ASSOC);
    
                if(empty($comments)) { // The status of the list has been checked.
    
                    // The current user's favorite coin has been deleted.
    
                    $run = $db->prepare("DELETE FROM favorites WHERE uid = ? AND coin = ?");
    
                    $run->execute([ $uid, $coin]);
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
