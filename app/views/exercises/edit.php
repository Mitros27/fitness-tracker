<div class="form-container" style="max-width:600px;">
    <h2>Izmeni vežbu</h2>

    <form action="<?= BASE_URL ?>/exercises/edit/<?= $exercise['id'] ?>" method="POST">
        <div class="form-group">
            <label for="name">Naziv vežbe</label>
            <input type="text" id="name" name="name" value="<?= htmlspecialchars($exercise['name']) ?>" required>
        </div>

        <div class="form-group">
            <label for="type">Tip vežbe</label>
            <select id="type" name="type" required>
                <option value="">-- Izaberi tip --</option>
                <?php foreach (['cardio', 'snaga', 'fleksibilnost', 'ravnoteža', 'ostalo'] as $tip): ?>
                    <option value="<?= $tip ?>" <?= $exercise['type'] === $tip ? 'selected' : '' ?>><?= ucfirst($tip) ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="calories_per_minute">Kalorija po minutu</label>
            <input type="number" id="calories_per_minute" name="calories_per_minute" min="0" step="0.1" value="<?= $exercise['calories_per_minute'] ?>" required>
        </div>

        <div class="form-group">
            <label for="description">Opis (opciono)</label>
            <textarea id="description" name="description" rows="4"><?= htmlspecialchars($exercise['description'] ?? '') ?></textarea>
        </div>

        <div style="display:flex;gap:1rem;">
            <button type="submit" class="btn btn-primary" style="flex:1;">Sačuvaj izmene</button>
            <a href="<?= BASE_URL ?>/exercises/view/<?= $exercise['id'] ?>" class="btn btn-secondary">Otkaži</a>
        </div>
    </form>
</div>
