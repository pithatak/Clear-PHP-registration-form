<?php ob_start(); ?>
<?php if (!empty($message)): ?>
    <div class="alert alert-success"><?= htmlspecialchars($message) ?></div>
<?php elseif (!empty($error)): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>
<?php include __DIR__ . "/../helpers.php"; ?>

    <h2>Login</h2>
    <form method="POST" action="/login">
        <?php
        renderInput('email', 'E-mail', 'email', $email ?? '', $errors ?? []);
        renderInput('password', 'Password', 'password', '', $errors ?? []);
        ?>
        <button type="submit" class="btn btn-success">Enter</button>
        <a href="/" class="btn btn-primary m-2">Back</a>
    </form>
<?php $content = ob_get_clean(); ?>

<?php include __DIR__ . "/layout.php";