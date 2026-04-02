<?php require_once __DIR__ . '/../layouts/header.php'; ?>
<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="card p-4">
            <h3 class="fw-bold mb-4">Assign Teacher to Subject</h3>
            <form action="<?= APP_URL ?>/admin/assign-teacher" method="POST">
                <div class="mb-3">
                    <label class="form-label small fw-bold">Select Teacher</label>
                    <select name="teacher_id" class="form-select" required>
                        <option value="">Choose a teacher...</option>
                        <?php foreach($teachers as $teacher): ?>
                            <option value="<?= $teacher['id'] ?>"><?= htmlspecialchars($teacher['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-4">
                    <label class="form-label small fw-bold">Select Subject</label>
                    <select name="subject_id" class="form-select" required>
                        <option value="">Choose a subject...</option>
                        <?php foreach($subjects as $subject): ?>
                            <option value="<?= $subject['id'] ?>"><?= htmlspecialchars($subject['name']) ?> (<?= htmlspecialchars($subject['code']) ?>)</option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary px-4 fw-bold">Confirm Assignment <i class="bi bi-shield-check"></i></button>
                    <a href="<?= APP_URL ?>/admin/subjects" class="btn btn-light border px-4">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
