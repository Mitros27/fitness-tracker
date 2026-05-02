<?php require_once APP_PATH . '/views/layouts/header.php'; ?>
<div class='error-container'>
    <h1 class="error-code">404</h1>
    <h2 class="error-title">Stranica nije pronadjena</h2>
    <p class="error-message">
        Zao nam je, stranica koju trazite ne postoji ili je premestena.
    </p>
    <a href="<?= BASE_URL ?>" class="btn btn-primary">
        Nazad na pocetnu
    </a>
</div>
<?php require_once APP_PATH . '/views/layouts/footer.php' ?>