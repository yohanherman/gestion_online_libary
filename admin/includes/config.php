<?php
// DB credentials.
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'library');
// Establish database connection.
try {
    $conn = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASS);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Instancier la classe PDO
} catch (PDOException $e) {
    exit("Error: " . $e->getMessage());
}


// $conn = new PDO('mysql:host='. DB_HOST .';dbname='. DB_NAME .',DB_USER,DB_PASSWORD);