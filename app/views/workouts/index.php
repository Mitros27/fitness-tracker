<div class="page-header">
    <h1>Moji treninzi</h1>
    <div style="display:flex;gap:0.75rem;flex-wrap:wrap;">
        <a href="<?= BASE_URL ?>/workouts/create" class="btn btn-primary">+ Novi trening</a>
        <a href="<?= BASE_URL ?>/export/workouts" class="btn btn-secondary">Izvozi CSV</a>
        <a href="<?= BASE_URL ?>/import/workouts" class="btn btn-secondary">Uvezi CSV</a>
    </div>
</div>

<?php if (empty($workouts)): ?>
    <div class="card text-center">
        <p class="text-muted">Još nemaš nijedan trening. <a href="<?= BASE_URL ?>/workouts/create" class="text-accent">Dodaj prvi!</a></p>
    </div>
<?php else: ?>
    <table class="data-table">
        <thead>
            <tr>
                <th>Datum</th>
                <th>Trajanje</th>
                <th>Napomene</th>
                <th>Akcije</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($workouts as $workout): ?>
                <tr>
                    <td><?= htmlspecialchars($workout['date']) ?></td>
                    <td><?= $workout['duration_minutes'] ?> min</td>
                    <td><?= htmlspecialchars($workout['notes'] ?? '—') ?></td>
                    <td>
                        <a href="<?= BASE_URL ?>/workouts/view/<?= $workout['id'] ?>" class="btn btn-secondary" style="padding:0.4rem 0.8rem;font-size:0.85rem;">Detalji</a>
                        <a href="<?= BASE_URL ?>/workouts/edit/<?= $workout['id'] ?>" class="btn btn-primary" style="padding:0.4rem 0.8rem;font-size:0.85rem;">Izmeni</a>
                        <a href="<?= BASE_URL ?>/workouts/delete/<?= $workout['id'] ?>" class="btn btn-danger" style="padding:0.4rem 0.8rem;font-size:0.85rem;" onclick="return confirm('Obrisati trening?')">Obriši</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <?php if ($totalPages > 1): ?>
        <div class="pagination">
            <?php if ($page > 1): ?>
                <a href="?page=<?= $page - 1 ?>">&#8592;</a>
            <?php endif; ?>
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <?php if ($i === $page): ?>
                    <span class="active"><?= $i ?></span>
                <?php else: ?>
                    <a href="?page=<?= $i ?>"><?= $i ?></a>
                <?php endif; ?>
            <?php endfor; ?>
            <?php if ($page < $totalPages): ?>
                <a href="?page=<?= $page + 1 ?>">&#8594;</a>
            <?php endif; ?>
        </div>
    <?php endif; ?>
<?php endif; ?>
