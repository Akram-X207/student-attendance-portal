<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="row justify-content-center mt-5">
    <div class="col-md-5 col-lg-4">
        <div class="card p-4">
            <h3 class="fw-bold mb-4 text-center">Faculty / Admin Login</h3>
            
            <?php if (isset($error) && !empty($error)): ?>
                <div class="alert alert-danger py-2 small fw-bold"><i class="bi bi-exclamation-triangle"></i> <?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <form action="<?= APP_URL ?>/login" method="POST">
                <div class="mb-3">
                    <label class="form-label text-muted-custom small fw-bold">Email Address</label>
                    <input type="email" name="email" class="form-control" required placeholder="name@college.edu">
                </div>
                <div class="mb-4">
                    <label class="form-label text-muted-custom small fw-bold">Password</label>
                    <input type="password" name="password" class="form-control" required placeholder="••••••••">
                </div>
                <button type="submit" class="btn btn-primary w-100 fw-bold">Sign In <i class="bi bi-arrow-right"></i></button>
            </form>
            <div class="mt-4 text-center">
                <a href="<?= APP_URL ?>" class="text-decoration-none small text-muted-custom"><i class="bi bi-arrow-left"></i> Back to options</a>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
