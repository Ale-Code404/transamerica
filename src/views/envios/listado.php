<!DOCTYPE html>
<html lang="en">

<?php view('layouts/header', [
    'titulo' => "Transamerica | Listado de envíos"
]); ?>

<body>
    <main>
        <?php view('layouts/navbar'); ?>

        <section class="container my-5">
            <header class="mb-4">
                <h1 class="text-center">Listado de envíos</h1>
            </header>

            <?php view('layouts/alertas'); ?>

            <!-- Botón para nuevo envío -->
            <div class="d-flex justify-content-end mb-3">
                <a href="/envios/nuevo" class="btn btn-primary">Nuevo Envío</a>
            </div>

            <!-- Tabla de envíos -->
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Apellido</th>
                            <th>Correo electrónico</th>
                            <th>Teléfono</th>
                            <th>Dirección</th>
                            <th>Envío de correo electrónico</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($envios) === 0) : ?>
                            <tr>
                                <td class="text-center" colspan="6">No hay envíos registrados</td>
                            </tr>
                        <?php endif; ?>
                        <?php foreach ($envios as $envio) : ?>
                            <tr>
                                <td><?= $envio->getNombre() ?></td>
                                <td><?= $envio->getApellido() ?></td>
                                <td><?= $envio->getEmail() ?></td>
                                <td><?= $envio->getTelefono() ?></td>
                                <td><?= $envio->getDireccion() ?></td>
                                <td>
                                    <?php if ($envio->isVerificado()) : ?>
                                        <span class="badge text-bg-success">Enviado</span>
                                    <?php else : ?>
                                        <span class="badge text-bg-danger">No enviado</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </section>
    </main>
</body>

</html>