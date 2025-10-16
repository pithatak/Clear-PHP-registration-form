<h2>Registration</h2>

<?php renderFlashMessage('success'); ?>
<?php renderFlashMessage('error'); ?>

<form method="POST" action="/register">
    <?php
    renderInput('first_name', 'Name', 'text', $data['first_name'] ?? '', $errors ?? []);
    renderInput('last_name', 'Last name', 'text', $data['last_name'] ?? '', $errors ?? []);
    renderInput('email', 'E-mail', 'email', $data['email'] ?? '', $errors ?? []);
    renderInput('phone', 'Phone', 'text', $data['phone'] ?? '', $errors ?? []);
    renderInput('password', 'Password', 'password', '', $errors ?? []);
    ?>
    <?= \App\Core\Csrf::getTokenField('registration') ?>
    <button type="submit" class="btn btn-success">Confirm</button>
    <a href="/" class="btn btn-primary m-2">Back</a>
</form>