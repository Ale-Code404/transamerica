<?php

namespace Transamerica\Controllers;

use Transamerica\Services\Auth;

class LoginController
{
    private Auth $auth;

    public function __construct()
    {
        $this->auth = new Auth();
    }

    public function login()
    {
        $username = input()->post('username')->getValue();
        $password = input()->post('password')->getValue();

        $esValido = $this->auth->login($username, $password);

        if (!$esValido) {
            // Se almacenan los errores en la sesión
            flash('errores', "Usuario y/o contraseña incorrectos");

            return view("auth/login");
        }

        // Retornamos el usuario al listado de envios
        return redirect("/envios");
    }

    public function logout()
    {
        $this->auth->logout();

        return redirect("/");
    }
}
