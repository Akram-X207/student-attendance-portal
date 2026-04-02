<?php require_once __DIR__ . '/../layouts/header.php'; ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb m-0 bg-transparent p-0 small">
        <li class="breadcrumb-item"><a href="<?= APP_URL ?>/teacher" class="text-decoration-none">Dashboard</a></li>
        <li class="breadcrumb-item active">Subject Report</li>
      </ol>
    </nav>
    <button onclick="window.print()" class="btn btn-sm btn-outline-secondary px-3 fw-bold"><i class="bi bi-printer"></i> Print Report</button>
</div>

<div class="card border-0 p-4 mb-4">
    <div class="row align-items-center">
        <div class="col-md-8">
            <h3 class="fw-bold m-0"><?= htmlspecialchars($subject['name']) ?> - Analytics</h3>
            <p class="text-muted-custom small mb-0 mt-1"><?= htmlspecialchars($subject['code']) ?> | Year <?= $subject['year'] ?></p>
        </div>
        <div class="col-md-4 text-md-end">
             <a href="<?= APP_URL ?>/teacher/export-csv?subject_id=<?= $subject['id'] ?>" class="btn btn-outline-success btn-sm fw-bold"><i class="bi bi-file-earmark-spreadsheet"></i> Export CSV</a>
        </div>
    </div>
</div>

<div class="card border-0 overflow-hidden">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="bg-secondary bg-opacity-50">
                <tr class="text-muted-custom small text-uppercase fw-bold">
                    <th class="ps-4 py-3">PRN</th>
                    <th class="py-3">Student Name</th>
                    <th class="py-3 text-center">Attended / Total</th>
                    <th class="py-3 text-end pe-4">Percentage</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($records as $row): 
                    $percent = $row['total_sessions'] > 0 ? round(($row['attended'] / $row['total_sessions']) * 100) : 0;
                    $statusColor = $percent >= 75 ? 'text-success' : 'text-danger';
                ?>
                    <tr>
                        <td class="ps-4 fw-bold"><?= htmlspecialchars($row['prn']) ?></td>
                        <td class="fw-medium"><?= htmlspecialchars($row['name']) ?></td>
                        <td class="text-center"><?= $row['attended'] ?> / <?= $row['total_sessions'] ?></td>
                        <td class="text-end pe-4">
                            <span class="fw-bold <?= $statusColor ?>"><?= $percent ?>%</span>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
