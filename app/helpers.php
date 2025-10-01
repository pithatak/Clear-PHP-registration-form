<?php

declare(strict_types=1);

function renderInput(string $name, string $label, string $type = 'text', string $value = '', array $errors = []): void
{
    $hasError = !empty($errors[$name]);
    $class = 'form-control ' . ($hasError ? 'is-invalid' : (!empty($_POST) ? 'is-valid' : ''));
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
<?php } ?>