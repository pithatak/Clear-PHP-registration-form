<?php ob_start(); ?>

<?php renderGlobalErrors($errors ?? []); ?>

<?php renderFlashMessage('success'); ?>
<?php renderFlashMessage('error'); ?>

    <h2>Login</h2>
    <form method="POST" action="/login">
        <?php
        renderInput('email', 'E-mail', 'email', $email ?? '', $errors ?? []);
        renderInput('password', 'Password', 'password', '', $errors ?? [], true);
        ?>
        <?= \App\Core\Csrf::getTokenField('login') ?>
        <button type="submit" class="btn btn-success">Enter</button>
        <a href="/" class="btn btn-primary m-2">Back</a>
    </form>

<?php $content = ob_get_clean(); ?>

<?php include __DIR__ . "/layout.php";