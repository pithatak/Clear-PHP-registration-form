<?php ob_start(); ?>
    <h2>Hello! Choose action:</h2>
    <a href="/showRegistrationForm" class="btn btn-primary m-2">Registration</a>
    <a href="/showLoginForm" class="btn btn-success m-2">Login</a>
<?php $content = ob_get_clean(); ?>

<?php include __DIR__ . "/layout.php";