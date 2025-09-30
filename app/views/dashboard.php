<?php ob_start(); ?>
    <h2>Account information</h2>
    <p><strong>Name: </strong><?= htmlspecialchars($userData['first_name']) ?></p>
    <p><strong>Last name: </strong><?= htmlspecialchars($userData['last_name']) ?></p>
    <p><strong>Email:</strong> <?= htmlspecialchars($userData['email']) ?></p>
    <p><strong>Phone:</strong> <?= htmlspecialchars($userData['phone']) ?></p>

    <a href="/logout" class="btn btn-danger">Log out of your account</a>
<?php $content = ob_get_clean(); ?>

<?php include __DIR__ . "/layout.php";