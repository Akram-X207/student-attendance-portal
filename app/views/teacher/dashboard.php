<?php require_once __DIR__ . '/../layouts/header.php'; ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold m-0">Teacher Dashboard</h2>
    <span class="badge bg-success py-2 px-3 fw-bold"><i class="bi bi-person-workspace border-end border-white pe-2 me-2 border-opacity-25"></i> Faculty</span>
</div>
<div class="row g-4 mb-4">
    <!-- Stat Cards -->
    <div class="col-md-4">
        <div class="card border-0 p-4 h-100 shadow-sm border-start border-primary border-4">
            <h6 class="text-muted-custom small fw-bold text-uppercase">Assigned Subjects</h6>
            <div class="d-flex align-items-end justify-content-between">
                <span class="display-5 fw-bold"><?= $stats['total_subjects'] ?></span>
                <i class="bi bi-journal-bookmark fs-1 text-primary opacity-25"></i>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 p-4 h-100 shadow-sm border-start border-success border-4">
            <h6 class="text-muted-custom small fw-bold text-uppercase">Enrolled Students</h6>
            <div class="d-flex align-items-end justify-content-between">
                <span class="display-5 fw-bold"><?= $stats['total_students'] ?></span>
                <i class="bi bi-people fs-1 text-success opacity-25"></i>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 p-4 h-100 shadow-sm border-start border-warning border-4">
            <h6 class="text-muted-custom small fw-bold text-uppercase">Last Session Activity</h6>
            <div class="d-flex align-items-start mt-2">
                <i class="bi bi-clock-history fs-3 text-warning me-3"></i>
                <div class="small">
                    <?php if ($stats['last_session']): ?>
                        <div class="fw-bold"><?= htmlspecialchars($stats['last_session']['sub_name']) ?></div>
                        <div class="text-muted-custom"><?= date('j M, h:i A', strtotime($stats['last_session']['date'].' '.$stats['last_session']['attendance_time'])) ?></div>
                    <?php else: ?>
                        <div class="text-muted-custom">No recent activity</div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card border-0 p-4 shadow-sm shadow-sm">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="fw-bold m-0"><i class="bi bi-calendar-check me-2 text-primary"></i>Your Assigned Subjects</h5>
        <span class="text-muted-custom small fw-bold"><i class="bi bi-calendar-event"></i> <?= date('F j, Y') ?></span>
    </div>
    
    <p class="text-muted-custom small mb-4">Select a subject below to manage attendance or view reports.</p>
    
    <div class="list-group">
        <?php if (empty($subjects)): ?>
            <div class="alert alert-info py-4 text-center">
                <i class="bi bi-info-circle fs-3 d-block mb-2"></i>
                No subjects assigned to you yet.
            </div>
        <?php else: ?>
            <?php foreach ($subjects as $subject): ?>
                <a href="<?= APP_URL ?>/teacher/mark?subject_id=<?= $subject['id'] ?>" class="list-group-item list-group-item-action border-0 d-flex justify-content-between align-items-center mb-2 rounded" style="background-color: var(--input-bg); color: var(--text-main); border: 1px solid var(--border-color) !important;">
                    <div>
                        <strong class="d-block fs-5 mb-1"><?= htmlspecialchars($subject['name']) ?></strong>
                        <span class="badge bg-secondary"><?= htmlspecialchars($subject['code']) ?></span>
                        <span class="text-muted-custom small ms-2"><i class="bi bi-people"></i> Year <?= $subject['year'] ?></span>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <a href="<?= APP_URL ?>/teacher/view-report?subject_id=<?= $subject['id'] ?>" class="btn btn-sm btn-outline-info px-3" title="View Detailed Report">
                            <i class="bi bi-eye"></i>
                        </a>
                        <a href="<?= APP_URL ?>/teacher/export-csv?subject_id=<?= $subject['id'] ?>" class="btn btn-sm btn-outline-secondary px-3" title="Export to CSV">
                            <i class="bi bi-download"></i>
                        </a>
                        <a href="<?= APP_URL ?>/teacher/mark?subject_id=<?= $subject['id'] ?>" class="btn btn-sm btn-primary fw-bold px-3">Mark Attendance <i class="bi bi-arrow-right"></i></a>
                    </div>
                </a>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>
<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
