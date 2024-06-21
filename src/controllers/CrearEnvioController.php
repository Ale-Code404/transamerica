<?php

namespace Transamerica\Controllers;

use Pecee\Http\Input\InputFile;
use Transamerica\Models\Envio;
use Transamerica\Services\Email;
use Transamerica\Services\Filesystem;

class CrearEnvioController
{
    private Filesystem $files;
    private Email $email;

    public function __construct()
    {
        // Instancir el servicio de archivos
        $this->files = new Filesystem();
        // Instanciar el servicio de correos
        $this->email = new Email();
    }

    public function crearEnvio()
    {
        $mensajes = [];
        $errores = [];

        $nombre = input()->post('nombre');
        $apellido = input()->post('apellido');
        $email = input()->post('email');
        $telefono = input()->post('telefono');
        $direccion = input()->post('direccion');

        // Validar datos
        $errores = $this->validarDatos();

        if (count($errores)) {
            // Guardar los errores en la sesión
            flash('errores', $errores);

            return redirect('/envios/nuevo');
        }

        // Crerar la instancia de envio
        $envio = new Envio(
            id: null,
            nombre: $nombre,
            apellido: $apellido,
            direccion: $direccion,
            telefono: $telefono,
            email: $email
        );

        // Guardar la instancia de envio
        $estaGuardado = $envio->guardar();
        if ($estaGuardado) {
            array_push($mensajes, "Envio creado con éxito");
        }

        // Guardar las imagenes
        $imagenes = $this->guardarImagenes($envio);
        if (count($imagenes)) {
            array_push($mensajes, sprintf("Se subieron (%s) imágenes con éxito", count($imagenes)));
        }

        // Enviar el email
        $emailEnviado = $this->enviarCorreo($envio);
        if ($emailEnviado) {
            array_push($mensajes, "Correo electrónico de notificación enviado con éxito");

            // Actualizar el modelo
            $envio->setVerificado(true);
            $envio->actualizar();
        } else {
            array_push($errores, "El correo electronico de notificación no pudo ser enviado");
        }

        // Guardar los mensajes en la sesión
        flash('mensajes', $mensajes);
        flash('errores', $errores);

        // Devolver mensajes y retornar al listado de envios
        return redirect('/envios');
    }

    /**
     * Valida los datos del envio y retorna una lista con los errores
     */
    private function validarDatos(): array
    {
        $pesoMaximo = 1024 * 1024 * 5;
        $errores = [];

        $nombre = input()->post('nombre');
        $apellido = input()->post('apellido');
        $email = input()->post('email');
        $telefono = input()->post('telefono');
        $direccion = input()->post('direccion');
        $imagenes = input()->file('imagenes', []);

        // Validaciones
        if (!isset($nombre)) {
            $errores['nombre'] = [];
            array_push($errores, "El nombre no puede estar vacío");
        }

        if (!isset($apellido)) {
            $errores['apellido'] = [];
            array_push($errores['apellido'], "El apellido no puede estar vacío");
        }

        if (!isset($email)) {
            $errores['email'] = [];
            array_push($errores['email'], "El email no puede estar vacío");
        }

        if (!isset($telefono)) {
            $errores['telefono'] = [];
            array_push($errores['telefono'], "El telefono no puede estar vacío");
        }

        if (!is_null($direccion) && !$direccion->getValue()) {
            $errores['direccion'] = [];
            array_push($errores['direccion'], "La dirección no puede estar vacía");
        }

        if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            if (!isset($errores['email'])) $errores['email'] = [];

            array_push($errores['email'], "El email no es válido");
        }

        if (strlen($nombre) > 50) {
            if (!isset($errores['nombre'])) $errores['nombre'] = [];
            array_push($errores['nombre'], "El nombre es de maximo 50 caracteres");
        }

        if (strlen($apellido) > 50) {
            if (!isset($errores['apellido'])) $errores['apellido'] = [];
            array_push($errores['apellido'], "El apellido es de maximo 50 caracteres");
        }

        if (strlen($direccion) > 100) {
            if (!isset($errores['direccion'])) $errores['direccion'] = [];
            array_push($errores['direccion'], "La dirección es de maximo 100 caracteres");
        }

        if (strlen($email) > 100) {
            if (!isset($errores['email'])) $errores['email'] = [];
            array_push($errores['email'], "El email es de maximo 100 caracteres");
        }

        if (isset($telefono) && \strlen($telefono) > 10) {
            if (!isset($errores['telefono'])) $errores['telefono'] = [];
            array_push($errores['telefono'], "El telefono es de maximo 10 caracteres");
        }

        if (count($imagenes) > 3) {
            $errores['imagenes'] = [];
            array_push($errores['imagenes'], "No se permiten más de 3 imágenes");
        }

        /** @var InputFile $imagen */
        foreach ($imagenes as $index => $imagen) {
            if ($imagen->hasError()) {
                continue;
            }

            // Validar el tipo de archivo
            if (strpos($imagen->getMime(), "image") === false) {
                if (!isset($errores['imagenes'])) $errores['imagenes'] = [];

                array_push($errores['imagenes'], sprintf("El archivo (%s) no es una imagen", $index + 1));
            }

            // Validar el tamaño maximo
            if ($imagen->getSize() > $pesoMaximo) {
                if (!isset($errores['imagenes'])) $errores['imagenes'] = [];

                array_push($errores['imagenes'], sprintf("El archivo (%s) sobrepasa el límite de 5MB", $index + 1));
            }
        }

        return $errores;
    }

    /**
     * Guarda la imagenes del envio y devuelve una lista con los paths de las imagenes guardadas
     */
    private function guardarImagenes(Envio $envio): array
    {
        $imagenes = input()->file('imagenes', []);
        $imagenesGuardadas = [];

        /** @var InputFile $imagen */
        foreach ($imagenes as $imagen) {
            // Saltar si hay errores
            if ($imagen->hasError()) {
                continue;
            }

            $nombre = sprintf("%s.%s", uniqid("img-"), $imagen->getExtension());
            $path = sprintf("envios/%s/%s", $envio->getId(), $nombre);

            $guardado = $this->files->guardar(
                carpeta: "envios/{$envio->getId()}",
                nombre: $nombre,
                archivo: $imagen->getContents(),
                contentType: $imagen->getMime()
            );

            if ($guardado) {
                array_push($imagenesGuardadas, $path);
            }
        }

        return $imagenesGuardadas;
    }

    /**
     * Enviar correo electrónico de notificación
     */
    private function enviarCorreo(Envio $envio)
    {
        $emailEnviado = $this->email->enviarTemplateEmail(
            template: "EnvioCreado",
            email: $envio->getEmail(),
            data: [
                'client' => [
                    'name' => $envio->getNombreCompleto(),
                    'address' => $envio->getDireccion(),
                    'email' => $envio->getEmail()
                ],
                'send' => [
                    'year' => date("Y"),
                    'date' => date('h:ia \d\e\l d M \d\e Y')
                ]
            ]
        );

        return $emailEnviado;
    }
}
