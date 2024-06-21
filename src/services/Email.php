<?php

namespace Transamerica\Services;

use Aws\SesV2\SesV2Client;
use Exception;

class Email
{
    private SesV2Client $ses;

    public function __construct()
    {
        $this->ses = new SesV2Client([
            'version' => 'latest',
            'region' => $_ENV['AWS_REGION'],
            'credentials' => [
                'key' => $_ENV['AWS_ACCESS_KEY'],
                'secret' => $_ENV['AWS_SECRET_KEY']
            ]
        ]);
    }

    /**
     * Envia un correo electronico usando SES como proveedor
     */
    public function enviarTemplateEmail(string $template, string $email, array $data): bool
    {
        try {
            $result = $this->ses->sendEmail([
                // Es el correo remitente
                'FromEmailAddress' => $_ENV['AWS_SES_EMAIL'],
                'Content' => [
                    'Template' => [
                        // Es una plantilla de correo previamente configurada
                        'TemplateName' => $template,
                        // Es la informacion de la plantilla
                        'TemplateData' => json_encode($data)
                    ]
                ],
                'Destination' => [
                    'ToAddresses' => [
                        $email
                    ]
                ]
            ]);

            // Si el resultado contiene el id del mensaje enviado se toma como correcto
            if ($result->hasKey('MessageId')) {
                $fueEnviado = true;
            }
        } catch (Exception $e) {
            $fueEnviado = false;
        }

        return $fueEnviado;
    }
}
