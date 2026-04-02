<?php
if (basename($_SERVER['PHP_SELF']) == 'database.php') { die('Direct access not permitted'); }
require_once __DIR__ . '/constants.php';

class Database {
    private static $connection = null;

    private function __construct() {} // Prevent instantiation

    public static function getConnection() {
        if (self::$connection === null) {
            try {
                $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4";
                $options = [
                    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Throw exceptions on error
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // Fetch associative arrays
                    PDO::ATTR_EMULATE_PREPARES   => false,                  // True prepared statements
                ];
                self::$connection = new PDO($dsn, DB_USER, DB_PASS, $options);
            } catch (PDOException $e) {
                // Return generic message to prevent leaking DB info to user
                die("Database Connection Failed. Check configuration.");
            }
        }
        return self::$connection;
    }
}
