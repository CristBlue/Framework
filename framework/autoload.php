<?php

/* -----------------------------------------------------------------------------
 * █▀▀▄░▀█▀░█░█░▀█▀░█▀▀░▀█▀░█▀▀░    * @name  divisis_framework
 * █░ █░ █░ █▄█░ █░ ▀▀█░ █░ ▀▀█░    * @autor Brayan Narváez
 * ▀▀▀░ ▀▀▀░ ▀░ ▀▀▀░▀▀▀░▀▀▀ ▀▀▀░    * @email <prinick@ocrend.com>
 * -----------------------------------------------------------------------------
 * Registra dinamicamente los archivos para la implementación de sus funciones
 * -------------------------------------------------------------------------- */

spl_autoload_register('__framework_autoload');

function __framework_autoload(string $class) {
    $class = _ROOT_ . str_replace('\\', '/', $class);
    if (is_readable($class . '.php')) {
        require_once $class . '.php';
    }
}
