<div class="page-header">
    <h1>Dashboard</h1>
    <a href="<?= BASE_URL ?>/workouts/create" class="btn btn-primary">+ Novi trening</a>
</div>

<!-- Stat kartice -->
<div class="cards-grid">
    <div class="card stat-card">
        <div class="stat-number"><?= (int)($stats['total_workouts'] ?? 0) ?></div>
        <div class="stat-label">Ukupno treninga</div>
    </div>
    <div class="card stat-card">
        <div class="stat-number"><?= (int)($stats['total_minutes'] ?? 0) ?></div>
        <div class="stat-label">Ukupno minuta</div>
    </div>
    <div class="card stat-card">
        <div class="stat-number"><?= round($stats['avg_duration'] ?? 0) ?></div>
        <div class="stat-label">Prosek min / trening</div>
    </div>
    <?php if ($latestMeasurement && !empty($latestMeasurement['weight'])): ?>
    <div class="card stat-card">
        <div class="stat-number"><?= $latestMeasurement['weight'] ?></div>
        <div class="stat-label">Poslednja težina (kg)</div>
    </div>
    <?php endif; ?>
</div>

<!-- Grafici — red 1 -->
<div class="cards-grid" style="grid-template-columns: repeat(auto-fit, minmax(380px, 1fr));">
    <div class="chart-container">
        <h3>Kalorije po mesecu</h3>
        <canvas id="chartKalorije"></canvas>
    </div>
    <div class="chart-container">
        <h3>Treninzi po mesecu</h3>
        <canvas id="chartTreninzi"></canvas>
    </div>
</div>

<!-- Grafici — red 2 -->
<div class="cards-grid" style="grid-template-columns: repeat(auto-fit, minmax(380px, 1fr));">
    <div class="chart-container">
        <h3>Treninzi po tipu vežbe</h3>
        <canvas id="chartTip"></canvas>
    </div>
    <?php if ($latestMeasurement && !empty($latestMeasurement['weight'])): ?>
    <div class="chart-container">
        <h3>Istorija težine</h3>
        <canvas id="chartTezina"></canvas>
    </div>
    <?php endif; ?>
</div>

<!-- Brzi linkovi -->
<div class="cards-grid">
    <a href="<?= BASE_URL ?>/workouts" class="card" style="text-decoration:none;">
        <h3 class="card-title">🏋️ Moji treninzi</h3>
        <p style="color:var(--text-secondary);">Pregled svih tvojih treninga</p>
    </a>
    <a href="<?= BASE_URL ?>/measurements" class="card" style="text-decoration:none;">
        <h3 class="card-title">📏 Merenja</h3>
        <p style="color:var(--text-secondary);">Prati promene svog tela</p>
    </a>
    <a href="<?= BASE_URL ?>/exercises" class="card" style="text-decoration:none;">
        <h3 class="card-title">📚 Katalog vežbi</h3>
        <p style="color:var(--text-secondary);">Pregled dostupnih vežbi</p>
    </a>
</div>

<script>
const accentColor = '#00d9ff';
const purpleColor = '#b794ff';
const successColor = '#00ff88';
const gridColor = 'rgba(42, 51, 77, 0.8)';

const chartDefaults = {
    responsive: true,
    plugins: {
        legend: { labels: { color: '#8b92a8' } }
    },
    scales: {
        x: { ticks: { color: '#8b92a8' }, grid: { color: gridColor } },
        y: { ticks: { color: '#8b92a8' }, grid: { color: gridColor }, beginAtZero: true }
    }
};

// Kalorije po mesecu
const kalorije = <?= $caloriesByMonth ?>;
new Chart(document.getElementById('chartKalorije'), {
    type: 'bar',
    data: {
        labels: kalorije.map(r => r.month),
        datasets: [{
            label: 'Kalorije',
            data: kalorije.map(r => r.total_calories),
            backgroundColor: 'rgba(0, 217, 255, 0.3)',
            borderColor: accentColor,
            borderWidth: 2,
            borderRadius: 6
        }]
    },
    options: chartDefaults
});

// Treninzi po mesecu
const treninzi = <?= $workoutsByMonth ?>;
new Chart(document.getElementById('chartTreninzi'), {
    type: 'line',
    data: {
        labels: treninzi.map(r => r.month),
        datasets: [{
            label: 'Treninzi',
            data: treninzi.map(r => r.total_workouts),
            borderColor: purpleColor,
            backgroundColor: 'rgba(183, 148, 255, 0.1)',
            borderWidth: 2,
            tension: 0.4,
            fill: true,
            pointBackgroundColor: purpleColor,
            pointRadius: 5
        }]
    },
    options: chartDefaults
});

// Treninzi po tipu
const tipovi = <?= $workoutsByType ?>;
new Chart(document.getElementById('chartTip'), {
    type: 'doughnut',
    data: {
        labels: tipovi.map(r => r.type),
        datasets: [{
            data: tipovi.map(r => r.total),
            backgroundColor: [accentColor, purpleColor, successColor, '#ffb800', '#ff3860'],
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

// Istorija težine
<?php if ($latestMeasurement && !empty($latestMeasurement['weight'])): ?>
const tezina = <?= $weightHistory ?>;
if (tezina.length > 0) {
    new Chart(document.getElementById('chartTezina'), {
        type: 'line',
        data: {
            labels: tezina.map(r => r.date),
            datasets: [{
                label: 'Težina (kg)',
                data: tezina.map(r => r.weight),
                borderColor: successColor,
                backgroundColor: 'rgba(0, 255, 136, 0.1)',
                borderWidth: 2,
                tension: 0.4,
                fill: true,
                pointBackgroundColor: successColor,
                pointRadius: 5
            }]
        },
        options: chartDefaults
    });
}
<?php endif; ?>
</script>
