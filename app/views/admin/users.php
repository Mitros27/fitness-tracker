<div class="page-header">
    <h1>Korisnici</h1>
    <a href="<?= BASE_URL ?>/admin" class="btn btn-secondary">&#8592; Admin panel</a>
</div>

<table class="data-table">
    <thead>
        <tr>
            <th>#</th>
            <th>Ime i prezime</th>
            <th>Korisničko ime</th>
            <th>Email</th>
            <th>Uloga</th>
            <th>Treninga</th>
            <th>Poslednji trening</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($users as $user): ?>
            <tr>
                <td style="color:var(--text-muted);"><?= $user['id'] ?></td>
                <td><?= htmlspecialchars($user['full_name']) ?></td>
                <td style="color:var(--accent);font-family:'JetBrains Mono',monospace;"><?= htmlspecialchars($user['username']) ?></td>
                <td style="color:var(--text-secondary);"><?= htmlspecialchars($user['email']) ?></td>
                <td>
                    <?php if ($user['role'] === 'admin'): ?>
                        <span style="color:var(--warning);font-weight:600;">admin</span>
                    <?php else: ?>
                        <span style="color:var(--text-muted);">user</span>
                    <?php endif; ?>
                </td>
                <td><?= $user['total_workouts'] ?></td>
                <td style="color:var(--text-secondary);"><?= $user['last_workout'] ?? '—' ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
