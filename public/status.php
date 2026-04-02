<?php
require_once __DIR__ . '/../app/config/database.php';

echo "<h1>Applying Fix...</h1>";

try {
    $db = Database::getConnection();
    
    // Generate a fresh hash for the password "password123" right here on the server
    $newHash = password_hash('password123', PASSWORD_BCRYPT);
    
    // Update all users to use this new password
    $stmt = $db->prepare("UPDATE users SET password = :hash");
    $stmt->execute([':hash' => $newHash]);
    
    echo "<h2 style='color:green;'>✅ ALL ACCOUNTS UPDATED SUCCESSFULLY!</h2>";
    echo "<h3>You can now log in using any email (like admin@attendance.local) and the password: <code>password123</code></h3>";
    
} catch (Exception $e) {
    echo "<p style='color:red;'>❌ Database Error: " . $e->getMessage() . "</p>";
}
