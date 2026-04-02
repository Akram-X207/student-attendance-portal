USE attendance_portal;

-- Seed Departments
INSERT INTO departments (name) VALUES ('Computer Engineering'), ('IT'), ('Electronics');

-- Seed Subjects (assuming Computer Engineering department_id = 1)
INSERT INTO subjects (code, name, department_id, year, semester, credits)
VALUES 
('CS301', 'Database Management Systems', 1, 3, 5, 4),
('CS302', 'Software Engineering', 1, 3, 5, 3),
('CS303', 'Operating Systems', 1, 3, 5, 4);

-- Seed Teachers
-- password is 'password' (bcrypt)
INSERT INTO users (name, email, password, role)
VALUES 
('Prof. John Doe', 'john@college.edu', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'teacher'),
('Prof. Jane Smith', 'jane@college.edu', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'teacher');

-- Assign Subjects to Teachers (Teacher IDs 2 and 3)
INSERT INTO teacher_subjects (teacher_id, subject_id)
VALUES (2, 1), (2, 2), (3, 3);

-- Seed Students
INSERT INTO students (prn, name, email, course, department, year, division)
VALUES 
('CS2022001', 'Alice Johnson', 'alice@student.test', 'B.E.', 'Computer Engineering', 3, 'A'),
('CS2022002', 'Bob Smith', 'bob@student.test', 'B.E.', 'Computer Engineering', 3, 'A'),
('CS2022003', 'Charlie Brown', 'charlie@student.test', 'B.E.', 'Computer Engineering', 3, 'A');

-- Enroll Students into Subjects (assuming Alice, Bob, Charlie IDs 1, 2, 3 and DBMS ID 1)
INSERT INTO student_subjects (student_id, subject_id)
VALUES 
(1, 1), (1, 2), (1, 3),
(2, 1), (2, 2), (2, 3),
(3, 1), (3, 2), (3, 3);
