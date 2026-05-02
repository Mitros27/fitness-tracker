<div class="form-container" style="max-width:600px;">
    <h2>Novo merenje</h2>

    <form action="<?= BASE_URL ?>/measurements/create" method="POST">
        <div class="form-group">
            <label for="date">Datum</label>
            <input type="date" id="date" name="date" value="<?= date('Y-m-d') ?>" required>
        </div>

        <div class="form-group">
            <label for="weight">Težina (kg)</label>
            <input type="number" id="weight" name="weight" min="1" max="300" step="0.01" placeholder="npr. 80.50">
        </div>

        <div class="form-group">
            <label for="body_fat_percentage">Procenat masti (%)</label>
            <input type="number" id="body_fat_percentage" name="body_fat_percentage" min="1" max="60" step="0.1" placeholder="npr. 18.5">
        </div>

        <div class="form-group">
            <label for="waist_cm">Struk (cm)</label>
            <input type="number" id="waist_cm" name="waist_cm" min="1" max="200" step="0.1" placeholder="npr. 82.0">
        </div>

        <div class="form-group">
            <label for="chest_cm">Grudi (cm)</label>
            <input type="number" id="chest_cm" name="chest_cm" min="1" max="200" step="0.1" placeholder="npr. 100.0">
        </div>

        <div class="form-group">
            <label for="arm_cm">Ruka (cm)</label>
            <input type="number" id="arm_cm" name="arm_cm" min="1" max="100" step="0.1" placeholder="npr. 35.0">
        </div>

        <div style="display:flex;gap:1rem;">
            <button type="submit" class="btn btn-primary" style="flex:1;">Sačuvaj merenje</button>
            <a href="<?= BASE_URL ?>/measurements" class="btn btn-secondary">Otkaži</a>
        </div>
    </form>
</div>
