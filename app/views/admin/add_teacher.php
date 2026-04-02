<?php require_once __DIR__ . '/../layouts/header.php'; ?>
<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="card p-4">
            <h3 class="fw-bold mb-4">Add New Teacher</h3>

            <?php if (isset($error)): ?>
                <div class="alert alert-danger small fw-bold py-2 mb-3"><?= $error ?></div>
            <?php endif; ?>

            <form action="<?= APP_URL ?>/admin/add-teacher" method="POST">
                <div class="mb-3">
                    <label class="form-label small fw-bold">Full Name</label>
                    <input type="text" name="name" class="form-control" placeholder="Prof. John Doe" required>
                </div>
                <div class="mb-3">
                    <label class="form-label small fw-bold">College Email</label>
                    <input type="email" name="email" class="form-control" placeholder="john@college.edu" required>
                </div>
                <div class="mb-4">
                    <label class="form-label small fw-bold">Default Password</label>
                    <input type="text" name="password" class="form-control" value="password" required>
                    <div class="form-text small text-muted-custom">Teacher can change this later.</div>
                </div>
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary px-4 fw-bold">Save Teacher</button>
                    <a href="<?= APP_URL ?>/admin" class="btn btn-light border px-4">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
