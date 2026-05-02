<div class="page-header">
    <h1>Katalog vežbi</h1>
    <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
        <a href="<?= BASE_URL ?>/exercises/create" class="btn btn-primary">+ Dodaj vežbu</a>
    <?php endif; ?>
</div>

<?php if (empty($exercises)): ?>
    <div class="card">
        <p class="text-muted text-center">Nema vežbi u katalogu.</p>
    </div>
<?php else: ?>
    <table class="data-table">
        <thead>
            <tr>
                <th>Naziv</th>
                <th>Tip</th>
                <th>Kal/min</th>
                <th>Akcije</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($exercises as $exercise): ?>
                <tr>
                    <td><a href="<?= BASE_URL ?>/exercises/view/<?= $exercise['id'] ?>" class="text-accent"><?= htmlspecialchars($exercise['name']) ?></a></td>
                    <td><?= htmlspecialchars($exercise['type']) ?></td>
                    <td><?= $exercise['calories_per_minute'] ?></td>
                    <td>
                        <a href="<?= BASE_URL ?>/exercises/view/<?= $exercise['id'] ?>" class="btn btn-secondary" style="padding:0.4rem 0.8rem;font-size:0.85rem;">Detalji</a>
                        <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                            <a href="<?= BASE_URL ?>/exercises/edit/<?= $exercise['id'] ?>" class="btn btn-primary" style="padding:0.4rem 0.8rem;font-size:0.85rem;">Izmeni</a>
                            <a href="<?= BASE_URL ?>/exercises/delete/<?= $exercise['id'] ?>" class="btn btn-danger" style="padding:0.4rem 0.8rem;font-size:0.85rem;" onclick="return confirm('Obrisati vežbu?')">Obriši</a>
                        <?php endif; ?>
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
