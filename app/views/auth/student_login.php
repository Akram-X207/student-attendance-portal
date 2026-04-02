<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="row justify-content-center mt-5">
    <div class="col-md-5 col-lg-4">
        <div class="card p-4">
            <h3 class="fw-bold mb-4 text-center">Student Portal</h3>
            
            <p class="text-muted-custom text-center small mb-4">Login with your assigned PRN to receive an OTP.</p>

            <?php if (isset($error) && !empty($error)): ?>
                <div class="alert alert-danger py-2 small fw-bold mb-3"><i class="bi bi-exclamation-triangle"></i> <?= htmlspecialchars($error) ?></div>
            <?php endif; ?>
            
            <?php if (isset($success) && !empty($success)): ?>
                <div class="alert alert-success py-2 small fw-bold mb-3"><i class="bi bi-check-circle"></i> <?= htmlspecialchars($success) ?></div>
            <?php endif; ?>

            <form action="<?= APP_URL ?>/student-login" method="POST">
                <div class="mb-3">
                    <label class="form-label text-muted-custom small fw-bold">PRN (Registration Number)</label>
                    <input type="text" name="prn" class="form-control text-uppercase" required placeholder="e.g. CS2022001" 
                           value="<?= htmlspecialchars($_SESSION['pending_prn'] ?? '') ?>" 
                           <?= isset($_SESSION['demo_otp']) ? 'readonly' : '' ?>>
                </div>
                
                <?php if (isset($_SESSION['demo_otp'])): ?>
                    <div class="mb-4" id="otp-group">
                        <label class="form-label text-muted-custom small fw-bold">6-Digit OTP</label>
                        <input type="text" name="otp" class="form-control text-center fs-3 fw-bold" maxlength="6" required placeholder="000000" style="letter-spacing: 0.5rem;">
                        <div class="form-text text-center text-muted-custom small">Enter the 6-digit code shown above.</div>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 fw-bold py-2">Verify & Login <i class="bi bi-shield-check"></i></button>
                    <?php 
                        // Clear pending session for next attempt if they refresh
                        // unset($_SESSION['demo_otp']); 
                        // unset($_SESSION['pending_prn']);
                    ?>
                <?php else: ?>
                    <button type="submit" class="btn btn-primary w-100 fw-bold py-2">Get Login OTP <i class="bi bi-envelope"></i></button>
                <?php endif; ?>
            </form>
            
            <div class="mt-4 text-center">
                <a href="<?= APP_URL ?>" class="text-decoration-none small text-muted-custom"><i class="bi bi-arrow-left"></i> Back to options</a>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
