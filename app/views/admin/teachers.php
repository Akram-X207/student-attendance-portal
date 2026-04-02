<?php require_once __DIR__ . '/../layouts/header.php'; ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold m-0">Manage Teachers</h2>
    <div>
        <a href="<?= APP_URL ?>/admin/add-teacher" class="btn btn-primary btn-sm fw-bold px-3">Add New Teacher <i class="bi bi-plus-lg"></i></a>
        <a href="<?= APP_URL ?>/admin" class="btn btn-sm btn-outline-secondary ms-2">Dashboard</a>
    </div>
</div>

<?php if (isset($_SESSION['success'])): ?>
    <div class="alert alert-success alert-dismissible fade show py-2 small fw-bold mb-4" role="alert">
        <?= $_SESSION['success']; unset($_SESSION['success']); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<div class="card border-0 overflow-hidden">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="bg-secondary bg-opacity-50">
                <tr class="text-muted-custom small text-uppercase fw-bold">
                    <th class="ps-4 py-3">Teacher Name</th>
                    <th class="py-3">Email Address</th>
                    <th class="py-3">Status</th>
                    <th class="py-3 text-end pe-4">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($teachers)): ?>
                    <tr><td colspan="4" class="text-center py-5 text-muted-custom">No teachers found.</td></tr>
                <?php else: ?>
                    <?php foreach ($teachers as $teacher): ?>
                        <tr>
                            <td class="ps-4 fw-bold"><?= htmlspecialchars($teacher['name']) ?></td>
                            <td><?= htmlspecialchars($teacher['email']) ?></td>
                            <td><span class="badge bg-success">Active</span></td>
                            <td class="text-end pe-4">
                                <a href="<?= APP_URL ?>/admin/edit-teacher?id=<?= $teacher['id'] ?>" class="btn btn-sm btn-outline-secondary me-1"><i class="bi bi-pencil"></i></a>
                                <a href="<?= APP_URL ?>/admin/delete-teacher?id=<?= $teacher['id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to remove this teacher?')"><i class="bi bi-trash"></i></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
