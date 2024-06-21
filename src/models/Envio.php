<?php

namespace Transamerica\Models;

use PDO;

class Envio extends Model
{
    public function __construct(
        private ?int $id,
        private string $nombre,
        private string $apellido,
        private string $direccion,
        private string $telefono,
        private string $email,
        private bool $verificado = false
    ) {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getNombre(): string
    {
        return $this->nombre;
    }

    public function getApellido(): string
    {
        return $this->apellido;
    }

    public function getDireccion(): string
    {
        return $this->direccion;
    }

    public function getTelefono(): string
    {
        return $this->telefono;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function isVerificado(): bool
    {
        return $this->verificado;
    }

    public function setVerificado(bool $verificado): void
    {
        $this->verificado = $verificado;
    }

    public function getNombreCompleto(): string
    {
        return "{$this->nombre} {$this->apellido}";
    }

    public function guardar(): bool
    {
        $prepared = self::obtenerConexion()->prepare(
            "INSERT INTO envios (nombre, apellido, direccion, telefono, email) VALUES (:nombre, :apellido, :direccion, :telefono, :email)"
        );

        $prepared->bindParam(':nombre', $this->nombre);
        $prepared->bindParam(':apellido', $this->apellido);
        $prepared->bindParam(':direccion', $this->direccion);
        $prepared->bindParam(':telefono', $this->telefono);
        $prepared->bindParam(':email', $this->email);

        $estaGuardado = $prepared->execute();

        if ($estaGuardado) {
            $this->id = self::obtenerConexion()->lastInsertId();
        }

        return $estaGuardado;
    }

    public function actualizar(): bool
    {
        $prepared = self::obtenerConexion()->prepare(
            "UPDATE envios 
            SET nombre = :nombre, apellido = :apellido, direccion = :direccion, telefono = :telefono, email = :email, verificado = :verificado
            WHERE id = :id"
        );

        $prepared->bindParam(':nombre', $this->nombre);
        $prepared->bindParam(':apellido', $this->apellido);
        $prepared->bindParam(':direccion', $this->direccion);
        $prepared->bindParam(':telefono', $this->telefono);
        $prepared->bindParam(':email', $this->email);
        $prepared->bindParam(':verificado', $this->verificado);
        // Definir el filtro principal para actualizar solo este modelo
        $prepared->bindParam(':id', $this->id);

        $estaActualizado = $prepared->execute();

        return $estaActualizado;
    }

    /**
     * Obtener todos los envios
     * 
     * @return Envio[]
     */
    public static function obtenerEnvios(): array
    {
        // Traer todos los envios
        $resultado = self::obtenerConexion()->query("SELECT * FROM envios");

        $envios = [];

        while ($row = $resultado->fetch(PDO::FETCH_ASSOC)) {
            $envios[] = new Envio(
                $row['id'],
                $row['nombre'],
                $row['apellido'],
                $row['direccion'],
                $row['telefono'],
                $row['email'],
                $row['verificado']
            );
        }

        return $envios;
    }
}
