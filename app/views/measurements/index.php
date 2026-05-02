<div class="page-header">
    <h1>Merenja</h1>
    <div style="display:flex;gap:0.75rem;flex-wrap:wrap;">
        <a href="<?= BASE_URL ?>/measurements/create" class="btn btn-primary">+ Novo merenje</a>
        <a href="<?= BASE_URL ?>/export/measurements" class="btn btn-secondary">Izvozi CSV</a>
        <a href="<?= BASE_URL ?>/import/measurements" class="btn btn-secondary">Uvezi CSV</a>
    </div>
</div>

<?php if (empty($measurements)): ?>
    <div class="card text-center">
        <p class="text-muted">Još nemaš nijedna merenja. <a href="<?= BASE_URL ?>/measurements/create" class="text-accent">Dodaj prvo!</a></p>
    </div>
<?php else: ?>
    <table class="data-table">
        <thead>
            <tr>
                <th>Datum</th>
                <th>Težina (kg)</th>
                <th>Mast (%)</th>
                <th>Struk (cm)</th>
                <th>Grudi (cm)</th>
                <th>Ruka (cm)</th>
                <th>Akcije</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($measurements as $m): ?>
                <tr>
                    <td><?= htmlspecialchars($m['date']) ?></td>
                    <td><?= $m['weight'] ?? '—' ?></td>
                    <td><?= $m['body_fat_percentage'] ?? '—' ?></td>
                    <td><?= $m['waist_cm'] ?? '—' ?></td>
                    <td><?= $m['chest_cm'] ?? '—' ?></td>
                    <td><?= $m['arm_cm'] ?? '—' ?></td>
                    <td>
                        <a href="<?= BASE_URL ?>/measurements/delete/<?= $m['id'] ?>"
                           class="btn btn-danger"
                           style="padding:0.4rem 0.8rem;font-size:0.85rem;"
                           onclick="return confirm('Obrisati merenje?')">Obriši</a>
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
