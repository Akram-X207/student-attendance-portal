<?php require_once __DIR__ . '/../layouts/header.php'; ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold m-0">Manage Subjects</h2>
    <div>
        <a href="<?= APP_URL ?>/admin/add-subject" class="btn btn-sm btn-primary fw-bold px-3">Add New Subject <i class="bi bi-plus-lg"></i></a>
        <a href="<?= APP_URL ?>/admin" class="btn btn-sm btn-outline-secondary ms-2">Dashboard</a>
    </div>
</div>

<?php if (isset($_SESSION['success'])): ?>
    <div class="alert alert-success py-2 small fw-bold mb-4"><?= $_SESSION['success']; unset($_SESSION['success']); ?></div>
<?php endif; ?>

<div class="card border-0 p-4 mb-4">
    <h5 class="fw-bold mb-3">Quick Assignments</h5>
    <div class="d-flex gap-2">
        <a href="<?= APP_URL ?>/admin/assign-teacher" class="btn btn-outline-secondary btn-sm"><i class="bi bi-person-badge"></i> Assign Teacher to Subject</a>
        <a href="<?= APP_URL ?>/admin/assign-student" class="btn btn-outline-secondary btn-sm"><i class="bi bi-person-plus"></i> Enroll Student to Subject</a>
    </div>
</div>

<div class="card border-0 overflow-hidden">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="bg-secondary bg-opacity-50">
                <tr class="text-muted-custom small text-uppercase fw-bold">
                    <th class="ps-4 py-3">Code</th>
                    <th class="py-3">Subject Name</th>
                    <th class="py-3">Course / Year</th>
                    <th class="py-3">Sem</th>
                    <th class="py-3 text-end pe-4">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($subjects)): ?>
                    <tr><td colspan="5" class="text-center py-5 text-muted-custom">No subjects found.</td></tr>
                <?php else: ?>
                    <?php foreach ($subjects as $subject): ?>
                        <tr>
                            <td class="ps-4 fw-bold text-primary"><?= htmlspecialchars($subject['code']) ?></td>
                            <td class="fw-medium"><?= htmlspecialchars($subject['name']) ?></td>
                            <td><?= htmlspecialchars($subject['course']) ?> (Yr <?= $subject['year'] ?>)</td>
                            <td>Sem <?= $subject['semester'] ?></td>
                            <td class="text-end pe-4">
                                <a href="<?= APP_URL ?>/admin/subject-students?id=<?= $subject['id'] ?>" class="btn btn-sm btn-outline-primary me-1" title="View Enrolled Students"><i class="bi bi-people"></i></a>
                                <a href="<?= APP_URL ?>/admin/edit-subject?id=<?= $subject['id'] ?>" class="btn btn-sm btn-outline-secondary me-1"><i class="bi bi-pencil"></i></a>
                                <a href="<?= APP_URL ?>/admin/delete-subject?id=<?= $subject['id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this subject?')"><i class="bi bi-trash"></i></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
