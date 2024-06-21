<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-light mb-4">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">
            <div class="d-flex flex-column">
                <span class="h4">Transamerica</span>
                <small class="text-muted h6">
                    <?= $app['ambiente'] ?>
                </small>
            </div>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="navbar-text">
                    <b><?php echo ($usuario->getName()); ?></b>
                    -
                    <em><?php echo ($usuario->getMail()); ?></em>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-danger" href="/logout">Cerrar sesión</a>
                </li>
            </ul>
        </div>
    </div>
</nav>