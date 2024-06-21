<?php

namespace Transamerica\Services;

use Transamerica\Models\User;

use LDAP\Connection;
use Exception;

class Ldap
{
    private Connection $connection;

    public function __construct()
    {
        // Iniciar la conexión con el servidor
        $this->connection = ldap_connect(
            uri: $_ENV['AUTH_LDAP_HOST'],
            port: $_ENV['AUTH_LDAP_PORT']
        );

        // Configurar la conexión
        ldap_set_option($this->connection, LDAP_OPT_PROTOCOL_VERSION, 3);
        ldap_set_option($this->connection, LDAP_OPT_REFERRALS, 0);
        ldap_set_option($this->connection, LDAP_OPT_NETWORK_TIMEOUT, 10);
    }

    public function getUser($username): User
    {
        $result = ldap_search(
            ldap: $this->connection,
            base: "{$_ENV['AUTH_LDAP_DOMINIO_OU']},{$_ENV['AUTH_LDAP_DOMINIO']}",
            // Buscar por username
            filter: "(uid=$username)",
            // Traer solo los atributos necesarioss
            attributes: [
                "uid", "cn", "mail"
            ]
        );

        if ($result === false) {
            throw new Exception("Error en la búsqueda LDAP.");
        }

        // Obtener la primera entrada del resultado
        $entries = ldap_get_entries($this->connection, $result);

        // Verificar si se encontraron entradas
        if ($entries["count"] == 0) {
            throw new Exception("Usuario no encontrado.");
        }

        // Obtener el primer registro
        $user = $entries[0];

        // Instanciar un modelo de Usuario
        return new User(
            $username,
            $user['mail'][0],
            $user['cn'][0],
        );
    }
    /**
     * Intenta autentica al usuario usando un dominio LDAP
     */
    public function login($username, $password): bool
    {
        try {
            // Intentar un login o bind con username y contraseña
            $logged = ldap_bind(
                ldap: $this->connection,
                dn: "uid={$username},{$_ENV['AUTH_LDAP_DOMINIO_OU']},{$_ENV['AUTH_LDAP_DOMINIO']}",
                password: $password
            );
        } catch (Exception $e) {
            $logged = false;
        }

        return $logged;
    }
}
