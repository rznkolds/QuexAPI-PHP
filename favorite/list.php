<?php
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {

        if (isset($_GET['uid'])) {

            require_once __DIR__ . '/../db/config.php'; // Database configuration is integrated.
    
            if (!$db) { // Checked the stability of the configuration.
    
                die("Incorrect connection : " . mysqli_connect_error());
            }
    
            $uid = $_GET['uid']; // The data received from the client was passed to the variable.
    
            $favorites = $db->query("SELECT * FROM favorites WHERE uid = '$uid'")->fetchAll(PDO::FETCH_ASSOC); // The favorite list of the requested user is received.
    
            if(!empty($favorites)) { // The status of the list has been checked.
    
                echo json_encode($favorites); // The information is transmitted to the client side.
            }
        }
    }
?>