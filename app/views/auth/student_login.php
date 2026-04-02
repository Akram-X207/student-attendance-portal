<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="row justify-content-center mt-5">
    <div class="col-md-5 col-lg-4">
        <div class="card p-4 border-0 shadow-sm">

            <div class="text-center mb-4">
                <div class="bg-primary bg-opacity-10 d-inline-flex rounded-circle p-3 mb-3">
                    <i class="bi bi-mortarboard-fill fs-2 text-primary"></i>
                </div>
                <h3 class="fw-bold m-0">Student Portal</h3>
                <p class="text-muted-custom small mt-1">Login with your assigned PRN</p>
            </div>

            <?php if (isset($error) && !empty($error)): ?>
                <div class="alert alert-danger py-2 small fw-bold mb-3 border-0">
                    <i class="bi bi-exclamation-triangle me-1"></i> <?= $error ?>
                </div>
            <?php endif; ?>

            <?php if (isset($success) && !empty($success)): ?>
                <div class="alert alert-success py-2 small fw-bold mb-3 border-0">
                    <i class="bi bi-check-circle me-1"></i> <?= $success ?>
                </div>
            <?php endif; ?>

            <?php 
            // ═══════════════════════════════════════════
            // STEP 1 — Enter PRN
            // ═══════════════════════════════════════════
            if (!isset($found_student) && !isset($otp_sent)): ?>
                <form action="<?= APP_URL ?>/student-login" method="POST">
                    <input type="hidden" name="step" value="find">
                    <div class="mb-4">
                        <label class="form-label text-muted-custom small fw-bold">PRN (Personal Registration Number)</label>
                        <input type="text" name="prn" class="form-control form-control-lg text-uppercase fw-bold text-center"
                               required placeholder="e.g. 22358010004"
                               style="letter-spacing: 0.1rem;">
                        <div class="form-text text-center small mt-2">Enter the PRN assigned by your college.</div>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 fw-bold py-2">
                        Continue <i class="bi bi-arrow-right ms-1"></i>
                    </button>
                </form>

            <?php 
            // ═══════════════════════════════════════════
            // STEP 2 — Choose OTP delivery channel
            // ═══════════════════════════════════════════
            elseif (isset($found_student) && !isset($otp_sent)): 
                $phone = $found_student['phone'] ?? '';
                $email = $found_student['email'] ?? '';
                // Mask phone: show only last 4 digits
                $maskedPhone = $phone ? '+91 ' . str_repeat('*', strlen($phone) - 4) . substr($phone, -4) : null;
                // Mask email
                [$local, $domain] = explode('@', $email);
                $maskedEmail = substr($local, 0, 2) . str_repeat('*', max(2, strlen($local) - 2)) . '@' . $domain;
            ?>
                <div class="mb-4 text-center">
                    <div class="fw-bold"><?= htmlspecialchars($found_student['name']) ?></div>
                    <div class="text-muted-custom x-small">PRN: <?= htmlspecialchars($found_student['prn']) ?></div>
                </div>

                <p class="small text-muted-custom text-center mb-3 fw-bold">Choose where to receive your OTP:</p>

                <form action="<?= APP_URL ?>/student-login" method="POST">
                    <input type="hidden" name="step" value="send">
                    <input type="hidden" name="prn"  value="<?= htmlspecialchars($found_student['prn']) ?>">

                    <!-- Email Option -->
                    <label class="d-block mb-3 cursor-pointer">
                        <div class="border rounded-3 p-3 d-flex align-items-center gap-3 hover-highlight" style="cursor:pointer;" id="email-card">
                            <input type="radio" name="method" value="email" id="method-email" class="form-check-input mt-0 flex-shrink-0" checked>
                            <div class="text-success bg-success bg-opacity-10 rounded-circle p-2 d-flex">
                                <i class="bi bi-envelope-fill fs-5"></i>
                            </div>
                            <div>
                                <div class="fw-bold small">Send to Email</div>
                                <div class="x-small text-muted-custom"><?= $maskedEmail ?></div>
                            </div>
                            <span class="ms-auto badge bg-success rounded-pill small">Real OTP</span>
                        </div>
                    </label>

                    <!-- SMS Option -->
                    <label class="d-block mb-4 cursor-pointer">
                        <div class="border rounded-3 p-3 d-flex align-items-center gap-3" style="cursor:pointer;" id="sms-card">
                            <input type="radio" name="method" value="sms" id="method-sms" class="form-check-input mt-0 flex-shrink-0">
                            <div class="text-primary bg-primary bg-opacity-10 rounded-circle p-2 d-flex">
                                <i class="bi bi-phone-fill fs-5"></i>
                            </div>
                            <div>
                                <div class="fw-bold small">Send to Mobile</div>
                                <div class="x-small text-muted-custom"><?= $maskedPhone ?? 'No phone on record' ?></div>
                            </div>
                            <span class="ms-auto badge bg-warning text-dark rounded-pill small">Demo</span>
                        </div>
                    </label>

                    <button type="submit" class="btn btn-primary w-100 fw-bold py-2">
                        Send OTP <i class="bi bi-send ms-1"></i>
                    </button>
                </form>

                <div class="text-center mt-3">
                    <a href="<?= APP_URL ?>/student-login" class="text-decoration-none small text-muted-custom">
                        <i class="bi bi-arrow-left me-1"></i>Not you? Go back
                    </a>
                </div>

            <?php 
            // ═══════════════════════════════════════════
            // STEP 3 — Enter OTP
            // ═══════════════════════════════════════════
            elseif (isset($otp_sent)): ?>
                <div class="text-center mb-4">
                    <i class="bi bi-shield-lock fs-1 text-primary"></i>
                    <p class="small text-muted-custom mt-2">Enter the 6-digit OTP sent to your 
                        <?= (isset($_SESSION['otp_method']) && $_SESSION['otp_method'] === 'email') ? 'email' : 'phone' ?>.
                    </p>
                </div>

                <form action="<?= APP_URL ?>/student-login" method="POST">
                    <input type="hidden" name="step" value="verify">
                    <input type="hidden" name="prn"  value="<?= htmlspecialchars($found_student['prn']) ?>">

                    <div class="mb-4">
                        <label class="form-label text-muted-custom small fw-bold text-center w-100">6-Digit OTP</label>
                        <input type="text" name="otp" 
                               class="form-control form-control-lg text-center fw-bold fs-3"
                               maxlength="6" required placeholder="• • • • • •"
                               autofocus inputmode="numeric"
                               style="letter-spacing: 0.8rem; border-radius: 12px;">
                    </div>

                    <button type="submit" class="btn btn-primary w-100 fw-bold py-2">
                        Verify & Login <i class="bi bi-shield-check ms-1"></i>
                    </button>
                </form>

                <div class="text-center mt-3">
                    <a href="<?= APP_URL ?>/student-login" class="text-decoration-none small text-muted-custom">
                        <i class="bi bi-arrow-left me-1"></i>Start over
                    </a>
                </div>

            <?php endif; ?>

            <div class="mt-4 pt-3 border-top text-center">
                <a href="<?= APP_URL ?>" class="text-decoration-none small text-muted-custom">
                    <i class="bi bi-arrow-left me-1"></i>Back to main portal
                </a>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
