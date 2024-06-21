<?php

namespace Transamerica\Middlewares;

use Pecee\Http\Middleware\IMiddleware;
use Pecee\Http\Request;

class Auth implements IMiddleware
{
    public function handle(Request $request): void
    {
        $tiempoLimite = 60 * 30;

        // Cargar la sesion activa
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Si no existe un usuario en la sesion retornar al login
        $tieneUsuario = isset($_SESSION['user']);
        $tieneTiempo = time() - $_SESSION['time'] <= $tiempoLimite;

        if (!$tieneUsuario || !$tieneTiempo) {
            flash('errores', "Su sesión ha expirado");

            redirect("/");
        }
    }
}
