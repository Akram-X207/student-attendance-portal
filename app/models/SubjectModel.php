<?php
require_once __DIR__ . '/../config/database.php';

class SubjectModel {
    private $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    public function getAll() {
        return $this->db->query("SELECT * FROM subjects ORDER BY code ASC")->fetchAll();
    }

    public function create($name, $code, $course, $year, $semester) {
        $stmt = $this->db->prepare("INSERT INTO subjects (name, code, course, year, semester) VALUES (?, ?, ?, ?, ?)");
        return $stmt->execute([$name, $code, $course, $year, $semester]);
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM subjects WHERE id = ?");
        return $stmt->execute([$id]);
    }

    /**
     * Assign a teacher to a subject
     */
    public function assignTeacher($teacher_id, $subject_id) {
        // Check if already assigned
        $stmt = $this->db->prepare("SELECT id FROM teacher_subjects WHERE teacher_id = ? AND subject_id = ?");
        $stmt->execute([$teacher_id, $subject_id]);
        if ($stmt->fetch()) return true;

        $stmt = $this->db->prepare("INSERT INTO teacher_subjects (teacher_id, subject_id) VALUES (?, ?)");
        return $stmt->execute([$teacher_id, $subject_id]);
    }

    /**
     * Enroll a student to a subject
     */
    public function enrollStudent($student_id, $subject_id) {
        // Check if already enrolled
        $stmt = $this->db->prepare("SELECT id FROM student_subjects WHERE student_id = ? AND subject_id = ?");
        $stmt->execute([$student_id, $subject_id]);
        if ($stmt->fetch()) return true;

        $stmt = $this->db->prepare("INSERT INTO student_subjects (student_id, subject_id) VALUES (?, ?)");
        return $stmt->execute([$student_id, $subject_id]);
    }
    
    public function getTeachersBySubject($subject_id) {
        $stmt = $this->db->prepare("
            SELECT u.name, u.email, ts.id as assignment_id
            FROM users u
            JOIN teacher_subjects ts ON u.id = ts.teacher_id
            WHERE ts.subject_id = ?
        ");
        $stmt->execute([$subject_id]);
        return $stmt->fetchAll();
    }
}
