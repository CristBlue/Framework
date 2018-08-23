<?php

/* -----------------------------------------------------------------------------
 * █▀▀▄░▀█▀░█░█░▀█▀░█▀▀░▀█▀░█▀▀░    * @name  divisis_framework
 * █░ █░ █░ █▄█░ █░ ▀▀█░ █░ ▀▀█░    * @autor Cristian Andres Afanador
 * ▀▀▀░ ▀▀▀░ ▀░ ▀▀▀░▀▀▀░▀▀▀ ▀▀▀░    * @email <caafanadord@ufpso.edu.co>
 * -----------------------------------------------------------------------------
 * Modelo Token/
 * -------------------------------------------------------------------------- */

namespace framework\kernel\Token;

use \Firebase\JWT\JWT;
use Exception;

class Token {

    private static $key = "";
    private static $pass = "";
    private $iv;

    const METHOD = 'aes-256-cbc';

    function __construct() {
        $this->iv = chr(0x15) . chr(0x28) . chr(0x32) . chr(0x63) . chr(0x20) . chr(0x15) . chr(0x123) . chr(0x85) . chr(0x74) . chr(0x14) . chr(0x2) . chr(0x65) . chr(0x3) . chr(0x0) . chr(0x6) . chr(0x5);
    }

    /**
     *
     * @param array $data datos con lo que se quiere crear el token
     * @return string
     */
    public function generateToken(array $data): string {
        global $config;
        $array_data = [
            'iat' => time(),
            'exp' => time() + $config['sessions']['lifetime'],
            'data' => $data
        ];

        $jwt = JWT::encode($array_data, self::$key);
        $encryptado = $this->encrypted($jwt);
        return $encryptado;
    }

    /**
     *
     * @param string $token :  token que se quiere validar
     * @return array
     */
    public function validateToken($token): array {
        try {
            $decrypted = $this->decrypted($token);
            $decode = JWT::decode($decrypted, self::$key, ['HS256']);
            return ['success' => true, 'data' => (array) $decode->data];
        } catch (Exception $ex) {
            return ['success' => false, 'data' => $ex->getMessage()];
        }
    }

    /**
     *
     * @param string $txt_plant  debe ser un texto plano
     * @return string
     */
    private function encrypted(string $txt_plant): string {
        $encrypted = base64_encode(openssl_encrypt($txt_plant, self::METHOD, substr(hash('sha256', self::$pass, true), 0, 32), OPENSSL_RAW_DATA, $this->iv));
        return $encrypted;
    }

    /**
     *
     * @param string $txt_plant texto encriptado con aes-256-cbc y matriz base
     * @return string
     */
    private function decrypted($txt_plant): string {
        if (is_null($txt_plant)) {
            throw new Exception('El texto se encuentra vacio');
        }
        $decrypted = openssl_decrypt(
                base64_decode($txt_plant), self::METHOD, substr(hash('sha256', self::$pass, true), 0, 32), OPENSSL_RAW_DATA, $this->iv);
        return $decrypted;
    }

}
