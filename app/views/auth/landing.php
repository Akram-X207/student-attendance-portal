<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="landing-container py-5">
    <div class="text-center w-100">
        <h1 class="display-5 fw-bold mb-3">Attendance Made Simple</h1>
        <p class="lead text-muted-custom mb-5">Select your portal to continue.</p>

        <div class="row justify-content-center g-4 mx-auto" style="max-width: 900px;">
            
            <div class="col-md-5">
                <a href="<?= APP_URL ?>/student-login" class="card role-card h-100 text-center p-4">
                    <div class="card-body">
                        <i class="bi bi-person-badge fs-1 mb-3 text-primary"></i>
                        <h4 class="card-title fw-bold">Student</h4>
                        <p class="card-text text-muted-custom small">View your individual attendance and subject performance summary.</p>
                    </div>
                </a>
            </div>

            <div class="col-md-5">
                <a href="<?= APP_URL ?>/login" class="card role-card h-100 text-center p-4">
                    <div class="card-body">
                        <i class="bi bi-briefcase fs-1 mb-3 text-success"></i>
                        <h4 class="card-title fw-bold">Faculty</h4>
                        <p class="card-text text-muted-custom small">Official portal for Teachers and Administrators to manage academic records.</p>
                    </div>
                </a>
            </div>

        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
