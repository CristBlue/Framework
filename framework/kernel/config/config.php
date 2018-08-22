<?php

use Symfony\Component\Yaml\Yaml;

# Cargadores iniciales
require ___ROOT___ . 'framework/vendor/autoload.php';



# Mínima versión, alerta
if (version_compare(phpversion(), '7.0.0', '<')) {
    throw new \RuntimeException('La versión actual de PHP es ' . phpversion() . ' y como mínimo se require la versión 7.0.0');
}

# Verificar usabilidad de twig
$__TWIG_CACHE_PATH = ___ROOT___ . 'app/templates/.compiled/';
$__TWIG_READABLE_AND_WRITABLE = !is_readable($__TWIG_CACHE_PATH) || !is_writable($__TWIG_CACHE_PATH);
if ($__TWIG_READABLE_AND_WRITABLE) {

    # Revisar la lectura para twig
    throw new \RuntimeException('Debe conceder permisos de escritura y lectura a la ruta ' . $__TWIG_CACHE_PATH . ' ó crearla si no existe.');
}


# Obtener la data informativa
$config = Yaml::parse(file_get_contents(___ROOT___ . 'framework/Kernel/config/config.yml'));
