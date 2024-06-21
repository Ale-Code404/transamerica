<?php

namespace Transamerica\Models;

class User
{
    public function __construct(
        private string $username,
        private string $mail,
        private string $name
    ) {
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getMail(): string
    {
        return $this->mail;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function guardar(): bool
    {
        // Guardar en la base de datos
        return false;
    }

    public function actualizar(): bool
    {
        // Actualizar la base de datos
        return false;
    }
}
