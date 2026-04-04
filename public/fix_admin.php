<?php
require_once __DIR__ . '/../app/config/database.php';

echo "<h1>Applying Admin Student Update Fix...</h1>";

try {
    $db = Database::getConnection();
    
    // 1. Add phone if not exists
    $stmt = $db->query("SHOW COLUMNS FROM students LIKE 'phone'");
    if (!$stmt->fetch()) {
        $db->exec("ALTER TABLE students ADD COLUMN phone VARCHAR(20) AFTER email");
        echo "<p>✅ Added 'phone' column.</p>";
    }

    // 2. Add semester if not exists
    $stmt = $db->query("SHOW COLUMNS FROM students LIKE 'semester'");
    if (!$stmt->fetch()) {
        $db->exec("ALTER TABLE students ADD COLUMN semester TINYINT UNSIGNED DEFAULT 1 AFTER year");
        echo "<p>✅ Added 'semester' column.</p>";
    }

    // 3. Rename department to faculty
    $stmt = $db->query("SHOW COLUMNS FROM students LIKE 'department'");
    if ($stmt->fetch()) {
        $db->exec("ALTER TABLE students CHANGE COLUMN department faculty VARCHAR(100) NOT NULL");
        echo "<p>✅ Renamed 'department' to 'faculty'.</p>";
    }

    // 4. Rename course to program
    $stmt = $db->query("SHOW COLUMNS FROM students LIKE 'course'");
    if ($stmt->fetch()) {
        $db->exec("ALTER TABLE students CHANGE COLUMN course program VARCHAR(100) NOT NULL");
        echo "<p>✅ Renamed 'course' to 'program'.</p>";
    }

    echo "<h2 style='color:green;'>✅ ALL UPDATES SUCCESSFUL!</h2>";
    echo "<p>The Admin Dashboard for editing students will now work perfectly.</p>";
    
} catch (Exception $e) {
    echo "<p style='color:red;'>❌ Database Error: " . $e->getMessage() . "</p>";
}
