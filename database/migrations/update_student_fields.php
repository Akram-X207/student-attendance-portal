<?php
require_once __DIR__ . '/../../app/config/database.php';

try {
    $db = Database::getConnection();

    // 1. Add contact_number (phone)
    $db->exec("ALTER TABLE students ADD COLUMN IF NOT EXISTS phone VARCHAR(20) AFTER email");

    // 2. Add semester
    $db->exec("ALTER TABLE students ADD COLUMN IF NOT EXISTS semester TINYINT UNSIGNED DEFAULT 1 AFTER year");

    // 3. Rename department to faculty (if it exists)
    try {
        $db->exec("ALTER TABLE students CHANGE COLUMN department faculty VARCHAR(100) NOT NULL");
    } catch (Exception $e) {
        if (strpos($e->getMessage(), "Unknown column") === false) {
             // If column is already 'faculty', this might fail, which is fine
        }
    }

    // 4. Rename course to program (if it exists)
    try {
        $db->exec("ALTER TABLE students CHANGE COLUMN course program VARCHAR(100) NOT NULL");
    } catch (Exception $e) { }

    echo "✅ Student table schema updated successfully!\n";
} catch (PDOException $e) {
    echo "❌ Error updating database: " . $e->getMessage() . "\n";
}
