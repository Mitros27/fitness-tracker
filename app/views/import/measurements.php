<div class="form-container" style="max-width:560px;">
    <h2>Uvezi merenja</h2>

    <div class="card mb-3" style="background:rgba(0,217,255,0.06);border-color:rgba(0,217,255,0.2);">
        <h3 class="card-title" style="font-size:1rem;">Format CSV fajla</h3>
        <p style="color:var(--text-secondary);font-size:0.9rem;margin-bottom:0.5rem;">Separator: tačka-zarez <code style="color:var(--accent);">;</code></p>
        <code style="color:var(--text-secondary);font-size:0.85rem;display:block;">
            Datum;Težina (kg);Mast (%);Struk (cm);Grudi (cm);Ruka (cm)<br>
            2024-01-15;80.50;18.5;82.0;100.0;35.0<br>
            2024-02-01;79.80;;;82.5;
        </code>
        <p style="color:var(--text-muted);font-size:0.8rem;margin-top:0.75rem;">
            Prazna polja su dozvoljena (osim datuma).
            <a href="<?= BASE_URL ?>/export/measurements" class="text-accent">Izvozi merenja</a> za primer.
        </p>
    </div>

    <form action="<?= BASE_URL ?>/import/measurements" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="csv_file">CSV fajl</label>
            <input type="file" id="csv_file" name="csv_file" accept=".csv" required>
        </div>
        <div style="display:flex;gap:1rem;">
            <button type="submit" class="btn btn-primary" style="flex:1;">Uvezi</button>
            <a href="<?= BASE_URL ?>/measurements" class="btn btn-secondary">Otkaži</a>
        </div>
    </form>
</div>
