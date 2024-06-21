<?php

namespace Transamerica\Models;

use PDO;

abstract class Model
{
    protected static PDO $pdo;

    /**
     * Permite obtener la conexión
     */
    public static function obtenerConexion(): PDO
    {
        // Crear la conexion solo si no existe
        if (!isset(self::$pdo)) {
            self::$pdo = new PDO(
                dsn: "{$_ENV['DB_TYPE']}:host={$_ENV['DB_HOST']};port={$_ENV['DB_PORT']};dbname={$_ENV['DB_NAME']}",
                username: $_ENV['DB_USER'],
                password: $_ENV['DB_PASSWORD'],
                options: [PDO::ATTR_PERSISTENT => true]
            );
        }

        return self::$pdo;
    }

    /**
     * Define como el modelo persiste en la base de datos
     */
    public abstract function guardar(): bool;

    /**
     * Define como el modelo actualiza en la base de datos
     */
    public abstract function actualizar(): bool;
}
