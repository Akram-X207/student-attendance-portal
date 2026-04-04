<?php
require_once __DIR__ . '/../models/StudentModel.php';
require_once __DIR__ . '/../models/UserModel.php';
require_once __DIR__ . '/../config/session.php';

class AdminController {
    
    /**
     * Admin Dashboard - Stats Overview
     */
    public function dashboard() {
        check_role(ROLE_ADMIN);
        
        $db = Database::getConnection();
        
        $stats = [
            'students' => $db->query("SELECT COUNT(*) FROM students")->fetchColumn(),
            'teachers' => $db->query("SELECT COUNT(*) FROM users WHERE role = 'teacher'")->fetchColumn(),
            'subjects' => $db->query("SELECT COUNT(*) FROM subjects")->fetchColumn(),
            'sessions' => $db->query("SELECT COUNT(DISTINCT date, subject_id) FROM attendance")->fetchColumn()
        ];
        
        require_once __DIR__ . '/../views/admin/dashboard.php';
    }

    /**
     * List all students with search/filter
     */
    public function students() {
        check_role(ROLE_ADMIN);
        
        $search = filter_input(INPUT_GET, 'q', FILTER_SANITIZE_STRING) ?? '';
        
        $db = Database::getConnection();
        $query = "SELECT * FROM students WHERE 1=1";
        $params = [];
        
        if (!empty($search)) {
            $query .= " AND (name LIKE :q1 OR prn LIKE :q2)";
            $params[':q1'] = "%$search%";
            $params[':q2'] = "%$search%";
        }
        
        $query .= " ORDER BY prn ASC";
        $stmt = $db->prepare($query);
        $stmt->execute($params);
        $students = $stmt->fetchAll();
        
        require_once __DIR__ . '/../views/admin/students.php';
    }
    /**
     * View and handle Add Student
     */
    public function addStudent() {
        check_role(ROLE_ADMIN);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $prn = strtoupper(filter_input(INPUT_POST, 'prn', FILTER_SANITIZE_STRING));
            $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
            $phone = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_STRING);
            $faculty = filter_input(INPUT_POST, 'faculty', FILTER_SANITIZE_STRING);
            $program = filter_input(INPUT_POST, 'program', FILTER_SANITIZE_STRING);
            $year = filter_input(INPUT_POST, 'year', FILTER_VALIDATE_INT);
            $sem = filter_input(INPUT_POST, 'semester', FILTER_VALIDATE_INT);
            $div = filter_input(INPUT_POST, 'division', FILTER_SANITIZE_STRING);

            if ($prn && $name && $email ) {
                $db = Database::getConnection();
                $stmt = $db->prepare("INSERT INTO students (prn, name, email, phone, faculty, program, year, semester, division) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
                $stmt->execute([$prn, $name, $email, $phone, $faculty, $program, $year, $sem, $div]);
                $_SESSION['success'] = "Student $name added successfully.";
                header("Location: " . APP_URL . "/admin/students");
                exit;
            }
        }
        require_once __DIR__ . '/../views/admin/add_student.php';
    }
    /**
     * View and handle Edit Student
     */
    public function editStudent() {
        check_role(ROLE_ADMIN);
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        $studentModel = new StudentModel();
        $student = $studentModel->getById($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                ':prn' => strtoupper(filter_input(INPUT_POST, 'prn', FILTER_SANITIZE_STRING)),
                ':name' => filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING),
                ':email' => filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL),
                ':phone' => filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_STRING),
                ':faculty' => filter_input(INPUT_POST, 'faculty', FILTER_SANITIZE_STRING),
                ':program' => filter_input(INPUT_POST, 'program', FILTER_SANITIZE_STRING),
                ':year' => filter_input(INPUT_POST, 'year', FILTER_VALIDATE_INT),
                ':semester' => filter_input(INPUT_POST, 'semester', FILTER_VALIDATE_INT),
                ':division' => filter_input(INPUT_POST, 'division', FILTER_SANITIZE_STRING)
            ];
            $studentModel->update($id, $data);
            $_SESSION['success'] = "Student updated successfully.";
            header("Location: " . APP_URL . "/admin/students");
            exit;
        }
        require_once __DIR__ . '/../views/admin/edit_student.php';
    }

    /**
     * Handle Delete Student
     */
    public function deleteStudent() {
        check_role(ROLE_ADMIN);
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        (new StudentModel())->delete($id);
        $_SESSION['success'] = "Student deleted.";
        header("Location: " . APP_URL . "/admin/students");
        exit;
    }

    /**
     * List all teachers
     */
    public function teachers() {
        check_role(ROLE_ADMIN);
        $db = Database::getConnection();
        $teachers = $db->query("SELECT * FROM users WHERE role = 'teacher' ORDER BY name ASC")->fetchAll();
        require_once __DIR__ . '/../views/admin/teachers.php';
    }

    /**
     * View and handle Add Teacher
     */
    public function addTeacher() {
        check_role(ROLE_ADMIN);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
            $pass = $_POST['password'] ?? 'password'; 

            if ($name && $email) {
                try {
                    $userModel = new UserModel();
                    $userModel->create($name, $email, $pass, ROLE_TEACHER);
                    $_SESSION['success'] = "Teacher $name added successfully.";
                    header("Location: " . APP_URL . "/admin/teachers");
                    exit;
                } catch (Exception $e) {
                    $error = "Failed to add teacher: " . $e->getMessage();
                }
            }
        }
        require_once __DIR__ . '/../views/admin/add_teacher.php';
    }

    /**
     * List all subjects
     */
    public function subjects() {
        check_role(ROLE_ADMIN);
        $db = Database::getConnection();
        $subjects = $db->query("SELECT * FROM subjects ORDER BY code ASC")->fetchAll();
        require_once __DIR__ . '/../views/admin/subjects.php';
    }

    /**
     * Handle Add Subject
     */
    public function addSubject() {
        check_role(ROLE_ADMIN);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
            $code = strtoupper(filter_input(INPUT_POST, 'code', FILTER_SANITIZE_STRING));
            $course = filter_input(INPUT_POST, 'course', FILTER_SANITIZE_STRING);
            $year = filter_input(INPUT_POST, 'year', FILTER_VALIDATE_INT);
            $sem = filter_input(INPUT_POST, 'semester', FILTER_VALIDATE_INT);

            if ($name && $code) {
                $stmt = Database::getConnection()->prepare("INSERT INTO subjects (name, code, course, year, semester) VALUES (?, ?, ?, ?, ?)");
                $stmt->execute([$name, $code, $course, $year, $sem]);
                $_SESSION['success'] = "Subject $name added.";
                header("Location: " . APP_URL . "/admin/subjects");
                exit;
            }
        }
        require_once __DIR__ . '/../views/admin/add_subject.php';
    }

    /**
     * Assign Teacher to Subject
     */
    public function assignTeacher() {
        check_role(ROLE_ADMIN);
        $db = Database::getConnection();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $tid = filter_input(INPUT_POST, 'teacher_id', FILTER_VALIDATE_INT);
            $sid = filter_input(INPUT_POST, 'subject_id', FILTER_VALIDATE_INT);
            if($tid && $sid) {
                $stmt = $db->prepare("INSERT INTO teacher_subjects (teacher_id, subject_id) VALUES (?, ?)");
                try {
                    $stmt->execute([$tid, $sid]);
                    $_SESSION['success'] = "Assignment successful.";
                } catch(Exception $e) { $_SESSION['error'] = "Already assigned."; }
                header("Location: " . APP_URL . "/admin/subjects");
                exit;
            }
        }
        $teachers = $db->query("SELECT id, name FROM users WHERE role = 'teacher'")->fetchAll();
        $subjects = $db->query("SELECT id, name, code FROM subjects")->fetchAll();
        require_once __DIR__ . '/../views/admin/assign_teacher.php';
    }

    /**
     * Assign Students to Subject (Multiple Enrollment)
     */
    public function assignStudent() {
        check_role(ROLE_ADMIN);
        $db = Database::getConnection();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $student_id = filter_input(INPUT_POST, 'student_id', FILTER_VALIDATE_INT);
            $subject_ids = $_POST['subject_ids'] ?? [];
            
            if ($student_id && !empty($subject_ids)) {
                $stmt = $db->prepare("INSERT INTO student_subjects (student_id, subject_id) VALUES (?, ?)");
                $count = 0;
                foreach ($subject_ids as $sid) {
                    try {
                        $stmt->execute([$student_id, $sid]);
                        $count++;
                    } catch(Exception $e) { /* Ignore duplicates */ }
                }
                $_SESSION['success'] = "Student enrolled in $count subjects.";
                header("Location: " . APP_URL . "/admin/subjects");
                exit;
            }
        }
        $subjects = $db->query("SELECT id, name, code FROM subjects ORDER BY name ASC")->fetchAll();
        $students = $db->query("SELECT id, name, prn FROM students ORDER BY name ASC")->fetchAll();
        require_once __DIR__ . '/../views/admin/assign_student.php';
    }

    /**
     * View and handle Edit Teacher
     */
    public function editTeacher() {
        check_role(ROLE_ADMIN);
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT id, name, email FROM users WHERE id = ? AND role = 'teacher'");
        $stmt->execute([$id]);
        $teacher = $stmt->fetch();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
            $password = $_POST['password'];

            if ($password) {
                $hash = password_hash($password, PASSWORD_BCRYPT);
                $stmt = $db->prepare("UPDATE users SET name = ?, email = ?, password = ? WHERE id = ?");
                $stmt->execute([$name, $email, $hash, $id]);
            } else {
                $stmt = $db->prepare("UPDATE users SET name = ?, email = ? WHERE id = ?");
                $stmt->execute([$name, $email, $id]);
            }

            $_SESSION['success'] = "Teacher record updated.";
            header("Location: " . APP_URL . "/admin/teachers");
            exit;
        }
        require_once __DIR__ . '/../views/admin/edit_teacher.php';
    }

    /**
     * View and handle Edit Subject
     */
    public function editSubject() {
        check_role(ROLE_ADMIN);
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT * FROM subjects WHERE id = ?");
        $stmt->execute([$id]);
        $subject = $stmt->fetch();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
            $code = strtoupper(filter_input(INPUT_POST, 'code', FILTER_SANITIZE_STRING));
            $course = filter_input(INPUT_POST, 'course', FILTER_SANITIZE_STRING);
            $year = filter_input(INPUT_POST, 'year', FILTER_VALIDATE_INT);
            $sem = filter_input(INPUT_POST, 'semester', FILTER_VALIDATE_INT);

            $stmt = $db->prepare("UPDATE subjects SET name = ?, code = ?, course = ?, year = ?, semester = ? WHERE id = ?");
            $stmt->execute([$name, $code, $course, $year, $sem, $id]);

            $_SESSION['success'] = "Subject updated successfully.";
            header("Location: " . APP_URL . "/admin/subjects");
            exit;
        }
        require_once __DIR__ . '/../views/admin/edit_subject.php';
    }

    /**
     * Handle Delete Subject
     */
    public function deleteSubject() {
        check_role(ROLE_ADMIN);
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        $db = Database::getConnection();
        $db->prepare("DELETE FROM subjects WHERE id = ?")->execute([$id]);
        $_SESSION['success'] = "Subject deleted.";
        header("Location: " . APP_URL . "/admin/subjects");
        exit;
    }

    /**
     * List students enrolled in a specific subject
     */
    public function subjectStudents() {
        check_role(ROLE_ADMIN);
        $subject_id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        if (!$subject_id) { header("Location: " . APP_URL . "/admin/subjects"); exit; }

        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT * FROM subjects WHERE id = ?");
        $stmt->execute([$subject_id]);
        $subject = $stmt->fetch();

        $stmt = $db->prepare("
            SELECT s.* 
            FROM students s
            JOIN student_subjects ss ON s.id = ss.student_id
            WHERE ss.subject_id = ?
            ORDER BY s.prn ASC
        ");
        $stmt->execute([$subject_id]);
        $students = $stmt->fetchAll();

        // Fetch assigned teachers
        $stmt = $db->prepare("
            SELECT u.id, u.name, u.email 
            FROM users u
            JOIN teacher_subjects ts ON u.id = ts.teacher_id
            WHERE ts.subject_id = ?
        ");
        $stmt->execute([$subject_id]);
        $teachers = $stmt->fetchAll();

        require_once __DIR__ . '/../views/admin/subject_students.php';
    }

    /**
     * Handle unenrollment
     */
    public function unenrollStudent() {
        check_role(ROLE_ADMIN);
        $subject_id = filter_input(INPUT_GET, 'subject_id', FILTER_VALIDATE_INT);
        $student_id = filter_input(INPUT_GET, 'student_id', FILTER_VALIDATE_INT);
        
        if ($subject_id && $student_id) {
            $db = Database::getConnection();
            $stmt = $db->prepare("DELETE FROM student_subjects WHERE student_id = ? AND subject_id = ?");
            $stmt->execute([$student_id, $subject_id]);
            $_SESSION['success'] = "Student de-enrolled from subject.";
        }
        header("Location: " . APP_URL . "/admin/subject-students?id=$subject_id");
        exit;
    }

    /**
     * View global attendance reports
     */
    public function reports() {
        check_role(ROLE_ADMIN);
        $db = Database::getConnection();
        
        // Comprehensive subject-wise stats
        $stmt = $db->query("
            SELECT s.id, s.name, s.code,
                   COUNT(a.id) as total_entries,
                   SUM(CASE WHEN a.status = 'present' THEN 1 ELSE 0 END) as total_present
            FROM subjects s
            LEFT JOIN attendance a ON s.id = a.subject_id
            GROUP BY s.id
            ORDER BY s.code ASC
        ");
        $subjectStats = $stmt->fetchAll();

        require_once __DIR__ . '/../views/admin/reports.php';
    }

    /**
     * Handle Delete Teacher
     */
    public function deleteTeacher() {
        check_role(ROLE_ADMIN);
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        $db = Database::getConnection();
        $db->prepare("DELETE FROM users WHERE id = :id AND role = 'teacher'")->execute([':id' => $id]);
        $_SESSION['success'] = "Teacher removed.";
        header("Location: " . APP_URL . "/admin/teachers");
        exit;
    }

    /**
     * Handle teacher unassignment
     */
    public function unassignTeacher() {
        check_role(ROLE_ADMIN);
        $subject_id = filter_input(INPUT_GET, 'subject_id', FILTER_VALIDATE_INT);
        $teacher_id = filter_input(INPUT_GET, 'teacher_id', FILTER_VALIDATE_INT);
        
        if ($subject_id && $teacher_id) {
            $db = Database::getConnection();
            $stmt = $db->prepare("DELETE FROM teacher_subjects WHERE teacher_id = ? AND subject_id = ?");
            $stmt->execute([$teacher_id, $subject_id]);
            $_SESSION['success'] = "Teacher unassigned from subject.";
        }
        header("Location: " . APP_URL . "/admin/subject-students?id=$subject_id");
        exit;
    }
}
