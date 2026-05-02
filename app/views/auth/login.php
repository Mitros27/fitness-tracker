<div class="form-container">
    <h2>Prijava</h2>

    <form action="<?= BASE_URL ?>/login" method="POST">
        <div class="form-group">
            <label for="username">Korisničko ime</label>
            <input
                type="text"
                id="username"
                name="username"
                placeholder="Unesite korisničko ime"
                required
                autofocus>
        </div>

        <div class="form-group">
            <label for="password">Lozinka</label>
            <input
                type="password"
                id="password"
                name="password"
                placeholder="Unesite lozinku"
                required>
        </div>

        <button type="submit" class="btn btn-primary" style="width: 100%;">
            Prijavi se
        </button>

        <p class="text-center mt-2 text-muted" style="font-size: 0.9rem;">
            Nemaš nalog?
            <a href="<?= BASE_URL ?>/register" class="text-accent">Registruj se</a>
        </p>
    </form>
</div>