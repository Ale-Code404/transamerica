<!DOCTYPE html>
<html lang="en">

<?php view('layouts/header', [
    'titulo' => "Transamerica | Nuevo envío"
]); ?>

<body>
    <main class="d-flex justify-content-center align-items-center min-vh-100">
        <div class="card w-100" style="max-width: 600px;">
            <h4 class="card-header text-center text-bg-light py-3">Crear envío</h4>
            <div class="card-body">
                <form action="/envios/nuevo" method="post" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-12 col-md-6 mb-3">
                            <label for="nombre" class="form-label">Nombre:</label>
                            <input type="text" id="nombre" name="nombre" class="form-control" maxlength="50" required>
                            <?php if (isset($errores['nombre']) && count($errores['nombre'])) : ?>
                                <div class="text-danger mt-1">
                                    <?php echo ($errores['nombre'][0]); ?>
                                </div>
                            <?php endif ?>
                        </div>
                        <div class="col-12 col-md-6 mb-3">
                            <label for="apellido" class="form-label">Apellido:</label>
                            <input type="text" id="apellido" name="apellido" class="form-control" maxlength="50" required>
                            <?php if (isset($errores['apellido']) && count($errores['apellido'])) : ?>
                                <div class="text-danger mt-1">
                                    <?php echo ($errores['apellido'][0]); ?>
                                </div>
                            <?php endif ?>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Correo electrónico:</label>
                        <input type="email" id="email" name="email" class="form-control" maxlength="100" required>
                        <?php if (isset($errores['email']) && count($errores['email'])) : ?>
                            <div class="text-danger mt-1">
                                <?php echo ($errores['email'][0]); ?>
                            </div>
                        <?php endif ?>
                    </div>
                    <div class="mb-3">
                        <label for="telefono" class="form-label">Teléfono:</label>
                        <input type="number" id="telefono" name="telefono" class="form-control" max="9999999999" required>
                        <?php if (isset($errores['telefono']) && count($errores['telefono'])) : ?>
                            <div class="text-danger mt-1">
                                <?php echo ($errores['telefono'][0]); ?>
                            </div>
                        <?php endif ?>
                    </div>
                    <div class="mb-3">
                        <label for="direccion" class="form-label">Dirección:</label>
                        <textarea id="direccion" name="direccion" class="form-control" maxlength="100" rows="5"></textarea>
                        <?php if (isset($errores['direccion']) && count($errores['direccion'])) : ?>
                            <div class="text-danger mt-1">
                                <?php echo ($errores['direccion'][0]); ?>
                            </div>
                        <?php endif ?>
                    </div>
                    <div class="mb-3">
                        <label for="imagenes" class="form-label">Seleccionar imagenes (max. 3): </label>
                        <input type="file" id="imagenes" name="imagenes[]" class="form-control" accept="image/*" multiple>
                        <?php if (isset($errores['imagenes']) && count($errores['imagenes'])) : ?>
                            <div class="text-danger mt-1">
                                <?php echo ($errores['imagenes'][0]); ?>
                            </div>
                        <?php endif ?>
                    </div>
                    <div class="d-grid mt-4">
                        <button type="submit" class="btn btn-primary">Enviar formulario</button>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <!-- Limpiar las sesiones de mensajes y errores -->
    <?php unset($_SESSION['mensajes']); ?>
    <?php unset($_SESSION['errores']); ?>
</body>

</html>