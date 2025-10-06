<?php

declare(strict_types=1);

use App\Core\Flash;

function renderInput(string $name, string $label, string $type = 'text', string $value = '', array $errors = [],
                     bool   $skipFeedback = false): void
{
    $class = 'form-control';
    if (!$skipFeedback) {
        $hasError = !empty($errors[$name]);
        $class .= $hasError ? ' is-invalid' : (!empty($_POST) ? ' is-valid' : '');
    } else {
        $hasError = false;
    }

    ?>
    <div class="mb-3">
        <label class="form-label" for="field-<?= $name ?>"><?= htmlspecialchars($label) ?></label>
        <input type="<?= $type ?>"
               name="<?= $name ?>"
               id="field-<?= $name ?>"
               class="<?= $class ?>"
               value="<?= $type !== 'password' ? htmlspecialchars($value ?? '') : '' ?>"
               required>
        <?php if ($hasError): ?>
            <?php foreach ($errors[$name] as $error): ?>
                <div class="invalid-feedback"><?= htmlspecialchars($error) ?></div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
<?php }

function renderGlobalErrors(array $errors = []): void
{
    if (!empty($errors['upper_form'])) {
        foreach ((array)$errors['upper_form'] as $error) {
            echo '<div class="alert alert-danger">' . htmlspecialchars($error) . '</div>';
        }
    }
}

function renderFlashMessage(string $type): void
{
    if (\App\Core\Flash::has($type)) {
        $class = $type === 'success' ? 'alert-success' : 'alert-danger';
        echo '<div class="alert ' . $class . '">' . htmlspecialchars(\App\Core\Flash::get($type)) . '</div>';
    }
}
