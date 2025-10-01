<?php ob_start(); ?>
<?php include __DIR__ . "/../../helpers.php"; ?>
<h2>Registration</h2>

<?php if (!empty($message)): ?>
    <div class="alert alert-success"><?= htmlspecialchars($message) ?></div>
<?php endif; ?>

<form method="POST" action="/register">

    <?php
    renderInput('first_name', 'Name', 'text', $name ?? '', $errors ?? []);
    renderInput('last_name', 'Last name', 'text', $lastName ?? '', $errors ?? []);
    renderInput('email', 'E-mail', 'email', $email ?? '', $errors ?? []);
    renderInput('phone', 'Phone', 'text', $phone ?? '', $errors ?? []);
    renderInput('password', 'Password', 'password', '', $errors ?? []);
    ?>

    <button type="submit" class="btn btn-success">Confirm</button>
    <a href="/" class="btn btn-primary m-2">Back</a>
</form>
<?php $content = ob_get_clean(); ?>

<?php include __DIR__ . "/../layout.php"; ?>
