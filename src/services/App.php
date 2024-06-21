<?php

namespace Transamerica\Services;

class App
{
    /**
     * Devuelve el entorno actual
     */
    public static function env(): string
    {
        return $_ENV['APP_ENV'];
    }

    /**
     * Devuelve el host actual
     */
    public static function host(): string
    {
        return gethostname();
    }

    /**
     * Devuelve el nombre del entorno concatenado el env con el host
     */
    public static function envName(): string
    {
        return self::env() . " - " . self::host();
    }
}
