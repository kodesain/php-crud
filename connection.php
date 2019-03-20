<?php

session_start();

defined('BASEPATH') or define('BASEPATH', 'http://localhost:8081/php-crud/');

defined('DB_NAME') or define('DB_NAME', 'crud');
defined('DB_USER') or define('DB_USER', 'root');
defined('DB_PASS') or define('DB_PASS', '');
defined('DB_HOST') or define('DB_HOST', 'localhost');


try {
    // create connection
    $conn = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASS);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Connection failed: ' . $e->getMessage());
}
?>