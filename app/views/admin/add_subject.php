<?php require_once __DIR__ . '/../layouts/header.php'; ?>
<div class="row justify-content-center mt-5">
    <div class="col-md-6">
        <div class="card p-4">
            <h3 class="fw-bold mb-4">Add New Subject</h3>
            <form action="<?= APP_URL ?>/admin/add-subject" method="POST">
                <div class="mb-3">
                    <label class="form-label small fw-bold">Subject Code</label>
                    <input type="text" name="code" class="form-control text-uppercase" placeholder="e.g. CS302" required>
                </div>
                <div class="mb-3">
                    <label class="form-label small fw-bold">Subject Name</label>
                    <input type="text" name="name" class="form-control" placeholder="e.g. Database Management Systems" required>
                </div>
                <div class="mb-3">
                    <label class="form-label small fw-bold">Course / Department</label>
                    <input type="text" name="course" class="form-control" placeholder="e.g. B.Tech Computer Engineering" required>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label small fw-bold">Academic Year</label>
                        <select name="year" class="form-select">
                            <option value="1">1st Year</option>
                            <option value="2">2nd Year</option>
                            <option value="3">3rd Year</option>
                            <option value="4">4th Year</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label small fw-bold">Semester</label>
                        <select name="semester" class="form-select">
                            <?php for($i=1;$i<=8;$i++) echo "<option value='$i'>Sem $i</option>"; ?>
                        </select>
                    </div>
                </div>
                <div class="d-flex gap-2 mt-2">
                    <button type="submit" class="btn btn-primary px-4 fw-bold">Save Subject</button>
                    <a href="<?= APP_URL ?>/admin/subjects" class="btn btn-light border px-4">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
