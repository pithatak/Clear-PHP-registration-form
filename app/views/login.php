<?php ob_start(); ?>
<?php if (!empty($message)): ?>
    <div class="alert alert-success"><?= htmlspecialchars($message) ?></div>
<?php elseif (!empty($error)): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>
    <h2>Login</h2>
    <form method="POST" action="/login">
        <div class="mb-3">
            <label class="form-label">E-mail</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success">Enter</button>
        <a href="/" class="btn btn-primary m-2">Back</a>
    </form>
<?php $content = ob_get_clean(); ?>

<?php include __DIR__ . "/layout.php";