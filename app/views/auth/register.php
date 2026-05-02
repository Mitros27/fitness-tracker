<div class="form-container">
    <h2>Registracija</h2>

    <form action="<?= BASE_URL ?>/register" method="POST">
        <div class="form-group">
            <label for="full_name">Ime i prezime</label>
            <input type="text" id="full_name" name="full_name" placeholder="Vaše ime i prezime" required autofocus>
        </div>

        <div class="form-group">
            <label for="username">Korisničko ime</label>
            <input type="text" id="username" name="username" placeholder="Izaberite korisničko ime" required>
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" placeholder="vas@email.com" required>
        </div>

        <div class="form-group">
            <label for="password">Lozinka</label>
            <input type="password" id="password" name="password" placeholder="Minimalno 6 karaktera" required>
        </div>

        <div class="form-group">
            <label for="confirm_password">Potvrda lozinke</label>
            <input type="password" id="confirm_password" name="confirm_password" placeholder="Ponovite lozinku" required>
        </div>

        <button type="submit" class="btn btn-success" style="width:100%;">Registruj se</button>

        <p class="text-center mt-2 text-muted" style="font-size:0.9rem;">
            Već imaš nalog?
            <a href="<?= BASE_URL ?>/login" class="text-accent">Prijavi se</a>
        </p>
    </form>
</div>
