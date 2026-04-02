<?php require_once __DIR__ . '/../layouts/header.php'; ?>
<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="card p-4">
            <h3 class="fw-bold mb-4">Enroll Student to Subject</h3>
            <form action="<?= APP_URL ?>/admin/assign-student" method="POST">
                <div class="mb-3">
                    <label class="form-label small fw-bold">Select Student</label>
                    <select name="student_id" class="form-select" required>
                        <option value="">Choose a student...</option>
                        <?php foreach($students as $student): ?>
                            <option value="<?= $student['id'] ?>"><?= htmlspecialchars($student['name']) ?> (<?= htmlspecialchars($student['prn']) ?>)</option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-4">
                    <label class="form-label small fw-bold">Select Subjects (Hold Ctrl to select multiple)</label>
                    <select name="subject_ids[]" class="form-select" multiple size="8" required>
                        <?php foreach($subjects as $subject): ?>
                            <option value="<?= $subject['id'] ?>"><?= htmlspecialchars($subject['name']) ?> (<?= htmlspecialchars($subject['code']) ?>)</option>
                        <?php endforeach; ?>
                    </select>
                    <div class="form-text x-small">You can pick multiple subjects at once.</div>
                </div>
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary px-4 fw-bold">Confirm Enrollment <i class="bi bi-shield-check"></i></button>
                    <a href="<?= APP_URL ?>/admin/subjects" class="btn btn-light border px-4">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
