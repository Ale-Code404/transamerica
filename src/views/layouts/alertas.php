<!-- Alertas de mensajes de sesión y errores -->
<?php if (isset($session['mensajes'])) : ?>
    <?php foreach ($session['mensajes'] as $mensaje) : ?>
        <div class="alert alert-success fade show" role="alert">
            <?= $mensaje ?>
        </div>
    <?php endforeach; ?>

    <?php unset($_SESSION['mensajes']); ?>
<?php endif; ?>

<?php if (isset($session['errores'])) : ?>
    <?php foreach ($session['errores'] as $error) : ?>
        <div class="alert alert-danger fade show" role="alert">
            <?= $error ?>
        </div>
    <?php endforeach; ?>

    <?php unset($_SESSION['errores']); ?>
<?php endif; ?>