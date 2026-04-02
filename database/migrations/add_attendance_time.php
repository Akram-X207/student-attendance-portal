<?php
require_once __DIR__ . '/../../app/config/database.php';

try {
    $db = Database::getConnection();

    // 1. Add attendance_time column if not exists
    $db->exec("ALTER TABLE attendance ADD COLUMN IF NOT EXISTS attendance_time TIME DEFAULT '00:00:00' AFTER date");

    // 2. Drop existing unique key
    try {
        $db->exec("ALTER TABLE attendance DROP INDEX uq_attendance");
    } catch (Exception $e) { /* Already dropped or doesn't exist */ }

    // 3. Add new unique key including time
    $db->exec("ALTER TABLE attendance ADD UNIQUE KEY uq_attendance_v2 (student_id, subject_id, date, attendance_time)");

    echo "✅ Attendance table updated with time support!\n";
} catch (PDOException $e) {
    echo "❌ Error updating database: " . $e->getMessage() . "\n";
}
