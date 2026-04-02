<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb m-0 bg-transparent p-0 small">
        <li class="breadcrumb-item"><a href="<?= APP_URL ?>/teacher" class="text-decoration-none">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">Mark Attendance</li>
      </ol>
    </nav>
    <div class="small text-muted-custom fw-bold"><i class="bi bi-calendar"></i> <?= date('F j, Y') ?></div>
</div>

<div class="card border-0 p-4 mb-4">
    <div class="row align-items-center">
        <div class="col-md-5">
            <h3 class="fw-bold m-0"><?= htmlspecialchars($subject['name']) ?></h3>
            <p class="text-muted-custom small mb-0 mt-1"><?= htmlspecialchars($subject['code']) ?> | Year <?= $subject['year'] ?> | Sem <?= $subject['semester'] ?></p>
        </div>
        <div class="col-md-7 text-md-end mt-3 mt-md-0 d-flex justify-content-md-end align-items-center gap-2">
            <div class="input-group input-group-sm w-auto d-inline-flex border rounded overflow-hidden">
                <span class="input-group-text bg-secondary border-0 small fw-bold">Date</span>
                <input type="date" id="attendance-date" class="form-control form-control-sm border-0" value="<?= $date ?>" style="max-width:140px;">
            </div>
            <?php 
                $timeParts = explode(':', $time);
                $hour24 = (int)$timeParts[0];
                $minute = $timeParts[1];
                $ampm = $hour24 >= 12 ? 'PM' : 'AM';
                $hour12 = $hour24 % 12;
                if ($hour12 === 0) $hour12 = 12;
            ?>
            <div class="d-inline-flex align-items-center bg-secondary bg-opacity-10 border rounded px-2 ms-3">
                <span class="x-small fw-bold text-muted-custom me-2 text-uppercase">Time</span>
                <select id="h12" class="form-select form-select-sm border-0 bg-transparent fw-bold" style="width: 60px; box-shadow: none;">
                    <?php for($i=1;$i<=12;$i++) echo "<option value='$i' ".($i==$hour12?'selected':'').">$i</option>"; ?>
                </select>
                <span class="fw-bold fs-5 mb-1">:</span>
                <select id="m12" class="form-select form-select-sm border-0 bg-transparent fw-bold" style="width: 65px; box-shadow: none;">
                    <?php for($i=0;$i<=59;$i++) { 
                        $m = str_pad($i, 2, '0', STR_PAD_LEFT);
                        echo "<option value='$m' ".($m==$minute?'selected':'').">$m</option>";
                    } ?>
                </select>
                <select id="ampm" class="form-select form-select-sm border-0 bg-transparent fw-bold text-primary" style="width: 70px; box-shadow: none;">
                    <option value="AM" <?= $ampm=='AM'?'selected':'' ?>>AM</option>
                    <option value="PM" <?= $ampm=='PM'?'selected':'' ?>>PM</option>
                </select>
            </div>
            <button id="save-attendance" class="btn btn-primary btn-sm fw-bold px-3">Save Changes <i class="bi bi-check2-circle"></i></button>
        </div>
    </div>
</div>

<div class="card border-0 overflow-hidden">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="bg-secondary bg-opacity-50">
                <tr class="text-muted-custom small text-uppercase fw-bold">
                    <th class="ps-4 py-3" style="width: 150px;">PRN</th>
                    <th class="py-3">Student Name</th>
                    <th class="py-3 text-center" style="width: 150px;">Status</th>
                    <th class="py-3 pe-4">Remarks</th>
                </tr>
            </thead>
            <tbody id="attendance-list">
                <?php if (empty($students)): ?>
                    <tr><td colspan="4" class="text-center py-5 text-muted-custom">No students enrolled for this subject.</td></tr>
                <?php else: ?>
                        <?php foreach ($students as $student): 
                            $saved = $attendanceMap[$student['id']] ?? null;
                            $status = $saved['status'] ?? 'present';
                            $remarks = $saved['remarks'] ?? '';
                        ?>
                        <tr class="student-row" data-id="<?= $student['id'] ?>">
                            <td class="ps-4 fw-bold"><?= htmlspecialchars($student['prn']) ?></td>
                            <td class="fw-medium"><?= htmlspecialchars($student['name']) ?></td>
                            <td class="text-center">
                                <div class="btn-group btn-group-sm" role="group">
                                    <input type="radio" class="btn-check" name="status_<?= $student['id'] ?>" id="p_<?= $student['id'] ?>" value="present" <?= $status == 'present' ? 'checked' : '' ?> autocomplete="off">
                                    <label class="btn btn-outline-success px-3 fw-bold" for="p_<?= $student['id'] ?>">P</label>
                                    
                                    <input type="radio" class="btn-check" name="status_<?= $student['id'] ?>" id="a_<?= $student['id'] ?>" value="absent" <?= $status == 'absent' ? 'checked' : '' ?> autocomplete="off">
                                    <label class="btn btn-outline-danger px-3 fw-bold" for="a_<?= $student['id'] ?>">A</label>
                                </div>
                            </td>
                            <td class="pe-4">
                                <input type="text" class="form-control form-control-sm border-0 bg-secondary bg-opacity-10 remark-input" placeholder="Notes (optional)" value="<?= htmlspecialchars($remarks) ?>">
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Scripts for Attendance Phase 4 -->
<script>
// Helper to get 24h time string from 12h selects
const get24hTime = () => {
    let h = parseInt(document.getElementById('h12').value);
    const m = document.getElementById('m12').value;
    const ampm = document.getElementById('ampm').value;
    if (ampm === 'PM' && h < 12) h += 12;
    if (ampm === 'AM' && h === 12) h = 0;
    return `${h.toString().padStart(2, '0')}:${m}`;
};

// Reload page when date or time changes to load existing data
const reloadWithParams = () => {
    const d = document.getElementById('attendance-date').value;
    const t = get24hTime();
    window.location.href = `<?= APP_URL ?>/teacher/mark?subject_id=<?= $subject_id ?>&date=${d}&time=${t}`;
};

document.getElementById('attendance-date').addEventListener('change', reloadWithParams);
document.getElementById('h12').addEventListener('change', reloadWithParams);
document.getElementById('m12').addEventListener('change', reloadWithParams);
document.getElementById('ampm').addEventListener('change', reloadWithParams);

document.getElementById('save-attendance').addEventListener('click', async () => {
    const date = document.getElementById('attendance-date').value;
    const time = get24hTime();
    const subjectId = <?= $subject_id ?>;
    const rows = document.querySelectorAll('.student-row');
    const records = [];

    rows.forEach(row => {
        const studentId = row.dataset.id;
        const status = row.querySelector('input[name="status_' + studentId + '"]:checked').value;
        const remarks = row.querySelector('.remark-input').value;
        records.push({ student_id: studentId, status: status, remarks: remarks });
    });

    const btn = document.getElementById('save-attendance');
    btn.disabled = true;
    btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Saving...';

    try {
        const res = await fetch('<?= APP_URL ?>/api/mark', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ date, time, subject_id: subjectId, records })
        });
        const data = await res.json();
        
        if (data.status === 'success') {
            alert('Attendance saved successfully!');
        } else {
            alert('Error: ' + data.message);
        }
    } catch (err) {
        alert('Failed to connect to the server.');
    } finally {
        btn.disabled = false;
        btn.innerHTML = 'Save Changes <i class="bi bi-check2-circle"></i>';
    }
});
</script>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
