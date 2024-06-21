<?php

namespace Transamerica\Controllers;

use Transamerica\Models\Envio;

use Transamerica\Services\Auth;
use Transamerica\Services\Email;
use Transamerica\Services\Filesystem;

class EnviosController
{
    public function listadoEnvios()
    {
        $user = Auth::user();

        return view("envios/listado", [
            'envios' => Envio::obtenerEnvios(),
            'usuario' => $user
        ]);
    }
}
