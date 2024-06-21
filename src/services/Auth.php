<?php

namespace Transamerica\Services;

use Transamerica\Models\User;

class Auth
{
    private Ldap $ldap;

    public function __construct()
    {
        $this->ldap = new Ldap();
    }

    /**
     * Devuelve el usuario actual que esta logeado
     */
    public static function user(): ?User
    {
        return $_SESSION['user'] ?? null;
    }

    /**
     * Intenta iniciar la sesion
     */
    public function login(string $username, string $password): bool
    {
        $esValido = $this->ldap->login($username, $password);

        // Si no es valido el login salimos
        if (!$esValido) {
            return false;
        }

        // Obtenemos la información del usuario
        $user = $this->ldap->getUser($username);

        // Iniciamos la sesión
        session_start();

        // Guardamos la información del usuario
        $_SESSION['user'] = $user;
        // Guardamos el momento exacto cuando se inicia sesión
        $_SESSION['time'] = time();

        return true;
    }

    public function logout(): void
    {
        session_start();
        session_destroy();
    }
}
