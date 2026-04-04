-- ============================================================
-- STUDENT ATTENDANCE PORTAL — DATABASE SCHEMA
-- Engine: MySQL 8+  |  Charset: utf8mb4
-- ============================================================

-- Database is assumed to be created externally (e.g. via cPanel)

-- ------------------------------------------------------------
-- TABLE: users  (Admin + Teacher accounts)
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS users (
    id          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name        VARCHAR(120)        NOT NULL,
    email       VARCHAR(180)        NOT NULL UNIQUE,
    password    VARCHAR(255)        NOT NULL,          -- bcrypt hash
    role        ENUM('admin','teacher') NOT NULL,
    is_active   TINYINT(1)          NOT NULL DEFAULT 1,
    created_at  TIMESTAMP           NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at  TIMESTAMP           NOT NULL DEFAULT CURRENT_TIMESTAMP
                    ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ------------------------------------------------------------
-- TABLE: students
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS students (
    id              INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    prn             VARCHAR(20)     NOT NULL UNIQUE,
    name            VARCHAR(120)    NOT NULL,
    email           VARCHAR(180)    NOT NULL UNIQUE,
    phone           VARCHAR(20)     NULL,              -- contact number
    program         VARCHAR(100)    NOT NULL,          -- e.g. B.Tech
    faculty         VARCHAR(100)    NOT NULL,          -- e.g. CSE / FST
    year            TINYINT UNSIGNED NOT NULL,         -- 3rd Year
    semester        TINYINT UNSIGNED NOT NULL DEFAULT 1, -- Sem 6
    division        VARCHAR(10),                       -- Div A
    is_active       TINYINT(1)      NOT NULL DEFAULT 1,
    created_at      TIMESTAMP       NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ------------------------------------------------------------
-- TABLE: departments  (lookup)
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS departments (
    id    SMALLINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name  VARCHAR(100) NOT NULL UNIQUE
) ENGINE=InnoDB;

-- ------------------------------------------------------------
-- TABLE: subjects
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS subjects (
    id              INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    code            VARCHAR(20)         NOT NULL UNIQUE, -- e.g. CS301
    name            VARCHAR(120)        NOT NULL,
    course          VARCHAR(100)        NULL,            -- e.g. B.Tech Computer Engineering
    department_id   SMALLINT UNSIGNED   NULL,
    year            TINYINT UNSIGNED    NOT NULL,
    semester        TINYINT UNSIGNED    NOT NULL,
    credits         TINYINT UNSIGNED    NOT NULL DEFAULT 3,
    created_at      TIMESTAMP           NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ------------------------------------------------------------
-- TABLE: teacher_subjects  (many-to-many: teacher <-> subject)
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS teacher_subjects (
    id          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    teacher_id  INT UNSIGNED        NOT NULL,
    subject_id  INT UNSIGNED        NOT NULL,
    assigned_at TIMESTAMP           NOT NULL DEFAULT CURRENT_TIMESTAMP,

    UNIQUE KEY uq_teacher_subject (teacher_id, subject_id),
    FOREIGN KEY (teacher_id)  REFERENCES users(id)     ON DELETE CASCADE,
    FOREIGN KEY (subject_id)  REFERENCES subjects(id)  ON DELETE CASCADE
) ENGINE=InnoDB;

-- ------------------------------------------------------------
-- TABLE: student_subjects  (many-to-many: student <-> subject)
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS student_subjects (
    id          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    student_id  INT UNSIGNED        NOT NULL,
    subject_id  INT UNSIGNED        NOT NULL,
    enrolled_at TIMESTAMP           NOT NULL DEFAULT CURRENT_TIMESTAMP,

    UNIQUE KEY uq_student_subject (student_id, subject_id),
    FOREIGN KEY (student_id) REFERENCES students(id)  ON DELETE CASCADE,
    FOREIGN KEY (subject_id) REFERENCES subjects(id)  ON DELETE CASCADE
) ENGINE=InnoDB;

-- ------------------------------------------------------------
-- TABLE: attendance
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS attendance (
    id          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    student_id  INT UNSIGNED        NOT NULL,
    subject_id  INT UNSIGNED        NOT NULL,
    teacher_id  INT UNSIGNED        NOT NULL,  -- who marked it
    date        DATE                NOT NULL,
    attendance_time TIME            NOT NULL DEFAULT '00:00:00',
    status      ENUM('present','absent','late','excused')
                                    NOT NULL DEFAULT 'absent',
    remarks     VARCHAR(255),
    marked_at   TIMESTAMP           NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at  TIMESTAMP           NOT NULL DEFAULT CURRENT_TIMESTAMP
                    ON UPDATE CURRENT_TIMESTAMP,

    -- One record per student per subject per session
    UNIQUE KEY uq_attendance (student_id, subject_id, date, attendance_time),

    FOREIGN KEY (student_id) REFERENCES students(id) ON DELETE CASCADE,
    FOREIGN KEY (subject_id) REFERENCES subjects(id) ON DELETE RESTRICT,
    FOREIGN KEY (teacher_id) REFERENCES users(id)    ON DELETE RESTRICT
) ENGINE=InnoDB;

-- ------------------------------------------------------------
-- TABLE: otp_tokens  (student login)
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS otp_tokens (
    id          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    student_id  INT UNSIGNED        NOT NULL,
    token       CHAR(6)             NOT NULL,          -- 6-digit OTP
    expires_at  TIMESTAMP           NOT NULL,          -- NOW() + 10 minutes
    used        TINYINT(1)          NOT NULL DEFAULT 0,
    created_at  TIMESTAMP           NOT NULL DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (student_id) REFERENCES students(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- ============================================================
-- INDEXES for common queries
-- ============================================================
CREATE INDEX idx_attendance_date       ON attendance (date);
CREATE INDEX idx_attendance_subject    ON attendance (subject_id);
CREATE INDEX idx_attendance_student    ON attendance (student_id);
CREATE INDEX idx_otp_expires           ON otp_tokens (expires_at);

-- ============================================================
-- INITIAL DATA SEED (Default Admin Password: password)
-- ============================================================
INSERT INTO users (name, email, password, role)
VALUES ('Super Admin', 'admin@attendance.local', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin')
ON DUPLICATE KEY UPDATE name=name;
