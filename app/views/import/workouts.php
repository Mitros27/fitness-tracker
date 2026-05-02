<div class="form-container" style="max-width:560px;">
    <h2>Uvezi treninge</h2>

    <div class="card mb-3" style="background:rgba(0,217,255,0.06);border-color:rgba(0,217,255,0.2);">
        <h3 class="card-title" style="font-size:1rem;">Format CSV fajla</h3>
        <p style="color:var(--text-secondary);font-size:0.9rem;margin-bottom:0.5rem;">Separator: tačka-zarez <code style="color:var(--accent);">;</code></p>
        <code style="color:var(--text-secondary);font-size:0.85rem;display:block;">
            Datum;Trajanje (min);Napomene<br>
            2024-01-15;60;Jutarnji trening<br>
            2024-01-17;45;
        </code>
        <p style="color:var(--text-muted);font-size:0.8rem;margin-top:0.75rem;">
            Možeš dobiti ovaj format preko
            <a href="<?= BASE_URL ?>/export/workouts" class="text-accent">Izvozi treninge</a>.
        </p>
    </div>

    <form action="<?= BASE_URL ?>/import/workouts" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="csv_file">CSV fajl</label>
            <input type="file" id="csv_file" name="csv_file" accept=".csv" required>
        </div>
        <div style="display:flex;gap:1rem;">
            <button type="submit" class="btn btn-primary" style="flex:1;">Uvezi</button>
            <a href="<?= BASE_URL ?>/workouts" class="btn btn-secondary">Otkaži</a>
        </div>
    </form>
</div>
