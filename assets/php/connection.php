<?php
    function getDB() {
        $host = 'localhost';
        $user = 'root';
        $pass = '';
            
        $bd = 'pruebainv';
        try {
            $conn = new PDO("mysql:host=$host;dbname=$bd", $user, $pass);
            $conn->exec("set names utf8");
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
            return $conn;
        } catch(PDOException $e) {
            echo "La conexión ha fallado. ". $e->getMessage();
        }
    }

?>