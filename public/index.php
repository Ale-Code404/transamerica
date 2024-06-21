<?php

/**
 * Punto de entrada de la aplicación
 */

use Dotenv\Dotenv;
use Pecee\SimpleRouter\SimpleRouter;

// Cargar todas las dependencias
require_once "../vendor/autoload.php";

require_once "../src/router.php";

// Establecer la zona horaria
date_default_timezone_set('America/Bogota');

// Cargar las variables de entorno
$env = Dotenv::createImmutable(dirname(__DIR__));
$env->safeLoad();

// Configurar la carpeta de controladores
SimpleRouter::setDefaultNamespace("Transamerica\Controllers");

// Iniciar el enrutamiento
SimpleRouter::start();
