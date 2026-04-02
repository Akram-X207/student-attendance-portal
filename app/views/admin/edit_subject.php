<?php require_once __DIR__ . '/../layouts/header.php'; ?>
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card p-4">
            <h3 class="fw-bold mb-4">Edit Subject</h3>
            <form action="<?= APP_URL ?>/admin/edit-subject?id=<?= $subject['id'] ?>" method="POST">
                <div class="mb-3">
                    <label class="form-label small fw-bold">Subject Code</label>
                    <input type="text" name="code" class="form-control text-uppercase" value="<?= htmlspecialchars($subject['code']) ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label small fw-bold">Subject Name</label>
                    <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($subject['name']) ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label small fw-bold">Course / Department</label>
                    <input type="text" name="course" class="form-control" value="<?= htmlspecialchars($subject['course']) ?>" required>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label small fw-bold">Academic Year</label>
                        <select name="year" class="form-select">
                            <option value="1" <?= $subject['year'] == 1 ? 'selected' : '' ?>>1st Year</option>
                            <option value="2" <?= $subject['year'] == 2 ? 'selected' : '' ?>>2nd Year</option>
                            <option value="3" <?= $subject['year'] == 3 ? 'selected' : '' ?>>3rd Year</option>
                            <option value="4" <?= $subject['year'] == 4 ? 'selected' : '' ?>>4th Year</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label small fw-bold">Semester</label>
                        <select name="semester" class="form-select">
                            <?php for($i=1;$i<=8;$i++) echo "<option value='$i' ".($subject['semester'] == $i ? 'selected' : '').">Sem $i</option>"; ?>
                        </select>
                    </div>
                </div>
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary px-4 fw-bold">Update Subject</button>
                    <a href="<?= APP_URL ?>/admin/subjects" class="btn btn-light border px-4">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
