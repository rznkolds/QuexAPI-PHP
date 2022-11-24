<?php
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {

        if (isset($_GET['uid'])) {

            require_once __DIR__ . '/../db/config.php'; // Database configuration is integrated.
    
            if (!$db) { // Checked the stability of the configuration.
    
                die("Incorrect connection : " . mysqli_connect_error());
            }
    
            $uid = $_GET['uid']; // The data received from the client was passed to the variable.
    
            $users = $db->query("SELECT * FROM users WHERE uid = '$uid'")->fetch(PDO::FETCH_ASSOC); // The requested user information has been received.
    
            if(!empty($users)) { // The status of the information has been checked.
    
                echo json_encode($users , JSON_UNESCAPED_UNICODE); // The information is transmitted to the client side.
            }
        }
    }
?>
