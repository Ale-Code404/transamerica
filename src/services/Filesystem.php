<?php

namespace Transamerica\Services;

use Aws\S3\S3Client;
use Exception;

class Filesystem
{
    private S3Client $s3;

    public function __construct()
    {
        $this->s3 = new S3Client([
            'version' => 'latest',
            'region' => $_ENV['AWS_REGION'],
            'credentials' => [
                'key' => $_ENV['AWS_ACCESS_KEY'],
                'secret' => $_ENV['AWS_SECRET_KEY']
            ]
        ]);
    }

    /**
     * Sube un archivo usando S3 a un bucket configurado
     */
    public function guardar(string $carpeta, string $nombre, string $archivo, string $contentType): bool
    {
        try {
            $result = $this->s3->putObject([
                'Bucket' => $_ENV['AWS_S3_BUCKET'],
                // La ubicación del archivo, concatenando la carpeta con el nombre del archivo
                'Key' => "{$carpeta}/{$nombre}",
                // Obtener el mime type del archivo, por ejemplo "image/png"
                'Content-Type' => $contentType,
                // El contenido del archivo
                'Body' => $archivo
            ]);

            if ($result->hasKey('ETag')) {
                $fueSubido = true;
            }
        } catch (Exception $e) {
            $fueSubido = false;
        }

        return $fueSubido;
    }
}
