<?php
// Proveri da li je korisnik ulogovan
$isLoggedIn = isset($_SESSION['user_id']);
$userRole = $_SESSION['role'] ?? null;
$userName = $_SESSION['full_name'] ?? '';
?>
<!DOCTYPE html>
<html lang="sr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? htmlspecialchars($title) . ' - ' : '' ?>Fitness Tracker</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <nav class="navbar">
        <div class="navbar-container">
            <a href="<?= BASE_URL ?>" class="navbar-brand">
                💪 Fitness Tracker
            </a>

            <ul class="navbar-menu">
                <?php if (!$isLoggedIn): ?>
                    <li><a href="<?= BASE_URL ?>/exercises">Vežbe</a></li>
                    <li><a href="<?= BASE_URL ?>/login">Prijava</a></li>
                    <li><a href="<?= BASE_URL ?>/register">Registracija</a></li>
                <?php else: ?>
                    <li><a href="<?= BASE_URL ?>/dashboard">Dashboard</a></li>
                    <li><a href="<?= BASE_URL ?>/workouts">Treninzi</a></li>
                    <li><a href="<?= BASE_URL ?>/exercises">Vežbe</a></li>
                    <li><a href="<?= BASE_URL ?>/measurements">Merenja</a></li>

                    <?php if ($userRole === 'admin'): ?>
                        <li><a href="<?= BASE_URL ?>/admin">Admin panel</a></li>
                    <?php endif; ?>

                    <li class="navbar-user">Pozdrav, <?= htmlspecialchars($userName) ?></li>
                    <li><a href="<?= BASE_URL ?>/logout" class="btn-logout">Odjava</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>
    <main class="main-container">
        <?php if (isset($_SESSION['flash_message'])): ?>
            <div class="flash-message flash-<?= htmlspecialchars($_SESSION['flash_type'] ?? 'info') ?>">
                <?= htmlspecialchars($_SESSION['flash_message']) ?>
            </div>
            <?php
            unset($_SESSION['flash_message']);
            unset($_SESSION['flash_type']);
            ?>
        <?php endif; ?>