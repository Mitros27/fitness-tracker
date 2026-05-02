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
                    <tr><th>Tip</th><th>Broj</th></tr>
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

<div class="card">
    <h3 class="card-title">Brze akcije</h3>
    <div style="display:flex;gap:1rem;flex-wrap:wrap;">
        <a href="<?= BASE_URL ?>/workouts/create" class="btn btn-primary">+ Novi trening</a>
        <a href="<?= BASE_URL ?>/exercises/create" class="btn btn-primary">+ Dodaj vežbu</a>
        <a href="<?= BASE_URL ?>/admin/users" class="btn btn-secondary">Upravljaj korisnicima</a>
        <a href="<?= BASE_URL ?>/admin/stats" class="btn btn-secondary">Detaljne statistike</a>
    </div>
</div>
