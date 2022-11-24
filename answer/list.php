<?php
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {

        if (isset($_GET['coin']) && isset($_GET['top']) && isset($_GET['date']) && isset($_GET['time'])) {

            require_once __DIR__ . '/../db/config.php'; // Database configuration is integrated.
    
            if (!$db) { // Checked the stability of the configuration.
    
                die("Incorrect connection : " . mysqli_connect_error());
            }
    
            // The data received from the client was passed to the variable.
    
            $coin = $_GET['coin'];
            $top  = $_GET['top'];
            $date = $_GET['date'];
            $time = $_GET['time'];
    
            // The answer list received for current user.
    
            $answers = $db->query("SELECT * FROM answers WHERE coin='$coin' AND top='$top' AND date='$date' AND time='$time'")->fetchAll(PDO::FETCH_ASSOC);
    
            echo json_encode($answers, JSON_UNESCAPED_UNICODE); // The information is transmitted to the client side.
        }
    }
?>
