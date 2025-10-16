<?php renderFlashMessage('success'); ?>
<h2>Account information</h2>
<?php if (isset($user)): ?>
    <div class="user-info">
        <p><strong>Name:</strong> <?= htmlspecialchars($user->getFirstName()) ?></p>
        <p><strong>Last Name:</strong> <?= htmlspecialchars($user->getLastName()) ?></p>
        <p><strong>Email:</strong> <?= htmlspecialchars($user->getEmail()) ?></p>
        <p><strong>Phone:</strong> <?= htmlspecialchars($user->getPhone()) ?></p>
    </div>
<?php else: ?>
    <div class="alert alert-warning">
        User information not available.
    </div>
<?php endif; ?>

<a href="/logout" class="btn btn-danger">Log out of your account</a>