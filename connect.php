<?php
    // A simple PHP script demonstrating how to connect to MySQL.
    // Press the 'Run' button on the top to start the web server,
    // then click the URL that is emitted to the Output tab of the console.

    $servername = "127.0.0.1";
    $username = "root";
    $password = "root";
    $database = "che_db";
    $dbport = 3308;

    try {
        $db_pdo = new PDO("mysql:host=127.0.0.1:3308;dbname=$database", "root", "root");
    } catch (Exception $e) {
        echo "Could not connect to the database.";
        exit;
    }

    // Connect to session
    session_start();
    
    // Check Login
    function logged_in()
    {
        if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true) {
            return(true);
        }
        return(false);
    }
