<?php

use Pecee\SimpleRouter\SimpleRouter;
use Transamerica\Controllers\CrearEnvioController;
use Transamerica\Controllers\EnviosController;
use Transamerica\Controllers\LoginController;
use Transamerica\Middlewares\Auth;

// Vista de login
SimpleRouter::get('/', function () {
    return view("auth/login");
});

// Procesar el login
SimpleRouter::post('/login', [LoginController::class, 'login']);

// Creamos un grupo de rutas protegidas
SimpleRouter::group(['middleware' => Auth::class], function () {
    // Cerrar sesión
    SimpleRouter::get('/logout', [LoginController::class, 'logout']);

    SimpleRouter::get('/envios', [EnviosController::class, 'listadoEnvios']);
    // Mostrar el fomulairo de envio
    SimpleRouter::get('/envios/nuevo', function () {
        return view("envios/nuevo");
    });
    // Procesar el envio
    SimpleRouter::post('/envios/nuevo', [CrearEnvioController::class, 'crearEnvio']);
});
