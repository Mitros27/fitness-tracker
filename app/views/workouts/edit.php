<div class="page-header">
    <h1>Izmeni trening</h1>
    <a href="<?= BASE_URL ?>/workouts/view/<?= $workout['id'] ?>" class="btn btn-secondary">&#8592; Nazad</a>
</div>

<div class="form-container" style="max-width:600px;">
    <form action="<?= BASE_URL ?>/workouts/edit/<?= $workout['id'] ?>" method="POST">
        <div class="form-group">
            <label for="date">Datum</label>
            <input type="date" id="date" name="date" value="<?= htmlspecialchars($workout['date']) ?>" required>
        </div>

        <div class="form-group">
            <label for="duration_minutes">Trajanje (minuti)</label>
            <input type="number" id="duration_minutes" name="duration_minutes" min="1" value="<?= $workout['duration_minutes'] ?>" required>
        </div>

        <div class="form-group">
            <label for="notes">Napomene (opciono)</label>
            <textarea id="notes" name="notes" rows="3"><?= htmlspecialchars($workout['notes'] ?? '') ?></textarea>
        </div>

        <div style="display:flex;gap:1rem;">
            <button type="submit" class="btn btn-primary" style="flex:1;">Sačuvaj izmene</button>
            <a href="<?= BASE_URL ?>/workouts/view/<?= $workout['id'] ?>" class="btn btn-secondary">Otkaži</a>
        </div>
    </form>
</div>
