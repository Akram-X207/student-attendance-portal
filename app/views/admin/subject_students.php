<?php require_once __DIR__ . '/../layouts/header.php'; ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold m-0"><?= htmlspecialchars($subject['name']) ?></h2>
        <span class="text-muted-custom small"><?= htmlspecialchars($subject['code']) ?> - Enrolled Students</span>
    </div>
    <a href="<?= APP_URL ?>/admin/subjects" class="btn btn-sm btn-outline-secondary px-3">Back to Subjects</a>
</div>

<?php if (isset($_SESSION['success'])): ?>
    <div class="alert alert-success py-2 small fw-bold mb-4"><?= $_SESSION['success']; unset($_SESSION['success']); ?></div>
<?php endif; ?>

<div class="card border-0 overflow-hidden">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="bg-secondary bg-opacity-50">
                <tr class="text-muted-custom small text-uppercase fw-bold">
                    <th class="ps-4 py-3">PRN</th>
                    <th class="py-3">Student Name</th>
                    <th class="py-3">Program / Faculty</th>
                    <th class="py-3 text-end pe-4">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($students)): ?>
                    <tr><td colspan="4" class="text-center py-5 text-muted-custom">No students enrolled yet.</td></tr>
                <?php else: ?>
                    <?php foreach ($students as $student): ?>
                        <tr>
                            <td class="ps-4 fw-bold"><?= htmlspecialchars($student['prn']) ?></td>
                            <td class="fw-medium"><?= htmlspecialchars($student['name']) ?></td>
                            <td><?= htmlspecialchars($student['program']) ?> (<?= htmlspecialchars($student['faculty']) ?>)</td>
                            <td class="text-end pe-4">
                                <a href="<?= APP_URL ?>/admin/unenroll-student?subject_id=<?= $subject['id'] ?>&student_id=<?= $student['id'] ?>" 
                                   class="btn btn-sm btn-outline-danger px-3 py-1 fw-bold"
                                   onclick="return confirm('Remove student from this subject?')">
                                   Unenroll <i class="bi bi-person-dash ms-1"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="d-flex justify-content-between align-items-center mt-5 mb-3">
    <h4 class="fw-bold m-0"><i class="bi bi-person-badge text-primary me-2"></i> Assigned Teachers</h4>
    <a href="<?= APP_URL ?>/admin/assign-teacher" class="btn btn-sm btn-primary">Assign New Teacher <i class="bi bi-plus-lg ms-1"></i></a>
</div>

<div class="card border-0 overflow-hidden mb-5">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="bg-secondary bg-opacity-50">
                <tr class="text-muted-custom small text-uppercase fw-bold">
                    <th class="ps-4 py-3">Teacher Name</th>
                    <th class="py-3">Email</th>
                    <th class="py-3 text-end pe-4">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($teachers)): ?>
                    <tr><td colspan="3" class="text-center py-5 text-muted-custom">No teachers assigned to this subject.</td></tr>
                <?php else: ?>
                    <?php foreach ($teachers as $teacher): ?>
                        <tr>
                            <td class="ps-4 fw-bold text-main"><?= htmlspecialchars($teacher['name']) ?></td>
                            <td class="text-muted-custom"><?= htmlspecialchars($teacher['email']) ?></td>
                            <td class="text-end pe-4">
                                <a href="<?= APP_URL ?>/admin/unassign-teacher?subject_id=<?= $subject['id'] ?>&teacher_id=<?= $teacher['id'] ?>" 
                                   class="btn btn-sm btn-outline-danger px-3 py-1 fw-bold"
                                   onclick="return confirm('Unassign teacher from this subject?')">
                                   Unassign <i class="bi bi-x-circle ms-1"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
