<?php
require_once __DIR__ . '/../app/config/database.php';

echo "<h1>Applying Database Fix for Student Dashboard...</h1>";

try {
    $db = Database::getConnection();
    
    // Check if attendance_time exists
    $stmt = $db->query("SHOW COLUMNS FROM attendance LIKE 'attendance_time'");
    $exists = $stmt->fetch();
    
    if (!$exists) {
        $db->exec("ALTER TABLE attendance ADD COLUMN attendance_time TIME DEFAULT '00:00:00' AFTER date");
        echo "<h2 style='color:green;'>✅ Successfully updated 'attendance' table with missing 'attendance_time' column!</h2>";
    } else {
        echo "<h2 style='color:orange;'>✅ Column 'attendance_time' already exists.</h2>";
    }
    
    // Let's also drop the old unique key that prevented multiple sessions per day, if it exists
    try {
        $db->exec("ALTER TABLE attendance DROP INDEX uq_attendance");
        $db->exec("ALTER TABLE attendance ADD UNIQUE KEY uq_attendance_multi (student_id, subject_id, date, attendance_time)");
        echo "<h2 style='color:green;'>✅ Updated Unique Keys successfully.</h2>";
    } catch (Exception $e) {
        // Ignore error if index doesn't exist
    }

    echo "<h3>If you see green checkmarks, the student dashboard will now work! Go try it.</h3>";
    
} catch (Exception $e) {
    echo "<p style='color:red;'>❌ Database Error: " . $e->getMessage() . "</p>";
}
