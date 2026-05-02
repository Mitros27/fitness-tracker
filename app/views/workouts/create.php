<div class="page-header">
    <h1>Novi trening</h1>
    <a href="<?= BASE_URL ?>/workouts" class="btn btn-secondary">&#8592; Nazad</a>
</div>

<form action="<?= BASE_URL ?>/workouts/create" method="POST" id="workoutForm">
    <div class="card mb-3">
        <h3 class="card-title">Osnovni podaci</h3>
        <div class="cards-grid">
            <div class="form-group">
                <label for="date">Datum</label>
                <input type="date" id="date" name="date" value="<?= date('Y-m-d') ?>" required>
            </div>
            <div class="form-group">
                <label for="duration_minutes">Trajanje (minuti)</label>
                <input type="number" id="duration_minutes" name="duration_minutes" min="1" placeholder="npr. 60" required>
            </div>
        </div>
        <div class="form-group">
            <label for="notes">Napomene (opciono)</label>
            <textarea id="notes" name="notes" rows="2" placeholder="Kako je prošao trening?"></textarea>
        </div>
    </div>

    <div class="card mb-3">
        <div class="page-header" style="margin-bottom:1.5rem;">
            <h3 class="card-title" style="margin-bottom:0;">Vežbe</h3>
            <button type="button" class="btn btn-success" style="padding:0.5rem 1rem;font-size:0.9rem;" onclick="dodajVezbu()">+ Dodaj vežbu</button>
        </div>

        <div id="vezbeContainer"></div>
        <p id="nemaVezbi" class="text-muted text-center" style="padding:1rem;">Dodaj barem jednu vežbu.</p>
    </div>

    <button type="submit" class="btn btn-primary" style="width:100%;padding:1rem;">Sačuvaj trening</button>
</form>

<template id="vezbaTemplate">
    <div class="card mb-2 vezba-row" style="border-color:var(--accent);opacity:0.95;">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1rem;">
            <h4 style="color:var(--accent);margin:0;">Vežba #<span class="vezba-broj"></span></h4>
            <button type="button" class="btn btn-danger" style="padding:0.3rem 0.7rem;font-size:0.8rem;" onclick="this.closest('.vezba-row').remove(); azuriraBrojeve();">✕ Ukloni</button>
        </div>
        <div class="cards-grid">
            <div class="form-group">
                <label>Vežba</label>
                <select name="exercise_id[]" required>
                    <option value="">-- Izaberi --</option>
                    <?php foreach ($exercises as $ex): ?>
                        <option value="<?= $ex['id'] ?>"><?= htmlspecialchars($ex['name']) ?> (<?= $ex['type'] ?>)</option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label>Serije</label>
                <input type="number" name="sets_count[]" min="1" placeholder="npr. 3">
            </div>
            <div class="form-group">
                <label>Ponavljanja</label>
                <input type="number" name="reps[]" min="1" placeholder="npr. 10">
            </div>
            <div class="form-group">
                <label>Trajanje (min)</label>
                <input type="number" name="duration[]" min="1" placeholder="npr. 20">
            </div>
            <div class="form-group">
                <label>Kalorije</label>
                <input type="number" name="calories_burned[]" min="0" step="0.1" placeholder="npr. 150">
            </div>
        </div>
    </div>
</template>

<script>
function dodajVezbu() {
    const container = document.getElementById('vezbeContainer');
    const template = document.getElementById('vezbaTemplate');
    const clone = template.content.cloneNode(true);
    container.appendChild(clone);
    azuriraBrojeve();
    document.getElementById('nemaVezbi').style.display = 'none';
}

function azuriraBrojeve() {
    const redovi = document.querySelectorAll('.vezba-row');
    redovi.forEach((red, i) => {
        red.querySelector('.vezba-broj').textContent = i + 1;
    });
    document.getElementById('nemaVezbi').style.display = redovi.length === 0 ? 'block' : 'none';
}

document.getElementById('workoutForm').addEventListener('submit', function(e) {
    if (document.querySelectorAll('.vezba-row').length === 0) {
        e.preventDefault();
        alert('Dodaj barem jednu vežbu!');
    }
});
</script>
