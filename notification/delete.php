<?php
    if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {

        if (isset($_GET['uid'])) {

            require_once __DIR__ . '/../db/config.php'; // Database configuration is integrated.
        
            if (!$db) { // Checked the stability of the configuration.
        
                die("Incorrect connection : " . mysqli_connect_error());
            }
        
            $uid = $_GET['uid']; // The data received from the client was passed to the variable.
        
            $notifications = $db->query("SELECT * FROM notifications WHERE uid = '$uid'")->fetchAll(PDO::FETCH_ASSOC); // The notification of the requested user has been received.
        
            if (!empty($notifications)) { // The status of the information has been checked.
        
                // User notifications are deleted.
        
                $run = $db->prepare("DELETE FROM notifications WHERE uid = ?");
        
                $run->execute([$uid]);
                
                $response['success'] = true;

                echo json_encode($response);
            } else { 
            
                $response['success'] = false;

                echo json_encode($response);
            }
        }
    }
?>



