-- Seed Data based on University Specifications

-- Seed Departments
INSERT INTO departments (name) VALUES ('CSE'), ('FST');

-- Seed Subjects (Assuming department_id 1 is CSE)
INSERT INTO subjects (code, name, course, department_id, year, semester, credits)
VALUES 
('23OGCSB27', 'OPERATING SYSTEMS', 'B.Tech CSE', 1, 3, 6, 3),
('23OGCSB51', 'COMPUTER ALGORITHMS', 'B.Tech CSE', 1, 3, 6, 3),
('23OGCSB66', 'DIGITAL FORENSICS AND INVESTIGATION', 'B.Tech CSE', 1, 3, 6, 3),
('23OUEEB19', 'ENGINEERING ECONOMICS', 'B.Tech CSE', 1, 3, 6, 3),
('23OUENB03', 'SOFT SKILL DEVELOPMENT', 'B.Tech CSE', 1, 3, 6, 3),
('25362YYBW', 'WEB TECHNOLOGY', 'B.Tech CSE', 1, 3, 6, 3);

-- Seed Teachers
-- password is 'password123' (bcrypt)
INSERT INTO users (name, email, password, role)
VALUES 
('Dr. Namdev Suryavanshi', 'namdev.faculty@jspmuni', '$2y$10$qP5rtgFYNRVnw2kEuY.01u4nY1oo6Zdxh/e477yxeu.y6yLITbiVO', 'teacher'),
('Dr. Vishal Patil', 'vishal.faculty@jspmuni', '$2y$10$qP5rtgFYNRVnw2kEuY.01u4nY1oo6Zdxh/e477yxeu.y6yLITbiVO', 'teacher'),
('Mrs. Chaitali Patil', 'chaitali.faculty@jspmuni', '$2y$10$qP5rtgFYNRVnw2kEuY.01u4nY1oo6Zdxh/e477yxeu.y6yLITbiVO', 'teacher'),
('Mrs. Jayshree Shilp', 'jayshree.faculty@jspmuni', '$2y$10$qP5rtgFYNRVnw2kEuY.01u4nY1oo6Zdxh/e477yxeu.y6yLITbiVO', 'teacher'),
('Mrs. Kshitija Potdar', 'kshitija.faculty@jspmuni', '$2y$10$qP5rtgFYNRVnw2kEuY.01u4nY1oo6Zdxh/e477yxeu.y6yLITbiVO', 'teacher'),
('Ms. Sadaf Syed', 'sadaf.faculty@jspmuni', '$2y$10$qP5rtgFYNRVnw2kEuY.01u4nY1oo6Zdxh/e477yxeu.y6yLITbiVO', 'teacher');

-- Assign Subjects to Teachers (Assigning consecutively)
INSERT INTO teacher_subjects (teacher_id, subject_id)
VALUES 
(2, 1), 
(3, 2), 
(4, 3), 
(5, 4), 
(6, 5), 
(7, 6);

-- Seed Students
INSERT INTO students (prn, name, email, course, department, year, division)
VALUES 
('22358010004', 'Shaikh Akram', 'akramakunji23.cs@jspmuni.ac.in', 'B.TECH', 'FST', 3, 'A'),
('22358010005', 'Almel Zeba', 'almelzeba@jspmuni', 'B.Tech', 'CSE', 3, 'A'),
('22358010006', 'Andhare Sumit', 'andharesumit@jspmuni', 'B.Tech', 'CSE', 3, 'A');

-- Enroll Students into Subjects
INSERT INTO student_subjects (student_id, subject_id)
VALUES 
(1, 1), (1, 2), (1, 3), (1, 4), (1, 5), (1, 6),
(2, 1), (2, 2), (2, 3), (2, 4), (2, 5), (2, 6),
(3, 1), (3, 2), (3, 3), (3, 4), (3, 5), (3, 6);
