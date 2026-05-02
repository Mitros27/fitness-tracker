<div class="page-header">
    <a href="<?= BASE_URL ?>/exercises" class="btn btn-secondary">&#8592; Nazad</a>
</div>

<div class="card">
    <h1 class="card-title"><?= htmlspecialchars($exercise['name']) ?></h1>
    <div class="cards-grid" style="margin-top:1.5rem;">
        <div class="card stat-card">
            <div class="stat-number"><?= htmlspecialchars($exercise['type']) ?></div>
            <div class="stat-label">Tip vežbe</div>
        </div>
        <div class="card stat-card">
            <div class="stat-number"><?= $exercise['calories_per_minute'] ?></div>
            <div class="stat-label">Kalorija po minutu</div>
        </div>
    </div>

    <?php if (!empty($exercise['description'])): ?>
        <div style="margin-top:1.5rem;">
            <h3>Opis</h3>
            <p style="color:var(--text-secondary);line-height:1.8;"><?= nl2br(htmlspecialchars($exercise['description'])) ?></p>
        </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
        <div style="margin-top:2rem;display:flex;gap:1rem;">
            <a href="<?= BASE_URL ?>/exercises/edit/<?= $exercise['id'] ?>" class="btn btn-primary">Izmeni</a>
            <a href="<?= BASE_URL ?>/exercises/delete/<?= $exercise['id'] ?>" class="btn btn-danger" onclick="return confirm('Obrisati vežbu?')">Obriši</a>
        </div>
    <?php endif; ?>
</div>
