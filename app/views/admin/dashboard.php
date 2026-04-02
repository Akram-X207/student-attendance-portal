<?php require_once __DIR__ . '/../layouts/header.php'; ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold m-0">Admin Dashboard</h2>
    <span class="badge bg-warning text-dark py-2 px-3 fw-bold"><i class="bi bi-shield-lock border-end border-dark pe-2 me-2 border-opacity-25"></i> Administration</span>
</div>
<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="card p-3 border-0 border-start border-4 border-primary">
            <div class="text-muted-custom small fw-bold text-uppercase">Total Students</div>
            <div class="fs-2 fw-bold"><?= $stats['students'] ?></div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card p-3 border-0 border-start border-4 border-success">
             <div class="text-muted-custom small fw-bold text-uppercase">Total Teachers</div>
             <div class="fs-2 fw-bold"><?= $stats['teachers'] ?></div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card p-3 border-0 border-start border-4 border-info">
             <div class="text-muted-custom small fw-bold text-uppercase">Total Subjects</div>
             <div class="fs-2 fw-bold"><?= $stats['subjects'] ?></div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card p-3 border-0 border-start border-4 border-warning">
             <div class="text-muted-custom small fw-bold text-uppercase">Today's Sessions</div>
             <div class="fs-2 fw-bold"><?= $stats['sessions'] ?></div>
        </div>
    </div>
</div>
<div class="card border-0 p-4">
    <h5 class="fw-bold mb-3">Quick Actions</h5>
    <div class="d-flex flex-wrap gap-2">
        <a href="<?= APP_URL ?>/admin/students" class="btn btn-outline-secondary"><i class="bi bi-people pe-2"></i> Manage Students</a>
        <a href="<?= APP_URL ?>/admin/teachers" class="btn btn-outline-secondary"><i class="bi bi-person-workspace pe-2"></i> Manage Teachers</a>
        <a href="<?= APP_URL ?>/admin/subjects" class="btn btn-outline-secondary"><i class="bi bi-book pe-2"></i> Manage Subjects</a>
        <a href="<?= APP_URL ?>/admin/reports" class="btn btn-outline-primary ms-auto"><i class="bi bi-file-earmark-bar-graph pe-2"></i> View Reports</a>
    </div>
</div>
<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
