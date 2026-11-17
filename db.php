<?php
/**
 * Dhaka Bus Route Planner & Transit Information System
 * Database Configuration & PDO Connection
 *
 * This file establishes a secure connection to the MySQL database.
 * If the database connection fails (e.g., MySQL server not running or database
 * not yet imported), it gracefully flags $is_database_connected = false so the
 * application seamlessly activates the fallback dummy data mode without crashing.
 */

// Database Credentials
define('DB_HOST', 'localhost');
define('DB_PORT', '3306');
define('DB_NAME', 'dhaka_transit');
define('DB_USER', 'root');
define('DB_PASS', '');

// Global state variables
$pdo = null;
$is_database_connected = false;
$database_connection_error = '';

try {
    $dsn = "mysql:host=" . DB_HOST . ";port=" . DB_PORT . ";dbname=" . DB_NAME . ";charset=utf8mb4";
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci"
    ];

    $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
    $is_database_connected = true;
} catch (PDOException $e) {
    // If the database cannot be reached, record the error and switch to fallback mode
    $is_database_connected = false;
    $database_connection_error = $e->getMessage();
}

/**
 * Helper function to retrieve the PDO instance
 * @return PDO|null
 */
function getDB() {
    global $pdo;
    return $pdo;
}

/**
 * Helper function to check if live MySQL is active
 * @return bool
 */
function isDatabaseConnected() {
    global $is_database_connected;
    return $is_database_connected;
}

