<?php require_once __DIR__ . '/../layouts/header.php'; ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold m-0 fs-1">Dashboard</h2>
    <span class="badge bg-primary py-2 px-3 fw-bold shadow-sm"><i class="bi bi-person-badge pe-2"></i> Role: Student</span>
</div>
<?php 
$totalAttended = 0;
$totalSessions = 0;
foreach($stats as $s) {
    $totalAttended += $s['attended_sessions'];
    $totalSessions += $s['total_sessions'];
}
$overallPercent = $totalSessions > 0 ? round(($totalAttended / $totalSessions) * 100) : 0;
$statusClass = $overallPercent >= 75 ? 'text-success bg-success' : 'text-danger bg-danger';
$statusText = $overallPercent >= 75 ? 'On Track (>75%)' : 'Below Target (<75%)';
$statusIcon = $overallPercent >= 75 ? 'bi-check-circle-fill' : 'bi-exclamation-circle-fill';
?>
<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="card border-0 p-4 h-100">
            <div class="mb-4 text-start w-100">
                <div class="fw-bold text-primary fs-5 mb-1"><?= htmlspecialchars($student['name']) ?></div>
                <div class="text-muted-custom small mb-3 border-bottom pb-3">PRN: <?= htmlspecialchars($student['prn']) ?></div>
                
                <div class="row g-0 text-center bg-light bg-opacity-50 py-2 rounded mb-3">
                    <div class="col-6 border-end">
                        <div class="x-small text-muted-custom fw-bold">YEAR</div>
                        <div class="small fw-bold"><?= $student['year'] ?><?= ($student['year']==1?'st':($student['year']==2?'nd':($student['year']==3?'rd':'th'))) ?></div>
                    </div>
                    <div class="col-6">
                        <div class="x-small text-muted-custom fw-bold">SEM</div>
                        <div class="small fw-bold"><?= $student['semester'] ?></div>
                    </div>
                </div>
            </div>

            <div class="text-center pt-2">
                <h6 class="text-muted-custom mb-4 fw-bold text-uppercase">Overall Attendance</h6>
                
                <div class="position-relative d-inline-flex align-items-center justify-content-center" style="width: 150px; height: 150px; border-radius: 50%; border: 12px solid <?= $overallPercent >= 75 ? 'var(--accent-color)' : '#ef4444' ?>;">
                    <div class="fs-2 fw-bold"><?= $overallPercent ?><span class="fs-5">%</span></div>
                </div>
                
                <div class="mt-3 text-muted-custom small fw-bold">Total Sessions Attended: <span class="text-primary fs-5"><?= $totalAttended ?></span></div>
                
                <p class="mt-3 small fw-bold <?= $statusClass ?> bg-opacity-10 py-2 px-3 rounded-pill d-inline-block"><i class="bi <?= $statusIcon ?> pe-1"></i> <?= $statusText ?></p>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card border-0 p-4 h-100">
            <h5 class="fw-bold mb-4">Subject Breakdown</h5>
            <div class="table-responsive">
                <table class="table table-borderless table-hover align-middle" style="color: var(--text-main) !important;">
                    <thead style="border-bottom: 2px solid var(--border-color)">
                        <tr class="text-muted-custom small text-uppercase">
                            <th class="pb-3">Subject</th>
                            <th class="pb-3 text-center">Attended</th>
                            <th class="pb-3 text-center">Total</th>
                            <th class="pb-3 text-end">Percentage</th>
                        </tr>
                    </thead>
                    <tbody class="fw-medium">
                        <?php if (empty($stats)): ?>
                            <tr><td colspan="4" class="text-center py-4 text-muted-custom">No subjects enrolled.</td></tr>
                        <?php else: ?>
                            <?php foreach ($stats as $row): 
                                $percent = $row['total_sessions'] > 0 ? round(($row['attended_sessions'] / $row['total_sessions']) * 100) : 0;
                                $badgeClass = $percent >= 75 ? 'bg-success' : ($percent >= 50 ? 'bg-warning' : 'bg-danger');
                            ?>
                                <tr>
                                    <td class="py-3">
                                        <div class="fw-bold"><?= htmlspecialchars($row['name']) ?></div>
                                        <div class="text-muted-custom x-small fw-normal"><?= htmlspecialchars($row['code']) ?></div>
                                    </td>
                                    <td class="py-3 text-center"><?= $row['attended_sessions'] ?></td>
                                    <td class="py-3 text-center"><?= $row['total_sessions'] ?></td>
                                    <td class="py-3 text-end"><span class="badge <?= $badgeClass ?> w-75 py-2"><?= $percent ?>%</span></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-12">
        <div class="card border-0 p-4 shadow-sm">
            <div class="d-flex justify-content-between align-items-center mb-1 flex-wrap gap-3">
                <div>
                    <h5 class="fw-bold m-0"><i class="bi bi-clock-history me-2 text-primary"></i>Attendance History</h5>
                    <div class="mt-2 d-flex gap-3 small fw-bold">
                        <span class="text-success"><i class="bi bi-check-circle-fill me-1"></i>Present: <span id="count-p">0</span></span>
                        <span class="text-danger"><i class="bi bi-x-circle-fill me-1"></i>Absent: <span id="count-a">0</span></span>
                    </div>
                </div>
                <div class="ms-md-auto">
                    <select id="subject-filter" class="form-select form-select-sm border-0 bg-secondary bg-opacity-10 fw-bold px-3 py-2" style="min-width: 200px; border-radius: 8px;">
                        <option value="all">All Subjects</option>
                        <?php foreach($stats as $row): ?>
                            <option value="<?= $row['code'] ?>"><?= htmlspecialchars($row['name']) ?> (<?= $row['code'] ?>)</option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="table-responsive mt-4">
                <table class="table table-hover align-middle border-top">
                    <thead>
                        <tr class="text-muted-custom small text-uppercase fw-bold">
                            <th class="py-3">Subject</th>
                            <th class="py-3">Date</th>
                            <th class="py-3">Time</th>
                            <th class="py-3 text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody id="history-body">
                        <?php if (empty($attendanceRecords)): ?>
                            <tr><td colspan="4" class="text-center py-5 text-muted-custom">No attendance records found.</td></tr>
                        <?php else: ?>
                            <?php foreach ($attendanceRecords as $att): ?>
                                <tr class="att-row" data-subject="<?= $att['code'] ?>" data-status="<?= $att['status'] ?>">
                                    <td class="py-3">
                                        <div class="fw-bold small"><?= htmlspecialchars($att['name']) ?></div>
                                        <div class="x-small text-muted-custom"><?= htmlspecialchars($att['code']) ?></div>
                                    </td>
                                    <td class="py-3 fw-medium"><?= date('d-m-Y', strtotime($att['date'])) ?></td>
                                    <td class="py-3 text-muted-custom small"><?= date('h:i A', strtotime($att['attendance_time'])) ?></td>
                                    <td class="py-3 text-center">
                                        <?php if ($att['status'] == 'present'): ?>
                                            <span class="badge bg-success rounded-pill px-3 py-2">Present</span>
                                        <?php else: ?>
                                            <span class="badge bg-danger rounded-pill px-3 py-2">Absent</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const filter = document.getElementById('subject-filter');
    const rows = document.querySelectorAll('.att-row');
    const countP = document.getElementById('count-p');
    const countA = document.getElementById('count-a');

    const updateCounts = () => {
        let p = 0, a = 0;
        rows.forEach(row => {
            if (row.style.display !== 'none') {
                if (row.dataset.status === 'present') p++;
                else a++;
            }
        });
        countP.innerText = p;
        countA.innerText = a;
    };

    filter.addEventListener('change', function() {
        const selected = this.value;
        rows.forEach(row => {
            if (selected === 'all' || row.dataset.subject === selected) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
        updateCounts();
    });

    updateCounts(); // Initial count
});
</script>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
