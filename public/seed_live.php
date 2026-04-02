<?php
require_once __DIR__ . '/../app/config/database.php';

echo "<h1>Auto-Seeding University Data...</h1>";

try {
    $db = Database::getConnection();
    
    // Disable foreign key checks so we can wipe safely
    $db->exec("SET FOREIGN_KEY_CHECKS = 0;");
    
    // Wipe old generic dummy data entirely (resetting AUTO_INCREMENT to 1)
    $db->exec("TRUNCATE TABLE teacher_subjects");
    $db->exec("TRUNCATE TABLE student_subjects");
    $db->exec("TRUNCATE TABLE attendance");
    $db->exec("TRUNCATE TABLE otp_tokens");
    $db->exec("TRUNCATE TABLE subjects");
    $db->exec("TRUNCATE TABLE students");
    $db->exec("TRUNCATE TABLE departments");
    $db->exec("TRUNCATE TABLE users");
    
    // Re-insert Super Admin so AUTO_INCREMENT = 1 is the Admin
    $db->exec("INSERT INTO users (name, email, password, role) VALUES ('Super Admin', 'admin@attendance.local', '\$2y\$10\$qP5rtgFYNRVnw2kEuY.01u4nY1oo6Zdxh/e477yxeu.y6yLITbiVO', 'admin')");
    
    // Re-enable checks
    $db->exec("SET FOREIGN_KEY_CHECKS = 1;");
    
    // Read the new seed.sql file
    $sql = file_get_contents(__DIR__ . '/../database/seed.sql');
    
    // Execute the seed script
    $db->exec($sql);

    echo "<h2 style='color:green;'>✅ ALL DONE! The exact teachers, students, and subjects from your screenshots have been injected into the system.</h2>";
    echo "<h3>You can log in with:</h3>";
    echo "<ul>
            <li><strong>Teacher:</strong> namdev.faculty@jspmuni (Password: password123)</li>
            <li><strong>Student:</strong> 22358010004 (Shaikh Akram)</li>
          </ul>";
          
} catch (Exception $e) {
    echo "<p style='color:red;'>❌ Database Error: " . $e->getMessage() . "</p>";
}
