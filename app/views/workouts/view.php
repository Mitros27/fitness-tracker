<div class="page-header">
    <h1>Trening — <?= htmlspecialchars($workout['date']) ?></h1>
    <div style="display:flex;gap:0.75rem;">
        <a href="<?= BASE_URL ?>/workouts/edit/<?= $workout['id'] ?>" class="btn btn-primary">Izmeni</a>
        <a href="<?= BASE_URL ?>/workouts/delete/<?= $workout['id'] ?>" class="btn btn-danger" onclick="return confirm('Obrisati trening?')">Obriši</a>
        <a href="<?= BASE_URL ?>/workouts" class="btn btn-secondary">&#8592; Nazad</a>
    </div>
</div>

<div class="cards-grid">
    <div class="card stat-card">
        <div class="stat-number"><?= $workout['duration_minutes'] ?></div>
        <div class="stat-label">Minuta</div>
    </div>
    <div class="card stat-card">
        <div class="stat-number"><?= count($exercises) ?></div>
        <div class="stat-label">Vežbi</div>
    </div>
    <div class="card stat-card">
        <div class="stat-number"><?= round($totalCalories) ?></div>
        <div class="stat-label">Kalorija</div>
    </div>
</div>

<?php if (!empty($workout['notes'])): ?>
    <div class="card mb-3">
        <h3 class="card-title">Napomene</h3>
        <p style="color:var(--text-secondary);"><?= nl2br(htmlspecialchars($workout['notes'])) ?></p>
    </div>
<?php endif; ?>

<?php if (!empty($exercises)): ?>
    <div class="card">
        <h3 class="card-title">Vežbe</h3>
        <table class="data-table">
            <thead>
                <tr>
                    <th>Vežba</th>
                    <th>Tip</th>
                    <th>Serije</th>
                    <th>Ponavljanja</th>
                    <th>Trajanje (min)</th>
                    <th>Kalorije</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($exercises as $ex): ?>
                    <tr>
                        <td><?= htmlspecialchars($ex['name']) ?></td>
                        <td><?= htmlspecialchars($ex['type']) ?></td>
                        <td><?= $ex['sets_count'] ?? '—' ?></td>
                        <td><?= $ex['reps'] ?? '—' ?></td>
                        <td><?= $ex['duration_minutes'] ?? '—' ?></td>
                        <td><?= $ex['calories_burned'] ? round($ex['calories_burned']) : '—' ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>
