<?php

/** @var int $totalUsers */
/** @var int $totalWorkouts */
/** @var int $totalExercises */
/** @var int $totalMeasurements */
/** @var array $globalStats */
/** @var array $exercisesByType */
/** @var string $globalWorkoutsByMonth */
?>

<div class="page-header">
    <h1>Admin panel</h1>
    <div style="display:flex;gap:0.75rem;">
        <a href="<?= BASE_URL ?>/admin/users" class="btn btn-secondary">Korisnici</a>
        <a href="<?= BASE_URL ?>/admin/stats" class="btn btn-secondary">Statistika</a>
    </div>
</div>

<div class="cards-grid">
    <div class="card stat-card">
        <div class="stat-number"><?= $totalUsers ?></div>
        <div class="stat-label">Korisnika</div>
    </div>
    <div class="card stat-card">
        <div class="stat-number"><?= $totalWorkouts ?></div>
        <div class="stat-label">Treninga</div>
    </div>
    <div class="card stat-card">
        <div class="stat-number"><?= $totalExercises ?></div>
        <div class="stat-label">Vežbi</div>
    </div>
    <div class="card stat-card">
        <div class="stat-number"><?= $totalMeasurements ?></div>
        <div class="stat-label">Merenja</div>
    </div>
</div>

<div class="cards-grid" style="grid-template-columns: repeat(auto-fit, minmax(340px, 1fr));">
    <div class="card">
        <h3 class="card-title">Globalne statistike</h3>
        <table class="data-table">
            <tbody>
                <tr>
                    <td style="color:var(--text-secondary);">Ukupno treninga</td>
                    <td><strong><?= (int)($globalStats['total_workouts'] ?? 0) ?></strong></td>
                </tr>
                <tr>
                    <td style="color:var(--text-secondary);">Ukupno minuta</td>
                    <td><strong><?= (int)($globalStats['total_minutes'] ?? 0) ?></strong></td>
                </tr>
                <tr>
                    <td style="color:var(--text-secondary);">Ukupno kalorija</td>
                    <td><strong><?= round($globalStats['total_calories'] ?? 0) ?></strong></td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="card">
        <h3 class="card-title">Vežbe po tipu</h3>
        <?php if (empty($exercisesByType)): ?>
            <p class="text-muted">Nema podataka.</p>
        <?php else: ?>
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Tip</th>
                        <th>Broj</th>
                    </tr>
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
</div>

<div class="chart-container">
    <h3>Treninzi po mesecu — svi korisnici</h3>
    <canvas id="chartGlobalWorkouts"></canvas>
</div>

<div class="card">
    <h3 class="card-title">Brze akcije</h3>
    <div style="display:flex;gap:1rem;flex-wrap:wrap;">
        <a href="<?= BASE_URL ?>/exercises/create" class="btn btn-primary">+ Dodaj vežbu</a>
        <a href="<?= BASE_URL ?>/admin/users" class="btn btn-secondary">Upravljaj korisnicima</a>
        <a href="<?= BASE_URL ?>/admin/stats" class="btn btn-secondary">Detaljne statistike</a>
    </div>
</div>

<script>
    const accentColor = '#00d9ff';
    const purpleColor = '#b794ff';
    const gridColor = 'rgba(42, 51, 77, 0.8)';

    const globalWorkouts = <?= $globalWorkoutsByMonth ?>;

    if (globalWorkouts.length > 0) {
        new Chart(document.getElementById('chartGlobalWorkouts'), {
            type: 'line',
            data: {
                labels: globalWorkouts.map(r => r.month),
                datasets: [{
                    label: 'Broj treninga (svi korisnici)',
                    data: globalWorkouts.map(r => r.total_workouts),
                    borderColor: accentColor,
                    backgroundColor: 'rgba(0, 217, 255, 0.1)',
                    borderWidth: 2,
                    tension: 0.4,
                    fill: true,
                    pointBackgroundColor: accentColor,
                    pointRadius: 5,
                    pointHoverRadius: 7
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        labels: {
                            color: '#8b92a8'
                        }
                    }
                },
                scales: {
                    x: {
                        ticks: {
                            color: '#8b92a8'
                        },
                        grid: {
                            color: gridColor
                        }
                    },
                    y: {
                        ticks: {
                            color: '#8b92a8',
                            stepSize: 1
                        },
                        grid: {
                            color: gridColor
                        },
                        beginAtZero: true
                    }
                }
            }
        });
    } else {
        document.getElementById('chartGlobalWorkouts').parentElement.innerHTML +=
            '<p class="text-muted text-center">Nema podataka za prikaz.</p>';
    }
</script>