<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold m-0">Manage Students</h2>
    <div>
        <a href="<?= APP_URL ?>/admin/add-student" class="btn btn-sm btn-primary fw-bold px-3">Add New Student <i class="bi bi-plus-lg"></i></a>
        <a href="<?= APP_URL ?>/admin" class="btn btn-sm btn-outline-secondary ms-2">Dashboard</a>
    </div>
</div>

<div class="card border-0 p-4 mb-4">
    <form action="<?= APP_URL ?>/admin/students" method="GET" class="row g-3">
        <div class="col-md-10">
            <div class="input-group">
                <span class="input-group-text bg-secondary border-0 text-muted-custom"><i class="bi bi-search"></i></span>
                <input type="text" name="q" class="form-control border-0 bg-secondary bg-opacity-10" placeholder="Search by name or PRN..." value="<?= htmlspecialchars($search) ?>">
            </div>
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-primary w-100 fw-bold">Search</button>
        </div>
    </form>
</div>

<div class="card border-0 overflow-hidden">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="bg-secondary bg-opacity-50">
                <tr class="text-muted-custom small text-uppercase fw-bold">
                    <th class="ps-4 py-3">PRN</th>
                    <th class="py-3">Name</th>
                    <th class="py-3">Program / Faculty</th>
                    <th class="py-3">Year / Sem / Div</th>
                    <th class="py-3 text-end pe-4">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($students)): ?>
                    <tr><td colspan="5" class="text-center py-5 text-muted-custom">No students found.</td></tr>
                <?php else: ?>
                    <?php foreach ($students as $student): ?>
                        <tr>
                            <td class="ps-4 fw-bold text-primary"><?= htmlspecialchars($student['prn']) ?></td>
                            <td class="fw-medium">
                                <div><?= htmlspecialchars($student['name']) ?></div>
                                <div class="text-muted-custom x-small"><?= htmlspecialchars($student['email']) ?></div>
                            </td>
                            <td>
                                <div class="small fw-bold"><?= htmlspecialchars($student['program']) ?></div>
                                <div class="text-muted-custom x-small"><?= htmlspecialchars($student['faculty']) ?></div>
                            </td>
                            <td>
                                <span class="badge bg-secondary-subtle text-dark border small">Yr <?= $student['year'] ?></span>
                                <span class="badge bg-info-subtle text-dark border small">Sem <?= $student['semester'] ?></span>
                                <span class="badge bg-light text-dark border small">Div <?= $student['division'] ?></span>
                            </td>
                            <td class="text-end pe-4">
                                <a href="<?= APP_URL ?>/admin/edit-student?id=<?= $student['id'] ?>" class="btn btn-sm btn-light border" title="Edit Student"><i class="bi bi-pencil"></i></a>
                                <a href="<?= APP_URL ?>/admin/delete-student?id=<?= $student['id'] ?>" class="btn btn-sm btn-outline-danger ms-1" title="Delete Student" onclick="return confirm('Delete this student?')"><i class="bi bi-trash"></i></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
