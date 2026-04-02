<?php require_once __DIR__ . '/../layouts/header.php'; ?>
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card p-4">
            <h3 class="fw-bold mb-4">Edit Student</h3>
            <form action="<?= APP_URL ?>/admin/edit-student?id=<?= $student['id'] ?>" method="POST">
                <div class="mb-3">
                    <label class="form-label small fw-bold">PRN</label>
                    <input type="text" name="prn" class="form-control" value="<?= htmlspecialchars($student['prn']) ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label small fw-bold">Full Name</label>
                    <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($student['name']) ?>" required>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label small fw-bold">College Mail id</label>
                        <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($student['email']) ?>" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label small fw-bold">Contact Number</label>
                        <input type="text" name="phone" class="form-control" value="<?= htmlspecialchars($student['phone'] ?? '') ?>">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label small fw-bold">Faculty</label>
                        <input type="text" name="faculty" class="form-control" value="<?= htmlspecialchars($student['faculty']) ?>">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label small fw-bold">Program</label>
                        <input type="text" name="program" class="form-control" value="<?= htmlspecialchars($student['program']) ?>">
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-md-4 mb-3">
                        <label class="form-label small fw-bold">Year</label>
                        <select name="year" class="form-select">
                            <option value="1" <?= $student['year'] == 1 ? 'selected' : '' ?>>1st Year</option>
                            <option value="2" <?= $student['year'] == 2 ? 'selected' : '' ?>>2nd Year</option>
                            <option value="3" <?= $student['year'] == 3 ? 'selected' : '' ?>>3rd Year</option>
                            <option value="4" <?= $student['year'] == 4 ? 'selected' : '' ?>>4th Year</option>
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label small fw-bold">Semester</label>
                        <select name="semester" class="form-select">
                            <?php for($i=1;$i<=8;$i++) echo "<option value='$i' ".($student['semester'] == $i ? 'selected' : '').">Sem $i</option>"; ?>
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label small fw-bold">Division</label>
                        <input type="text" name="division" class="form-control" value="<?= htmlspecialchars($student['division']) ?>">
                    </div>
                </div>
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary px-4 fw-bold">Update Student</button>
                    <a href="<?= APP_URL ?>/admin/students" class="btn btn-light border px-4">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
