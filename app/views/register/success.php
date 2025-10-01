<?php ob_start(); ?>
<?php if (!empty($message)): ?>
    <div class="alert alert-success"><?= htmlspecialchars($message) ?></div>
<?php endif; ?>
    <a href="/" class="btn btn-primary m-2">Back</a>
    <a href="/showLoginForm" class="btn btn-success m-2">Login</a>
<?php $content = ob_get_clean(); ?>

<?php include __DIR__ . "/../layout.php";