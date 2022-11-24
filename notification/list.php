<?php
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {

        if (isset($_GET['uid'])) {

            require_once __DIR__ . '/../db/config.php'; // Database configuration is integrated.
    
            if (!$db) { // Checked the stability of the configuration.
    
                die("Incorrect connection : " . mysqli_connect_error());
            }
    
            $uid = $_GET['uid']; // The data received from the client was passed to the variable.
    
            $notifications = $db->query("SELECT * FROM notifications WHERE uid = '$uid' ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC); // The notification of the requested user has been received.
    
            if(!empty($notifications)) { // The status of the information has been checked.
    
                echo json_encode($notifications); // The information is transmitted to the client side.
            }
        }
    }
?>
