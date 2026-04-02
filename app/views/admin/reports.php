<?php require_once __DIR__ . '/../layouts/header.php'; ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold m-0">Attendance Reports</h2>
    <a href="<?= APP_URL ?>/admin" class="btn btn-sm btn-outline-secondary">Dashboard</a>
</div>

<div class="row g-4 mb-5">
    <?php foreach ($subjectStats as $stat): 
        $percent = $stat['total_entries'] > 0 ? round(($stat['total_present'] / $stat['total_entries']) * 100) : 0;
        $color = $percent >= 75 ? 'success' : 'danger';
    ?>
    <div class="col-md-4">
        <div class="card p-4 border-0 h-100">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <h5 class="fw-bold mb-1"><?= htmlspecialchars($stat['code']) ?></h5>
                    <p class="text-muted-custom small mb-0"><?= htmlspecialchars($stat['name']) ?></p>
                </div>
                <span class="badge bg-<?= $color ?> bg-opacity-10 text-<?= $color ?> border border-<?= $color ?> px-2 py-1"><?= $percent ?>% Avg</span>
            </div>
            
            <div class="mt-4">
                <div class="progress" style="height: 8px;">
                    <div class="progress-bar bg-<?= $color ?>" style="width: <?= $percent ?>%"></div>
                </div>
                <div class="d-flex justify-content-between mt-2 small text-muted-custom">
                    <span><?= $stat['total_present'] ?> Present</span>
                    <span><?= $stat['total_entries'] ?> Total Entries</span>
                </div>
            </div>
            <a href="<?= APP_URL ?>/admin/subject-students?id=<?= $stat['id'] ?>" class="btn btn-sm btn-light border w-100 mt-3 fw-bold">View Student Status</a>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<div class="card border-0 p-4">
    <h5 class="fw-bold mb-4">Subject-wise Comparison</h5>
    <div style="height: 350px;">
        <canvas id="adminReportsChart"></canvas>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('adminReportsChart').getContext('2d');
    const data = <?= json_encode($subjectStats) ?>;
    
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: data.map(s => s.code),
            datasets: [{
                label: 'Attendance Percentage',
                data: data.map(s => s.total_entries > 0 ? Math.round((s.total_present / s.total_entries) * 100) : 0),
                backgroundColor: data.map(s => (s.total_entries > 0 && (s.total_present / s.total_entries) * 100 >= 75) ? '#10b981' : '#ef4444'),
                borderRadius: 5
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: { beginAtZero: true, max: 100 }
            },
            plugins: {
                legend: { display: false }
            }
        }
    });
});
</script>
<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
