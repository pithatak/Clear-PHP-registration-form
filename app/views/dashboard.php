<?php ob_start(); ?>
<?php renderFlashMessage('success'); ?>
    <h2>Account information</h2>
    <p><strong>Name: </strong><?= htmlspecialchars($user->getFirstName()) ?></p>
    <p><strong>Last name: </strong><?= htmlspecialchars($user->getLastName()) ?></p>
    <p><strong>Email:</strong> <?= htmlspecialchars($user->getEmail()) ?></p>
    <p><strong>Phone:</strong> <?= htmlspecialchars($user->getPhone()) ?></p>

    <a href="/logout" class="btn btn-danger">Log out of your account</a>
<?php $content = ob_get_clean(); ?>

<?php include __DIR__ . "/layout.php";