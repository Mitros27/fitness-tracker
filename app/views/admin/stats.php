<div class="page-header">
    <h1>Statistika aplikacije</h1>
    <a href="<?= BASE_URL ?>/admin" class="btn btn-secondary">&#8592; Admin panel</a>
</div>

<div class="cards-grid">
    <div class="card stat-card">
        <div class="stat-number"><?= (int)($globalStats['total_workouts'] ?? 0) ?></div>
        <div class="stat-label">Ukupno treninga</div>
    </div>
    <div class="card stat-card">
        <div class="stat-number"><?= (int)($globalStats['total_minutes'] ?? 0) ?></div>
        <div class="stat-label">Ukupno minuta</div>
    </div>
    <div class="card stat-card">
        <div class="stat-number"><?= round($globalStats['total_calories'] ?? 0) ?></div>
        <div class="stat-label">Ukupno kalorija</div>
    </div>
</div>

<div class="card">
    <h3 class="card-title">Vežbe po tipu</h3>
    <?php if (empty($exercisesByType)): ?>
        <p class="text-muted">Nema podataka.</p>
    <?php else: ?>
        <div style="max-width:400px;margin:0 auto;">
            <canvas id="chartTip"></canvas>
        </div>
        <table class="data-table" style="margin-top:1.5rem;">
            <thead>
                <tr><th>Tip</th><th>Broj vežbi</th></tr>
            </thead>
            <tbody>
                <?php foreach ($exercisesByType as $row): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['type']) ?></td>
                        <td><?= $row['total'] ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

<?php if (!empty($exercisesByType)): ?>
<script>
const tipovi = <?= json_encode($exercisesByType) ?>;
new Chart(document.getElementById('chartTip'), {
    type: 'doughnut',
    data: {
        labels: tipovi.map(r => r.type),
        datasets: [{
            data: tipovi.map(r => r.total),
            backgroundColor: ['#00d9ff', '#b794ff', '#00ff88', '#ffb800', '#ff3860'],
            borderColor: '#1a2138',
            borderWidth: 3
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { position: 'bottom', labels: { color: '#8b92a8', padding: 16 } }
        }
    }
});
</script>
<?php endif; ?>
