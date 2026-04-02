<?php require_once __DIR__ . '/../layouts/header.php'; ?>
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card p-4">
            <h3 class="fw-bold mb-4">Add New Student</h3>
            <form action="<?= APP_URL ?>/admin/add-student" method="POST">
                <div class="mb-3">
                    <label class="form-label small fw-bold">PRN (Registration Number)</label>
                    <input type="text" name="prn" class="form-control" placeholder="CS2023001" required>
                </div>
                <div class="mb-3">
                    <label class="form-label small fw-bold">Full Name</label>
                    <input type="text" name="name" class="form-control" placeholder="John Doe" required>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label small fw-bold">College Mail id</label>
                        <input type="email" name="email" class="form-control" placeholder="john.cs@college.edu" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label small fw-bold">Contact Number</label>
                        <input type="text" name="phone" class="form-control" placeholder="+91 9876543210">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label small fw-bold">Faculty</label>
                        <input type="text" name="faculty" class="form-control" placeholder="e.g. Faculty of Computer Science (FST)">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label small fw-bold">Program</label>
                        <input type="text" name="program" class="form-control" placeholder="e.g. BTech CSE">
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-md-4 mb-3">
                        <label class="form-label small fw-bold">Year</label>
                        <select name="year" class="form-select">
                            <option value="1">1st Year</option>
                            <option value="2">2nd Year</option>
                            <option value="3">3rd Year</option>
                            <option value="4">4th Year</option>
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label small fw-bold">Semester</label>
                        <select name="semester" class="form-select">
                            <?php for($i=1;$i<=8;$i++) echo "<option value='$i'>Sem $i</option>"; ?>
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label small fw-bold">Division</label>
                        <input type="text" name="division" class="form-control" placeholder="A">
                    </div>
                </div>
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary px-4 fw-bold">Save Student</button>
                    <a href="<?= APP_URL ?>/admin/students" class="btn btn-light border px-4">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
