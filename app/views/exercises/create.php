<div class="form-container" style="max-width:600px;">
    <h2>Dodaj vežbu</h2>

    <form action="<?= BASE_URL ?>/exercises/create" method="POST">
        <div class="form-group">
            <label for="name">Naziv vežbe</label>
            <input type="text" id="name" name="name" placeholder="npr. Trčanje, Čučnjevi..." required autofocus>
        </div>

        <div class="form-group">
            <label for="type">Tip vežbe</label>
            <select id="type" name="type" required>
                <option value="">-- Izaberi tip --</option>
                <option value="cardio">Cardio</option>
                <option value="snaga">Snaga</option>
                <option value="fleksibilnost">Fleksibilnost</option>
                <option value="ravnoteža">Ravnoteža</option>
                <option value="ostalo">Ostalo</option>
            </select>
        </div>

        <div class="form-group">
            <label for="calories_per_minute">Kalorija po minutu</label>
            <input type="number" id="calories_per_minute" name="calories_per_minute" min="0" step="0.1" placeholder="npr. 8.5" required>
        </div>

        <div class="form-group">
            <label for="description">Opis (opciono)</label>
            <textarea id="description" name="description" rows="4" placeholder="Kratki opis vežbe..."></textarea>
        </div>

        <div style="display:flex;gap:1rem;">
            <button type="submit" class="btn btn-primary" style="flex:1;">Sačuvaj vežbu</button>
            <a href="<?= BASE_URL ?>/exercises" class="btn btn-secondary">Otkaži</a>
        </div>
    </form>
</div>
