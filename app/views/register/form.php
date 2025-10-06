<?php ob_start(); ?>
<h2>Registration</h2>

<?php renderFlashMessage('success'); ?>
<?php renderFlashMessage('error'); ?>

<form method="POST" action="/register">
    <?php
    renderInput('first_name', 'Name', 'text', $name ?? '', $errors ?? []);
    renderInput('last_name', 'Last name', 'text', $lastName ?? '', $errors ?? []);
    renderInput('email', 'E-mail', 'email', $email ?? '', $errors ?? []);
    renderInput('phone', 'Phone', 'text', $phone ?? '', $errors ?? []);
    renderInput('password', 'Password', 'password', '', $errors ?? []);
    ?>
    <?= \App\Core\Csrf::getTokenField('registration') ?>
    <button type="submit" class="btn btn-success">Confirm</button>
    <a href="/" class="btn btn-primary m-2">Back</a>
</form>

<?php $content = ob_get_clean(); ?>

<?php include __DIR__ . "/../layout.php"; ?>
