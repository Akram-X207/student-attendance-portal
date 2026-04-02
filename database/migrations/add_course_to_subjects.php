<?php
require_once __DIR__ . '/../../app/config/database.php';

try {
    $db = Database::getConnection();

    // 1. Add course column to subjects
    $db->exec("ALTER TABLE subjects ADD COLUMN IF NOT EXISTS course VARCHAR(100) AFTER name");

    // 2. Make department_id optional (nullable) until we have a department manager
    $db->exec("ALTER TABLE subjects MODIFY COLUMN department_id SMALLINT UNSIGNED NULL");

    // 3. Drop existing foreign key so we don't get errors if departments doesn't have IDs
    try {
        $db->exec("ALTER TABLE subjects DROP FOREIGN KEY subjects_ibfk_1");
    } catch (Exception $e) { /* Already dropped or doesn't exist */ }

    echo "✅ Database schema updated successfully!\n";
} catch (PDOException $e) {
    echo "❌ Error updating database: " . $e->getMessage() . "\n";
}
