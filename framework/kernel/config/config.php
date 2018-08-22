<?php

use Symfony\Component\Debug\ExceptionHandler;
use Symfony\Component\Debug\ErrorHandler;
use Symfony\Component\Yaml\Yaml;

# Cargadores iniciales
require _ROOT_ . 'framework/vendor/autoload.php';


# Manejador de excepciones
ErrorHandler::register();
ExceptionHandler::register();

# Mínima versión, alerta
if (version_compare(phpversion(), '7.0.0', '<')) {
    throw new \RuntimeException('La versión actual de PHP es ' . phpversion() . ' y como mínimo se require la versión 7.0.0');
}

# Verificar usabilidad de twig
$__TWIG_CACHE_PATH = _ROOT_ . 'app/templates/compiled/';
$__TWIG_READABLE_AND_WRITABLE = !is_readable($__TWIG_CACHE_PATH) || !is_writable($__TWIG_CACHE_PATH);
if ($__TWIG_READABLE_AND_WRITABLE) {

# Revisar la lectura para twig
    throw new \RuntimeException('Debe conceder permisos de escritura y lectura a la ruta ' . $__TWIG_CACHE_PATH . ' ó crearla si no existe.');
}
# Obtener la data informativa
$config = Yaml::parse(file_get_contents(_ROOT_ . 'Divisis/Kernel/Config/Divisis.ini.yml'));

# Define el timezone actual
date_default_timezone_set($config['build']['timezone']);
