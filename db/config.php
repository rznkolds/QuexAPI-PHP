<?php
    $db = new PDO("mysql:host=quex.cmbsw9fpkkwe.eu-central-1.rds.amazonaws.com;dbname=quex",'root','Tr901324.');
    $db->exec("SET NAMES utf8");
    $db->query("SET CHARACTER SET utf8");
    $db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION); 
?>