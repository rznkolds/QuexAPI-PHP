<?php
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {

        if (isset($_GET['coin'])) {

            require_once __DIR__ . '/../db/config.php'; // Database configuration is integrated.
    
            if (!$db) { // Checked the stability of the configuration.
    
                die("Incorrect connection : " . mysqli_connect_error());
            }
    
            $coin = $_GET['coin']; // The data received from the client was passed to the variable.
    
            // The comment list for the requested coin has been received.
    
            $comments = $db->query("SELECT * FROM comments WHERE coin='$coin' ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC); 
    
            echo json_encode($comments); // The information is transmitted to the client side.
        }
    }
?>
