<!DOCTYPE html>
<html lang="en">

<?php view("layouts/header", [
    "titulo" => "Transamerica | Iniciar sesión"
]) ?>

<body>
    <main class="d-flex justify-content-center align-items-center min-vh-100">
        <section class="w-100" style="max-width: 400px;">
            <form action="/login" method="post" class="mb-4 p-4 border rounded shadow-sm bg-light">
                <header class="mb-4 text-center">
                    <h2 class="mb-0">Iniciar sesión</h2>
                    <small>
                        <em><?= $app['ambiente'] ?></em>
                    </small>
                </header>
                <div class="mb-3">
                    <label for="username" class="form-label">Usuario</label>
                    <input type="text" id="username" name="username" class="form-control" placeholder="Ej: vrojas" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Contraseña</label>
                    <input type="password" id="password" name="password" class="form-control" placeholder="Contraseña" required>
                </div>
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">Iniciar sesión</button>
                </div>
            </form>

            <?php view('layouts/alertas') ?>
        </section>
    </main>
</body>

</html>